<?php

error_reporting(E_ALL);
require "../connect/connect.php";
if (isset($_GET['id'])||isset($_GET['title']) || isset($_GET['sum']) || isset($_GET['interest'])) {
    
    $title = mysqli_real_escape_string($connect, trim($_GET['title']));
    $sum = mysqli_real_escape_string($connect, trim($_GET['sum']));
    $interest = mysqli_real_escape_string($connect, trim($_GET['interest']));


    $error = '';
    if (strlen($title) < 5) $error = "Актив должен содержать не менее 5 символов";
    else if (strlen($sum) < 7) $error = "Сумма должен содержать не менее 7 символов";
    else if (strlen($interest) < 1) $error = "Проценты должен содержать не менее 1 символов";
    if ($error) {
        echo $error;
        exit();
    } else {
        $id = $_GET['id'];
        $connect->query("UPDATE `active` SET `title` = '$title', `sum` = '$sum', `interest` = '$interest' WHERE `active`.`id` = $id");
        echo "ready";
    }
}
