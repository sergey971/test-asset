<?php
$connect=mysqli_connect('localhost', 'root', 'root', 'gb');
if(!$connect){
    echo "Ошибка соединения";
    exit();
}