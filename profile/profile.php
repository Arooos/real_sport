<?php
    include('authentication.php');
    include "../app/connection/tennis_cnf.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../css/style.min.css">
    <title>Профиль</title>
</head>
<body>
    <header>
        <nav>  
            <div class="row">
                <div class="container">
                    <div class="col-lg-2 offset-lg-10 col-sm-3 offset-sm-9 col-sm-3 offset-sm-9 col-xs-4 offset-xs-8">
                        <ul class="menu">
                            <li><a href="/tennis.php" class="menu_link">главная</a></li>
                            <li><div class="profile_img"><a href="logout.php"><img src="../icons/profile/logout.png" alt=""></a></div></li>
                        </ul>
                    </div>
                </div>   
            </div>         
        </nav>
    </header>
    <div class="bg">
    <section class="info">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-2 col-md-6 col-sm-12">
                    <img src="uploads/<?=$_SESSION['auth_user']['img_path']?>">
                    <form action="imageProfile.php" method="POST" enctype="multipart/form-data">
                        <input class="select" type="file" name="img">
                        <button class="reload" type="submit">Обновить картинку профиля</button>
                    </form>
                    <div class="alert">
                        <?php
                            if (isset($_SESSION['img_status']))
                            {
                                echo "<h4>".$_SESSION['img_status']."</h4>";
                                unset($_SESSION['img_status']);
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="text">Имя: <span><?php echo $_SESSION['auth_user']['name']?></span></div>
                    <div class="text">Фамилия: <span><?php echo $_SESSION['auth_user']['surname']?></span></div>
                    <div class="text">Телефон: <span><?php echo $_SESSION['auth_user']['phone']?></span></div>
                    <div class="text">Электронная почта: <span><?php echo $_SESSION['auth_user']['email']?></span></div>
                    <div class="text">Уровень игрока: <span>
                        <?php 
                            $id_class = $_SESSION['auth_user']['id_class'];
                            $opt = $db->prepare("SELECT `name` FROM `class` WHERE ID = $id_class");
                            $opt->execute(array());
                            $class = $opt->fetch(PDO::FETCH_COLUMN);
                            echo $class
                        ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="history">
        <div class="container">
            <div class="years"></div>
            <div class="date"></div>
            <div class="tournament">
            <?php  
                require "../app/connection/tennis_cnf.php";
                if(isset($_POST["tournament_id"])){
                    $opt = $db->prepare("SELECT * FROM tournament WHERE id = '".$_POST["tournament_id"]."'");
                    $opt->execute(array());
                    $value = $opt->fetchall(PDO::FETCH_ASSOC);
                    foreach ($value as $row){
                    ?>
                        <div class="col-md-6 col-12">
                            <div class="modal-body">
                                <div class="more_title">
                                <?php
                                $dt = $row["id_categories"];
                                $opt = $db->prepare("SELECT `name` FROM `categories` WHERE ID = $dt;");
                                $opt->execute(array());
                                $value = $opt->fetch(PDO::FETCH_COLUMN);
                                echo $value;
                                ?><br><?php 
                                $dt = $row["id_place"];
                                $opt = $db->prepare("SELECT `name` FROM `place` WHERE ID = $dt;");
                                $opt->execute(array());
                                $value = $opt->fetch(PDO::FETCH_COLUMN);
                                echo $value;
                                ?><br><?php
                                    $class = $db->prepare("SELECT MONTH(`date`) FROM `tournament` WHERE id = '".$_POST["tournament_id"]."'");
                                    $class->execute(array());
                                    $mouth = $class->fetch(PDO::FETCH_COLUMN);
                                    $date = $db->prepare("SELECT DAY(`date`) FROM `tournament` WHERE id = '".$_POST["tournament_id"]."'");
                                    $date->execute(array());
                                    $day = $date->fetch(PDO::FETCH_COLUMN);
                                    $date = $db->prepare("SELECT YEAR(`date`) FROM `tournament` WHERE id = '".$_POST["tournament_id"]."'");
                                    $date->execute(array());
                                    $year = $date->fetch(PDO::FETCH_COLUMN);
                                    $date=explode(".", date("m"));
                                    switch ($mouth){
                                    case 1: $m='января'; break;
                                    case 2: $m='февраля'; break;
                                    case 3: $m='марта'; break;
                                    case 4: $m='апреля'; break;
                                    case 5: $m='мая'; break;
                                    case 6: $m='июня'; break;
                                    case 7: $m='июля'; break;
                                    case 8: $m='августа'; break;
                                    case 9: $m='сентября'; break;
                                    case 10: $m='октября'; break;
                                    case 11: $m='ноября'; break;
                                    case 12: $m='декабря'; break;
                                    }
                                    echo $day.'&nbsp;'.$m.'&nbsp;'.$year;
                                    }
                                ?></div>
                                <div class="more_subtitle">ПОБЕДИТЕЛИ ТУРНИРА:</div>
                                <ul>
                                    <?php 
                                        $opt = $db->prepare("SELECT `surname`,`name` FROM `users` WHERE `id` IN (SELECT `id_user` FROM `users_result_tour` WHERE `id_tournament` = $_POST[tournament_id] AND `id_result` = 1)");
                                        $opt->execute(array());
                                        $value = $opt->fetchall(PDO::FETCH_ASSOC);
                                        foreach ($value as $result_row){
                                        ?>
                                        <li> <?php echo $result_row["surname"],' ',$result_row["name"]?></li>
                                    <?php 
                                        }
                                        $opt = $db->prepare("SELECT `surname`,`name` FROM `users` WHERE `id` IN (SELECT `id_user` FROM `users_result_tour` WHERE `id_tournament` = $_POST[tournament_id] AND `id_result` = 2)");
                                        $opt->execute(array());
                                        $value = $opt->fetchall(PDO::FETCH_ASSOC);
                                        foreach ($value as $result_row){
                                        ?>
                                        <li> <?php echo $result_row["surname"],' ',$result_row["name"]?></li>
                                    <?php 
                                        }
                                        $opt = $db->prepare("SELECT `surname`,`name` FROM `users` WHERE `id` IN (SELECT `id_user` FROM `users_result_tour` WHERE `id_tournament` = $_POST[tournament_id] AND `id_result` = 3)");
                                        $opt->execute(array());
                                        $value = $opt->fetchall(PDO::FETCH_ASSOC);
                                        foreach ($value as $result_row){
                                        ?>
                                        <li> <?php echo $result_row["surname"],' ',$result_row["name"]?></li>
                                    <?php 
                                        }
                                    ?>
                                </ul>
                                <div class="more_subtitle">ДОПОЛНИТЕЛЬНЫЙ ТУРНИР</div>
                                <ul>
                                    <?php
                                        $opt = $db->prepare("SELECT `surname`,`name` FROM `users` WHERE ID = (SELECT `id_user` FROM `users_result_tour` WHERE `id_tournament` = $_POST[tournament_id] AND `id_result` = 4)");
                                        $opt->execute(array());
                                        $value = $opt->fetchall(PDO::FETCH_ASSOC);
                                        foreach ($value as $result_row){
                                        ?>
                                        <li> <?php echo $result_row["surname"],' ',$result_row["name"]?></li>
                                    <?php }?>
                                </ul>
                                <a href="">фото</a>';  
                            </div>
                        </div>
                        <div class="col-md-6 col-12 pl">
                            <div class="more_subtitle more_subtitle_mt0">СОСТАВ УЧАСТНИКОВ:</div>
                            <ul>
                                <?php 
                                    $opt = $db->prepare("SELECT id_user FROM users_result_tour WHERE id_tournament = '".$_POST["tournament_id"]."'");
                                    $opt->execute(array());
                                    $value = $opt->fetchall(PDO::FETCH_ASSOC);
                                    foreach ($value as $row){
                                ?>
                                <li>
                                    <?php
                                        $opt = $db->prepare("SELECT `surname` FROM `users` WHERE ID = $row[id_user]");
                                        $opt->execute(array());
                                        $surname = $opt->fetch(PDO::FETCH_COLUMN);
                                        $opt = $db->prepare("SELECT `name` FROM `users` WHERE ID = $row[id_user]");
                                        $opt->execute(array());
                                        $name = $opt->fetch(PDO::FETCH_COLUMN);
                                        echo $surname,' ',$name;
                                    ?>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                <?php }?>
            </div>
        </div>
    </section>
    </div>
    
</body>

<script>
    $('.modal_history_close').on('click', function(){
        $('#modal_history').fadeOut('o.5s')
    })
</script>

</html>