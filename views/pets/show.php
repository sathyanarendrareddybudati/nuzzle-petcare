<style>
    .pet-gallery-item {
        border-radius: 0.75rem;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.3s ease;
    }
    .pet-gallery-item.active, .pet-gallery-item:hover {
        border-color: #2e59d9;
    }

    .owner-card {
        background: #f8f9fc;
        border-radius: 1rem;
        padding: 1.5rem;
    }

    .action-card {
        background: #fff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        position: sticky;
        top: 2rem;
    }
</style>

<div class="container py-5">
    <div class="row g-5">
        <!-- Pet Details -->
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/pets">Browse Pets</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= e($pet['name']) ?></li>
                </ol>
            </nav>
            
            <!-- Image Gallery -->
            <div class="mb-4">
                <img src="<?= e($pet['image_url'] ?? 'https://via.placeholder.com/1200x800') ?>" 
                     class="img-fluid rounded-3" 
                     alt="Main image of <?= e($pet['name']) ?>" 
                     id="main-pet-image">
            </div>

            <!-- Details -->
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="fw-bold mb-1"><?= e($pet['name']) ?></h1>
                            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2"></i><?= e($pet['location'] ?? 'Location not provided') ?></p>
                        </div>
                        <span class="badge bg-primary rounded-pill fs-6 px-3 py-2"><?= e($pet['species']) ?></span>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3">About <?= e($pet['name']) ?></h5>
                    <p class="text-muted lh-lg">
                        <?= nl2br(e($pet['description'] ?? 'No description available.')) ?>
                    </p>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3">Details</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong class="d-block text-dark">Age</strong>
                            <span><?= e((string)$pet['age']) ?> years</span>
                        </div>
                        <div class="col-md-4">
                            <strong class="d-block text-dark">Gender</strong>
                            <span><?= e($pet['gender']) ?></span>
                        </div>
                        <div class="col-md-4">
                            <strong class="d-block text-dark">Breed</strong>
                            <span><?= e($pet['breed'] ?? 'Mixed') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action/Owner Card -->
        <div class="col-lg-4">
            <div class="action-card">
                <div class="text-center mb-4">
                    <h4 class="fw-bold">Interested?</h4>
                    <p class="text-muted">Contact the owner to learn more.</p>
                </div>
                
                <div class="d-grid gap-3">
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="fas fa-envelope me-2"></i> Express Interest
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-heart me-2"></i> Add to Favorites
                    </a>
                </div>
                
                <hr class="my-4">
                
                <div class="owner-card text-center">
                     <img src="https://i.pravatar.cc/150?u=<?= e($pet['owner_id'] ?? 'a') ?>" 
                         alt="Owner" 
                         class="img-fluid rounded-circle mb-3 mx-auto" 
                         style="width: 80px; height: 80px;">
                    <h6 class="fw-bold mb-1">Owner</h6>
                    <p class="text-muted small">Member since 2023</p>
                </div>
            </div>
        </div>
    </div>
</div>
