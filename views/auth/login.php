<?php require __DIR__ . '/../partials/form-styles.php'; ?>

<div class="form-page">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card">
          <div class="card-body p-5">
            <div class="text-center mb-4">
              <h1 class="h3 mb-2">Sign In</h1>
              <p class="text-muted">Sign in to access your account</p>
            </div>

            <form action="/login" method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input type="email" class="form-control" id="email" name="email"
                         value="<?= e($_POST['email'] ?? '') ?>" placeholder="name@example.com" required>
                </div>
                <div class="invalid-feedback">Please enter a valid email address.</div>
              </div>

              <div class="mb-3">
                <div class="d-flex justify-content-between">
                  <label for="password" class="form-label">Password</label>
                  <a href="#" class="small">Forgot password?</a>
                </div>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input type="password" class="form-control" id="password" name="password"
                         placeholder="Enter your password" required>
                  <button class="btn btn-outline-secondary toggle-password" type="button" title="Show password">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                <div class="invalid-feedback">Please enter your password.</div>
              </div>

              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
              </div>

              <button class="btn btn-primary btn-lg w-100 mb-3" type="submit">
                <i class="fas fa-sign-in-alt me-2"></i> Sign In
              </button>

              <div class="text-center mt-3">
                <p class="mb-0">Don't have an account? <a href="/register">Create one</a></p>
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