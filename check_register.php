<?php
  require_once('connect/connent_DB.php');

  $username = $_POST['username'];
  $password = $_POST['password'];
  $nickname = $_POST['nickname'];

  $check_sql = "SELECT username, nickname FROM $user_table"."WHERE username=:username OR nickname=:nickname";

  $check_sth = $conn->prepare($sql);

  $check_sth->bindParam(':username', $username);
  $check_sth->bindParam(':nickname', $nickname);

  $check_sth->execute();

  $check_sth->setFetchMode(PDO::FETCH_ASSOC);

  if ($check_sth->rowCount() === 0 ){
    
  } else {

  }



  $sqlSelect = "SELECT * FROM $users_table where username='" . $username . "'" ;

  if ($username && $password ) {
    $sqlInsert = "INSERT INTO $users_table(username,password) VALUES('$username','$password')";
    $result = $conn->query($sqlInsert);
    if ($result) {
       echo 'Register success';
    } else {
       echo 'Register failed';
    }
  } else {
    echo '請輸入正確的格式' ;
?>
    <br>
    <a href="index.php">Back to register</a>
<?php
  }
?>