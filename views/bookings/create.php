<?php
/** @var array $pageTitle */
/** @var array $provider */
/** @var array $pets */
/** @var array $services */

?>

<div class="container my-5">
    <h1 class="mb-4 text-center">Book a Service with <?= e($provider['name']) ?></h1>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <?php if (empty($pets)) : ?>
                        <div class="alert alert-warning" role="alert">
                            You must <a href="/my-pets/create">add a pet</a> before you can book a service.
                        </div>
                    <?php else : ?>
                        <form action="/bookings" method="post">
                            <input type="hidden" name="provider_id" value="<?= e($provider['id']) ?>">

                            <div class="mb-3">
                                <label for="pet_id" class="form-label">Select Your Pet</label>
                                <select name="pet_id" id="pet_id" class="form-select">
                                    <?php foreach ($pets as $pet) : ?>
                                        <option value="<?= e($pet['id']) ?>"><?= e($pet['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="service_id" class="form-label">Select a Service</label>
                                <select name="service_id" id="service_id" class="form-select">
                                    <?php foreach ($services as $service) : ?>
                                        <option value="<?= e($service['id']) ?>"><?= e($service['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes for the Provider</label>
                                <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Let <?= e($provider['name']) ?> know about your pet's needs, habits, and any special instructions."></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Send Booking Request</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>