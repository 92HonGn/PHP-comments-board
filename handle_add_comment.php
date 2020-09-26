<?php
    require_once('connect/connent_DB.php');
    $nickname = $_POST['nickname'];
    $content = $_POST['content'];

    if(isset($nickname) && isset($content)){
        $sqlInsert = "INSERT INTO Ben_comments(nickname, content) VALUES('$nickname','$content')";
        $result = $conn->query($sqlInsert);
    }else{
        echo '請輸入正確的格式' ;
    }
?>