<?php 
    require "../app/connection/tennis_cnf.php";
    session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="../css/style.min.css">
        <title>Регистрация</title>
    </head>
    <body>
        <div class="bg_reg">
            <nav>
                <a class="link_main" href="../tennis.php">Главная</a>
            </nav>
            <div class="bg_body_reg">
                <div class="container">
                    <div class="card_header">Регистрация</div>
                    <div class="card_body">
                        <form class="feed_form" action="mail.php" method="POST">
                            <input name="name" type="name" class="form-control" placeholder="Имя" required>
                            <input name="lastname" type="text" class="form-control" placeholder="Фамилия" required>
                            <input name="patronymic" type="text" class="form-control" placeholder="Отчество">
                            <select name="select" class="select">
                                <option value="<?php 
                                        $sth = $db->prepare("SELECT `name` FROM `class` WHERE id=1");
                                        $sth->execute(array());
                                        $value = $sth->fetch(PDO::FETCH_COLUMN);
                                        echo $value;
                                    ?>"><?php 
                                    $sth = $db->prepare("SELECT `name` FROM `class` WHERE id=1");
                                    $sth->execute(array());
                                    $value = $sth->fetch(PDO::FETCH_COLUMN);
                                    echo $value;
                                ?></option>
                                <option value="<?php 
                                        $sth = $db->prepare("SELECT `name` FROM `class` WHERE id=2");
                                        $sth->execute(array());
                                        $value = $sth->fetch(PDO::FETCH_COLUMN);
                                        echo $value;
                                    ?>"><?php 
                                    $sth = $db->prepare("SELECT `name` FROM `class` WHERE id=2");
                                    $sth->execute(array());
                                    $value = $sth->fetch(PDO::FETCH_COLUMN);
                                    echo $value;
                                ?></option>
                            </select>
                            <input name="phone" type="phone" class="form-control" placeholder="Телефон" required>
                            <input name="email" type="email" class="form-control"placeholder="Электронная почта" required>
                            <input name="password" type="text" class="form-control" placeholder="Пароль" required>
                                <div class="alert_success">
                                <?php
                                        if (isset($_SESSION['status']))
                                        {
                                            echo $_SESSION['status'];
                                            unset($_SESSION['status']);
                                        }
                                    ?>
                                </div>
                            <div class="btn_wrap">
                                <button type="submit" style="width:240px;color:#fff;" class="btn btn_reg" name="register_btn">Зарегистрироваться</button>
                                <a class="btn btn_log" style="width:130px;color:#fff;text-decoration:none;text-transform:none" href="./login.php">Войти</a>
                            </div>            
                        </form>
                    </div>
                        
                </div>
            </div>
        </div>
    </body>
