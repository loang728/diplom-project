<?php

session_start();
include('setup.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    include('setup.php');
    $id = $_POST['taskId'];


    $qDELETE = "DELETE FROM usertasks WHERE id='$id';";
    
    
    
    if (mysqli_query($dbc, $qDELETE)) {
                                
                              if (!mysqli_commit($dbc)) {
                                print("Transaction commit failed\n");
                                exit();
                            }
                                echo "Задачата е изтрита.";
                            } else {
                                echo "Error: " . $qDELETE . "<br>" . mysqli_error($dbc);
                            }
                            mysqli_close($dbc);
                            include('updateXMLs.php');
                             
}
?>