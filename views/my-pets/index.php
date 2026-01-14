<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold">My Pet Dashboard</h1>
        <a href="/my-pets/create" class="btn btn-primary">+ Add New Pet</a>
    </div>

    <div class="row g-4">
        <!-- My Pets Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <h2 class="h4 mb-0">My Pets</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($pets)) : ?>
                        <div class="text-center p-5">
                            <i class="fas fa-paw fa-4x text-muted mb-3"></i>
                            <h3 class="fw-bold">No Pets Yet</h3>
                            <p class="text-muted">Add your furry, feathery, or scaly friends to get started!</p>
                            <a href="/my-pets/create" class="btn btn-primary mt-3">Add First Pet</a>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;"></th>
                                        <th>Name</th>
                                        <th>Species</th>
                                        <th>Breed</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pets as $pet) : ?>
                                        <tr>
                                            <td>
                                                <img src="<?= e($pet['image_url'] ?? '/img/placeholder.jpg') ?>" alt="<?= e($pet['name']) ?>" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td><strong class="text-primary"><?= e($pet['name']) ?></strong></td>
                                            <td><?= e($pet['species']) ?></td>
                                            <td><?= e($pet['breed']) ?></td>
                                            <td class="text-end">
                                                <a href="/my-pets/<?= $pet['id'] ?>/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form action="/my-pets/<?= $pet['id'] ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Side Cards -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
                    <h5 class="card-title">My Bookings</h5>
                    <p class="text-muted">View and manage your upcoming and past service bookings.</p>
                    <a href="/bookings" class="btn btn-success mt-2">View Bookings</a>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-circle fa-3x text-info mb-3"></i>
                    <h5 class="card-title">My Profile</h5>
                    <p class="text-muted">Keep your personal information up to date.</p>
                    <a href="/profile" class="btn btn-info mt-2">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- My Pet Ads Section -->
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">My Pet Ads</h2>
            <a href="/pets/create" class="btn btn-success btn-sm">+ Post New Ad</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <?php if (empty($ads)) : ?>
                    <div class="text-center p-4">
                        <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">You haven't posted any ads for your pets yet.</p>
                    </div>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ads as $ad) : ?>
                                    <tr>
                                        <td><a href="/pets/<?= $ad['id'] ?>" class="text-decoration-none"><?= e($ad['title']) ?></a></td>
                                        <td><span class="badge bg-secondary"><?= e($ad['service_name']) ?></span></td>
                                        <td><span class="badge bg-<?= e($ad['status'] === 'open' ? 'success' : 'secondary') ?>"><?= e(ucfirst($ad['status'])) ?></span></td>
                                        <td class="text-end">
                                            <a href="/pets/<?= $ad['id'] ?>/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
