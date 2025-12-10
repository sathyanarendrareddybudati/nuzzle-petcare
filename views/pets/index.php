<?php
$filters = $filters ?? ['species'=>'','gender'=>'','q'=>'','sort'=>'newest'];
function sort_url($key) {
    $q = $_GET; $q['sort'] = $key; return '/pets?' . http_build_query($q);
}
?>
<section class="hero-section text-center mb-4">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">Find Your Perfect Pet</h1>
        <p class="lead mb-4">Browse pets and refine your search</p>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form class="row g-3" method="GET" action="/pets">
                    <div class="col-md-4">
                        <input type="text" name="q" class="form-control" placeholder="Search name, breed, location"
                               value="<?= e($filters['q']) ?>">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="species">
                            <option value="" <?= $filters['species']===''?'selected':''; ?>>All Species</option>
                            <?php foreach (['Dog','Cat','Bird','Other'] as $sp): ?>
                                <option value="<?= e($sp) ?>" <?= $filters['species']===$sp?'selected':''; ?>><?= e($sp) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="gender">
                            <option value="" <?= $filters['gender']===''?'selected':''; ?>>Any Gender</option>
                            <?php foreach (['Male','Female','Other'] as $g): ?>
                                <option value="<?= e($g) ?>" <?= $filters['gender']===$g?'selected':''; ?>><?= e($g) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Available Pets</h2>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort By: <?= $filters['sort']==='price_asc'?'Price: Low to High':($filters['sort']==='price_desc'?'Price: High to Low':'Newest First') ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item" href="<?= e(sort_url('newest')) ?>">Newest First</a></li>
                    <li><a class="dropdown-item" href="<?= e(sort_url('price_asc')) ?>">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="<?= e(sort_url('price_desc')) ?>">Price: High to Low</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($pets)): ?>
                <?php foreach ($pets as $pet): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <?php if (!empty($pet['image_url'])): ?>
                                <img src="<?= e($pet['image_url']) ?>" class="card-img-top" alt="<?= e($pet['name']) ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0"><?= e($pet['name']) ?></h5>
                                    <span class="badge bg-primary"><?= e($pet['species']) ?></span>
                                </div>
                                <p class="text-muted mb-2">
                                    <?= e($pet['breed'] ?? 'Mixed') ?>
                                    <span class="mx-2">•</span>
                                    <?= e((string)($pet['age'] ?? 0)) ?> years
                                    <span class="mx-2">•</span>
                                    <?= e($pet['gender']) ?>
                                </p>
                                <p class="card-text text-muted small mb-3">
                                    <?php
                                        $desc = $pet['description'] ?? '';
                                        $desc = is_string($desc) ? $desc : '';
                                        echo e(strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc);
                                    ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="pet-price">$<?= number_format((float)($pet['price'] ?? 0), 2) ?></div>
                                        <?php if (!empty($pet['location'])): ?>
                                            <div class="pet-location"><i class="fas fa-map-marker-alt me-1"></i><?= e($pet['location']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <a href="/pets/<?= (int)$pet['id'] ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded">
                        <i class="fas fa-paw fa-3x text-muted mb-4"></i>
                        <h3>No Pets Found</h3>
                        <p class="text-muted">Try adjusting your filters.</p>
                        <a href="/pets" class="btn btn-primary mt-3"><i class="fas fa-sync me-2"></i>Reset Filters</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>