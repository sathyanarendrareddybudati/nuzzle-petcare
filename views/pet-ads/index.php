<?php
/**
 * @var array $ads The pet ads to display.
 * @var array $filters The current filter values.
 * @var array $locations The list of available locations.
 * @var array $services The list of available services.
 * @var array $species The list of available species.
 * @var string $pageTitle The page title.
 */

$ads = $ads ?? [];
$filters = $filters ?? ['q' => '', 'service' => '', 'location' => '', 'species' => '', 'gender' => '', 'sort' => 'newest'];
$locations = $locations ?? [];
$services = $services ?? [];
$species = $species ?? [];

function sort_url($key, $currentFilters) {
    $q = $currentFilters; 
    $q['sort'] = $key; 
    return '/pets?' . http_build_query(array_filter($q));
}
?>

<section class="hero-section text-center mb-4">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3"><?= e($pageTitle ?? 'Find Pet Care Services') ?></h1>
        <p class="lead mb-4">Browse pet service ads from our community.</p>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form class="row g-3" method="GET" action="/pets">
                    <div class="col-md-3">
                        <input type="text" name="q" class="form-control" placeholder="Keyword (e.g., breed, service)"
                               value="<?= e($filters['q']) ?>">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="service">
                            <option value="" <?= $filters['service'] === '' ? 'selected' : '' ?>>All Services</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= e($service['id']) ?>" <?= (int)$filters['service'] === (int)$service['id'] ? 'selected' : '' ?>><?= e($service['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="location">
                            <option value="" <?= $filters['location'] === '' ? 'selected' : '' ?>>All Locations</option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= e($location['id']) ?>" <?= (int)$filters['location'] === (int)$location['id'] ? 'selected' : '' ?>><?= e($location['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="species">
                            <option value="" <?= $filters['species'] === '' ? 'selected' : '' ?>>All Species</option>
                            <?php foreach ($species as $spec): ?>
                                <option value="<?= e($spec['id']) ?>" <?= (int)$filters['species'] === (int)$spec['id'] ? 'selected' : '' ?>><?= e($spec['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="gender">
                            <option value="" <?= $filters['gender'] === '' ? 'selected' : '' ?>>Any Gender</option>
                            <option value="Male" <?= $filters['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $filters['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 h4">Available Pet Service Ads (<?= count($ads) ?>)</h2>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort By: <?= e(match($filters['sort']) {
                        'price_asc' => 'Price: Low to High',
                        'price_desc' => 'Price: High to Low',
                        default => 'Newest First',
                    }) ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item" href="<?= e(sort_url('newest', $filters)) ?>">Newest First</a></li>
                    <li><a class="dropdown-item" href="<?= e(sort_url('price_asc', $filters)) ?>">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="<?= e(sort_url('price_desc', $filters)) ?>">Price: High to Low</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($ads)): ?>
                <?php foreach ($ads as $ad): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0 ad-card">
                            <a href="/pets/<?= (int)$ad['id'] ?>">
                                <img src="<?= e($ad['image_url'] ?? '/img/placeholder.jpg') ?>" class="card-img-top ad-card-img" alt="<?= e($ad['title']) ?>">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><a href="/pets/<?= (int)$ad['id'] ?>" class="text-decoration-none text-dark stretched-link"><?= e($ad['title']) ?></a></h5>
                                <small class="text-muted mb-2">Service: <?= e($ad['service_name']) ?></small>
                                <p class="card-text text-muted small mb-3 flex-grow-1"><?= e(substr($ad['description'], 0, 80)) ?>...</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div>
                                        <div class="fw-bold fs-5 text-primary">$<?= number_format((float)($ad['price'] ?? 0), 2) ?></div>
                                        <div class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i><?= e($ad['location_name']) ?></div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">Posted by <?= e($ad['user_name']) ?></small>
                                        <?php if($ad['pet_name']): ?>
                                            <small class="d-block text-muted">For: <?= e($ad['pet_name']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded-3">
                        <i class="fas fa-paw fa-4x text-muted mb-4"></i>
                        <h3 class="fw-bold">No Ads Found</h3>
                        <p class="text-muted">Try adjusting your search filters or check back later.</p>
                        <a href="/pets" class="btn btn-primary mt-3"><i class="fas fa-sync-alt me-2"></i>Reset Filters</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>