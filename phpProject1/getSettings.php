<?php
session_start();
include('setup.php');
include('globals.php');
$userid=$_SESSION['userid'];

    $qSettings = "SELECT * FROM userssettings where userid='$userid'";
    $rSettings = mysqli_query($dbc, $qSettings);
    $userdataSettings= mysqli_fetch_assoc($rSettings);
 
        //echo "Yes";
        $_SESSION['background'] = $userdataSettings['background'];
        $_SESSION['even']=$userdataSettings['even'];
        $_SESSION['uneven']=$userdataSettings['uneven'];
?>