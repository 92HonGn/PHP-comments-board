<?php
  session_start();
  require_once('connect/connent_DB.php');

  $username = $_POST['username'];
  $password = $_POST['password'];
  $nickname = $_POST['nickname'];

  $check_sql = "SELECT username, nickname FROM $user_table"."WHERE username=:username OR nickname=:nickname";

  $check_sth = $conn->prepare($check_sql);

  $check_sth->bindParam(':username', $username);
  $check_sth->bindParam(':nickname', $nickname);

  $check_sth->execute();

  $check_sth->setFetchMode(PDO::FETCH_ASSOC);

  if ($check_sth->rowCount() === 0 ){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $register_sql = "INSERT INTO $user_table (username, password, nickname"."VALUES (:username, :password, :nickname)";

    $register_sth = $conn->prepare($register_sql);

    $param = [
      ':username' => $username,
      ':password' => $hashed_password,
      ':nickname' => $nickname,
    ];

    if ($register_sth->execute($param)){
      $_SESSION['user_id'] = $conn->lastInsertId();
      echo 'ok';
    }

  } else {
    while($check_row = $check_sth->fetch()){
      if(!strcasecmp($check_row['username'],$username) AND !strcasecmp($check_row['nickname'],$nickname)){
        echo '帳號匿名錯誤';
      }else if(!strcasecmp($check_row['nickname'],$nickname)){
        echo '匿名錯誤';
      }else if(!strcasecmp($check_ro['username'],$username)){
        echo '帳號錯誤';
      }else{
        echo '例外錯誤';
      }
    }
  }
?>