<?php 
    session_start();
    require "../app/connection/tennis_cnf.php";

    if (isset($_GET['token'])) 
    {
        $token = $_GET['token'];
        
        $opt = $db->prepare("SELECT `verify_token`, `verify_status` FROM `users` WHERE `verify_token` = '$token' LIMIT 1");
        $opt->execute(array());
        $value = $opt->fetchall(PDO::FETCH_ASSOC);
        $token_val = $value[0]['verify_token'];
        $status_val = $value[0]['verify_status'];
        if ($token_val == $token){
            //если токен уже в системе
            if($status_val == 0){
                $sql = "UPDATE `users` SET `verify_status` = '1' WHERE `verify_token` = '$token_val' LIMIT 1";
                $query = $db->exec($sql);

                if ($query){
                    $_SESSION['status'] = "Вы успешно подтвердили почту!";
                    header("Location: login.php");
                    exit(0);
                }
                else {
                    $_SESSION['status'] = "Ошибка подтверждения почты!";
                    header("Location: login.php");
                    exit(0);
                }

            }
            else {
                $_SESSION['status'] = "Этот email уже подтверждён, пожалуйста войдите в аккаунт";
                header("Location: login.php");
            }
        } 
        else 
        {
            $_SESSION['status'] = "Этот email не подтверждён";
            header("Location: login.php");
        }
        

    }
    else {
        $_SESSION['status'] = "Not Allowed";
        header("Location: login.php");
    }
    ?>