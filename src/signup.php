<?php
// get database connection
/*
Use this URL to register users:
http://localhost/main-store/src/signup.html
*/

require('../settings/database.php');

// Get payload from frontend
$first_name   = trim($_POST['fname'] ?? '');
$last_name    = trim($_POST['lname'] ?? '');
$ident_number = trim($_POST['idnumber'] ?? '');
$mobile_phone = trim($_POST['mphone'] ?? '');
$e_mail       = trim($_POST['email'] ?? '');
$raw_password = $_POST['pswd'] ?? '';
$PHOTO_URL    = 'photos/photo_default.png';

if ($e_mail === '' || $raw_password === '') {
    echo "<script>alert('Email and password are required. Try again !!!')</script>";
    header('refresh:0;url=signup.html');
    exit;
}

// 1. Check if email already exists in local PostgreSQL
$sql_check_email = "SELECT id FROM users WHERE email = $1";
$res = pg_query_params($local_conn, $sql_check_email, [$e_mail]);
$total = $res ? pg_num_rows($res) : 0;

// Check if email already exists in Supabase
$res_sb = pg_query_params($supa_conn, $sql_check_email, [$e_mail]);
$total_sb = $res_sb ? pg_num_rows($res_sb) : 0;

if ($total < 1 && $total_sb < 1) {
    // Generate secure hash compatible with password_verify()
    $password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Prepare parameterized insert query
    $sql = "
        INSERT INTO users (firstname, lastname, ident_number, email, password, url_photo, mobile_phone)
        VALUES ($1, $2, $3, $4, $5, $6, $7)
    ";
    $params = [
        $first_name,
        $last_name,
        $ident_number,
        $e_mail,
        $password,
        $PHOTO_URL,
        $mobile_phone
    ];

    // Execute query in local PostgreSQL
    $res_local = pg_query_params($local_conn, $sql, $params);
    if ($res_local) {
        echo "<script>alert('user has been created successfully !!!')</script>";
    } else {
        echo "<br>Error: user hasn't been created in local DB";
    }

    // Execute query in Supabase
    $res_supabase = pg_query_params($supa_conn, $sql, $params);
    if ($res_supabase) {
        echo "<script>alert('user has been created successfully in supabase !!!')</script>";
    } else {
        echo "<br>Error: user hasn't been created in supabase";
    }

    if ($res_local || $res_supabase) {
        header('refresh:0;url=signin.html');
    }
} else {
    if ($total >= 1) {
        echo "<script>alert('User has email already exist. Try again !!!')</script>";
    }
    if ($total_sb >= 1) {
        echo "<script>alert('User has email already exist in supabase. Try again !!!')</script>";
    }
    header('refresh:0;url=signup.html');
}


// input date in supabase
if($total_sb < 1){

    //prepare query
    $sql = "
        INSERT INTO 
        users(firstname, lastname, ident_number, email, password) 
        values(
            '$first_name' ,
            '$last_name', 
            '$ident_number',
            '$e_mail',
            '$password'
        ) ;
    ";

}