<?php
require_once('connect/connent_DB.php');

$comment_id = $_POST['comment_id'];
$content = $_POST['content'];

$sql = "UPDATE $cmmts_table SET content = :content WHERE id = :comment_id";

$sth = $conn->prepare($sql);

$sth->bindParam(':comment_id', $comment_id);
$sth->bindParam(':content', $content);


if ($sth->execute()) {
  echo '已編輯';
} else {
  echo '錯誤';
}



?>