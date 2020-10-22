<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>留言板</title>
        <link rel="stylesheet" href="stylesheet/style.css">
    </head>
    <body>

        <main class="board">

            <?php
                require_once('connect/connent_DB.php');

                if (isset($_SESSION['user_id'])) {
                    $user_sql = "SELECT nickname FROM $users_table WHERE id = :user_id";
                    $user_sth = $conn->prepare($user_sql);
                    $user_sth->bindParam(':user_id', $_SESSION['user_id']);
                    $user_sth->execute();
                    $user_sth->setFetchMode(PDO::FETCH_ASSOC);
                    $user_row->$user_sth->fetch();
            ?>
                <!--登入時才能留言-->
                <h1 class="board__title">Comments</h1>
                <form class="board__new-comment-form" method="POST" action="">
                    <div class="board__nickname">
                        <span>暱稱：</span>
                        <span><?php echo $user_row['nickname'] ?></span>
    <!--                <input type="text" name="nickname" />-->
                        <a href="#">編輯</a>
                    </div>
                    <textarea name="content" rows="5" placeholder="留言在此" required></textarea>
                    <input type="hidden" name="parent_id" value='0' />
                    <input class="board__submit-btn" type="submit" value="送出" />
                </form>
            <?php
				} else {
			?>
                <input class="gotoLogin" type="button" value="請登入才能使用留言板" onclick="location.href='login.php'" />
            <?php
                }
            ?>


            <div class="board__hr"></div>


            <section>
                <?php
                    
                    $pages_sth = $conn->prepare("SELECT COUNT(parent_id) AS datanum FROM $cmmts_table  WHERE parent_id = 0");
                    $pages_sth->execute();
                    $pages_sth->setFetchMode(PDO::FETCH_ASSOC);
                    $pages_row = $pages_sth->fetch();

                    $pagesnum = (int)ceil( $pages_row['datanum'] / 10 );

                    if( !isset( $_GET['page']) OR !intval($_GET['page'])) $page=1;
                    else $page =  intval( $_GET['page'] );

                    $cmmt_start_num = ($page-1)*10;

                    $cmmt_sth = $conn->prepare("SELECT c.id AS cmmt_id, user_id, nickname, created_by, content FROM $cmmts_table AS c INNER JOIN" . 
                        " $users_table ON parent_id = 0 AND user_id = $users_table.id ORDER BY created_by DESC LIMIT $cmmt_start_num, 10");
                    
                    $cmmt_sth->execute();
                    $cmmt_sth->setFetchMode(PDO::FETCH_ASSOC);
                    while( $cmmt_row = $cmmt_sth->fetch() ){
                ?>

                        <div class="card">
                            <div class="card__avatar">
                            </div>
                            <div class="card__body">
                                <div class="card__info">
                                    <span class="card__author"><?php echo $cmmt_row["nickname"] ?></span>
                                    <span class="card__time"><?php echo $cmmt_row["created_at"] ?></span>
                                    <span class="card__edit-delete">
                                        <?php
                                            if( isset($_SESSION['user_id']) AND $cmmt_row['user_id'] === $_SESSION['user_id'] ){
                                            
                                                echo '<span class="card__edit">編輯</span>&nbsp;/&nbsp;<span class="card__delete">刪除</span>';
                                            }
			                            ?>
                                    </span>
                                </div>
                                <p class="card__content">
                                    <?php echo $cmmt_row["content"] ?>
                                </p>
                                <p class="card__id">
                                    <?php echo $cmmt_row["commet_id"] ?> //commet_id
                                </p>

                               
                                <?php 
                                    
                                    $sub_sth = $conn->prepare("SELECT c.id AS commet_id, user_id, nickname, created_at, content FROM $cmmts_table AS c INNER JOIN $users_table".
                                                " WHERE parent_id = :commet_id AND user_id = $users_table.id ORDER BY created_at ASC");
                                    $sub_sth->bindParam( ':commet_id', $cmmt_row['commet_id'] );
                                    $sub_sth->execute();
                                    $sub_sth->setFetchMode(PDO::FETCH_ASSOC);
                                    while( $sub_row = $sub_sth->fetch() ){

                                        if( $sub_row['user_id'] === $cmmt_row['user_id'] ) echo '<div class="sub-card__body sub-cmmt__main">';
                                        else echo '<div class="sub-card__body">';

			                    ?>
                                        <div class="card__info">
                                            <span class="card__author"><?php echo $sub_row["nickname"] ?></span>
                                            <span class="card__time"><?php echo $sub_row["created_at"] ?></span>
                                            <span class="card__edit-delete">
                                                <?php
                                                    if( isset($_SESSION['user_id']) AND $sub_row['user_id'] === $_SESSION['user_id'] ){
                                                    
                                                        echo '<span class="card__edit">編輯</span>&nbsp;/&nbsp;<span class="card__delete">刪除</span>';
                                                    }
                                                ?>
                                            </span>
                                        </div>
                                        <p class="card__content">
                                            <?php echo $sub_row["content"] ?>
                                        </p>
                                        <p class="card__id">
                                            <?php echo $sub_row["commet_id"] ?> //commet_id
                                        </p>
                                    </div>
                                    <?php
					                    }
			                        ?>
                                    <div class="sub-commet">  
                                    <?php
                                        if( isset($_SESSION['user_id']) ){
                                    ?>
                                        <h1 class="board__title">子留言</h1>
                                        <div class="sub-cmmt__collapse-toggle">回應[+]</div>
                                        <form class="board__new-comment-form" method="POST" action="">
                                            <div class="board__nickname">
                                                <span>暱稱：</span>
                                                <span><?php echo $user_row['nickname'] ?></span>
                                                <a href="#">編輯</a>
                                            </div>
                                            <textarea name="content" rows="5" placeholder="留言在此" required></textarea>
                                            <input type="hidden" name="parent_id" value=<?php echo $cmmt_row['cmmt_id'] ?> />
                                            <input class="board__submit-btn" type="submit" value="送出" />
                                        </form>
                                        <?php
                                                    }else{
                                        ?>
                                            <a class="sub-cmmt__login-link" onclick="location.href='login.php'">
                                                登入以發表回應 
                                            </a>
                                            <?php
                                                    }
                                        ?>
                            </div>
                        </div>
                <?php
                    }
                ?>

                <nav aria-label="comment borad pages" class="my-5">
                    <ul class="pagination justify-content-center">    
                <?php 
                    if( $page === 1 ){

                        echo '<li class="page-item disabled">';
                        echo '<a class="page-link" href="#" aria-label="Previous" tabindex="-1">';

                    }else{

                        echo '<li class="page-item">';
                        echo '<a class="page-link" href="index.php?page='. ($page-1) .'" aria-label="Previous">';

                    }
                ?>
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                <?php

                    for( $i=1; $i<=$pagesnum; $i++ ){
                        if( $i === $page ){
                            
                            echo '<li class="page-item disabled"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
                        }else{
                            
                            echo '<li class="page-item"><a class="page-link" href="index.php?page='.$i.'">'.$i.'</a></li>';
                        }
                        
                    }

                    
                    if( $page === $pagesnum ){

                        echo '<li class="page-item disabled">';
                        echo '<a class="page-link" href="#" aria-label="Next" tabindex="-1">';

                    }else{

                        echo '<li class="page-item">';
                        echo '<a class="page-link" href="index.php?page='. ($page+1) .'" aria-label="Next">';
                    }
                ?>

                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
            </section>

        </main>

    </body>
    
</html>