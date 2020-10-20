<?php

require_once('connect/connent_DB.php');

$stmt = $conn->prepare("DELETE FROM $cmmts_table WHERE id = :commet_id OR parent_id = :commet_id");

$stmt->bindParam(':commet_id', $_POST['commet_id']);

if( $stmt->execute() ){
	echo '已刪除';
}else{
	echo '刪除失敗';
}


?>