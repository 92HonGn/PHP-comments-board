<?php

function certificate( $user_id, $conn ){

	$stmt = $conn->prepare("SELECT * FROM users_certificate WHERE user_id = :user_id");
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();

	if( $stmt->rowCount() ){
		$del_sql = "DELETE FROM users_certificate WHERE user_id = $user_id";
		$conn->exec($del_sql);
	}

	$certificate = uniqid();
	$stmt = $conn->prepare("INSERT INTO users_certificate (user_id, certificate) VALUES (:user_id, :certificate)");
	$stmt->bindParam(':user_id', $user_id);
	$stmt->bindParam(':certificate', $certificate);
	$stmt->execute();

	return $certificate;
}

?>