<?php
// Admin Dashboard View
// This is a placeholder for the admin content.
?>

<div class="container py-5">
    <h1 class="fw-bold">Admin Dashboard</h1>
    <p class="text-muted">Welcome to the admin area. Here you can manage users, pets, and site content.</p>

    <div class="row g-4 mt-4">
        <div class="col-md-6 col-lg-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">User Management</h5>
                    <p class="card-text">View, edit, or ban users.</p>
                    <a href="/admin/users" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-paw fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Pet Listings</h5>
                    <p class="card-text">Moderate and manage pet ads.</p>
                    <a href="/admin/pets" class="btn btn-primary">Manage Pets</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Content Management</h5>
                    <p class="card-text">Edit FAQs, terms, and more.</p>
                    <a href="/admin/content" class="btn btn-primary">Manage Content</a>
                </div>
            </div>
        </div>
    </div>
</div>
