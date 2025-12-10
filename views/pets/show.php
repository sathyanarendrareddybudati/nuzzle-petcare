<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/pets">Browse Pets</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= e($pet['name']) ?></li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <?php if (!empty($pet['image_url'])): ?>
                <img src="<?= e($pet['image_url']) ?>" class="card-img-top" alt="<?= e($pet['name']) ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h1 class="h3 mb-1"><?= e($pet['name']) ?></h1>
                        <p class="text-muted mb-0"><?= e($pet['breed'] ?? 'Mixed') ?> • <?= e((string)$pet['age']) ?> years • <?= e($pet['gender']) ?></p>
                    </div>
                    <div class="text-end">
                        <div class="h4 text-primary mb-0">$<?= number_format((float)$pet['price'], 2) ?></div>
                        <div class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i><?= e($pet['location']) ?></div>
                    </div>
                </div>
                <h5 class="mb-2">About <?= e($pet['name']) ?></h5>
                <p><?= nl2br(e($pet['description'] ?? '')) ?></p>
                <div class="border-top pt-3 mt-3">
                    <div class="row">
                        <div class="col-md-6"><div class="text-muted small">Phone</div><div class="fw-medium"><?= e($pet['contact_phone'] ?? '') ?></div></div>
                        <div class="col-md-6"><div class="text-muted small">Email</div><div class="fw-medium"><?= e($pet['contact_email'] ?? '') ?></div></div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex mt-3">
                    <?php if (!empty($pet['contact_phone'])): ?>
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $pet['contact_phone'])) ?>" class="btn btn-primary"><i class="fas fa-phone-alt me-2"></i> Call Now</a>
                    <?php endif; ?>
                    <?php if (!empty($pet['contact_email'])): ?>
                    <a href="mailto:<?= e($pet['contact_email']) ?>" class="btn btn-outline-primary"><i class="fas fa-envelope me-2"></i> Send Email</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
