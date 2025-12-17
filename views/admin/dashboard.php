<?php
// Admin Dashboard View
$pageTitle = 'Admin Dashboard';

// Mock data for dashboard widgets
$totalUsers = 150;
$totalAds = 320;
$pendingApprovals = 5;
$reportedContent = 2;

?>

<div class="container my-5">
    <h1 class="mb-4"><i class="fas fa-user-shield me-2"></i>Admin Dashboard</h1>

    <!-- Dashboard Widgets -->
    <div class="row g-4">
        <!-- Total Users -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Total Users</h5>
                    <p class="display-4 fw-bold"><?= $totalUsers ?></p>
                    <a href="/admin/users" class="btn btn-outline-primary">Manage Users</a>
                </div>
            </div>
        </div>

        <!-- Total Ads -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Total Ads Posted</h5>
                    <p class="display-4 fw-bold"><?= $totalAds ?></p>
                    <a href="/admin/ads" class="btn btn-outline-primary">Manage Ads</a>
                </div>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Pending Approvals</h5>
                    <p class="display-4 fw-bold text-warning"><?= $pendingApprovals ?></p>
                    <a href="/admin/approvals" class="btn btn-warning">Review Now</a>
                </div>
            </div>
        </div>

        <!-- Reported Content -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">Reported Content</h5>
                    <p class="display-4 fw-bold text-danger"><?= $reportedContent ?></p>
                    <a href="/admin/reports" class="btn btn-danger">View Reports</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-5">
        <h3 class="mb-3">Quick Actions</h3>
        <div class="list-group">
            <a href="/admin/users/create" class="list-group-item list-group-item-action"><i class="fas fa-user-plus me-2"></i>Create a New User</a>
            <a href="/admin/settings" class="list-group-item list-group-item-action"><i class="fas fa-cog me-2"></i>Platform Settings</a>
            <a href="/admin/reports" class="list-group-item list-group-item-action"><i class="fas fa-flag me-2"></i>View User Reports</a>
        </div>
    </div>
</div>
