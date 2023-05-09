<?php


#Старт на сесия
session_start();
include('menu.php');

?>
<html>
<head>
    <style>
     .basic {
                position: absolute;
                left: 300px;
                top:100px;
                width: 700px;
                font-family: Verdana, Geneva, sans-serif;
                font-size: 24px;
                color: white;
                text-align: center;
            }
            
      .right {
                position: absolute;
                right: 0px;
                top:530px;
                width: 680px;
                background-color: #75d03b;
                font-family: Verdana, Geneva, sans-serif;
                font-size: 12px;
            }
    </style>
</head>
<body background="common/imgs/financial-planning1366dark.jpg">
 
    <div class="basic">
        <p>
            &nbsp; &nbsp; Органайзърът е инструмент за управление на задачи и плащания, който Ви предлага:
        <ul>
            <li>Съхранение на задачи и плащания</li>
            <li>Управление на задачи и плащания</li>
            <li>Диаграми и изгледи</li>
            <li>Персонализация на Вашия профил</li>
        </ul>
            <br>
            <?php if((!isset($_SESSION['username'])))
            {
            echo" &nbsp; &nbsp;  За да използвате приложението е необходимо да създадете Ваша <a href=\"registration_1.php\" > регистрация </a>.";
            }
                     ?>
                     </p>
        </div>
    <div class="right">
       <p> &nbsp; &nbsp;<a href="userPage.php">Напред към приложението!</a></p>
       </div>
    </ul>
   
</body>
</html>