<?php
    //Get database connection
    include "../settings/database.php";
    //Get payload from fronted
    $email = $_POST['email'];
    $password_form = ($_POST['pswd']);
    //Verify if form password is equal to database pasword => Same user

    $sq_get_password= "SELECT COUNT (email) FROM users WHERE email = '$email' ";
    $res = ps_query($local_conn, $sql_check_email);
    $row = pg_fetch_assoc($res);

    $sq_get_password= "SELECT password FROM users WHERE email = '$email' ";
    $res = ps_query($local_conn, $sql_get_password);
    $row = pg_fetch_assoc($res);
    $password_db = $row['password'];

    $password_db= pasword_verify($passwors_form, $password_db);
    