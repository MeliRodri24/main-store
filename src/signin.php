<?php
// get database connection
include('../settings/database.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signin.html');
    exit();
}

$email = $_POST['email'] ?? '';
$pswd_input = $_POST['pswd'] ?? '';

$sql = "
    SELECT 
        id,
        firstname,
        lastname,
        email,
        password,
        url_photo,
        role
    FROM 
        users 
    WHERE  
        email = $1
";
$res = pg_query_params($local_conn, $sql, array($email));
$row = pg_fetch_assoc($res);

if ($row && password_verify($pswd_input, $row['password'])) {
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_firstname'] = $row['firstname'];
    $_SESSION['user_lastname'] = $row['lastname'];
    $_SESSION['user_role'] = $row['role'];

    header('Location: home.php');
    exit();
} else {
    echo "<script>alert('Invalid email or password. Try again!!!'); window.location.href='signin.html';</script>";
    exit();
}