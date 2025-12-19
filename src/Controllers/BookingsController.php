<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Booking;
use App\Models\PetAd;

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

        $bookedServices = $bookingModel->getBookedServicesByUserId($userId);
        $serviceRequests = $bookingModel->getServiceRequestsForUserId($userId);

        $this->render('bookings/index', [
            'pageTitle' => 'My Bookings',
            'bookedServices' => $bookedServices,
            'serviceRequests' => $serviceRequests,
        ]);
    }

    public function create(int $adId): void
    {
        Session::start();
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $adModel = new PetAd();
        $ad = $adModel->find($adId);

        if (!$ad) {
            $this->error(404, 'Ad not found');
            return;
        }

        $bookingModel = new Booking();
        $bookingModel->create([
            'pet_ad_id' => $adId,
            'provider_id' => Session::get('user')['id'],
            'status' => 'pending',
            'start_date' => $ad['start_date'],
            'end_date' => $ad['end_date'],
            'notes' => 'Booking request for ad #' . $adId,
        ]);

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
        $isServiceRequestor = ($userId === (int)$booking['ad_owner_id']);

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
        if (!Session::get('user')) {
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

        $userId = Session::get('user')['id'];
        $isServiceProvider = ($userId === (int)$booking['provider_id']);
        $isServiceRequestor = ($userId === (int)$booking['ad_owner_id']);

        $allowed = false;

        // Authorization logic
        if ($isServiceRequestor) {
            if ($status === 'confirmed' && $booking['status'] === 'pending') {
                $allowed = true;
            }
            if ($status === 'completed' && $booking['status'] === 'confirmed') {
                $allowed = true;
            }
            if ($status === 'cancelled' && in_array($booking['status'], ['pending', 'confirmed'])) {
                $allowed = true;
            }
        }

        if ($isServiceProvider) {
            if ($status === 'cancelled' && in_array($booking['status'], ['pending', 'confirmed'])) {
                $allowed = true;
            }
        }

        if ($allowed) {
            $bookingModel->updateStatus($bookingId, $status);
        } else {
            Session::set('flash_message', 'You are not authorized to perform this action.');
        }


        $this->redirect("/bookings/manage/{$bookingId}");
    }

    public function rate(int $bookingId): void
    {
        Session::start();
        if (!Session::get('user')) {
            $this->redirect('/login');
            return;
        }

        $rating = $_POST['rating'] ?? null;
        $review = $_POST['review'] ?? null;

        if (!$rating) {
            $this->redirect("/bookings/manage/{$bookingId}");
            return;
        }

        $bookingModel = new Booking();
        $bookingModel->addRating($bookingId, (int)$rating, $review);

        $this->redirect("/bookings/manage/{$bookingId}");
    }
}
