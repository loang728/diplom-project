<?php
session_start();

$userid=$_SESSION['userid'];
include('setup.php');
echo $_SESSION['userid'];
    
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    $type = $_POST['type'];
    $q="SELECT *
        FROM incomes
        WHERE (date BETWEEN '$dateFrom' AND '$dateTo') AND  userid='$userid' AND type='$type'";
    
    $r = mysqli_query($dbc, $q);
   $num=1;
    $xml="<data> \n \t";
    
    print_r($_POST);
    while ($page = mysqli_fetch_assoc($r)) {
       
        
        $xml .=" \t <item id=\"".$num."\">\n \t\t";
        $xml .= "<amount>".$page['amount']."</amount>\n\t\t";
        $xml .= "<date>". $page['date']."</date>\n\t";
        $xml.="</item>\n\t";
        $num++;
    }
    
   
    

$xml.="</data>";
$xmlobj=new SimpleXMLElement($xml);
$xmlobj->asXML("xml/chartPayments.xml");
mysqli_close($dbc);


