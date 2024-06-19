<?php
    setlocale(LC_ALL, 'ru_RU.utf8');
    session_start(); 
    $case = $_SESSION['case'];
    switch($case){
        case 1: 
            require "app/connection/basketball_cnf.php";
            break;
        case 2: 
            require "app/connection/hockey_cnf.php";
            break;
        case 3: 
            require "app/connection/ski_cnf.php";
            break;
        case 4: 
            require "app/connection/tennis_cnf.php";
            break;
    }

    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $patronymic = $_POST['patronymic'];
    $select = $_POST['select'];
    $phone = $_POST['phone'];
    $token = "6151514804:AAGk6pAtx-zsjN1QRXMQMQz9YMZ-MVBH1rQ";
    $chat_id = "-860516376";
    $arr = array(
        'Фамилия: ' => $surname,
        'Имя: ' => $name,
        'Отчество: ' => $patronymic,
        'Класс: ' => $select,
        'Телефон: ' => $phone,
    );
    
    foreach($arr as $key => $value) {
        $txt .= "<b>".$key."</b> ".$value."%0A";
    };
    $txt = urlencode($txt);

    $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

    //убираем лишнее из номера
    $phone= str_replace([' ', '(', ')', '-'], '', $phone);
    // делаем проверку для записи id
    if ($select == 'любитель'):
    $select = 1;
    else:
    $select = 2;
    endif;
    //ввод данных из "записи" в таблицу users
        //ищем есть ли участник в базе
        $opt = $db->prepare("SELECT `phone` FROM `users` WHERE `phone` = $phone");
        $opt->execute(array());
        $value = $opt->fetchall(PDO::FETCH_ASSOC);
        $phone_val = $value[0]['phone'];
        if ($phone_val == $phone){
            //  если есть то получаем его id
            $opt = $db->prepare("SELECT `ID` FROM `users` WHERE `phone` = $phone");
            $opt->execute(array());
            $id_user = $opt->fetch(PDO::FETCH_COLUMN);
        }
        else {
            $sql = "INSERT INTO `users` (`id`, `surname`, `name`, `patronymic`, `phone`, `id_class`) VALUES (NULL, '$surname', '$name', '$patronymic', ' $phone', '$select')";
            $query = $db->exec($sql);
            $opt = $db->prepare("SELECT `ID` FROM `users` WHERE `phone` = $phone");
            $opt->execute(array());
            $id_user = $opt->fetch(PDO::FETCH_COLUMN);
        }
        
    //автоматическая запись в сводную таблицу users_result_tour (участник + турнир)

    //получаем id актуального турнира в который записывается участник
    $opt = $db->prepare("SELECT * FROM `tournament` WHERE date = (SELECT MIN(date) from tournament WHERE date >= CURRENT_DATE);");
    $opt->execute(array());
    $id_tour = $opt->fetch(PDO::FETCH_COLUMN);?>
    <script>
    console.log(<?= json_encode($id_tour); ?>);
    console.log(<?= json_encode($id_user); ?>);
</script>
<?php
    //получаем id_tour из таблицы users_result_tour
    $opt = $db->prepare("SELECT `id` FROM `users_result_tour` WHERE `id_tournament` = $id_tour and `id_user` = $id_user");
    $opt->execute(array());
    $value = $opt->fetchall(PDO::FETCH_ASSOC);
    $id_val = $value[0]['id'];

    if ($id_val){
        exit;
    }
    else{
        $sql = "INSERT INTO `users_result_tour` (`id`, `id_user`, `id_tournament`) VALUES (NULL, '$id_user', '$id_tour')";
        $query = $db->exec($sql);
        $db= null;
        
    }
    
?>