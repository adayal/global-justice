<?php
class connectDB {
    static function getConnection() 
    {
        require dirname(__FILE__) . "/../dbinfo.php";
        $db_conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if (mysqli_connect_errno()) 
        {
            printf("Connection to database has failed: %s\n", $db_conn->connect_error);
            exit();
        }
        return $db_conn;
    } 
}