<?php
// get database conecction 
require('../settings/database.php');

//get payload from fronted
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $ident_number =  $_POST['idnumber'];
    $mobile_phone = $_POST['mphone'];
    $e_mail = $_POST['email'];
    //MD5 metodo de encriptacion 
    $password = MD5($_POST['pswd']);
    
$sql_check_email = "SELECT * FROM users WHERE email = '$e_mail' "; 
$res = pg_query($local_conn, $sql_check_email);
$total = pg_num_rows($res);

// input date in supabase
$res_sb = pg_query($supa_conn, $sql_check_email);
$total_sb = pg_num_rows($res_sb);


if($total < 1){

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

    //Execute query 
    $res = pg_query($local_conn, $sql);

    if ($res){
        echo "<script>alert('user has been created successfully !!!') </script>";
        header('refresh:0;url=signin.html');
    } 
    else{
        echo"<br>Error: user hasn't been created";
    }
} else{
    echo "<script>alert('User has email already exist. Try again !!!')</script>";
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

    //Execute query 
    $res_sb = pg_query($supa_conn, $sql);

    if ($res_sb){
        echo "<script>alert('user has been created successfully in supabase !!!') </script>";
        //header('refresh:0;url=signin.html');
    } 
    else{
        echo"<br>Error: user hasn't been created";
    }
} else{
    echo "<script>alert('User has email already exist in supabase. Try again !!!')</script>";
    //header('refresh:0;url=signup.html');
}