
<?php
session_start();
include('setup.php');

#Проверка за съответствие между потребител и парола

if ($_POST) {

    $q = "SELECT * FROM users where email='$_POST[user]' AND password='$_POST[password]'";
    $r = mysqli_query($dbc, $q);
    $num = mysqli_num_rows($r);
    $userdata= mysqli_fetch_assoc($r);
    
    if ($num == 1) {
        //echo "Yes";
        $_SESSION['username'] = $_POST['user'];
        $_SESSION['userid']=$userdata['id'];
        $_SESSION['userfirst']=$userdata['first'];
        $_SESSION['userlast']=$userdata['last'];
        $_SESSION['background'] = $userdata['background'];
        $_SESSION['even']=$userdata['even'];
        $_SESSION['uneven']=$userdata['uneven'];
        echo "<br>";
        var_dump($userdata);
        header('Location: userPage.php');
    } else {
        //echo "Моля, проверете отново името и паролата си!";
      // echo" <font size=\"4\" color=\"#2ca5a5\" top=\"500px\"> <br> <br> &nbsp Моля, проверете отново името и паролата си!</font>";
    
        echo "<script> alert (\"fsfsef\") </script>";
    }
    
    
   
 
        //echo "Yes";
       
}
mysqli_close($dbc);
?>


<html>
    <head>
        <title>Вход</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<script src="codebase/dhtmlx.js"></script>
        <link rel="stylesheet" type="text/css" href="css/login.css"/>
     <style>
            .rightt {
                position: absolute;
                left: 0px;
                top:  30px;
                width: 400px;
                background-color: #9bb7df;
                font-family: Verdana, Geneva, sans-serif;
                font-size: 12px;
            }
            
            .left {
                position: absolute;
                right: 0px;
                top:500px;
                width: 400px;
                background-color: #9bb7df;
                font-family: Verdana, Geneva, sans-serif;
                font-size: 12px;
            }
            
            
        </style>   
    </head>
  
    <body onload="doOnLoad();" >
       <?php include('menu.php'); ?>
     <h2>Влезте в профила си, за да използвате приложението!</h2>
<div class="signup">
                 <form action="login.php" method="post" role="form" >
		<span class="ribben">Вход в системата</span>
		<p>Електронен адрес : <span class="dot"> </span></p>
		<input type="text" name="user"  placeholder="example@email.com" required="">
		<p>Парола: <span class="dot"> </span></p>
	 	<input type="password" name="password" placeholder="" required="">
	 	
	 	<input type="submit" value="Вход">
                </form>
</div>

    </body>
</html>