<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
	include('setup.php');
        
                        $type=$_POST['type'];
                            $desc = $_POST['description'];
                            $date=$_POST['date'];
                            $urgent=$_POST['urgent'];
                            $userid=$_SESSION['userid'];
                            $amount=$_POST['amount'];
                            $type=$_POST['type'];
                                
                          

                            $qINSERT = "INSERT INTO incomes (description,date,urgent,userid,amount,type)
                                        VALUES ('$desc','$date','$urgent','$userid','$amount','$type');";

                            if (mysqli_query($dbc, $qINSERT)) {
                                
                              if (!mysqli_commit($dbc)) {
                                print("Transaction commit failed\n");
                                exit();
                            }
                                echo "Плащането е добавено!";
                            } else {
                                echo "Error: " . $qINSERT . "<br>" . mysqli_error($dbc);
                            }
                            mysqli_close($dbc);
                            include('updateXMLs.php');
                            
                            
}
?>