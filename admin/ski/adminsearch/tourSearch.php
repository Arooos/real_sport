<?php
    session_start();
    require "../../../app/connection/ski_cnf.php";
    $dateTour = $_POST['data_search'];
    $opt = $db->prepare("SELECT * FROM `tournament` WHERE `date` = '$dateTour'");
    $opt->execute(array());
    $value = $opt->fetchall(PDO::FETCH_ASSOC);
    foreach($value as $val){?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>
        <?php 
            $dt = $val["id_categories"];
            $opt = $db->prepare("SELECT `name` FROM `categories` WHERE id = $dt;");
            $opt->execute(array());
            $value = $opt->fetch(PDO::FETCH_COLUMN);
            echo $value
        ?>
    </h2>
        <div class="col-12" style="display: flex;font-size:17px;font-weight:500;margin-bottom:15px">
            <div class="col-8">Участники</div>
            <div class="col-4">Место</div>
        </div>
            <?php
            $opt = $db->prepare("SELECT * FROM `users_result_tour` WHERE `id_tournament` = $val[id]");
            $opt->execute(array());
            $value = $opt->fetchall(PDO::FETCH_ASSOC);
            foreach($value as $val){
                $id_btn = $val["id"];?>
            <form id='<?php echo $id_btn ?>' method="post">
                <div class="input-group col-12">
                    <div class="col-8">
                        <?php
                            $id_result = $val["id_result"];
                            $id_user = $val["id_user"];
                            $id_btn = $val["id"];
                            $_SESSION['ID_user_tour_result'] = $id_btn;
                            $opt = $db->prepare("SELECT `surname`,`name`,`patronymic` FROM `users` WHERE ID = $id_user;");
                            $opt->execute(array());
                            $value = $opt->fetchall(PDO::FETCH_ASSOC);
                            foreach ($value as $val){
                                echo $val["surname"],' ',$val["name"],' ',$val["patronymic"];
                            }
                        ?>
                    </div>
                        <input style="display: none;" method="post" type="text" name="id" value="<?php echo $id_btn ?>">
                        <input class="col-2" method="post" style="height:80%" type="text" name="result" value="<?php echo $id_result ?>" require>
                    <div class="col-2">
                        <button type="submit" id="<?php echo $id_btn ?>" class="btn btn-primary" style="display: flex;align-items:center;;margin-right: 0;margin-left: auto;height:80%;">Записать</button>
                    </div>
                </div>
            </form>                               
</body>
<script>
    $(document).ready(function(){
        $('#<?php echo $id_btn ?>').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type:"POST",
                url: "adminsearch/resultUser.php",
                data: $(this).serialize(),
                success:function(data){
                    console.log(data);
                }
            });
        });
        return false;
    });
</script>
<?php }} ?> 
</html>
    
