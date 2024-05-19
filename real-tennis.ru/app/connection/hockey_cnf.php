<?php
$config = array(
    'inst_url' => 'https://www.instagram.com/ontennis.ru/',
    'teleg_url' => 'https://t.me/ontennisru',
    'whats_url' => 'https://wa.me/+79500048474',

    'title' => 'real_hockey',
    );

    $db_host = "localhost";
    $db_user = "u2054783_admin"; // Логин БД
    $db_password = "bdSQL-8861"; // Пароль БД
    $db_base = 'u2054783_hockey'; // Имя БД

    $db = new PDO("mysql:host=$db_host;dbname=$db_base;charset=utf8mb4", $db_user, $db_password);

?>