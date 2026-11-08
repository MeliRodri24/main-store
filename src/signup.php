<?php
// Get database connection
require ('../settings/database.php');


// Get payload from fronted
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $ident_number =  $_POST['idnumber'];
    $mobile_phone = $_POST['mphhone'];
    $e_mail = $_POST['email'];
    $password = MD5($_POST['pswd']);

    //Prepare query
    $sql = "
        INSERT INTO users (firstname, lastname, ident_number, email, password) 
        VALUES (
        '$first_name',
        '$last_name', 
        '$ident_number', 
        '$email',
        '$passwd'
    );
";

//execute query
$res = pg_query($local_conn, $sql);

if($res){
    echo "User has been created successfully !!!";

}else{
    echo "Error: User hasn't been created successfully !!!";

}