<?php
$current_page = $_SERVER['REQUEST_URI'];
?>

<div class="list-group">
    <a href="/admin" class="list-group-item list-group-item-action <?= ($current_page === '/admin') ? 'active' : '' ?>">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a href="/admin/users" class="list-group-item list-group-item-action <?= (strpos($current_page, '/admin/users') !== false) ? 'active' : '' ?>">
        <i class="fas fa-users me-2"></i> Manage Users
    </a>
    <a href="/admin/ads" class="list-group-item list-group-item-action <?= (strpos($current_page, '/admin/ads') !== false) ? 'active' : '' ?>">
        <i class="fas fa-ad me-2"></i> Manage Pet Ads
    </a>
    <a href="/admin/content" class="list-group-item list-group-item-action <?= (strpos($current_page, '/admin/content') !== false) ? 'active' : '' ?>">
        <i class="fas fa-file-alt me-2"></i> Manage Content
    </a>
</div>
