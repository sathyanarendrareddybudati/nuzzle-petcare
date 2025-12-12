<?php
// Caretaker Dashboard View
?>

<div class="container py-5">
    <h1 class="fw-bold">Caretaker Dashboard</h1>
    <p class="text-muted">Manage your schedule, applications, and profile.</p>

    <div class="row g-4 mt-4">
        <!-- Quick Stats -->
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Upcoming Jobs</h5>
                    <p class="fs-1 fw-bold">3</p>
                    <a href="/my-schedule" class="btn btn-primary">View Schedule</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Pending Applications</h5>
                    <p class="fs-1 fw-bold">2</p>
                    <a href="/my-applications" class="btn btn-primary">View Applications</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Profile Views</h5>
                    <p class="fs-1 fw-bold">128</p>
                    <a href="/profile" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Appointment -->
    <div class="mt-5">
        <h3 class="fw-bold">Next Appointment</h3>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Dog walking for <strong>Max</strong></h5>
                <p class="card-text text-muted">with John Doe on <strong>Tomorrow at 10:00 AM</strong></p>
                <a href="/appointment/123" class="btn btn-outline-primary">View Details</a>
            </div>
        </div>
    </div>
</div>
