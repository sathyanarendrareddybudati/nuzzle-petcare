<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Booking;
use App\Models\CaretakerProfile;
use App\Models\Pet;
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

        // Data for when the user is a service PROVIDER
        $bookedServices = $bookingModel->getBookedServicesByUserId($userId);
        $serviceRequests = $bookingModel->getServiceRequestsForUserId($userId);

        // Data for when the user is a CLIENT
        $clientBookings = $bookingModel->getBookingsByClientId($userId);

        $this->render('bookings/index', [
            'pageTitle' => 'My Bookings',
            'bookedServices' => $bookedServices,
            'serviceRequests' => $serviceRequests,
            'clientBookings' => $clientBookings,
        ]);
    }

    public function create(int $providerId): void
    {
        Session::start();
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $userModel = new User();
        $provider = $userModel->find($providerId);

        if (!$provider) {
            $this->error(404, 'Service provider not found');
            return;
        }

        $petModel = new Pet();
        $pets = $petModel->getPetsByUserId(Session::get('user')['id']);

        $serviceModel = new Service();
        $services = $serviceModel->all();

        $this->render('bookings/create', [
            'pageTitle' => 'Book ' . $provider['name'],
            'provider' => $provider,
            'pets' => $pets,
            'services' => $services,
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

        $providerId = $_POST['provider_id'];
        $petId = $_POST['pet_id'];
        $serviceId = $_POST['service_id'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $notes = $_POST['notes'];

        $caretakerProfileModel = new CaretakerProfile();
        $caretakerProfile = $caretakerProfileModel->getProfileByUserId($providerId);
        $locationId = $caretakerProfile['location'] ?? null;

        if (empty($locationId)) {
            Session::flash('error', 'The service provider does not have a location set. Cannot create booking.');
            $this->redirect("/bookings/create/{$providerId}");
            return;
        }

        $bookingModel = new Booking();
        $bookingId = $bookingModel->create([
            'pet_id' => $petId,
            'provider_id' => $providerId,
            'client_id' => $userId,
            'service_id' => $serviceId,
            'location_id' => $locationId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'pending',
            'notes' => $notes,
        ]);

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

        $allowed = false;

        if ($isServiceProvider) {
            if ($status === 'confirmed' && $booking['status'] === 'pending') $allowed = true;
            if ($status === 'cancelled' && in_array($booking['status'], ['pending', 'confirmed'])) $allowed = true;
        } elseif ($isServiceRequestor) {
            if ($status === 'completed' && $booking['status'] === 'confirmed') $allowed = true;
            if ($status === 'cancelled' && in_array($booking['status'], ['pending', 'confirmed'])) $allowed = true;
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
