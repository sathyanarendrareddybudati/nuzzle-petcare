<?php require __DIR__ . '/../partials/form-styles.php'; ?>

<div class="form-page">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 mb-2">Forgot Your Password?</h1>
                            <p class="text-muted">Enter your email address and we will send you a link to reset your password.</p>
                        </div>

                        <form action="/forgot-password" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                <i class="fas fa-paper-plane me-2"></i> Send Reset Link
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0"><a href="/login"><i class="fas fa-arrow-left me-2"></i>Back to Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
