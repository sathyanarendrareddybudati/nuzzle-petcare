<div class="container py-5" style="max-width: 800px;">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Post a New Pet Service Ad</h1>
        <p class="text-muted">Fill out the details below to find the perfect caretaker for your needs.</p>
    </div>

    <div class="card p-4 p-md-5 shadow-sm">
        <form action="/my-ads/store" method="POST">
            <div class="mb-4">
                <label for="title" class="form-label fs-5">Ad Title</label>
                <input type="text" class="form-control form-control-lg" id="title" name="title" required placeholder="e.g., 'Dog Sitter Needed for Weekend'">
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="service_id" class="form-label fs-5">Service</label>
                    <select class="form-select form-select-lg" id="service_id" name="service_id" required>
                        <option value="" disabled selected>Select a service</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= e($service['id']) ?>"><?= e($service['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="location_id" class="form-label fs-5">Location</label>
                    <select class="form-select form-select-lg" id="location_id" name="location_id" required>
                        <option value="" disabled selected>Select a location</option>
                        <?php foreach ($locations as $location): ?>
                            <option value="<?= e($location['id']) ?>"><?= e($location['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fs-5">Description</label>
                <textarea class="form-control form-control-lg" id="description" name="description" rows="6" placeholder="Provide details about the service, pets involved, and any special requirements."></textarea>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="price" class="form-label fs-5">Compensation ($)</label>
                    <input type="number" class="form-control form-control-lg" id="price" name="price" step="0.01" required placeholder="e.g., 50.00">
                </div>
                <div class="col-md-4">
                    <label for="start_date" class="form-label fs-5">Start Date</label>
                    <input type="date" class="form-control form-control-lg" id="start_date" name="start_date" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label fs-5">End Date</label>
                    <input type="date" class="form-control form-control-lg" id="end_date" name="end_date" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="gender" class="form-label fs-5">Gender</label>
                <select class="form-select form-select-lg" id="gender" name="gender" required>
                    <option value="" disabled selected>Select a gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Create Ad</button>
            </div>
        </form>
    </div>
</div>