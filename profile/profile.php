<?php
    include('authentication.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
</head>
<body>
    <section class="info">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="img_profile"><?php ?></div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="name"><?php ?></div>
                    <div class="lastname"><?php ?></div>
                    <div class="phone"><?php ?></div>
                    <div class="email">
                        <?php ?>
                        <div class="confirmed"><?php ?></div>
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
</body>

<script>
    $('.modal_history_close').on('click', function(){
        $('#modal_history').fadeOut('o.5s')
    })
</script>

</html>