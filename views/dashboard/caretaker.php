<div class="container py-5">
    <h1 class="mb-4 display-5 fw-bold">Service Provider Dashboard</h1>

    <div class="row g-4">
        <!-- My Caretaker Profile Card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-address-card fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">My Caretaker Profile</h5>
                    <?php if ($profile): ?>
                        <p class="text-muted">Your profile is visible to pet owners. Keep it updated to attract more clients.</p>
                        <a href="/caretaker/profile" class="btn btn-primary mt-3">Manage Profile</a>
                    <?php else: ?>
                        <p class="text-muted">Create your public profile to start offering your services and connecting with pet owners.</p>
                        <a href="/caretaker/profile" class="btn btn-success mt-3">Create Profile</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">My Bookings</h5>
                    <p class="text-muted">View and manage your service bookings. Track upcoming appointments and client requests.</p>
                    <a href="/bookings" class="btn btn-warning mt-3">Manage Bookings</a>
                </div>
            </div>
        </div>

        <!-- My Account Settings Card -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-cog fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Account Settings</h5>
                    <p class="text-muted">Manage your personal information, password, and other account settings.</p>
                    <a href="/profile" class="btn btn-info mt-3">My Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Ads List -->
    <!-- <div class="mt-5">
        <h2 class="mb-3 h4">My Recent Ads</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <?php if (empty($recentAds)): ?>
                    <div class="text-center p-4">
                        <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">You haven't posted any ads recently.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Service</th>
                                    <th>Location</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentAds as $ad): ?>
                                    <tr>
                                        <td><a href="/pets/<?= e($ad['id']) ?>" class="text-decoration-none"><?= e($ad['title']) ?></a></td>
                                        <td><span class="badge bg-secondary"><?= e($ad['service_name']) ?></span></td>
                                        <td><i class="fas fa-map-marker-alt me-1 text-muted"></i><?= e($ad['location']) ?></td>
                                        <td class="text-end">
                                            <a href="/pets/<?= e($ad['id']) ?>/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <a href="/pets/<?= e($ad['id']) ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div> -->
</div>
