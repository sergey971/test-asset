<?php

error_reporting(E_ALL);

require_once "../connect/connect.php";

$title = mysqli_real_escape_string($connect, trim($_POST['title']));
$sum = mysqli_real_escape_string($connect, trim($_POST['sum']));
$interest = mysqli_real_escape_string($connect, trim($_POST['interest']));



$error = '';
if (strlen($title) < 5) $error = "Имя должно иметь не менее 5 символов";
else if (strlen($sum) < 3) $error = "Сумма должна иметь не менее 3 символов";
else if (strlen($interest) < 1) $error = "Рост актива должен иметь не менее 1 символов";

if($error) 
{
    echo $error;
    exit();
} else {
    $connect -> query("INSERT INTO `active` (`id`, `title`, `sum`, `interest`) VALUES (NULL, '$title', '$sum', '$interest')");
    echo "ready";
}

