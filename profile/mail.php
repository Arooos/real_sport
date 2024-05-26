<?php 
    session_start();
    require "../app/connection/tennis_cnf.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/phpmailer/phpm';

    function sendEmail_verify($name, $email, $verify_token){

    };

    if (isset($_POST['register_btn']))
        {
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $patronymic = $_POST['patronymic'];
            $phone = $_POST['phone'];
            $select = $_POST['select'];
            $email = $_POST['email'];
            $password = $_POST['Password'];
            $rePassword = $_POST['rePassword'];
            $verify_token = md5(rand());

            //проверка email
            $opt = $db->prepare("SELECT `email` FROM `users` WHERE `email` = '$email' LIMIT 1");
            $opt->execute(array());
            $check_email_query = $opt->fetch(PDO::FETCH_COLUMN);
            if ($check_email_query > 0){
                //если пользователь уже в системе
                $_SESSION['status'] = "Email уже существует";
                header("Location: registration.php");
            }
            else {
                // добавить пользователя 
                $sql = "INSERT INTO `users` (`id`, `surname`, `name`, `patronymic`, `phone`, `id_class`, `password`, `email`, `verify_token`) VALUES (NULL, '$surname', '$name', '$patronymic', '$phone', '$select', '$password', '$email', '$verify_token')";
                $query = $db->exec($sql);

                if($query){
                    sendEmail_verify("$name", "$email", "$verify_token");

                    $_SESSION['status'] = "Вы успешно зарегистрировались! Пожалуйста, подтвердите Вашу элшектронную почту. ";
                    header("Location: registration.php");
                }
                else{
                    $_SESSION['status'] = "Ошибка регистрации";
                    header("Location: registration.php");
                }
            }
        }
?>

