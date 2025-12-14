<?php require __DIR__ . '/../layouts/main.php'; ?>

<div class="container py-5">
    <div class="card">
        <div class="card-header">
            <h1 class="h3 mb-0"><?= e($ad['title']) ?></h1>
        </div>
        <div class="card-body">
            <p><?= e($ad['description']) ?></p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Species:</strong> <?= e($ad['species']) ?></li>
                <li class="list-group-item"><strong>Location:</strong> <?= e($ad['location']) ?></li>
                <li class="list-group-item"><strong>Price:</strong> $<?= e(number_format((float)($ad['price'] ?? 0), 2)) ?></li>
                <li class="list-group-item"><strong>Gender:</strong> <?= e($ad['gender']) ?></li>
                <li class="list-group-item"><strong>Posted By:</strong> <?= e($ad['user_name']) ?> (<?= e($ad['user_email']) ?>)</li>
                <li class="list-group-item"><strong>Ad Active From:</strong> <?= e(date('d M Y', strtotime($ad['start_date']))) ?></li>
                <li class="list-group-item"><strong>Ad Active Until:</strong> <?= e(date('d M Y', strtotime($ad['end_date']))) ?></li>
            </ul>
        </div>
        <div class="card-footer text-muted">
            Posted on <?= e(date('d M Y', strtotime($ad['created_at']))) ?>
        </div>
    </div>
    <a href="/pets" class="btn btn-secondary mt-3">Back to Browse</a>
</div>
