<?php
/**
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
                <div class="card-header">
                    <h1 class="h4 mb-0"><?= $pageTitle ?? 'Manage Content' ?></h1>
                </div>
                <div class="card-body">
                    <p>This is where you will manage your website's content. You can add, edit, or remove content from this page.</p>
                    <p>For example, you could manage:</p>
                    <ul>
                        <li>FAQs</li>
                        <li>About Us page content</li>
                        <li>Contact information</li>
                        <li>Homepage promotions</li>
                    </ul>
                    <p>This page is a placeholder for now. You can customize it with your specific content management features.</p>
                </div>
            </div>
        </div>
    </div>
</div>
