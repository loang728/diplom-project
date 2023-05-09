<?php

session_start();
print_r($_POST);

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	include('setup.php');
        
        
                            $title = $_POST['title'];
                            $desc = $_POST['description'];
                            $date=$_POST['date'];
                            $urgent=$_POST['urgent'];
                            $completed=$_POST['completed'];
                            $userid=$_SESSION['userid'];
                            $taskid=$_POST['id'];
                          

                            $qUPDATE = "UPDATE usertasks SET title='$title',description='$desc',date='$date',urgent='$urgent',completed='$completed' WHERE id='$taskid';";

                            if (mysqli_query($dbc, $qUPDATE)) {
                                
                              if (!mysqli_commit($dbc)) {
                                print("Transaction commit failed\n");
                                exit();
                              }
                                echo "New record updated successfully";
                            } else {
                                echo "Error: " . $qUPDATE . "<br>" . mysqli_error($dbc);
                            }
                            mysqli_close($dbc);
                            include('updateXMLs.php');  
                            
                        }


?>
?>