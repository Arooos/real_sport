<?php 
    session_start();
    require "../app/connection/tennis_cnf.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    function sendemail_verify($name, $email, $verify_token, $password)
    {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 2;
            $mail->isSMTP();                                       
            $mail->SMTPAuth   = true;  
            $mail->CharSet = "UTF-8";

            $mail->Host       = 'ssl://smtp.gmail.com';                                   
            $mail->Username   = 'realtennis001@gmail.com';                     //SMTP username
            $mail->Password   = "pdclafbzzjpdzmzd";                               //SMTP password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('realtennis001@gmail.com', $name);
            $mail->addAddress($email);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Real Tennis';

            $email_template = "
                <h2>Вы зарегистрировались на сайте real-tennis</h2>
                <h5>Ваш пароль: $password</h5>
                <h5>Подтвердите пожалуста свой email по ссылке ниже</h5>
                <br/><br/>
                <a href='http://localhost/profile/verify-email.php?token=$verify_token'>Нажми меня</a>
            ";

            $mail->Body = $email_template;
            $mail->send();
        }

    if (isset($_POST['register_btn']))
        {
            $name = $_POST['name'];
            $surname = $_POST['lastname'];
            $patronymic = $_POST['patronymic'];
            $phone = $_POST['phone'];
            $select = $_POST['select'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $verify_token = md5(rand());

            if (empty($name)){
                $_SESSION['status'] = "Введите имя";
                header("Location: registration.php");
                exit;
            }
            elseif (empty($surname)){
                $_SESSION['status'] = "Введите фамилию";
                header("Location: registration.php");
                exit;
            }
            elseif (empty($email)){
                $_SESSION['status'] = "Введите адрес электронной почты";
                header("Location: registration.php");
                exit;
            }
            elseif (empty($phone)){
                $_SESSION['status'] = "Введите мобильный телефон";
                header("Location: registration.php");
                exit;
            }
            elseif (empty($password)){
                $_SESSION['status'] = "Введите пароль";
                header("Location: registration.php");
                exit;
            }
            else {
                //проверка email
                $opt = $db->prepare("SELECT `email` FROM `users` WHERE `email` = '$email'");
                $opt->execute(array());
                $value = $opt->fetchall(PDO::FETCH_ASSOC);
                $email_val = $value[0]['email'];

                $opt = $db->prepare("SELECT `phone` FROM `users` WHERE `phone` = '$phone'");
                $opt->execute(array());
                $value = $opt->fetchall(PDO::FETCH_ASSOC);
                $phone_val = $value[0]['phone'];
                ?>
                <script>
                console.log(<?= json_encode($phone_val); ?>);
                console.log(<?= json_encode($email_val); ?>);
                </script>
                <?
                if ($email_val == $email || $phone == $phone_val){
                    //если пользователь уже в системе
                    $_SESSION['status'] = "Email $email_val или телефон $phone уже существует, пожалуйста войдите или проверьте данные";
                    header("Location: login.php");
                } else {
                    $phone= str_replace([' ', '(', ')', '-'], '', $phone);
                    // делаем проверку для записи id
                    if ($select == 'любитель'):
                    $select = 1;
                    else:
                    $select = 2;
                    endif;
                    
                    // добавить пользователя
                    $sql = "INSERT INTO `users` (`id`, `surname`, `name`, `patronymic`, `phone`, `id_class`, `email`, `password`, `verify_token`) VALUES (NULL, '$surname', '$name', '$patronymic', '$phone', '$select', '$email', '$password', '$verify_token')";
                    $query = $db->exec($sql);

                    if($query){
                        sendemail_verify("$name", "$email", "$verify_token", "$password");

                        $_SESSION['status'] = "Вы успешно зарегистрировались! Пожалуйста, подтвердите Вашу электронную почту. $check_email_query ";
                        header("Location: registration.php");
                    }
                    else{
                        $_SESSION['status'] = "Ошибка регистрации";
                        header("Location: registration.php");
                    }
                }
            }
        }
?>

