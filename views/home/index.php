<style>
    /* Custom CSS for the new hero section */
    .hero-section {
        background-color: #f0f4ff; /* A light, welcoming blue */
        padding: 6rem 0;
        position: relative;
        overflow: hidden;
    }

    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 800;
        color: #2c3e50; /* Charcoal */
    }

    .hero-section .text-primary {
        color: #2e59d9 !important; /* Primary blue from the original CSS */
    }

    .hero-section p.lead {
        font-size: 1.25rem;
        color: #5a5c69; /* Dark gray from original CSS */
        max-width: 500px;
    }

    .search-bar-wrapper {
        background: #fff;
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-top: 3rem;
    }

    .search-bar-wrapper .form-control, .search-bar-wrapper .form-select {
        border-radius: 0.75rem;
        border: 1px solid #e3e6f0;
        padding: 0.75rem 1rem;
    }
    
    .search-bar-wrapper .form-control:focus, .search-bar-wrapper .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(46, 89, 217, 0.25);
        border-color: #2e59d9;
    }

    .hero-image-container {
        position: relative;
    }

    .hero-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 1.5rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    .floating-card {
        position: absolute;
        bottom: -20px;
        left: -20px;
        background: white;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .floating-card .icon {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        background: #fdf2e9; /* Peach color */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .featured-pets {
        padding: 6rem 0;
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

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill fw-medium">
                        Trusted by 10,000+ Pet Owners
                    </span>
                </div>
                <h1 class="display-3 fw-bolder text-charcoal mb-4">
                    More Than Care,<br>
                    <span class="text-primary">We Give Love</span>
                </h1>
                <p class="lead mb-4">
                    Connect with trusted pet caretakers in your area. Whether you need pet sitting, walking, boarding, or fostering — we\'ve got your furry friends covered.
                </p>
                <div class="d-flex gap-2">
                    <a href="#featured-pets" class="btn btn-primary btn-lg px-4">Find a Caretaker</a>
                    <a href="/pets/create" class="btn btn-outline-secondary btn-lg px-4">Post an Ad</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-container">
                    <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=600&h=700&fit=crop" 
                         alt="Happy dog with caretaker" 
                         class="hero-image">
                    <div class="floating-card">
                         <div class="icon">
                            <span>🐕</span>
                         </div>
                         <div>
                            <p class="fw-bold mb-0">Max is Happy!</p>
                            <p class="text-muted small mb-0">Walked by Sarah</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar-wrapper">
            <form action="/pets" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-5">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control border-0" placeholder="Search for pets, breeds, or keywords">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <select name="location" class="form-select border-0">
                            <option value="">All Locations</option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= e($location['id']) ?>"><?= e($location['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select name="service" class="form-select border-0">
                            <option value="">All Services</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= e($service['id']) ?>"><?= e($service['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-primary w-100 btn-lg" type="submit">
                            <i class="fas fa-search me-1"></i> Search
                        </button
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Featured Ads Section -->
<section class="featured-pets" id="featured-pets">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Pet Ads</h2>
            <p class="text-muted">Discover opportunities to care for a pet in your area.</p>
        </div>
        <div class="row g-4">
            <?php if (!empty($ads)):
                foreach ($ads as $ad): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card pet-card h-100">
                            <img src="<?= e($ad['image_url'] ?? 'https://via.placeholder.com/400x300') ?>" 
                                 class="card-img-top pet-card-img" 
                                 alt="<?= e($ad['name'] ?? 'Pet') ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?= e($ad['title'] ?? 'Untitled Ad') ?></h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt me-2"></i><?= e($ad['location_name'] ?? 'Location unknown') ?>
                                </p>
                                <p class="card-text flex-grow-1"><?= e(substr($ad['description'], 0, 80)) ?>...</p>
                                <a href="/pets/<?= $ad['id'] ?>" class="btn btn-primary mt-auto">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else:
                ?>
                <div class="col">
                    <p class="text-center text-muted">No featured ads available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-5">
            <a href="/pets" class="btn btn-outline-primary btn-lg">Browse All Ads</a>
        </div>
    </div>
</section>

<!-- Featured Caretakers Section -->
<section class="featured-caretakers bg-light" id="featured-caretakers">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Top Caretakers</h2>
            <p class="text-muted">Meet some of our highly-rated and trusted pet caretakers.</p>
        </div>
        <div class="row g-4">
            <?php if (!empty($caretakers)):
                foreach ($caretakers as $caretaker): ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="card pet-card h-100 text-center">
                             <img src="<?= e($caretaker['photo_url'] ?? 'https://i.pravatar.cc/150?u=' . e($caretaker['user_name'])) ?>" 
                                 class="card-img-top pet-card-img w-50 h-50 rounded-circle mx-auto mt-4" 
                                 alt="<?= e($caretaker['user_name']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold"><?= e($caretaker['user_name']) ?></h5>
                                <p class="card-text text-muted small mb-2"><?= e($caretaker['title']) ?></p>
                                <p class="card-text flex-grow-1 small">
                                    <?php if (!empty($caretaker['bio'])): ?>
                                        <?= e(substr($caretaker['bio'], 0, 70)) ?>...
                                    <?php endif; ?>
                                </p>
                                <a href="/caretaker/<?= $caretaker['id'] ?>" class="btn btn-outline-primary btn-sm mt-auto">View Profile</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else:
                ?>
                <div class="col">
                    <p class="text-center text-muted">No featured caretakers available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<style>
.how-it-works-section {
    padding: 6rem 0;
    background-color: #f8f9fa;
}
.step-card {
    position: relative;
    text-align: center;
}
.step-connector {
    position: absolute;
    top: 60px; /* Adjust based on icon size */
    left: 75%;
    width: 50%;
    height: 2px;
    background-color: #dee2e6; /* Bootstrap border color */
}
.step-number {
    position: absolute;
    top: -1rem;
    left: 50%;
    transform: translateX(-50%);
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff7e5f, #feb47b);
    color: #fff;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
.step-icon-wrapper {
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem;
    border-radius: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}
.step-card:hover .step-icon-wrapper {
    transform: scale(1.05);
}
.step-icon {
    font-size: 3rem;
    color: #2e59d9;
}
.bg-peach {
    background-color: #fdf2e9;
}
.bg-coral-light {
    background-color: rgba(255, 126, 95, 0.3);
}
.bg-primary-light {
    background-color: rgba(46, 89, 217, 0.2);
}
</style>

<section class="how-it-works-section" id="how-it-works">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 600px;">
            <span class="text-primary fw-semibold text-uppercase small mb-2 d-inline-block">Simple Process</span>
            <h2 class="display-5 fw-bold text-charcoal mb-3">How Nuzzle Works</h2>
            <p class="lead text-muted">Finding the perfect pet caretaker has never been easier. Follow these simple steps.</p>
        </div>

        <div class="row g-5">
            <?php
            $steps = [
                [
                    'icon' => 'fa-search',
                    'title' => 'Search & Discover',
                    'description' => 'Browse through verified caretakers in your area based on services, ratings, and availability.',
                    'color' => 'bg-peach',
                ],
                [
                    'icon' => 'fa-comments',
                    'title' => 'Connect & Communicate',
                    'description' => 'Message caretakers directly, discuss your pet\'s needs, and find the perfect match.',
                    'color' => 'bg-coral-light',
                ],
                [
                    'icon' => 'fa-heart',
                    'title' => 'Book with Confidence',
                    'description' => 'Schedule your pet care service with a trusted caretaker who loves pets as much as you do.',
                    'color' => 'bg-primary-light',
                ],
                [
                    'icon' => 'fa-star',
                    'title' => 'Rate & Review',
                    'description' => 'After the service, share your experience to help other pet owners find great caretakers.',
                    'color' => 'bg-peach',
                ],
            ];
            ?>

            <?php foreach ($steps as $index => $step): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <?php if ($index < count($steps) - 1): ?>
                            <div class="step-connector d-none d-lg-block"></div>
                        <?php endif; ?>
                        
                        <div class="step-number"><?= $index + 1 ?></div>

                        <div class="step-icon-wrapper <?= $step['color'] ?>">
                            <i class="fas <?= $step['icon'] ?> step-icon"></i>
                        </div>

                        <h3 class="h5 fw-bold mb-2"><?= $step['title'] ?></h3>
                        <p class="text-muted"><?= $step['description'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- CTA Section -->
<style>
.cta-section {
    padding: 6rem 0;
}
.cta-card {
    position: relative;
    background: #2e59d9;
    border-radius: 1.5rem; /* rounded-3xl */
    padding: 4rem;
    overflow: hidden;
    color: #fff;
}
.cta-card::before, .cta-card::after {
    content: '';
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 0;
}
.cta-card::before {
    width: 250px;
    height: 250px;
    top: -100px;
    right: -100px;
}
.cta-card::after {
    width: 200px;
    height: 200px;
    bottom: -80px;
    left: -80px;
}
.cta-content {
    position: relative;
    z-index: 1;
}
.cta-icon-wrapper {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 1rem; /* rounded-2xl */
    margin-bottom: 1.5rem;
}
.cta-icon {
    font-size: 1.75rem; /* w-8 h-8 */
    color: #fff;
}
</style>

<section class="cta-section bg-light" id="post">
    <div class="container">
        <div class="cta-card">
            <div class="cta-content text-center">
                <div class="col-lg-9 col-md-10 mx-auto">
                    <div class="cta-icon-wrapper">
                        <i class="fas fa-heart cta-icon"></i>
                    </div>

                    <h2 class="display-4 fw-bold text-white mb-4">
                        Ready to Find the Perfect Care for Your Pet?
                    </h2>

                    <p class="fs-5 text-white-75 mb-5">
                        Join our community of loving pet owners and trusted caretakers. Your furry friend deserves the best!
                    </p>

                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a href="/register" class="btn btn-light btn-lg px-4 gap-3 fw-bold">
                            Get Started Free
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="/aboutus" class="btn btn-outline-light btn-lg px-4">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>