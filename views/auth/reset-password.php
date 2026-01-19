<?php require __DIR__ . '/../partials/form-styles.php'; ?>

<div class="form-page">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="h3 mb-2">Reset Your Password</h1>
                            <p class="text-muted">Enter your new password below to reset your account.</p>
                        </div>

                        <form action="/reset-password" method="POST">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
                                </div>
                                <small class="text-muted d-block mt-1">Your account email address</small>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" required minlength="6">
                                </div>
                                <small class="text-muted d-block mt-1">Minimum 6 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required minlength="6">
                                </div>
                                <small class="text-muted d-block mt-1">Must match the password above</small>
                            </div>

                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                <i class="fas fa-check me-2"></i> Reset Password
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