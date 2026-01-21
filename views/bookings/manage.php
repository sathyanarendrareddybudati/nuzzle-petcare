<?php
/**
 * @var array $booking The booking details.
 * @var string $pageTitle The page title.
 * @var bool $isServiceRequestor Whether the current user is the one who requested the service.
 * @var bool $isServiceProvider Whether the current user is the one providing the service.
 */
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0"><?= $pageTitle ?? 'Manage Booking' ?></h1>
                    <a href="/bookings" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to My Bookings
                    </a>
                </div>
                <div class="card-body">
                    <!-- Ad and User Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold">Booking Details</h5>
                            <p class="mb-1"><strong>Service:</strong> <?= e($booking['service_name']) ?></p>
                            <p class="mb-1"><strong>For Pet:</strong> <?= e($booking['pet_name'] ?? 'N/A') ?></p>
                            <p class="mb-1"><strong>Owner:</strong> <?= e($booking['owner_name']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold">Provider Details</h5>
                            <p class="mb-1"><strong>Name:</strong> <?= e($booking['provider_name']) ?></p>
                        </div>
                    </div>

                    <hr>

                    <!-- Booking Status and Actions -->
                    <div class="text-center">
                        <h5 class="fw-bold">Booking Status</h5>
                        <p class="fs-4"><span class="badge bg-<?= e(match($booking['status']) {
                            'pending' => 'warning',
                            'confirmed' => 'success',
                            'completed' => 'primary',
                            'cancelled' => 'secondary',
                            default => 'light',
                        }) ?>"><?= e(ucfirst($booking['status'] ?? '')) ?></span></p>

                        <div class="mt-4">
                            <form method="POST" action="/bookings/update/<?= (int)$booking['id'] ?>" class="d-inline">
                                <?php 
                                    // Robust check for ad type
                                    $adType = $booking['ad_type'] ?? '';
                                    $isServiceRequest = ($adType === 'service_request');
                                    
                                    // Determine who is allowed to confirm this booking:
                                    // 1. If it's a response to a service request (provider offering to owner), the owner (client) confirms.
                                    // 2. Otherwise (normal booking of a caretaker), the provider (caretaker) confirms.
                                    if ($isServiceRequest) {
                                        $canConfirm = $isServiceRequestor;
                                    } else {
                                        $canConfirm = $isServiceProvider;
                                    }
                                ?>

                                <?php if ($canConfirm && $booking['status'] === 'pending'): ?>
                                    <button type="submit" name="status" value="confirmed" class="btn btn-success btn-lg mx-1">
                                        <i class="fas fa-check me-2"></i> Confirm Booking
                                    </button>
                                <?php endif; ?>

                                <?php if (($isServiceProvider || $isServiceRequestor) && in_array($booking['status'], ['pending', 'confirmed'])): ?>
                                    <button type="submit" name="status" value="cancelled" class="btn btn-danger btn-lg mx-1">Cancel Booking</button>
                                <?php endif; ?>

                                <?php if ($isServiceRequestor && $booking['status'] === 'confirmed'): ?>
                                    <button type="submit" name="status" value="completed" class="btn btn-primary btn-lg mx-1">Mark as Completed</button>
                                <?php endif; ?>
                            </form>

                            <!-- Rating Action -->
                            <?php if ($isServiceRequestor && $booking['status'] === 'completed' && empty($booking['rating'])): ?>
                                <button type="button" class="btn btn-warning btn-lg mx-1" data-bs-toggle="modal" data-bs-target="#ratingModal">Leave a Rating</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Notes/Review Section -->
                    <?php if (!empty($booking['notes'])): ?>
                    <div class="mt-4 pt-4 border-top">
                        <h5 class="fw-bold">Review & Notes</h5>
                        <?php if (!empty($booking['rating'])): ?>
                            <div class="mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?><i class="fas fa-star text-<?= $i <= $booking['rating'] ? 'warning' : 'muted' ?>"></i><?php endfor; ?>
                            </div>
                        <?php endif; ?>
                        <p class="text-muted fst-italic">"<?= e($booking['notes']) ?>"</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating Modal -->
<?php if ($isServiceRequestor && $booking['status'] === 'completed' && empty($booking['rating'])) : ?>
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/bookings/rate/<?= (int)$booking['id'] ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="ratingModalLabel">Rate This Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5)</label>
                        <select class="form-select" id="rating" name="rating" required>
                            <option value="5">5 Stars (Excellent)</option>
                            <option value="4">4 Stars (Good)</option>
                            <option value="3">3 Stars (Average)</option>
                            <option value="2">2 Stars (Fair)</option>
                            <option value="1">1 Star (Poor)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="review" class="form-label">Review (Optional)</label>
                        <textarea class="form-control" id="review" name="review" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
