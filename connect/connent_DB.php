<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mysql:host=localhost;port=80;dbname=Ben;charset=utf8";
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$cmmts_table = "Ben_comments";
$users_table = "Ben_users";


//用 PDO 方式改寫
try{

    $conn = new PDO($dbname, $username, $password, $options);
    $conn->exec("SET CHARACTER SET utf8");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected Successfully";
}

catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>