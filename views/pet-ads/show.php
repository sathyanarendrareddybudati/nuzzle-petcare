<style>
    .ad-details-card {
        background: #fff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .poster-card {
        background: #f8f9fc;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    .pet-image-container {
        width: 150px;
        height: 150px;
        border-radius: .5rem;
        overflow: hidden;
        margin-right: 1.5rem;
        float: left;
    }
    .pet-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/pets">Browse Ads</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= e($ad['title']) ?></li>
                </ol>
            </nav>
            
            <div class="ad-details-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h1 class="fw-bold mb-1"><?= e($ad['title']) ?></h1>
                        <p class="text-muted mb-0">Posted by: <?= e($ad['user_name']) ?></p>
                    </div>
                    <span class="badge bg-success rounded-pill fs-6 px-3 py-2"><?= e($ad['service_name']) ?></span>
                </div>

                <hr class="my-4">

                <?php if ($ad['pet_id']): ?>
                <h5 class="fw-bold mb-3">About the Pet</h5>
                <div class="d-flex align-items-start mb-4">
                    <div class="pet-image-container">
                         <img src="<?= e($ad['image_url'] ?? 'https://via.placeholder.com/150') ?>" 
                             alt="<?= e($ad['name']) ?>" 
                             class="pet-image">
                    </div>
                    <div>
                        <h4 class="fw-bold"><?= e($ad['name']) ?></h4>
                        <p class="mb-1"><strong>Species:</strong> <?= e($ad['species']) ?></p>
                        <p class="mb-1"><strong>Breed:</strong> <?= e($ad['breed']) ?></p>
                        <p class="mb-1"><strong>Gender:</strong> <?= e($ad['gender']) ?></p>
                        <p class="mb-1"><strong>Age:</strong> <?= e($ad['age_years']) ?> years</p>
                    </div>
                </div>
                <?php endif; ?>

                <h5 class="fw-bold mb-3">Service Details</h5>
                <div class="info-grid mb-4">
                    <div>
                        <strong class="d-block text-dark"><i class="fas fa-map-marker-alt me-2"></i>Location</strong>
                        <span><?= e($ad['location_name']) ?></span>
                    </div>
                    <div>
                        <strong class="d-block text-dark"><i class="fas fa-calendar-alt me-2"></i>Dates</strong>
                        <span><?= e(date("M j, Y", strtotime($ad['start_date']))) ?> - <?= e(date("M j, Y", strtotime($ad['end_date']))) ?></span>
                    </div>
                     <div>
                        <strong class="d-block text-dark"><i class="fas fa-dollar-sign me-2"></i>Compensation</strong>
                        <span>$<?= e(number_format($ad['price'] ?? 0, 2)) ?></span>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Description</h5>
                <p class="text-muted lh-lg">
                    <?= nl2br(e($ad['description'])) ?>
                </p>
            </div>
        </div>

        <!-- Contact Card -->
        <div class="col-lg-4">
            <div class="poster-card sticky-top" style="top: 2rem;">
                 <img src="https://i.pravatar.cc/150?u=<?= e($ad['user_name']) ?>" 
                     alt="Poster" 
                     class="img-fluid rounded-circle mb-3 mx-auto" 
                     style="width: 100px; height: 100px;">
                <h5 class="fw-bold mb-1"><?= e($ad['user_name']) ?></h5>
                <p class="text-muted small">Member since 2023</p>
                <hr>
                <div class="d-grid">
                    <a href="/bookings/create/<?= (int)$ad['id'] ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-calendar-check me-2"></i> Book Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
