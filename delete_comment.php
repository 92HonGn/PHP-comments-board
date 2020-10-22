<?php

	require_once('connect/connent_DB.php');

	$sth = $conn->prepare("DELETE FROM $cmmts_table WHERE id = :commet_id OR parent_id = :commet_id");

	$sth->bindParam(':commet_id', $_POST['commet_id']);

	if( $sth->execute() ){
		echo '已刪除';
	}else{
		echo '刪除失敗';
	}


?>