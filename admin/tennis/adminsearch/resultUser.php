<?php
    require "../../../app/connection/tennis_cnf.php";
    $id = $_POST['id'];
    $result = $_POST['result'];
    if ($result == false){
        $sql = "UPDATE `users_result_tour` SET `id_result` = null WHERE `users_result_tour`.`id` = $id";
        $query = $db->exec($sql);
        echo "место удалено";
    }
    else {
        $sql = "UPDATE `users_result_tour` SET `id_result` = '$result' WHERE `users_result_tour`.`id` = $id";
        $query = $db->exec($sql);
        echo "место $result добавлено";
    }
   
?>