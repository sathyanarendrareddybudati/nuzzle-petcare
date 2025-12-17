<div class="container my-5">
    <h1 class="text-center mb-4">Add a New Pet</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/my-pets" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Pet Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Pet Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Select a Category --</option>
                                <?php 
                                $categories = (new \App\Models\PetCategory())->all();
                                foreach ($categories as $category): ?>
                                    <option value="<?= $category[\'id\'] ?>"><?= htmlspecialchars($category[\'name\']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="breed" class="form-label">Breed</label>
                            <input type="text" class="form-control" id="breed" name="breed">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="age_years" class="form-label">Age (Years)</label>
                                <input type="number" class="form-control" id="age_years" name="age_years" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="age_months" class="form-label">Age (Months)</label>
                                <input type="number" class="form-control" id="age_months" name="age_months" min="0" max="11">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Unknown">Unknown</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Pet Photo</label>
                            <input class="form-control" type="file" id="image" name="image">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Add Pet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
