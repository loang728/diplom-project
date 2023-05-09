<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#Старт на сесия

if(!isset($_SESSION['username'])){
    header('Location: login.php');
}

session_start();
#Изтриване на username
unset($_SESSION['username']);
#Изтрива всички ключове
session_destroy();
header('Location: login.php');
?>
