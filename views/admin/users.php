<?php
/**
 * @var array $users The list of users.
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
                    <h1 class="h4 mb-0"><?= $pageTitle ?? 'Manage Users' ?></h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Joined</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No users found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <th scope="row"><?= (int)$user['id'] ?></th>
                                            <td><?= e($user['name']) ?></td>
                                            <td><?= e($user['email']) ?></td>
                                            <td><span class="badge bg-<?= e($user['role'] === 'admin' ? 'danger' : 'secondary') ?>"><?= e(ucfirst($user['role'])) ?></span></td>
                                            <td><?= e(date('M d, Y', strtotime($user['created_at']))) ?></td>
                                            <td>
                                                <a href="/admin/users/edit/<?= (int)$user['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="/admin/users/delete/<?= (int)$user['id'] ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                                    </button>
                                                </form>
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
