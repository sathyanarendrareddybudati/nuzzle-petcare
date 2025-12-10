<?php require __DIR__ . '/../partials/form-styles.php'; ?>

<div class="form-page">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card">
          <div class="card-body p-5">
            <div class="text-center mb-4">
              <h1 class="h3 mb-2">Create an Account</h1>
              <p class="text-muted">Join our community today</p>
            </div>

            <form action="/register" method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="<?= e($_POST['name'] ?? '') ?>" placeholder="John Doe" required>
                <div class="invalid-feedback">Please enter your full name.</div>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= e($_POST['email'] ?? '') ?>" placeholder="name@example.com" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Register as</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="role_id" id="role_pet_owner" value="2" required>
                  <label class="form-check-label" for="role_pet_owner">Pet Owner</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="role_id" id="role_service_provider" value="3" required>
                  <label class="form-check-label" for="role_service_provider">Service Provider</label>
                </div>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Phone (optional)</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                       value="<?= e($_POST['phone'] ?? '') ?>" placeholder="+33 78965432">
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password" name="password"
                         placeholder="Create a password" required>
                  <button class="btn btn-outline-secondary toggle-password" type="button"><i class="fas fa-eye"></i></button>
                </div>
                <div class="form-text">Must be at least 8 characters long.</div>
              </div>

              <div class="mb-4">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                         placeholder="Confirm your password" required>
                  <button class="btn btn-outline-secondary toggle-password" type="button"><i class="fas fa-eye"></i></button>
                </div>
                <div class="invalid-feedback">Passwords must match.</div>
              </div>

              <button class="btn btn-primary btn-lg w-100 mb-3" type="submit">
                <i class="fas fa-user-plus me-2"></i> Create Account
              </button>

              <div class="text-center mt-3">
                <p class="mb-0">Already have an account? <a href="/login">Sign in</a></p>
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
  const form = document.querySelector('.needs-validation');
  const password = document.getElementById('password');
  const confirmPassword = document.getElementById('confirm_password');

  function validatePassword() {
    confirmPassword.setCustomValidity(password.value !== confirmPassword.value ? "Passwords don't match" : '');
  }
  password.addEventListener('change', validatePassword);
  confirmPassword.addEventListener('keyup', validatePassword);

  document.querySelectorAll('.toggle-password').forEach(function (button) {
    button.addEventListener('click', function () {
      const input = this.parentNode.querySelector('input');
      const icon = this.querySelector('i');
      if (input.type === 'password') { input.type = 'text'; icon.classList.replace('fa-eye','fa-eye-slash'); }
      else { input.type = 'password'; icon.classList.replace('fa-eye-slash','fa-eye'); }
    });
  });

  form.addEventListener('submit', function (e) {
    if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
    form.classList.add('was-validated');
  }, false);
})();
</script>