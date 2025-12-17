<?php
http_response_code(404);
require __DIR__ . '/../partials/form-styles.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(78,115,223,0.08), transparent 60%),
                radial-gradient(circle at bottom right, rgba(28,200,138,0.08), transparent 60%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poppins", sans-serif;
        }

        .error-card {
            border: none;
            border-radius: 22px;
            box-shadow: 0 0.15rem 1.75rem rgba(58,59,69,.15);
            background: #ffffff;
            padding: 45px 40px;
            max-width: 540px;
        }

        .error-code {
            font-size: 4.8rem;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: 0.05em;
        }

        .error-icon {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            background: rgba(78,115,223,0.09);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            color: var(--secondary-color);
        }

        .hint {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .btn {
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="error-card text-center">
        <div class="mb-3">
            <span class="error-icon">
                <i class="fas fa-circle-exclamation"></i>
            </span>
        </div>

        <div class="error-code">404</div>
        <h2 class="h4 mb-2">Oops! Page Not Found</h2>

        <p class="text-muted mb-4">
            The page you are looking for doesn’t exist or may have been moved.
        </p>

        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2 mb-3">
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home me-2"></i>Go Home
            </a>

            <a href="/pets" class="btn btn-outline-primary">
                <i class="fas fa-paw me-2"></i>Browse Pets
            </a>
        </div>

        <p class="hint mb-0">
            Please check the URL or return to the home screen.
        </p>
    </div>
</body>
</html>
