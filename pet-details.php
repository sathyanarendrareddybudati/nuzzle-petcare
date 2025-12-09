<?php
require_once __DIR__ . '/config/database.php';

// Get database connection
$db = Database::getInstance();
$pdo = $db->getConnection();

// Check if pet ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: pets.php');
    exit();
}

$petId = (int)$_GET['id'];

// Fetch pet details
$stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
$stmt->execute([$petId]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

// If pet not found, redirect to pets listing
if (!$pet) {
    header('Location: pets.php');
    exit();
}

// Get related pets (same species, excluding current pet)
$relatedStmt = $pdo->prepare("SELECT * FROM pets WHERE species = ? AND id != ? ORDER BY RAND() LIMIT 3");
$relatedStmt->execute([$pet['species'], $petId]);
$relatedPets = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<!-- Pet Details Section -->
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="pets.php">Browse Pets</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($pet['name']); ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <img src="<?php echo htmlspecialchars($pet['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($pet['name']); ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="h3 mb-1"><?php echo htmlspecialchars($pet['name']); ?></h1>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-<?php echo strtolower($pet['gender']) === 'male' ? 'mars' : 'venus'; ?> me-1"></i>
                                    <?php echo htmlspecialchars($pet['breed'] ?? 'Mixed'); ?>
                                    <span class="mx-2">•</span>
                                    <?php echo htmlspecialchars($pet['age']); ?> years old
                                </p>
                            </div>
                            <div class="text-end">
                                <div class="h4 text-primary mb-0">$<?php echo number_format($pet['price'], 2); ?></div>
                                <div class="text-muted small">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    <?php echo htmlspecialchars($pet['location']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="me-4">
                                <div class="text-muted small">Species</div>
                                <div class="fw-medium"><?php echo htmlspecialchars($pet['species']); ?></div>
                            </div>
                            <div class="me-4">
                                <div class="text-muted small">Gender</div>
                                <div class="fw-medium"><?php echo htmlspecialchars($pet['gender']); ?></div>
                            </div>
                            <div>
                                <div class="text-muted small">Listed On</div>
                                <div class="fw-medium"><?php echo date('M d, Y', strtotime($pet['created_at'])); ?></div>
                            </div>
                        </div>

                        <h5 class="mb-3">About <?php echo htmlspecialchars($pet['name']); ?></h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($pet['description'])); ?></p>

                        <div class="border-top border-bottom py-3 my-4">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-3 me-3">
                                            <i class="fas fa-phone-alt text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Contact Number</div>
                                            <div class="fw-medium"><?php echo htmlspecialchars($pet['contact_phone']); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-3 me-3">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Email Address</div>
                                            <div class="fw-medium"><?php echo htmlspecialchars($pet['contact_email']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex">
                            <a href="tel:<?php echo htmlspecialchars(preg_replace('/[^0-9+]/', '', $pet['contact_phone'])); ?>" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="fas fa-phone-alt me-2"></i> Call Now
                            </a>
                            <a href="mailto:<?php echo htmlspecialchars($pet['contact_email']); ?>" class="btn btn-outline-primary btn-lg flex-grow-1">
                                <i class="fas fa-envelope me-2"></i> Send Email
                            </a>
                        </div>
                    </div>
                </div>

                <?php if (!empty($relatedPets)): ?>
                    <div class="mb-5">
                        <h4 class="mb-4">More <?php echo htmlspecialchars($pet['species']); ?>s You Might Like</h4>
                        <div class="row">
                            <?php foreach ($relatedPets as $relatedPet): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="<?php echo htmlspecialchars($relatedPet['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($relatedPet['name']); ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($relatedPet['name']); ?></h5>
                                            <p class="card-text text-muted small">
                                                <?php echo htmlspecialchars($relatedPet['breed']); ?>
                                                <span class="mx-2">•</span>
                                                <?php echo htmlspecialchars($relatedPet['age']); ?> years
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-primary fw-bold">$<?php echo number_format($relatedPet['price'], 2); ?></span>
                                                <a href="pet-details.php?id=<?php echo $relatedPet['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Pet Safety Tips</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-paw"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Meet the Pet</h6>
                                        <p class="small text-muted mb-0">Always meet the pet in person before making any payments.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Check the Environment</h6>
                                        <p class="small text-muted mb-0">Ensure the pet has been raised in a safe and loving environment.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-3">
                                <div class="d-flex">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-file-medical"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Health Records</h6>
                                        <p class="small text-muted mb-0">Ask for health records and vaccination history.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <div class="me-3 text-primary">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Ask Questions</h6>
                                        <p class="small text-muted mb-0">Don't hesitate to ask about the pet's behavior, diet, and care requirements.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Report This Ad</h5>
                        <p class="small text-muted">If you think this ad violates our Terms of Service, please report it to us.</p>
                        <button class="btn btn-outline-danger w-100">
                            <i class="fas fa-flag me-2"></i>Report Ad
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
