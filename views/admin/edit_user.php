<?php
/**
 * @var array $user The user to edit.
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
                    <h1 class="h4 mb-0"><?= $pageTitle ?? 'Edit User' ?></h1>
                    <a href="/admin/users" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Users
                    </a>
                </div>
                <div class="card-body">
                    <form action="/admin/users/update/<?= (int)$user['id'] ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= e($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= e($user['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="user" <?= ($user['role'] === 'user') ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
