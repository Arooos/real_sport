<?php 
session_start();
require "../app/connection/tennis_cnf.php";
    // if ($error == UPLOAD_ERR_OK) {
    //     $name = basename($_FILES["img"]["name"]);
    //     move_uploaded_file($_FILES["img"]["tmp_name"], "uploads/$name");
    //     $_SESSION['img_status'] = "картинка загружена успешно";
    //     header("Location: profile.php");
    //     exit();
    // }
    // else {
    //     $_SESSION['img_status'] = "Ошибка! Картинка не была загружена";
    //     header("Location: profile.php");
    //     exit();
    // }


        $img_name = $_FILES['img']['name'];
        $img_size = $_FILES['img']['size'];
        $tmp_name = $_FILES['img']['tmp_name'];
        $error = $_FILES['img']['error'];

        if ($error === 0) {
            if ($img_size > 10485760) {
                $_SESSION['img_status'] = "Ошибка! Картинка не должна превышать 10 мегабайт";
                header("Location: profile.php");
                exit();
            }else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png"); 

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'uploads/'.$new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // Insert into Database
                    $id_user = $_SESSION['auth_user']['userID'];
                    $sql = "UPDATE `users` SET `img_path` = '$new_img_name' WHERE ID = '$id_user'";
                    $query = $db->exec($sql);

                    $_SESSION['img_status'] = "Картинка успешно загружена";
                    // header("Location: profile.php");
                }else {
                    $_SESSION['img_status'] = "Ошибка! Вы не можете загрузить данный тип файла";
                    // header("Location: profile.php");
                }
            }
        }else {
            $_SESSION['img_status'] = "Ошибка! Картинка не загружена";
            // header("Location: profile.php");
        }

?>