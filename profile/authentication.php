<?php
session_start();

if(!isset($_SESSION['authenticadet']))
{
    $_SESSION['status'] = "Пожалуйста зарегистрируйтесь или войдите в аккаунт для активации личного кабинета";
    header('Location: login.php');
    exit(0);
}

?>