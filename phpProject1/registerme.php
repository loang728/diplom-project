<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include('setup.php');


                $emails = array();
                $q = "SELECT email FROM users ";
                $r = mysqli_query($dbc, $q);

                while ($row = mysqli_fetch_assoc($r)) {
                   $emails[] = $row['email'];
                }



                if (!in_array($_POST['tMail'], $emails)) {
                  
                    
                        
                          echo "passwords match!";
                       
                            echo "all is set";
                            $first = $_POST['tFirst'];
                            $last = $_POST['tLast'];
                            $email = $_POST['tMail'];
                            $psw = $_POST['pPass'];

                            $qINSERT = "INSERT INTO users (first,last,email,password,background,even, uneven)
                                        VALUES ('$first','$last','$email','$psw','#e3d3e3','#d2cafc','#d5f1eb');";

                            if (mysqli_query($dbc, $qINSERT)) {
                                echo "New record created successfully";
                            } else {
                                echo "Error: " . $qINSERT . "<br>" . mysqli_error($dbc);
                            }
                           
                        
                    
                } else {
                    echo "Потребител с този адрес вече съществува!";
                }
         
     
        
        echo "hi";
        ?>


       
