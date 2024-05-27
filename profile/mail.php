<?php 
    session_start();
    require "../app/connection/tennis_cnf.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/phpmailer/phpm';

    function sendEmail_verify($name, $email, $verify_token){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'user@example.com';                     //SMTP username
            $mail->Password   = 'secret';                               //SMTP password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($email);     //Add a recipient

            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $email_template = "
                <h2> Вы зареистрировались на сайте real-tennis</h2>
                <h5>Подтвердимте пожалуста свой email по ссылке ниже</h5>
                <br/><br/>
                <a href='http://localhost/'></a>
            ";

            $mail->Body = $email_template;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
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

