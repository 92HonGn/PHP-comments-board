<?php
 session_start();

  require_once('connect/connent_DB.php');

  $user_id = $_SESSION['user_id'];
  $parent_id = $_POST['parent_id'];
  $content = $_POST['content'];

  $sql = "INSERT INTO $cmmts_table (user_id, parent_id, content)" .
 " VALUES (:user_id, :parent_id , :content )";
  $sth = $conn->prepare($sql);
  $sth->bindParam(':user_id', $user_id);
  $sth->bindParam(':parent_id',  $parent_id);
  $sth->bindParam(':content', $content);
  $sth->execute();

  $comment_id = $conn->lastInsetId();
  $sth = $conn->prepare("SELECT nickname, created_by FROM $cmmts_table AS c INNER JOIN $users_table AS u ON c.id = :comment_id AND user_id = u.id");
  $sth->bindParam(':comment_id', $comment_id);
  $sth->execute();
  $sth->setFetchMode(PDO::FETCH_ASSOC);
  $row = $sth->fetch();

  $arr = array( 
    'nickname' => $row['nickname'],
    'cmmt_id' => $commet_id,
    'created_by' => $row['created_by'] 
  );

  echo json_encode($arr);
 
?>