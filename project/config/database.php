<?php
// used to connect to the database
$host = "localhost";
$db_name = "chowkuiheng";
$username = "chowkuiheng";
$password = "mI8@oi!mCj@_wSrb";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
}  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
