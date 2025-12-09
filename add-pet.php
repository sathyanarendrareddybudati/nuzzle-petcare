<?php
require_once __DIR__ . '/config/database.php';

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $pet_name = trim($_POST['pet_name'] ?? '');
    $owner_name = trim($_POST['owner_name'] ?? '');
    $species = trim($_POST['species'] ?? '');
    $breed = trim($_POST['breed'] ?? '');
    $age = (int)($_POST['age'] ?? 0);
    $gender = trim($_POST['gender'] ?? '');
    $rate_per_day = (float)($_POST['rate_per_day'] ?? 0);
    $care_duration = trim($_POST['care_duration'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $contact_phone = trim($_POST['contact_phone'] ?? '');
    $contact_email = filter_var(trim($_POST['contact_email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $image_url = trim($_POST['image_url'] ?? '');
    $special_requirements = trim($_POST['special_requirements'] ?? '');

    // Basic validation
    if (empty($pet_name)) $errors[] = 'Pet name is required';
    if (empty($owner_name)) $errors[] = 'Your name is required';
    if (empty($species)) $errors[] = 'Species is required';
    if (empty($gender)) $errors[] = 'Gender is required';
    if ($rate_per_day <= 0) $errors[] = 'Please enter a valid rate per day';
    if (empty($care_duration)) $errors[] = 'Please specify the care duration';
    if (empty($description)) $errors[] = 'Description is required';
    if (empty($location)) $errors[] = 'Location is required';
    if (empty($contact_phone)) $errors[] = 'Contact phone is required';
    if (!$contact_email) $errors[] = 'Valid email is required';
    if (empty($image_url)) $errors[] = 'Please provide an image URL of your pet';

    // If no errors, insert into database
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO pet_ads (pet_name, owner_name, species, breed, age, gender, rate_per_day, care_duration, description, special_requirements, location, contact_phone, contact_email, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $pet_name,
                $owner_name,
                $species,
                $breed,
                $age,
                $gender,
                $rate_per_day,
                $care_duration,
                $description,
                $special_requirements,
                $location,
                $contact_phone,
                $contact_email,
                $image_url
            ]);
            
            $success = true;
            // Clear form
            $_POST = [];
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
            error_log('Database error: ' . $e->getMessage());
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Find a Pet Sitter</h2>
                    <p class="text-center text-muted mb-4">Need someone to take care of your pet? Fill out the form below to find a caring pet sitter.</p>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Your pet has been listed successfully! <a href="pets.php" class="alert-link">View all pets</a>.
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <h5 class="alert-heading">Please fix the following errors:</h5>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="add-pet.php" id="petForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pet_name" class="form-label">Pet's Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pet_name" name="pet_name" value="<?php echo htmlspecialchars($_POST['pet_name'] ?? ''); ?>" required>
                                <div class="invalid-feedback">Please enter your pet's name.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="owner_name" class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name" value="<?php echo htmlspecialchars($_POST['owner_name'] ?? ''); ?>" required>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="species" class="form-label">Species <span class="text-danger">*</span></label>
                                <select class="form-select" id="species" name="species" required>
                                    <option value="" disabled selected>Select species</option>
                                    <option value="Dog" <?php echo (isset($_POST['species']) && $_POST['species'] === 'Dog') ? 'selected' : ''; ?>>Dog</option>
                                    <option value="Cat" <?php echo (isset($_POST['species']) && $_POST['species'] === 'Cat') ? 'selected' : ''; ?>>Cat</option>
                                    <option value="Bird" <?php echo (isset($_POST['species']) && $_POST['species'] === 'Bird') ? 'selected' : ''; ?>>Bird</option>
                                    <option value="Fish" <?php echo (isset($_POST['species']) && $_POST['species'] === 'Fish') ? 'selected' : ''; ?>>Fish</option>
                                    <option value="Reptile" <?php echo (isset($_POST['species']) && $_POST['species'] === 'Reptile') ? 'selected' : ''; ?>>Reptile</option>
                                    <option value="Small Animal" <?php echo (isset($_POST['species']) && $_POST['species'] === 'Small Animal') ? 'selected' : ''; ?>>Small Animal</option>
                                    <option value="Other" <?php echo (isset($_POST['species']) && $_POST['species'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <div class="invalid-feedback">Please select a species.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="breed" class="form-label">Breed</label>
                                <input type="text" class="form-control" id="breed" name="breed" value="<?php echo htmlspecialchars($_POST['breed'] ?? ''); ?>">
                                <div class="form-text">e.g., Golden Retriever, Persian, etc.</div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="age" class="form-label">Age (years)</label>
                                <input type="number" class="form-control" id="age" name="age" min="0" max="50" value="<?php echo htmlspecialchars($_POST['age'] ?? '1'); ?>">
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="" disabled selected>Select gender</option>
                                    <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">About Your Pet <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                            <div class="form-text">Tell us about your pet's personality, habits, and daily routine.</div>
                            <div class="invalid-feedback">Please tell us about your pet.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="special_requirements" class="form-label">Special Requirements</label>
                            <textarea class="form-control" id="special_requirements" name="special_requirements" rows="2"><?php echo htmlspecialchars($_POST['special_requirements'] ?? ''); ?></textarea>
                            <div class="form-text">Any special care instructions, medications, or specific needs.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rate_per_day" class="form-label">Rate Per Day ($) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="rate_per_day" name="rate_per_day" min="0" step="0.01" value="<?php echo htmlspecialchars($_POST['rate_per_day'] ?? ''); ?>" required>
                                </div>
                                <div class="form-text">How much you're willing to pay per day</div>
                                <div class="invalid-feedback">Please enter a valid rate.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="care_duration" class="form-label">Care Duration <span class="text-danger">*</span></label>
                                <select class="form-select" id="care_duration" name="care_duration" required>
                                    <option value="" disabled selected>Select duration</option>
                                    <option value="1-3 days" <?php echo (isset($_POST['care_duration']) && $_POST['care_duration'] === '1-3 days') ? 'selected' : ''; ?>>1-3 days</option>
                                    <option value="4-7 days" <?php echo (isset($_POST['care_duration']) && $_POST['care_duration'] === '4-7 days') ? 'selected' : ''; ?>>4-7 days</option>
                                    <option value="1-2 weeks" <?php echo (isset($_POST['care_duration']) && $_POST['care_duration'] === '1-2 weeks') ? 'selected' : ''; ?>>1-2 weeks</option>
                                    <option value="2-4 weeks" <?php echo (isset($_POST['care_duration']) && $_POST['care_duration'] === '2-4 weeks') ? 'selected' : ''; ?>>2-4 weeks</option>
                                    <option value="1+ month" <?php echo (isset($_POST['care_duration']) && $_POST['care_duration'] === '1+ month') ? 'selected' : ''; ?>>1+ month</option>
                                </select>
                                <div class="invalid-feedback">Please select the care duration.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Pet's Photo URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" id="image_url" name="image_url" value="<?php echo htmlspecialchars($_POST['image_url'] ?? ''); ?>" required>
                            <div class="form-text">Upload a clear photo of your pet to help sitters recognize them.</div>
                            <div class="invalid-feedback">Please provide a valid image URL.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($_POST['location'] ?? ''); ?>" required>
                                <div class="form-text">e.g., New York, NY</div>
                                <div class="invalid-feedback">Please enter a location.</div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="contact_phone" class="form-label">Contact Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo htmlspecialchars($_POST['contact_phone'] ?? ''); ?>" required>
                                <div class="invalid-feedback">Please provide a contact phone number.</div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="contact_email" class="form-label">Contact Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($_POST['contact_email'] ?? ''); ?>" required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paw me-2"></i>List My Pet
                            </button>
                            <a href="pets.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Listings
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Client-side form validation
(function () {
    'use strict'
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false)
    })
})()

// Preview image when URL is entered
const imageUrlInput = document.getElementById('image_url');
const imagePreview = document.createElement('div');
imagePreview.className = 'mt-2 text-center';
imageUrlInput.parentNode.appendChild(imagePreview);

imageUrlInput.addEventListener('change', function() {
    if (this.value) {
        imagePreview.innerHTML = `
            <div class="card mt-2">
                <div class="card-body p-2">
                    <p class="small text-muted mb-1">Image Preview:</p>
                    <img src="${this.value}" class="img-fluid rounded" style="max-height: 150px;" onerror="this.style.display='none'; document.querySelector('.image-error').style.display='block';">
                    <div class="image-error alert alert-warning mt-2 py-1 small" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-1"></i> Could not load image preview. Please check the URL.
                    </div>
                </div>
            </div>`;
    } else {
        imagePreview.innerHTML = '';
    }
});
</script>

<?php include 'includes/footer.php'; ?>
