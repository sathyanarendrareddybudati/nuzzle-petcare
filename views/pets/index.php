<?php
$filters = $filters ?? ['species' => '', 'gender' => '', 'q' => '', 'sort' => 'newest'];
function sort_url($key, $currentFilters) {
    $queryParams = array_merge($currentFilters, ['sort' => $key]);
    return '/pets?' . http_build_query($queryParams);
}
?>

<style>
    .browse-hero {
        background-color: #e9ecef;
        padding: 4rem 0;
    }

    .filter-sidebar {
        background: #fff;
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .pet-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .pet-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
    }
    .pet-card-img {
        height: 250px;
        object-fit: cover;
    }

</style>

<section class="browse-hero text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Find Your Perfect Companion</h1>
        <p class="lead text-muted">Browse our listings to find the right pet for you.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <h5 class="mb-3">Filters</h5>
                    <form method="GET" action="/pets">
                        <div class="mb-3">
                            <label for="q" class="form-label fw-medium">Keyword</label>
                            <input type="text" name="q" id="q" class="form-control" placeholder="Name, breed, etc."
                                   value="<?= e($filters['q']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="species" class="form-label fw-medium">Species</label>
                            <select class="form-select" name="species" id="species">
                                <option value="" <?= $filters['species'] === '' ? 'selected' : ''; ?>>All Species</option>
                                <?php foreach (['Dog', 'Cat', 'Bird', 'Other'] as $sp): ?>
                                    <option value="<?= e($sp) ?>" <?= $filters['species'] === $sp ? 'selected' : ''; ?>><?= e($sp) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label fw-medium">Gender</label>
                            <select class="form-select" name="gender" id="gender">
                                <option value="" <?= $filters['gender'] === '' ? 'selected' : ''; ?>>Any Gender</option>
                                <?php foreach (['Male', 'Female', 'Other'] as $g): ?>
                                    <option value="<?= e($g) ?>" <?= $filters['gender'] === $g ? 'selected' : ''; ?>><?= e($g) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid">
                             <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-2"></i>Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pet Listings -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Available Pets (<?= count($pets) ?>)</h3>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Sort By: <strong><?= e(ucfirst($filters['sort'])) ?></strong>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item" href="<?= e(sort_url('newest', $filters)) ?>">Newest First</a></li>
                             <li><a class="dropdown-item" href="<?= e(sort_url('name_asc', $filters)) ?>">Name (A-Z)</a></li>
                            <li><a class="dropdown-item" href="<?= e(sort_url('name_desc', $filters)) ?>">Name (Z-A)</a></li>
                        </ul>
                    </div>
                </div>

                <div class="row g-4">
                    <?php if (!empty($pets)): ?>
                        <?php foreach ($pets as $pet): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card pet-card h-100">
                                    <a href="/pets/<?= (int)$pet['id'] ?>" class="text-decoration-none">
                                        <img src="<?= e($pet['image_url'] ?? 'https://via.placeholder.com/400x300') ?>" class="card-img-top pet-card-img" alt="<?= e($pet['title'] ?? 'Pet') ?>">
                                    </a>
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h5 class="card-title fw-bold text-dark"><?= e($pet['title'] ?? 'Untitled Pet') ?></h5>
                                            <span class="badge bg-info-light text-info rounded-pill"><?= e($pet['category_id'] ?? 'Category') ?></span>
                                        </div>
                                        <p class="card-text text-muted small flex-grow-1">
                                            <i class="fas fa-map-marker-alt me-2"></i><?= e($pet['location'] ?? 'Location unknown') ?>
                                        </p>
                                        <a href="/pets/<?= (int)$pet['id'] ?>" class="btn btn-primary stretched-link mt-2">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center p-5 bg-light rounded">
                                <i class="fas fa-paw fa-3x text-muted mb-3"></i>
                                <h4 class="fw-bold">No Pets Found</h4>
                                <p class="text-muted">Your search did not return any results. Try broadening your criteria.</p>
                                <a href="/pets" class="btn btn-primary mt-2"><i class="fas fa-sync-alt me-2"></i>Reset Filters</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
