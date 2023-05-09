<?php
session_start();


if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    
    include('setup.php');
    

    $pass=$_POST['password'];
    $usr=$_POST['user'];
    //$q = "SELECT * FROM users where email='$usr' AND password='$pass'";
    
     $q = "SELECT * FROM users where email='$_POST[user]' AND password='$_POST[password]'";
    $r = mysqli_query($dbc, $q);
    $num = mysqli_num_rows($r);
    if ($num == 1) {
        echo "Yes";
        $_SESSION['username'] =$_POST[user];
        $_SESSION['username'] = $_POST['user'];
        $_SESSION['userid']=$userdata['id'];
        $_SESSION['userfirst']=$userdata['first'];
        $_SESSION['userlast']=$userdata['last'];
        
        header('Location: index.php');
     
    } else {
        echo "Моля, проверете отново името и паролата си!";
        // die;
    }
   
}
else echo "nishto nqma tuk";
?>