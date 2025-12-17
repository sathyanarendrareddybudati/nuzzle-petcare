

<div class="container py-5">
    <h1 class="mb-4">Find Pet Care Services</h1>

    <form method="get" class="row g-3 mb-4 align-items-center">
        <div class="col-md-4">
            <label for="location" class="visually-hidden">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Location (e.g., city)" value="<?= e($filters['location'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label for="availability" class="visually-hidden">Availability</label>
            <input type="text" class="form-control" id="availability" name="availability" placeholder="Availability (e.g., weekdays)" value="<?= e($filters['availability'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label for="sort" class="visually-hidden">Sort by</label>
            <select class="form-select" id="sort" name="sort">
                <option value="newest" <?= ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
                <option value="oldest" <?= ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' ?>>Oldest</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <?php if (empty($profiles)): ?>
        <div class="alert alert-info">No caretaker profiles found matching your criteria.</div>
    <?php else: ?>
        <div class="row gy-4">
            <?php foreach ($profiles as $profile): ?>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><a href="#"><?= e($profile['title']) ?></a></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Posted by <?= e($profile['username'] ?? 'Unknown User') ?></h6>
                            <p class="card-text"><strong>Location:</strong> <?= e($profile['location']) ?></p>
                            <p class="card-text"><strong>Availability:</strong> <?= e($profile['availability']) ?></p>
                            <p class="card-text"><?= nl2br(e(substr($profile['description'], 0, 150))) ?>...</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
