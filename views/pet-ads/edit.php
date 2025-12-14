<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center mb-4"><?= $pageTitle ?? 'Edit Pet Ad' ?></h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/pets/<?= $ad['id'] ?>" method="POST">
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= e($ad['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required><?= e($ad['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= e($ad['price']) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Ad</button>
                <a href="/my-ads" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
