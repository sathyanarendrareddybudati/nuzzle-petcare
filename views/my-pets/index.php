<div class="container my-5">
    <h1 class="text-center mb-5">My Pet Dashboard</h1>

    <!-- My Pets Section -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">My Pets</h2>
            <a href="/my-pets/create" class="btn btn-primary btn-sm">+ Add New Pet</a>
        </div>
        <div class="card-body">
            <?php if (empty($pets)) : ?>
                <div class="text-center py-4">
                    <p class="mb-3">You haven't added any pets yet. Add one to get started!</p>
                </div>
            <?php else : ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($pets as $pet) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0"><?= e($pet['name']) ?></h5>
                                <small class="text-muted"><?= e($pet['species']) ?> - <?= e($pet['breed']) ?></small>
                            </div>
                            <div>
                                <a href="/my-pets/<?= $pet['id'] ?>/edit" class="btn btn-outline-secondary btn-sm">Edit</a>
                                <form action="/my-pets/<?= $pet['id'] ?>/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pet?');">
    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
</form>

                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- My Pet Ads Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">My Pet Ads</h2>
            <a href="/pets/create" class="btn btn-primary btn-sm">+ Post New Ad</a>
        </div>
        <div class="card-body">
            <?php if (empty($ads)) : ?>
                <div class="text-center py-4">
                    <p class="mb-3">You haven't posted any pet ads yet.</p>
                </div>
            <?php else : ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($ads as $ad) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <a href="/pets/<?= $ad['id'] ?>" class="text-decoration-none">
                                    <h5 class="mb-0"><?= e($ad['title']) ?></h5>
                                </a>
                                <small class="text-muted">Status: <span class="fw-bold text-<?= $ad['status'] === 'active' ? 'success' : 'warning' ?>"><?= e(ucfirst($ad['status'])) ?></span></small>
                            </div>
                            <div>
                                <a href="/pets/<?= $ad['id'] ?>/edit" class="btn btn-outline-secondary btn-sm">Edit</a>
                                <form action="/pets/<?= $ad['id'] ?>/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ad?');">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
