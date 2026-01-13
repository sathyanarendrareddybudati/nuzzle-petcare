<?php

use App\Core\Session;

$user = Session::get('user');
$pageTitle = e($profile['title']);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1><?= e($profile['title']) ?></h1>
                </div>
                <div class="card-body">
                    <p><strong>Location:</strong> <?= e($profile['location_name']) ?></p>
                    <p><strong>Availability:</strong> <?= e($profile['availability']) ?></p>
                    <hr>
                    <p><?= nl2br(e($profile['description'])) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Contact <?= e($profile['user_name']) ?></h3>
                </div>
                <div class="card-body">
                    <?php if ($user && $user['id'] !== $profile['user_id']): ?>
                        <a href="/messages/chat/<?= e($profile['user_id']) ?>" class="btn btn-success w-100 mb-2">Send Message</a>
                        <a href="/bookings/create/<?= e($profile['user_id']) ?>" class="btn btn-primary w-100">Book Now</a>
                    <?php elseif ($user && $user['id'] === $profile['user_id']): ?>
                        <p class="text-muted">This is your profile.</p>
                        <a href="/caretaker/profile" class="btn btn-secondary w-100">Edit Your Profile</a>
                    <?php else: ?>
                        <p><a href="/login">Log in</a> to contact this caretaker.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>