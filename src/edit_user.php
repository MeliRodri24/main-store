<?php

// http://localhost/main-store/src/edit_user.php 

session_start();
    if (!isset($_SESSION['user_id'])){
        header('refresh:0;url=signin.html');
    }else{
        header('refresh:0;url=home.php');
    }

    
include('../settings/database.php');

$id = $_GET['id'];   // el número que llegó en la URL

$sql = 'SELECT * FROM users WHERE id = $1';
$result = pg_query_params($local_conn, $sql, array($id));
$user = pg_fetch_assoc($result);   // una sola fila: el usuario a editar
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
</head>
<body>
    <h1>Editar usuario</h1>

    <form action="update_user.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <label>Nombre</label><br>
        <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" required><br><br>

        <label>Apellido</label><br>
        <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" required><br><br>

        <label>Correo</label><br>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <label>Celular</label><br>
        <input type="text" name="mobile_phone" value="<?php echo $user['mobile_phone']; ?>" required><br><br>

        <?php if ($user['url_photo'] != "") { ?>
            <p>Foto actual:</p>
            <img src="<?php echo $user['url_photo']; ?>" width="120"><br><br>
        <?php } ?>

        <label>Foto (JPG o PNG)</label><br>
        <input type="file" name="photo" accept=".jpg,.jpeg,.png"> <br><br>
                                                                                  
        <button type="submit">Guardar</button>
        <a href="list_users.php">Cancelar</a>
    </form>
</body>
</html>