

<?php
//Datebase connection 

/* 
To test connection, please go to:
http://localhost/main-store/src/settings/database.php 
*/

//local connection

    $local_host = "localhost";
    $local_port = "5432";
    $local_dbname = "mainstore";
    $local_user = "postgres";
    $local_password = "postgres";
 
    $local_conn = pg_connect(
        "
            host=$local_host
            port=$local_port
            dbname=$local_dbname
            user=$local_user
            password=$local_password"
    );

    //supa connection

    $supa_host = "aws-0-us-east-1.pooler.supabase.com";
    $supa_port = "6543";
    $supa_dbname = "postgres";
    $supa_user = "postgres.gerrrfmgblwjitatiyro";
    $supa_password = "main-store@@";
 
    $supa_conn = pg_connect(
        "
            host=$supa_host
            port=$supa_port
            dbname=$supa_dbname
            user=$supa_user
            password=$supa_password"
    );
 
    if (!$local_conn) {
        die("Error connection");
    }else {
        echo "<br>Success database connetion !!!";
    }

     if (!$supa_conn) {
        die("Error supa connection");
    }else {
        echo "<br>Success database supa connetion !!!";
    }

?>
 