<?php
session_start();
require "../app/connection/tennis_cnf.php";
if(isset($_POST['login_now_btn']))
{
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $opt = $db->prepare("SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password' LIMIT 1;");
        $opt->execute(array());
        $value = $opt->fetchall(PDO::FETCH_ASSOC);
        if (isset($value[0]))
        {
            if($value[0]['verify_status'] == "1")
            {
                $userData = $value[0];
                $_SESSION['authenticadet'] = TRUE;
                $_SESSION['auth_user'] = [
                    'userID' => $userData['id'],
                    'name' => $userData['name'],
                    'surname' => $userData['surname'],
                    'patronymic' => $userData['patronymic'],
                    'phone' => $userData['phone'],
                    'id_class' => $userData['id_class'],
                    'email' => $userData['email'], 
                    'img_path' => $userData['img_path'],
                ];
                $_SESSION['status'] = "Вы успешно авторизировались";
                header("Location: profile.php");
                exit();
            } 
            else 
            {
                $_SESSION['status'] = "Подтвердите Вашу электронную почту для входа";
                header("Location: login.php");
                exit();
            }
        }
        else {
            $_SESSION['status'] = "Неверный адрес электронной почты или пароль";
            header("Location: login.php");
            exit();
        }
    }
    else
    {
        $_SESSION['status'] = "All field are Mandentory";
        header("Location: login.php");
        exit();
    }
    
}
?>