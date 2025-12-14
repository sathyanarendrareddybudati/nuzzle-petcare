<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Pet Ads</h1>
        <a href="/pets/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Post a New Ad
        </a>
    </div>

    <?php if (empty($ads)): ?>
        <div class="text-center">
            <p>You have not posted any ads yet.</p>
            <a href="/pets/create" class="btn btn-primary">Create Your First Ad</a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Pet Name</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ads as $ad): ?>
                                <tr>
                                    <td>
                                        <a href="/pets/<?= $ad['id'] ?>" class="text-decoration-none fw-bold"><?= e($ad['title']) ?></a>
                                    </td>
                                    <td><?= e($ad['pet_name']) ?></td>
                                    <td><?= e(ucfirst(str_replace('_', ' ', $ad['ad_type']))) ?></td>
                                    <td>$<?= e(number_format($ad['price'], 2)) ?></td>
                                    <td class="text-end">
                                        <a href="/pets/<?= $ad['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="/pets/<?= $ad['id'] ?>/edit" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <form action="/pets/<?= $ad['id'] ?>/delete" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ad?');">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
