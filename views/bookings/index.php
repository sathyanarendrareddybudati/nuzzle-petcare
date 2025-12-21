<?php
/**
 * @var array $bookedServices The services booked by the current user.
 * @var array $serviceRequests The service requests for the current user's ads.
 * @var string $pageTitle The page title.
 */
?>

<div class="container my-5">
    <h1 class="text-center mb-5"><?= $pageTitle ?? 'My Bookings' ?></h1>

    <!-- Service Requests for My Ads -->
    <div class="card shadow-sm mb-5">
        <div class="card-header">
            <h2 class="h4 mb-0">Service Requests for My Ads</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($serviceRequests)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ad Title</th>
                                <th>Requester</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($serviceRequests as $request): ?>
                                <tr>
                                    <td><a href="/pets/<?= (int)$request['pet_ad_id'] ?>"><?= e($request['ad_title']) ?></a></td>
                                    <td><?= e($request['provider_name']) ?></td>
                                    <td><span class="badge bg-<?= e(match($request['status']) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'completed' => 'primary',
                                        'cancelled' => 'secondary',
                                        default => 'light',
                                    }) ?>"><?= e(ucfirst($request['status'])) ?></span></td>
                                    <td><?= e(date('M d, Y', strtotime($request['created_at']))) ?></td>
                                    <td class="text-end">
                                        <a href="/bookings/manage/<?= (int)$request['id'] ?>" class="btn btn-sm btn-outline-primary">Manage</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center p-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">You have no service requests for your ads.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- My Booked Services -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="h4 mb-0">My Booked Services</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($bookedServices)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ad Title</th>
                                <th>Ad Owner</th>
                                <th>Status</th>
                                <th>Date Booked</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookedServices as $booking): ?>
                                <tr>
                                    <td><a href="/pets/<?= (int)$booking['pet_ad_id'] ?>"><?= e($booking['ad_title']) ?></a></td>
                                    <td><?= e($booking['ad_owner_name']) ?></td>
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
</div>
