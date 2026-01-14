<?php
/**
 * @var array $ad The pet ad to edit.
 * @var array $pets The user's pets.
 * @var array $services The available services.
 * @var array $locations The available locations.
 * @var array $categories The available pet categories.
 * @var string $pageTitle The page title.
 */
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h1 class="h4 mb-0"><?= $pageTitle ?? 'Edit Pet Ad' ?></h1>
                </div>
                <div class="card-body">
                    <form id="editAdForm" action="/pets/<?= (int)$ad['id'] ?>/update" method="POST">
                        <!-- Ad Type -->
                        <div class="mb-3">
                            <label class="form-label">What are you looking for?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ad_type" id="seeking_care" value="care" <?= $ad['ad_type'] === 'care' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="seeking_care">I need a carer for my pet</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ad_type" id="providing_service" value="service" <?= $ad['ad_type'] === 'service' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="providing_service">I'm a carer providing a service</label>
                                </div>
                            </div>
                        </div>

                        <!-- Ad Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Ad Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= e($ad['title']) ?>" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?= e($ad['description']) ?></textarea>
                        </div>

                        <!-- Pet Selection (for 'care' ads) -->
                        <div id="pet-selection" class="mb-3" style="display: <?= $ad['ad_type'] === 'care' ? 'block' : 'none' ?>;">
                            <label for="pet_id" class="form-label">Select Your Pet</label>
                            <select class="form-select" id="pet_id" name="pet_id">
                                <option value="">Select a pet</option>
                                <?php foreach ($pets as $pet): ?>
                                    <option value="<?= (int)$pet['id'] ?>" <?= (int)$ad['pet_id'] === (int)$pet['id'] ? 'selected' : '' ?>><?= e($pet['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Service Selection -->
                        <div class="mb-3">
                            <label for="service_id" class="form-label">Service</label>
                            <select class="form-select" id="service_id" name="service_id" required>
                                <?php foreach ($services as $service): ?>
                                    <option value="<?= (int)$service['id'] ?>" <?= (int)$ad['service_id'] === (int)$service['id'] ? 'selected' : '' ?>><?= e($service['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="mb-3">
                            <label for="location_id" class="form-label">Location</label>
                            <select class="form-select" id="location_id" name="location_id" required>
                                <?php foreach ($locations as $location): ?>
                                    <option value="<?= (int)$location['id'] ?>" <?= (int)$ad['location_id'] === (int)$location['id'] ? 'selected' : '' ?>><?= e($location['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (per day)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" value="<?= e($ad['price']) ?>" required>
                            </div>
                        </div>

                        <!-- Dates (for 'care' ads) -->
                        <div id="care-dates" class="row mb-3" style="display: <?= $ad['ad_type'] === 'care' ? 'block' : 'none' ?>;">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= e($ad['start_date']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= e($ad['end_date']) ?>">
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Ad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adTypeRadios = document.querySelectorAll('input[name="ad_type"]');
    const petSelection = document.getElementById('pet-selection');
    const careDates = document.getElementById('care-dates');

    function toggleFields() {
        if (document.querySelector('input[name="ad_type"]:checked').value === 'care') {
            petSelection.style.display = 'block';
            careDates.style.display = 'flex';
        } else {
            petSelection.style.display = 'none';
            careDates.style.display = 'none';
        }
    }

    adTypeRadios.forEach(radio => {
        radio.addEventListener('change', toggleFields);
    });

    // Initial check
    toggleFields();
});
</script>