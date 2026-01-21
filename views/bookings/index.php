<?php
/**
 * @var array $clientBookings The services the current user has booked from others.
 * @var array $bookedServices The services the current user is confirmed to provide.
 * @var array $serviceRequests The pending service requests for the current user's ads.
 * @var array $sentOffers The offers the current user has sent to others' requests.
 * @var string $pageTitle The page title.
 */

$clientBookings = $clientBookings ?? [];
$bookedServices = $bookedServices ?? [];
$serviceRequests = $serviceRequests ?? [];
$sentOffers = $sentOffers ?? [];
?>

<div class="container my-5">
    <h1 class="text-center mb-5"><?= e($pageTitle ?? 'My Bookings') ?></h1>

    <!-- 1. Hiring Section: Services I am booking from others -->
    <div class="card shadow-sm mb-5 border-primary">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="fas fa-shopping-basket me-2"></i>Services I'm Hiring</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($clientBookings)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Provider / Caretaker</th>
                                <th>Status</th>
                                <th>Date Booked</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientBookings as $booking): ?>
                                <tr>
                                    <td><?= e($booking['service_name']) ?></td>
                                    <td><?= e($booking['other_user_name'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge bg-<?= e(match($booking['status']) {
                                            'pending' => 'warning',
                                            'confirmed' => 'success',
                                            'completed' => 'primary',
                                            'cancelled' => 'secondary',
                                            default => 'light',
                                        }) ?>"><?= e(ucfirst($booking['status'])) ?></span>
                                    </td>
                                    <td><?= e(date('M d, Y', strtotime($booking['created_at']))) ?></td>
                                    <td class="text-end">
                                        <a href="/bookings/manage/<?= (int)$booking['id'] ?>" class="btn btn-sm btn-outline-primary">Manage</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center p-4">
                    <p class="text-muted mb-0">You are not currently hiring any pet services.</p>
                    <a href="/pets" class="btn btn-sm btn-primary mt-2">Find a Caretaker</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2. Providing Section: Services I am offering to others -->
    <div class="card shadow-sm border-success">
        <div class="card-header bg-success text-white">
            <h2 class="h4 mb-0"><i class="fas fa-paw me-2"></i>Provider Dashboard</h2>
        </div>
        <div class="card-body">
            
            <!-- A. Incoming Service Requests (New work for me) -->
            <h3 class="h5 mb-3"><i class="fas fa-inbox me-2"></i>Incoming Requests</h3>
            <?php if (!empty($serviceRequests)): ?>
                <div class="table-responsive mb-4">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>From Client</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($serviceRequests as $request): ?>
                                <tr>
                                    <td><?= e($request['service_name']) ?></td>
                                    <td><?= e($request['other_user_name'] ?? 'N/A') ?></td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td><?= e(date('M d, Y', strtotime($request['created_at']))) ?></td>
                                    <td class="text-end">
                                        <a href="/bookings/manage/<?= (int)$request['id'] ?>" class="btn btn-sm btn-outline-primary">Review Request</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center p-3 border rounded mb-4 bg-light">
                    <p class="text-muted mb-0 small">No new incoming requests.</p>
                </div>
            <?php endif; ?>

            <!-- B. Sent Offers (Responses I sent to owner requests) -->
            <h3 class="h5 mb-3 mt-4"><i class="fas fa-paper-plane me-2"></i>My Sent Offers</h3>
            <?php if (!empty($sentOffers)): ?>
                <div class="table-responsive mb-4">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Requested By (Owner)</th>
                                <th>Status</th>
                                <th>Date Sent</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sentOffers as $offer): ?>
                                <tr>
                                    <td><?= e($offer['service_name']) ?></td>
                                    <td><?= e($offer['other_user_name'] ?? 'N/A') ?></td>
                                    <td><span class="badge bg-info">Waiting for Owner</span></td>
                                    <td><?= e(date('M d, Y', strtotime($offer['created_at']))) ?></td>
                                    <td class="text-end">
                                        <a href="/bookings/manage/<?= (int)$offer['id'] ?>" class="btn btn-sm btn-outline-primary">Manage Offer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center p-3 border rounded mb-4 bg-light">
                    <p class="text-muted mb-0 small">You haven't sent any offers to owners.</p>
                </div>
            <?php endif; ?>

            <!-- C. Confirmed & Past Services -->
            <h3 class="h5 mb-3 mt-4"><i class="fas fa-check-circle me-2"></i>Confirmed / Completed Work</h3>
            <?php if (!empty($bookedServices)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Client Name</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookedServices as $booking): ?>
                                <tr>
                                    <td><?= e($booking['service_name']) ?></td>
                                    <td><?= e($booking['other_user_name'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge bg-<?= e(match($booking['status']) {
                                            'confirmed' => 'success',
                                            'completed' => 'secondary',
                                            'cancelled' => 'danger',
                                            default => 'light',
                                        }) ?>"><?= e(ucfirst($booking['status'])) ?></span>
                                    </td>
                                    <td><?= e(date('M d, Y', strtotime($booking['created_at']))) ?></td>
                                    <td class="text-end">
                                        <a href="/bookings/manage/<?= (int)$booking['id'] ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center p-3 border rounded bg-light">
                    <p class="text-muted mb-0 small">No confirmed services in your history yet.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
