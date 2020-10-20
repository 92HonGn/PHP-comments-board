<?php
  session_start();

  require_once('connect/connent_DB.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM $users_table" .
         "where username = :username";

  $sth = $conn->prepare($sql);

  $sth->bindParam(':username',$username);

  $sth->execute();

  $sth->setFetchMode(PDO::FETCH_ASSOC);

  if ($sth->rowCount() === 1) {
    
    $row = $sth->fetch();

    if(password_verify($password, $row['password'])){
      $_SESSION['user_id'] = $row['id'];
      echo '登入成功';
    }else{
      echo '密碼錯誤';
    }
    
  } else {

    echo '查無此帳號';
    
  }

?>