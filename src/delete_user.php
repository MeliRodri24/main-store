<?php
   /* 
   Use this Endpoint to test request
   http://localhost/main-store/src/delet_user.php?userID=ANY-ID-NUMBER
   */
  /*session_start();
  if(!isset($_SESSION['user_id'])){
        header('refresh:0;url=signin.html');
  }else{
        header('refresh:0;url=home.php'); 
  }*/

include('../settings/database.php');

// Get data 
$user_id = $_GET['userID'];

// Prepare query


$sql_delete_user  = "DELETE FROM users WHERE id = $user_id";
$res = pg_query($local_conn, $sql_delete_user); 
if($res){
    echo "<script>alert('User has benn deletd successfully !!!')</script>";
    header('refresh:0;url=list_users.php'); 
}else{
    echo "<script>alert('User has not benn deletd successfully !!!')</script>"; 
    header('refresh:0;url=list_users.php');
    }
?>