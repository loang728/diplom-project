<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

	include('setup.php');
        
        
                            $title = $_POST['title'];
                            $desc = $_POST['description'];
                            $date=$_POST['date'];
                            $urgent=$_POST['urgent'];
                            $userid=$_SESSION['userid'];
                          

                            $qINSERT = "INSERT INTO usertasks (title,description,date,urgent,userid)
                                        VALUES ('$title','$desc','$date','$urgent','$userid');";

                            if (mysqli_query($dbc, $qINSERT)) {
                                
                              if (!mysqli_commit($dbc)) {
                                print("Transaction commit failed\n");
                                exit();
                            }
                                echo "New record created successfully";
                            } else {
                                echo "Error: " . $qINSERT . "<br>" . mysqli_error($dbc);
                            }
                            mysqli_close($dbc); 
                            include('updateXMLs.php');
                            
                //mysqli_close($dbc);            
                        }




?>