<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-3 fw-normal">Admin Registration</h1>
                </div>
                <div class="card-body">

                    <?php if (App\Core\Session::has('error')): ?>
                        <div class="alert alert-danger">
                            <?= App\Core\Session::get('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="/register/admin" method="post">
                        <input type="hidden" name="role_id" value="1">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <label for="confirm_password">Confirm Password</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">
                            Register Admin
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
