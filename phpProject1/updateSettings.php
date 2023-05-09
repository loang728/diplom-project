<?php

print_r($_POST);
session_start();
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	include('setup.php');
        
                            $userid=$_SESSION['userid'];
                            $background = $_POST['background'];
                            $even = $_POST['even'];
                            $uneven=$_POST['uneven'];
                           
                          

                            $qUPDATE = "UPDATE users SET background='$background',even='$even',uneven='$uneven' WHERE id='$userid';";

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
                            $_SESSION['background']=$background;
                            $_SESSION['even']=$even;
                            $_SESSION['uneven']=$uneven;
                          //include('updateXMLs.php');  
                        }


