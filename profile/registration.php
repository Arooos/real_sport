<?php 
    require "../app/connection/tennis_cnf.php";
    session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Регистрация</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
    </head>
    <body>
        <div class="py-5">
            <div class="container">
                <div class="row justify-content-centre">
                    <div class="col-mb-6">
                        <div class="alert">
                            <?php
                                if (isset($_SESSION['status']))
                                {
                                    echo "<h4>".$_SESSION['status']."</h4>";
                                    unset($_SESSION['status']);
                                }
                            ?>
                        </div>
                        <div class="card shadow">
                            <div class="card-header">
                                <h5>Регистрация нового пользователя</h5>
                            </div>
                            <div class="card-body">
                                <form action="mail.php" method="POST">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Имя</label>
                                        <input name="name" type="name" class="form-control" id="regName">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Фамилия</label>
                                        <input name="lastname" type="text" class="form-control" id="regLastname">
                                    </div>
                                    <div class="mform-group mb-3">
                                        <label class="form-label">Отчество</label>
                                        <input name="patronymic" type="text" class="form-control" id="regSurname">
                                    </div>
                                    <div class="form-group">
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
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Телефон для связи</label>
                                        <input name="phone" type="phone" class="form-control" id="regPhone">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Адрес электронной почты</label>
                                        <input name="email" type="email" class="form-control" id="regEmail">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Пароль</label>
                                        <input name="password" type="textd" class="form-control" id="regPassword">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="register_btn">Зарегистрироваться</button>
                                    <a class="btn btn-primary" style="position: absolute;right:18px;" href="./login.php">Войти</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
