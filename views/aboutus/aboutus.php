<style>
    .aboutus {
        --accent: var(--primary-color);
        --text: var(--dark-color);
        --muted: #6c757d;
        --soft: var(--light-color);
    }

    .aboutus .hero {
        position: relative;
        background:
            linear-gradient(180deg, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.15)),
            url('https://images.unsplash.com/photo-1548199973-03cce0bbc87b?auto=format&fit=crop&w=1600&q=60') center/cover no-repeat;
        color: #fff;
        /* border-radius: 16px; */
        overflow: hidden;
    }

    .aboutus .hero .content {
        padding: 80px 24px;
    }

    .aboutus .badge-accent {
        background: var(--accent);
    }

    .aboutus .stat-card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, .08);
    }

    .aboutus .stat-value {
        font-weight: 800;
        color: var(--text);
    }

    .aboutus .stat-label {
        color: var(--muted);
    }

    .aboutus .section-title {
        font-weight: 800;
        color: var(--text);
    }

    .aboutus .team-card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, .08);
        transition: transform .2s ease;
    }

    .aboutus .team-card:hover {
        transform: translateY(-4px);
    }

    .aboutus .team-photo {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--accent);
    }

    .aboutus .partners {
        filter: grayscale(100%);
        opacity: .75;
    }

    .aboutus .partners img {
        max-height: 36px;
    }

    .aboutus .cta {
        background: var(--accent);
        color: #fff;
        border-radius: 16px;
    }

    @media (min-width: 992px) {
        .aboutus .hero .content {
            padding: 120px 72px;
        }
    }
</style>

<div class="aboutus">
    <!-- Hero -->
    <section class="hero mb-5">
        <div class="content">
            <div class="container">
                <span class="badge badge-accent px-3 py-2 mb-3">About Nuzzle</span>
                <h1 class="display-5 fw-bold mb-3">We care deeply about pets and their people</h1>
                <p class="lead mb-0" style="max-width: 720px;">
                    Our mission is to make exceptional pet care accessible, friendly, and stress-free — wherever you are.
                </p>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="mb-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <div class="stat-card p-4 text-center">
                        <div class="stat-value display-6">10K+</div>
                        <div class="stat-label">Happy Pet Owners</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card p-4 text-center">
                        <div class="stat-value display-6">5★</div>
                        <div class="stat-label">App Rating</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card p-4 text-center">
                        <div class="stat-value display-6">120+</div>
                        <div class="stat-label">Cities Covered</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card p-4 text-center">
                        <div class="stat-value display-6">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission -->
    <section class="mb-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <img
                        src="https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=1000&q=60"
                        class="img-fluid rounded shadow-sm" alt="Happy dog with owner" loading="lazy" decoding="async">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title mb-3">Our Mission</h2>
                    <p class="text-muted mb-3">
                        We believe every pet deserves care filled with compassion and expertise.
                        Nuzzle connects loving homes with trusted services for wellness, grooming, and everyday joy.
                    </p>
                    <ul class="list-unstyled text-muted mb-0">
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Trusted caregivers and verified services</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Transparent pricing and easy booking</li>
                        <li class="mb-2"><i class="fas fa-check text-primary me-2"></i>Community-first approach</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="mb-5">
        <div class="container">
            <h2 class="section-title mb-4 text-center">Meet the Team</h2>
            <p class="text-muted text-center mb-4">A small team with a big heart.</p>
            <div class="row g-4 justify-content-center">
                <?php
                $team = [
                    ['img' => 'blank-profile-picture-973460_640.webp', 'name' => 'Satya', 'role' => 'Project Manager'],
                    ['img' => 'blank-profile-picture-973460_640.webp', 'name' => 'Anshul', 'role' => 'Frontend Development'],
                    ['img' => 'blank-profile-picture-973460_640.webp', 'name' => 'Nikhil', 'role' => 'Engineering'],
                    ['img' => 'blank-profile-picture-973460_640.webp', 'name' => 'Tarun', 'role' => 'Support lead'],
                    ['img' => 'blank-profile-picture-973460_640.webp', 'name' => 'Meghanath', 'role' => 'Support Team'],
                ];
                foreach ($team as $m):
                ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="team-card h-100 text-center p-4">
                            <img class="team-photo mb-3" src="<?= e($m['img']) ?>" alt="<?= e($m['name']) ?>" loading="lazy" decoding="async">
                            <h6 class="mb-1"><?= e($m['name']) ?></h6>
                            <div class="text-muted small"><?= e($m['role']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta mb-5">
        <div class="container">
            <div class="p-4 p-lg-5 text-center rounded">
                <h2 class="fw-bold mb-2">Ready to meet your new best friend?</h2>
                <p class="mb-4">Browse pets and connect with verified caregivers today.</p>
                <a href="/pets" class="btn btn-light me-2"><i class="fas fa-paw me-1"></i> Browse Pets</a>
                <a href="/contact" class="btn btn-outline-light"><i class="fas fa-envelope me-1"></i> Contact Us</a>
            </div>
        </div>
    </section>
</div>