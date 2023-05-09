<?php

session_start();
print_r($_POST);

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	include('setup.php');
        
                            $paymentid=$_POST['paymentId'];
                            $qUPDATE = "UPDATE incomes SET completed=true WHERE id='$paymentid';";

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