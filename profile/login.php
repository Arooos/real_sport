<?php 
    session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Вход в аккаунт</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
    </head>
    <body>
        <div class="py-5">
            <div class="container">
                <div class="row justify-content-centre">
                    <div class="col-mb-6">

                        <?php
                            if(isset($_SESSION['status'])){
                                ?>
                                    <div class="alert alert-success">
                                        <h5><?= $_SESSION['status']; ?></h5>
                                    </div>
                                <?php
                                unset($_SESSION['status']);
                            }
                        ?>

                        <div class="card shadow">
                            <div class="card-header">
                                <h5>Форма авторизации</h5>
                            </div>
                            <div class="card-body">
                                <form action="logincode.php" method="POST">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Адрес электроной почты</label>
                                        <input type="email" name="email" class="form-control" id="regPhone">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Пароль</label>
                                        <input type="password" name="password" class="form-control" id="regPassword">
                                    </div>
                                    <button type="submit" name="login_now_btn" class="btn btn-primary">Войти</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>