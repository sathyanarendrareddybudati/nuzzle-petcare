<?php
/**
 * @var array $clientBookings The services the current user has booked from others.
 * @var array $bookedServices The services the current user is confirmed to provide.
 * @var array $serviceRequests The pending service requests for the current user's ads.
 * @var string $pageTitle The page title.
 */

// Initialize variables to prevent errors if they are not passed
$clientBookings = $clientBookings ?? [];
$bookedServices = $bookedServices ?? [];
$serviceRequests = $serviceRequests ?? [];

?>

<div class="container my-5">
    <h1 class="text-center mb-5"><?= e($pageTitle ?? 'My Bookings') ?></h1>

    <!-- My Bookings (as a Client) -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h2 class="h4 mb-0">My Booked Services</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($clientBookings)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Provider</th>
                                <th>Status</th>
                                <th>Date Booked</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientBookings as $booking): ?>
                                <tr>
                                    <td><?= e($booking['service_name']) ?></td>
                                    <td><?= e($booking['provider_name']) ?></td>
                                    <td><span class="badge bg-<?= e(match($booking['status']) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'completed' => 'primary',
                                        'cancelled' => 'secondary',
                                        default => 'light',
                                    }) ?>"><?= e(ucfirst($booking['status'])) ?></span></td>
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
                    <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">You have not booked any services yet.</p>
                    <a href="/pets" class="btn btn-primary mt-3">Browse Services</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- My Provider Dashboard -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h2 class="h4 mb-0">Provider Dashboard</h2>
        </div>
        <div class="card-body">
            <h3 class="h5 mb-3">Incoming Service Requests</h3>
            <?php if (!empty($serviceRequests)): ?>
                <div class="table-responsive mb-4">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($serviceRequests as $request): ?>
                                <tr>
                                    <td><?= e($request['service_name']) ?></td>
                                    <td><?= e($request['requester_name']) ?></td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td><?= e(date('M d, Y', strtotime($request['created_at']))) ?></td>
                                    <td class="text-end">
                                        <a href="/bookings/manage/<?= (int)$request['id'] ?>" class="btn btn-sm btn-outline-primary">Review</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center p-4 border-bottom mb-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">You have no new service requests.</p>
                </div>
            <?php endif; ?>

            <h3 class="h5 mb-3">My Confirmed Services</h3>
             <?php if (!empty($bookedServices)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Date Confirmed</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookedServices as $booking): ?>
                                <tr>
                                    <td><?= e($booking['service_name']) ?></td>
                                    <td><?= e($booking['client_name']) ?></td>
                                     <td><span class="badge bg-<?= e(match($booking['status']) {
                                        'confirmed' => 'success',
                                        'completed' => 'primary',
                                        'cancelled' => 'secondary',
                                        default => 'light',
                                    }) ?>"><?= e(ucfirst($booking['status'])) ?></span></td>
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
                     <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">You have no confirmed services.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
