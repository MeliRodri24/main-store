<?php

//get database connection 
include('../settings/database.php');

    $email= $_POST['email'];
        $passwd_form= $_POST['pswd'];

    $sql_check_email ="SELECT email as total FROM users WHERE email = '$email'";
    $res =pg_query ($local_conn, $sql_check_email );
    //$row1= pg_fetch_assoc ($res);
    $total = pg_num_rows ($res);

    //verificar si el passwor del formulario es = a database
    $sql_get_password = "SELECT password FROM users WHERE email = '$email'";
    $res =pg_query ($local_conn, $sql_get_password);
    if (pg_num_rows ($res) > 0){
        $row2= pg_fetch_assoc ($res);
        $passwd_db =$row2['password'];
        $passwd= password_verify( $passwd_form, $passwd_db);
    } else {
        $passwd = 0;
    }

    echo "Q1: ". $total . "<br>";
    echo "Q2 ". $passwd;

    if ($total==1 and $passwd == 1){
        echo "You got it.";
    }else {
        echo "No access. ";
    }