<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center mb-4"><?= $pageTitle ?? 'My Pets' ?></h1>

    <?php if (empty($pets)): ?>
        <div class="text-center">
            <p>You haven't added any pets yet.</p>
            <a href="/my-pets/create" class="btn btn-primary">Add a New Pet</a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($pets as $pet): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= e($pet['image_url'] ?? 'https://via.placeholder.com/300x200') ?>" class="card-img-top" alt="<?= e($pet['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= e($pet['name']) ?></h5>
                            <p class="card-text"><?= e($pet['breed']) ?></p>
                            <a href="/my-pets/<?= $pet['id'] ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
