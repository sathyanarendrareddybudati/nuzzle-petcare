<?php require __DIR__ . '/../partials/form-styles.php'; ?>

<div class="form-page">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-8">
        <div class="card">
          <div class="card-body p-5">
            <div class="text-center mb-4">
              <h2 class="mb-2">List a Pet</h2>
              <p class="text-muted mb-0">Add your pet details below</p>
            </div>

            <form method="POST" action="/pets" class="row g-3 needs-validation" novalidate>
              <div class="col-md-6">
                <label class="form-label">Name *</label>
                <input name="name" class="form-control" value="<?= e($_POST['name'] ?? '') ?>" required>
                <div class="invalid-feedback">Please enter a name.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Species *</label>
                <select name="species" class="form-select" required>
                  <option value="">Select</option>
                  <?php foreach (['Dog','Cat','Bird','Other'] as $sp): ?>
                    <option value="<?= e($sp) ?>" <?= (($_POST['species'] ?? '')===$sp)?'selected':''; ?>><?= e($sp) ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select a species.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Breed</label>
                <input name="breed" class="form-control" value="<?= e($_POST['breed'] ?? '') ?>">
              </div>
              <div class="col-md-3">
                <label class="form-label">Age (years)</label>
                <input type="number" name="age" class="form-control" min="0" value="<?= e($_POST['age'] ?? '1') ?>">
              </div>
              <div class="col-md-3">
                <label class="form-label">Gender *</label>
                <select name="gender" class="form-select" required>
                  <option value="">Select</option>
                  <?php foreach (['Male','Female','Other'] as $g): ?>
                    <option value="<?= e($g) ?>" <?= (($_POST['gender'] ?? '')===$g)?'selected':''; ?>><?= e($g) ?></option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select a gender.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Price (USD) *</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= e($_POST['price'] ?? '') ?>" required>
                <div class="invalid-feedback">Please enter a valid price.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Image URL *</label>
                <input type="url" name="image_url" class="form-control" value="<?= e($_POST['image_url'] ?? '') ?>" required>
                <div class="invalid-feedback">Please provide a valid image URL.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Location *</label>
                <input name="location" class="form-control" value="<?= e($_POST['location'] ?? '') ?>" required>
                <div class="invalid-feedback">Please enter a location.</div>
              </div>
              <div class="col-md-3">
                <label class="form-label">Contact Phone</label>
                <input name="contact_phone" class="form-control" value="<?= e($_POST['contact_phone'] ?? '') ?>">
              </div>
              <div class="col-md-3">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="<?= e($_POST['contact_email'] ?? '') ?>">
              </div>

              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control"><?= e($_POST['description'] ?? '') ?></textarea>
              </div>

              <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="fas fa-paw me-2"></i> List My Pet
                </button>
                <a href="/pets" class="btn btn-outline-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  'use strict';
  document.querySelectorAll('.needs-validation').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>