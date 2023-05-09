<?php

print_r($_POST);
session_start();
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	include('setup.php');
        
        
                            $desc = $_POST['description'];
                            $type = $_POST['type'];
                            $date=$_POST['date'];
                            $urgent=$_POST['urgent'];
                            //$userid=$_SESSION['userid'];
                            $completed=$_POST['completed'];
                            $paymentid=$_POST['id'];
                            $amount=$_POST['amount'];
                          

                            $qUPDATE = "UPDATE incomes SET description='$desc',type='$type',date='$date',amount='$amount',urgent='$urgent',completed='$completed' WHERE id='$paymentid';";

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
