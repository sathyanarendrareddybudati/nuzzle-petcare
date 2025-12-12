<?php
// Owner Dashboard View
?>

<div class="container py-5">
    <h1 class="fw-bold">Owner Dashboard</h1>
    <p class="text-muted">Manage your pets and view applications from caretakers.</p>

    <div class="row g-4 mt-4">
        <!-- Quick Stats -->
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Active Listings</h5>
                    <p class="fs-1 fw-bold">2</p>
                    <a href="/my-pets" class="btn btn-primary">Manage Pets</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">New Applications</h5>
                    <p class="fs-1 fw-bold">5</p>
                    <a href="/applications" class="btn btn-primary">View Applications</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Messages</h5>
                    <p class="fs-1 fw-bold">3</p>
                    <a href="/messages" class="btn btn-primary">Read Messages</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mt-5">
        <h3 class="fw-bold">Recent Activity</h3>
        <div class="list-group mt-3">
            <a href="#" class="list-group-item list-group-item-action">A new caretaker applied to care for <strong>Max</strong>.</a>
            <a href="#" class="list-group-item list-group-item-action">You received a new message about <strong>Bella</strong>.</a>
            <a href="#" class="list-group-item list-group-item-action">Your listing for <strong>Max</strong> was viewed 25 times today.</a>
        </div>
    </div>
</div>
