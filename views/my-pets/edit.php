<?php
/** @var array $pet */
/** @var string $pageTitle */
?>
<div class="container my-5">
    <h1 class="text-center mb-4"><?= $pageTitle ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/my-pets/<?= $pet['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Pet Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($pet['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Pet Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <?php 
                                $categories = (new App\Models\PetCategory())->all();
                                foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $pet['category_id'] == $category['id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="breed" class="form-label">Breed</label>
                            <input type="text" class="form-control" id="breed" name="breed" value="<?= htmlspecialchars($pet['breed']) ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="age_years" class="form-label">Age (Years)</label>
                                <input type="number" class="form-control" id="age_years" name="age_years" min="0" value="<?= $pet['age_years'] ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="age_months" class="form-label">Age (Months)</label>
                                <input type="number" class="form-control" id="age_months" name="age_months" min="0" max="11" value="<?= $pet['age_months'] ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="Male" <?= $pet['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $pet['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Unknown" <?= $pet['gender'] == 'Unknown' ? 'selected' : '' ?>>Unknown</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($pet['description']) ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Pet Photo</label>
                            <input class="form-control" type="file" id="image" name="image">
                            <?php if ($pet['image_url']): ?>
                                <div class="mt-2">
                                    <img src="<?= htmlspecialchars($pet['image_url']) ?>" alt="Current pet photo" style="max-height: 100px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">Update Pet</button>
                            <a href="/my-pets" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
