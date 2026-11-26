<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('refresh:0;url=signin.html');
    exit();
}

$role = $_SESSION['user_role'] ?? 'user';
$fullname = trim(($_SESSION['user_firstname'] ?? '') . ' ' . ($_SESSION['user_lastname'] ?? ''));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Main Store</title>
    <link rel="icon" type="image/png" href="icons/main.store.icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100">
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="home.php">
                <img src="icons/main.store.icon.png" alt="Main Store" width="32" height="32" class="rounded-circle object-fit-cover">
                <span>Main Store</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge text-bg-secondary text-uppercase"><?= htmlspecialchars($role) ?></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 p-4 mb-4">
                    <h1 class="h4 mb-1">Welcome to Main Store</h1>
                    <p class="text-muted mb-0">
                        <?php if ($fullname !== ''): ?>
                            Hola, <strong><?= htmlspecialchars($fullname) ?></strong>.
                        <?php endif; ?>
                        Select an option from the menu to continue.
                    </p>
                </div>

                <div class="card shadow-sm border-0 p-4">
                    <h2 class="h6 text-uppercase text-muted mb-3">Menu</h2>
                    <?php if ($role === 'admin'): ?>
                        <div class="d-grid gap-2">
                            <a href="list_users.php" class="btn btn-primary">Go to list user</a>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small mb-0">
                            Tu cuenta tiene rol de <strong>usuario</strong>. Solo el administrador puede gestionar la lista de usuarios.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>