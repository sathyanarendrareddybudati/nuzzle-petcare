<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Backend</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="icon" type="image/png" href="assets/images/favicon.png">

    <?php include_once __DIR__ . '/includes/header.php'; ?>
</head>

<body>
    <header>
        <h1>🐾 Welcome to PetCare's Backend</h1>
    </header>

    <main>
        <p>This is your backend dashboard for managing pet services, users, and admins.</p>
        <p>Start building your features inside the <code>/src</code> folder.</p>

        <section>
            <a href="src/admin/">Go to Admin Panel</a> |
            <a href="src/users/">Manage Users</a> |
            <a href="src/servies/">Manage Services</a>
        </section>
    </main>

    <footer>
        <?php include_once __DIR__ . '/includes/footer.php'; ?>
    </footer>
</body>
</html>
