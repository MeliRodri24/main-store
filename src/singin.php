<?php
include "../settings/database.php";

session_start();
if(!isset($_SESSION['user_id'])){
    header('refresh:0;url=signin.html');
}else{
   header('refresh:0;url=home.php'); 
}


$email = $_POST['email'];
$password = MD5($_POST['pswd']);

$sql_check_email = "
    SELECT 
        id,
        firstname,
        lastname,
        email 
    FROM 
        users
    WHERE 
        email = '$email' and
        password = '$password'
";

// in local
$res = pg_query($local_conn, $sql_check_email);
$total = pg_num_rows($res);
$row = pg_fetch_assoc($res);

//verify in supabase 
$res_sb = pg_query($supa_conn, $sql_check_email);
$total_sb = pg_num_rows($res_sb);

// in local
if($total>0){
    $_SESSION['user_id'] = $row['id'];
    header('refresh:0;url=home.php');
}else{
     echo "<script>alert('User email does not  exist. Try again !!!')</script>";
     header('refresh:0;url=signin.html');
}


// supabase
if($total_sb > 0){
    //header('refresh:0;url=home.php');
}else{
    echo "<script>alert('User email does not exist in supabase. Try again !!!')</script>";   
}