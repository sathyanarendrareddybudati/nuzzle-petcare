<?php
/**
 * @var array $ads The list of pet ads.
 * @var string $pageTitle The page title.
 */
?>

<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-3">
            <?php include __DIR__ . '/../partials/admin_sidebar.php'; ?>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="h4 mb-0"><?= $pageTitle ?? 'Manage Pet Ads' ?></h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Posted</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($ads)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No pet ads found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($ads as $ad): ?>
                                        <tr>
                                            <th scope="row"><?= (int)$ad['id'] ?></th>
                                            <td><?= e($ad['title']) ?></td>
                                            <td><?= e($ad['service_name']) ?></td>
                                            <td><?= e($ad['user_name']) ?></td>
                                            <td><?= e($ad['location_name']) ?></td>
                                            <td><span class="badge bg-info"><?= e(ucfirst($ad['status'])) ?></span></td>
                                            <td><?= e(date('M d, Y', strtotime($ad['created_at']))) ?></td>
                                            <td>
                                                <a href="/pets/<?= (int)$ad['id'] ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
