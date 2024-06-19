<?php 
    session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap-reboot.min.css">
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="../css/style.min.css">
        <title>Вход в аккаунт</title>

    </head>
    <body>
        <div class="bg_log">
            <nav>
                <a class="link_main" href="../tennis.php">Главная</a>
            </nav>
            <div class="bg_body">
                <div class="container">
                    <div class="card_header">Вход в аккаунт
                    </div>
                    <div class="card_body">
                        <form class="feed_form" action="logincode.php" method="POST">
                                <input type="email" name="email" class="form-control" id="regPhone" placeholder="Адрес электроной почты">
                                <input type="password" name="password" class="form-control" id="regPassword" placeholder="Пароль">
                                <?php
                                        if(isset($_SESSION['status'])){
                                            ?>
                                                <div class="alert_success">
                                                    <h5><?= $_SESSION['status']; ?></h5>
                                                </div>
                                            <?php
                                            unset($_SESSION['status']);
                                        }
                                    ?>
                            <div class="btn_wrap">
                                <button type="submit" name="login_now_btn" class="btn btn_log">Войти</button>
                                <a class="btn btn_reg" href="./registration.php">Регистрация</a>
                            </div>            
                        </form>
                    </div>
                        
                </div>
            </div>
        </div>
    </body>