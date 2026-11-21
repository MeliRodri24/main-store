<?php
/*
Use this URL to print data in browser:
http://localhost/main-store/src/list_users.php
*/

  /*session_start();
   if (!isset($_SESSION['user_id'])) {
      header('refresh:0;url=signin.html');
      exit();
   }*/

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>


   <form method="GET" action="list_users.php">
        <select name="userStatus" onchange="this.form.submit()">
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

        <table border = "2" align = "center" class="table table-striped">

            <tr>
               <th>photo</th> 
               <th>First name</th>
               <th>Email</th>
               <th>Mobile phone</th>
               <th>Status</th>
               <th>Options</th>
            </tr>
            <?php while($row = pg_fetch_assoc($res)) {?>
            <tr>
                <!-- here print data from database-->
               <td>
                  <?php 
                     if ($row['url_photo'] != "") { ?>
                          <img src="<?php echo $row['url_photo']; ?>" width="60" height="60"><?php }
                     else { ?>
                        Sin foto
                     <?php } ?>
               </td>
               <td><?= $row['fullname']?></td>
               <td><?= $row['email']?></td>
               <td><?= $row['mobile_phone']?></td>
               <td><?= $row['status']?></td>
               <td  align="center">
                  <a href="edit_user.php?id=<?php echo $row['id']; ?>">
                     <img src="icons/edit.png" alt="Edit user" width="20">
                  </a>
                  <a href="icons/search.png">
                     <img src="icons/search.png" alt="Search user" width="20">
                  </a>
                 <?php
                      // Si llega el parámetro confirmar por la URL, la variable será true
                      $mostrarConfirmacion = isset($_GET['confirmar']) && $_GET['confirmar'] == '1';
                  ?>

                  <a  href="?confirmar=1&id=<?= $row['id'] ?>">
                     <img src="icons/delete.png" alt="Delete user" width="20">
                  </a>
                  <!-- Cuadro de confirmación (fuera del enlace <a>) -->
                 <?php if ($mostrarConfirmacion && $_GET['id'] == $row['id']): ?>
                     <fieldset style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; z-index: 1000; width: 220px; padding: 10px; font-size: 12px; text-align: center; font-family: sans-serif; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                           <legend style="font-weight: bold;">Confirmación</legend>
                           <p style="margin: 6px 0;">¿Quieres confirmar los cambios?</p>

                           <a href="delete_user.php?userID=<?= $row['id'] ?>" style="text-decoration: none;">
                              <button type="button" style="font-size: 11px; padding: 3px 8px;">Sí</button>
                           </a>

                           <a href="list_users.php" style="text-decoration: none;">
                              <button type="button" style="font-size: 11px; padding: 3px 8px;">No</button>
                           </a>
                     </fieldset>
               <?php endif; ?>
                  


                  <a href="update_user.php?userID=<?= $row['id'] ?>&userStatus=<?= $row['status'] ?>">
                     <?php
                     if ($row['status'] == 'Active'){
                        echo"<img src='icons/inactive.png' alt='Inactive user' width='20'>";
                     }else{
                        echo"<img src='icons/active.png' alt='Active user' width='20'>";
                     }
                     ?>
                  </a>
               </td>

            </tr>
             <?php }?>
            
       </table>
       menu: <br>
       <a href='home.php' >Go to home</a>    
    </body>
</html>