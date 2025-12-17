<div class="container py-5">
    <h1 class="mb-4">My Caretaker Profile</h1>

    <form action="/caretaker/profile/store" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Profile Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= e($profile['title'] ?? '') ?>" required>
            <div class="form-text">A short, descriptive title for your profile (e.g., "Experienced Dog Walker").</div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">About Me</label>
            <textarea class="form-control" id="description" name="description" rows="5"><?= e($profile['description'] ?? '') ?></textarea>
            <div class="form-text">Tell pet owners about your experience, skills, and why you'd be a great caretaker for their pets.</div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?= e($profile['location'] ?? '') ?>">
                <div class="form-text">The general area where you provide services (e.g., "San Francisco, CA").</div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="availability" class="form-label">Availability</label>
                <input type="text" class="form-control" id="availability" name="availability" value="<?= e($profile['availability'] ?? '') ?>">
                <div class="form-text">Your general availability (e.g., "Weekdays", "Weekends Only").</div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Profile</button>
        <a href="/dashboard/caretaker" class="btn btn-secondary">Cancel</a>
    </form>
</div>
