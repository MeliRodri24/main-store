<?php
// http://localhost/main-store/src/edit_user.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('refresh:0;url=signin.html');
    exit();
}

include('../settings/database.php');

$id = $_GET['id'] ?? ''; // el número que llegó en la URL

if ($id === '') {
    header('Location: list_users.php');
    exit();
}

$sql = 'SELECT * FROM users WHERE id = $1';
$result = pg_query_params($local_conn, $sql, array($id));
$user = pg_fetch_assoc($result); // una sola fila: el usuario a editar

if (!$user) {
    echo "Usuario no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario - Main Store</title>
    <link rel="icon" type="image/png" href="icons/main.store.icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light min-vh-100">
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="home.php">
                <img src="icons/main.store.icon.png" alt="Main Store" width="32" height="32" class="rounded-circle object-fit-cover">
                <span>Main Store</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="list_users.php" class="btn btn-outline-secondary btn-sm">Volver a usuarios</a>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-6">
                <div class="card shadow-sm border-0 p-4">
                    <h1 class="h4 mb-1">Editar usuario</h1>
                    <p class="text-muted small mb-4">Actualiza los datos o la foto del usuario.</p>

                    <form action="update_user.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

                        <div class="row">
                            <div class="col-12 col-sm-6 mb-3">
                                <label for="firstname" class="form-label">Nombre</label>
                                <input id="firstname" type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                            </div>

                            <div class="col-12 col-sm-6 mb-3">
                                <label for="lastname" class="form-label">Apellido</label>
                                <input id="lastname" type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input id="email" type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="mobile_phone" class="form-label">Celular</label>
                            <input id="mobile_phone" type="text" name="mobile_phone" class="form-control" value="<?php echo htmlspecialchars($user['mobile_phone']); ?>" required>
                        </div>

                        <?php if ($user['url_photo'] != "") { ?>
                            <div class="mb-3">
                                <p class="form-label mb-1">Foto actual</p>
                                <img src="<?php echo htmlspecialchars($user['url_photo']); ?>" alt="Foto actual" width="96" height="96" class="rounded-circle object-fit-cover border">
                            </div>
                        <?php } ?>

                        <div class="mb-4">
                            <label for="photo" class="form-label">Foto (JPG o PNG)</label>
                            <input id="photo" type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="list_users.php" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>