<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Booking;
use App\Models\CaretakerProfile;
use App\Models\Pet;
use App\Models\PetAd;
use App\Models\Service;
use App\Models\User;

class BookingsController extends Controller
{
    public function index(): void
    {
        Session::start();
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $userId = Session::get('user')['id'];
        $bookingModel = new Booking();

        // Data for when the user is a service PROVIDER or responding to requests
        $bookedServices = $bookingModel->getBookedServicesByUserId($userId);
        $serviceRequests = $bookingModel->getServiceRequestsForUserId($userId);
        $sentOffers = $bookingModel->getSentOffersByUserId($userId);

        // Data for when the user is a CLIENT (hiring someone)
        $clientBookings = $bookingModel->getBookingsByClientId($userId);

        $this->render('bookings/index', [
            'pageTitle' => 'My Bookings',
            'bookedServices' => $bookedServices,
            'serviceRequests' => $serviceRequests,
            'sentOffers' => $sentOffers,
            'clientBookings' => $clientBookings,
        ]);
    }

    public function create(int $id): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            $this->redirect('/login');
            return;
        }

        $userModel = new User();
        
        $adId = !empty($_GET['ad_id']) ? (int)$_GET['ad_id'] : null;
        $ad = null;
        if ($adId) {
            $petAdModel = new PetAd();
            $ad = $petAdModel->getAdById($adId);
        }

        $pets = [];
        $services = [];
        $displayProvider = null;

        if ($ad && $ad['ad_type'] === 'service_request') {
            // Logged-in user is the provider, ad poster is the client
            $displayProvider = $ad; // Use ad poster's info
            $displayProvider['name'] = $ad['user_name'];
            
            // For a service request, the pet is already determined
            $pets = [
                ['id' => $ad['pet_id'], 'name' => $ad['pet_name'] . ' (from Ad)']
            ];
        } else {
            // Normal flow: Logged-in user is the client, $id is the provider
            $displayProvider = $userModel->find($id);
            if (!$displayProvider) {
                $this->error(404, 'Service provider not found');
                return;
            }

            $petModel = new Pet();
            $pets = $petModel->getPetsByUserId($user['id']);
        }

        $serviceModel = new Service();
        $services = $serviceModel->all();

        $this->render('bookings/create', [
            'pageTitle' => 'Book ' . ($displayProvider['name'] ?? 'Service'),
            'provider' => $displayProvider,
            'pets' => $pets,
            'services' => $services,
            'ad' => $ad
        ]);
    }

    public function store(): void
    {
        Session::start();
        $sessionUser = Session::get('user');
        if (!$sessionUser) {
            $this->redirect('/login');
            return;
        }
        $userId = $sessionUser['id'];

        $adId = !empty($_POST['ad_id']) ? (int)$_POST['ad_id'] : null;
        $ad = null;
        if ($adId) {
            $petAdModel = new PetAd();
            $ad = $petAdModel->getAdById($adId);
        }

        if ($ad && $ad['ad_type'] === 'service_request') {
            // Scenario: Caretaker is BOOKING an Owner's request
            $providerId = $userId; // The person doing the booking is the provider
            $clientId = $ad['user_id']; // The owner is the ad poster
            $petId = $ad['pet_id'];
            $serviceId = $ad['service_id'] ?? $_POST['service_id'];
            $locationId = $ad['location_id'];
        } else {
            // Scenario: Owner is BOOKING a Caretaker (or no specific ad)
            $providerId = $_POST['provider_id'];
            $clientId = $userId;
            $petId = $_POST['pet_id'];
            $serviceId = $_POST['service_id'];

            // Get location from caretaker profile
            $caretakerProfileModel = new CaretakerProfile();
            $caretakerProfile = $caretakerProfileModel->getProfileByUserId($providerId);
            $locationId = $caretakerProfile['location'] ?? null;
        }

        if (empty($locationId)) {
            Session::flash('error', 'Location information is missing. Cannot create booking.');
            $this->redirect($adId ? "/pets/{$adId}" : "/bookings");
            return;
        }

        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $notes = $_POST['notes'];

        $bookingModel = new Booking();
        $bookingData = [
            'pet_id' => $petId,
            'provider_id' => $providerId,
            'client_id' => $clientId,
            'service_id' => $serviceId,
            'location_id' => $locationId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'pending',
            'notes' => $notes,
        ];
        
        // Only add pet_ad_id if it's a valid integer
        if ($adId && $adId > 0) {
            $bookingData['pet_ad_id'] = $adId;
        }
        
        $bookingId = $bookingModel->create($bookingData);

        if ($bookingId) {
            Session::flash('success', 'Your booking request has been sent!');
        } else {
            Session::flash('error', 'There was an error creating your booking.');
        }
        
        $this->redirect('/bookings');
    }

    public function manage(int $bookingId): void
    {
        Session::start();
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $bookingModel = new Booking();
        $booking = $bookingModel->getBookingDetailsById($bookingId);

        if (!$booking) {
            $this->error(404, 'Booking not found');
            return;
        }

        $userId = Session::get('user')['id'];
        $isServiceProvider = ($userId === (int)$booking['provider_id']);
        $isServiceRequestor = ($userId === (int)$booking['owner_id']); 

        if (!$isServiceProvider && !$isServiceRequestor) {
            $this->error(403, 'You are not authorized to view this page');
            return;
        }

        $this->render('bookings/manage', [
            'pageTitle' => 'Manage Booking',
            'booking' => $booking,
            'isServiceProvider' => $isServiceProvider,
            'isServiceRequestor' => $isServiceRequestor,
        ]);
    }

    public function update(int $bookingId): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            $this->redirect('/login');
            return;
        }

        $status = $_POST['status'] ?? null;
        if (!$status) {
            $this->redirect("/bookings/manage/{$bookingId}");
            return;
        }

        $bookingModel = new Booking();
        $booking = $bookingModel->getBookingDetailsById($bookingId);

        if (!$booking) {
            $this->error(404, 'Booking not found');
            return;
        }

        $userId = $user['id'];
        $isServiceProvider = ($userId === (int)$booking['provider_id']);
        $isServiceRequestor = ($userId === (int)$booking['owner_id']);
        $isServiceRequestAd = (($booking['ad_type'] ?? '') === 'service_request');

        $allowed = false;

        if ($status === 'cancelled' && in_array($booking['status'], ['pending', 'confirmed'])) {
            if ($isServiceProvider || $isServiceRequestor) $allowed = true;
        }

        if ($status === 'confirmed' && $booking['status'] === 'pending') {
            if ($isServiceRequestAd) {
                if ($isServiceRequestor) $allowed = true; // Owner confirms the caretaker's offer
            } else {
                if ($isServiceProvider) $allowed = true; // Caretaker confirms the owner's booking
            }
        }

        if ($status === 'completed' && $booking['status'] === 'confirmed') {
            if ($isServiceRequestor) $allowed = true; // Owner marks as completed
        }

        if ($allowed) {
            if ($bookingModel->updateStatus($bookingId, $status)) {
                Session::flash('success', 'Booking status updated successfully.');
            } else {
                Session::flash('error', 'Failed to update booking status.');
            }
        } else {
            Session::flash('error', 'You are not authorized to perform this action or the status transition is not allowed.');
        }

        $this->redirect("/bookings/manage/{$bookingId}");
    }


    public function rate(int $bookingId): void
    {
        Session::start();
        $user = Session::get('user');
        if (!$user) {
            $this->redirect('/login');
            return;
        }

        $rating = $_POST['rating'] ?? null;
        $review = $_POST['review'] ?? null;

        if (!$rating) {
            Session::flash('error', 'A rating is required.');
            $this->redirect("/bookings/manage/{$bookingId}");
            return;
        }

        $bookingModel = new Booking();
        $booking = $bookingModel->getBookingDetailsById($bookingId);
        $userId = $user['id'];

        if ($booking && $booking['owner_id'] === $userId && $booking['status'] === 'completed') {
            $bookingModel->addRating($bookingId, (int)$rating, $review);
            Session::flash('success', 'Your review has been submitted.');
        } else {
            Session::flash('error', 'You cannot submit a review for this booking at this time.');
        }

        $this->redirect("/bookings/manage/{$bookingId}");
    }
}
