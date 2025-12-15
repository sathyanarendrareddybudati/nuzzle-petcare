<?php
// Owner Dashboard View
?>

<div class="container py-5">
    <h1 class="fw-bold">Owner Dashboard</h1>
    <p class="text-muted">Manage your ads and view applications from caretakers.</p>

    <div class="row g-4 mt-4">
        <!-- Quick Stats -->
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Your Ads</h5>
                    <p class="fs-1 fw-bold"><?= count($recentAds ?? []) ?></p>
                    <a href="/my-pets" class="btn btn-primary">Manage Ads</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">New Applications</h5>
                    <p class="fs-1 fw-bold">0</p>
                    <a href="#" class="btn btn-secondary disabled">View Applications</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Messages</h5>
                    <p class="fs-1 fw-bold">0</p>
                    <a href="/messages" class="btn btn-secondary disabled">Read Messages</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Ads -->
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Your Recent Ads</h3>
            <a href="/my-pets/create" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Create New Ad
            </a>
        </div>

        <?php if (empty($recentAds)): ?>
            <div class="text-center py-5 bg-light rounded">
                <p class="lead">You haven't posted any ads yet.</p>
                <a href="/my-pets/create" class="btn btn-lg btn-primary">Post Your First Ad</a>
            </div>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($recentAds as $ad): ?>
                    <a href="/pets/<?= e($ad['id']) ?>"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1"><?= e($ad['title']) ?></h5>
                            <p class="mb-1 text-muted">
                                <span class="me-3">
                                    <i class="fas fa-concierge-bell me-2"></i>
                                    Service: <?= e($ad['service_name']) ?>
                                </span>
                                <span class="me-3">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Location: <?= e($ad['location_name']) ?>
                                </span>
                                <span>
                                    <i class="fas fa-dollar-sign me-2"></i>
                                    Cost: <?= e($ad['cost']) ?>
                                </span>
                            </p>
                        </div>
                        <span class="badge bg-primary rounded-pill">View</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>