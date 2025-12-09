<?php
require_once __DIR__ . '/config/database.php';

$db = Database::getInstance();
$pdo = $db->getConnection();

try {
    $stmt = $pdo->query("SELECT * FROM pet_ads ORDER BY created_at DESC");
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $pets = [];
    $error = "Unable to load pets at this time. Please try again later.";
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Find Your Perfect Pet</h1>
        <p class="lead mb-5">Browse our selection of adorable pets looking for their forever homes</p>
        
        <!-- Search Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form class="row g-3">
                    <div class="col-md-4">
                        <select class="form-select" id="species">
                            <option value="" selected>All Species</option>
                            <option value="Dog">Dogs</option>
                            <option value="Cat">Cats</option>
                            <option value="Bird">Birds</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="gender">
                            <option value="" selected>Any Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Pets Listing Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="section-title">Available Pets</h2>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort By: Newest First
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item" href="#">Newest First</a></li>
                    <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($pets)): ?>
                <?php foreach ($pets as $pet): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($pet['image_url']); ?>" class="card-img-top pet-image" alt="<?php echo htmlspecialchars($pet['name']); ?>">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0"><?php echo htmlspecialchars($pet['name']); ?></h5>
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($pet['species']); ?></span>
                                </div>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-<?php echo strtolower($pet['gender']) === 'male' ? 'mars' : 'venus'; ?> me-1"></i>
                                    <?php echo htmlspecialchars($pet['breed'] ?? 'Mixed'); ?>
                                    <span class="mx-2">•</span>
                                    <?php echo htmlspecialchars($pet['age']); ?> years old
                                </p>
                                <p class="card-text text-muted small mb-3">
                                    <?php echo !empty($pet['description']) ? (strlen($pet['description']) > 100 ? substr(htmlspecialchars($pet['description']), 0, 100) . '...' : htmlspecialchars($pet['description'])) : 'No description available'; ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="pet-price">$<?php echo isset($pet['price']) ? number_format($pet['price'], 2) : '0.00'; ?></div>
                                        <?php if (!empty($pet['location'])): ?>
                                        <div class="pet-location">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <?php echo htmlspecialchars($pet['location']); ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($pet['id'])): ?>
                                    <a href="pet-details.php?id=<?php echo $pet['id']; ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-light p-5 rounded">
                        <i class="fas fa-paw fa-3x text-muted mb-4"></i>
                        <h3>No Pets Available</h3>
                        <p class="text-muted">Check back later for new pet listings.</p>
                        <a href="add-pet.php" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i>List a Pet
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Pagination" class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
