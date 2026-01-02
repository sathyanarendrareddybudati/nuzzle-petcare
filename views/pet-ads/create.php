<div class="container my-5">
    <h1 class="text-center mb-4"><?= $pageTitle ?? 'Post a New Ad' ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/pets" method="POST" id="new-ad-form">
                        <div class="mb-3">
                            <label for="ad_type" class="form-label">Ad Type</label>
                            <select class="form-select" id="ad_type" name="ad_type" required>
                                <option value="service_request">Request a Service</option>
                                <option value="adoption">Post for Adoption</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Ad Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>

                        <div class="mb-3" id="pet-selection">
                            <label for="pet_id" class="form-label">Which pet is this for?</label>
                            <div class="input-group">
                                <select class="form-select" id="pet_id" name="pet_id">
                                    <option value="">-- Select a Pet --</option>
                                    <?php foreach ($pets as $pet): ?>
                                        <option value="<?= $pet['id'] ?>"><?= htmlspecialchars($pet['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#add-pet-modal">Add</button>
                            </div>
                        </div>

                        <div class="mb-3" id="service-selection">
                            <label for="service_id" class="form-label">Service Required</label>
                            <select class="form-select" id="service_id" name="service_id">
                                <option value="">-- Select a Service --</option>
                                <?php foreach ($services as $service): ?>
                                    <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price / Fee</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location_id" class="form-label">Location</label>
                                <select class="form-select" id="location_id" name="location_id" required>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Service Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Service End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Post Ad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Pet Modal -->
<div class="modal fade" id="add-pet-modal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPetModalLabel">Add a New Pet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-pet-form" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="pet-name" class="form-label">Pet Name</label>
                        <input type="text" class="form-control" id="pet-name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="pet-category" class="form-label">Pet Category</label>
                        <select class="form-select" id="pet-category" name="category_id" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pet-breed" class="form-label">Breed</label>
                        <input type="text" class="form-control" id="pet-breed" name="breed">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pet-age" class="form-label">Age (Years)</label>
                            <input type="number" class="form-control" id="pet-age" name="age_years" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pet-gender" class="form-label">Gender</label>
                            <select class="form-select" id="pet-gender" name="gender">
                                <option value="">-- Select Gender --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Unknown">Unknown</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pet-image" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="pet-image" name="image">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-pet-btn">Save Pet</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const adType = document.getElementById('ad_type');
    const petSelection = document.getElementById('pet-selection');
    const serviceSelection = document.getElementById('service-selection');
    const savePetBtn = document.getElementById('save-pet-btn');
    const addPetForm = document.getElementById('add-pet-form');
    const petIdDropdown = document.getElementById('pet_id');
    const addPetModal = new bootstrap.Modal(document.getElementById('add-pet-modal'));

    function toggleFields() {
        if (adType.value === 'adoption') {
            petSelection.style.display = 'block';
            serviceSelection.style.display = 'none';
        } else {
            petSelection.style.display = 'block';
            serviceSelection.style.display = 'block';
        }
    }

    adType.addEventListener('change', toggleFields);
    toggleFields();

    savePetBtn.addEventListener('click', function () {
        const formData = new FormData(addPetForm);

        fetch('/my-pets/create-from-ad', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newOption = new Option(data.pet.name, data.pet.id, true, true);
                petIdDropdown.add(newOption);
                addPetModal.hide();
                addPetForm.reset();
            } else {
                // Handle errors
                alert('Error adding pet: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
        });
    });
});
</script>
