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
                    <input class="board__submit-btn" type="submit" value="送出"/>
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
                    require_once('connect/connent_DB.php');
                    $sql = "SELECT * from $cmmts_table";
                    $sth = $conn->prepare($sql);
                    $sth->execute();
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    while ($sth_row = $sth->fetch()){
                ?>
                        <div class="card">
                            <div class="card__avatar">
                            </div>
                            <div class="card__body">
                                <div class="card__info">
                                    <span class="card__author"><?php echo $sth_row["nickname"] ?></span>
                                    <span class="card__time"><?php echo $sth_row["created_at"] ?></span>
                                </div>
                                <p class="card__content">
                                    <?php echo $sth_row["content"] ?>
                                </p>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </section>
        </main>
    </body>
</html>