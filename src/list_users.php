<?php
/*
Use this URL to print data in browser:
http://localhost/main-store/src/list_users.php
*/

session_start();
if (!isset($_SESSION['user_id'])) {
    header('refresh:0;url=signin.html');
    exit();
}

include('../settings/database.php');

// 1. Capturamos el filtro de la URL
$status = $_GET['userStatus'] ?? '';

// 2. Armamos la condición WHERE para PostgreSQL (TRUE / FALSE)
$where = "";
if ($status === '1') {
    $where = "WHERE status = TRUE";
} elseif ($status === '0') {
    $where = "WHERE status = FALSE";
}

// Get data frm users table
$sql = "
    SELECT 
        id,
        firstname || ' ' || lastname AS fullname,
        mobile_phone,
        email,
        CASE WHEN status = true THEN 'Active' ELSE 'Inactive' END AS status,
        url_photo 
    FROM 
        users
    $where
";
$res = pg_query($local_conn, $sql);

$mostrarConfirmacion = isset($_GET['confirmar']) && $_GET['confirmar'] == '1';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List - Main Store</title>
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
                <a href="home.php" class="btn btn-outline-secondary btn-sm">Go to home</a>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="card shadow-sm border-0 p-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div>
                    <h1 class="h4 mb-1">Users List</h1>
                    <p class="text-muted small mb-0">Filter and manage registered users.</p>
                </div>

                <form method="GET" action="list_users.php" class="d-flex align-items-center">
                    <select name="userStatus" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="" <?= $status === '' ? 'selected' : '' ?>>
                            Todos los usuarios
                        </option>
                        <option value="1" <?= $status === '1' ? 'selected' : '' ?>>
                            Usuarios activos
                        </option>
                        <option value="0" <?= $status === '0' ? 'selected' : '' ?>>
                            Usuarios inactivos
                        </option>
                    </select>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Photo</th>
                            <th>First name</th>
                            <th>Email</th>
                            <th>Mobile phone</th>
                            <th>Status</th>
                            <th class="text-center">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = pg_fetch_assoc($res)) { ?>
                            <tr>
                                <td>
                                    <?php if ($row['url_photo'] != "") { ?>
                                        <img src="<?= htmlspecialchars($row['url_photo']) ?>" alt="User photo" width="56" height="56" class="rounded-circle object-fit-cover">
                                    <?php } else { ?>
                                        <span class="text-muted small">Sin foto</span>
                                    <?php } ?>
                                </td>
                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['mobile_phone']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Active') { ?>
                                        <span class="badge text-bg-success">Active</span>
                                    <?php } else { ?>
                                        <span class="badge text-bg-secondary">Inactive</span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <a href="edit_user.php?id=<?= $row['id'] ?>" title="Edit user" class="text-decoration-none">
                                            <img src="icons/edit.png" alt="Edit user" width="20">
                                        </a>
                                        <a href="icons/search.png" title="Search user" class="text-decoration-none">
                                            <img src="icons/search.png" alt="Search user" width="20">
                                        </a>
                                        <a href="?confirmar=1&id=<?= $row['id'] ?><?= $status !== '' ? '&userStatus=' . urlencode($status) : '' ?>" title="Delete user" class="text-decoration-none">
                                            <img src="icons/delete.png" alt="Delete user" width="20">
                                        </a>
                                        <a href="update_user.php?userID=<?= $row['id'] ?>&userStatus=<?= $row['status'] ?>" title="Change status" class="text-decoration-none">
                                            <?php
                                            if ($row['status'] == 'Active') {
                                                echo "<img src='icons/active.png' alt='Active user' width='20'>";
                                            } else {
                                                echo "<img src='icons/inactive.png' alt='Inactive user' width='20'>";
                                            }
                                            ?>
                                        </a>
                                    </div>

                                    <?php if ($mostrarConfirmacion && isset($_GET['id']) && $_GET['id'] == $row['id']): ?>
                                        <div class="position-fixed top-50 start-50 translate-middle bg-white border rounded shadow p-3" style="z-index: 1050; width: 260px;">
                                            <div class="fw-semibold mb-1">Confirmación</div>
                                            <p class="small text-muted mb-3">¿Quieres confirmar eliminar este usuario?</p>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="delete_user.php?userID=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Sí</a>
                                                <a href="list_users.php<?= $status !== '' ? '?userStatus=' . urlencode($status) : '' ?>" class="btn btn-secondary btn-sm">No</a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>