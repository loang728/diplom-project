<?php
session_start();

$userid=$_SESSION['userid'];
include('setup.php');
echo $_SESSION['userid'];
    
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    // date>'$dateFrom' AND date<'$dateTo' AND 
    //$q = "SELECT * FROM usertasks WHERE date>='$dateFrom' AND date<='$dateTo' AND userid='$userid'";
    $q="SELECT *
        FROM usertasks
        WHERE (date BETWEEN '$dateFrom' AND '$dateTo') AND  userid='$userid'";
    
    $r = mysqli_query($dbc, $q);
    $num = mysqli_num_rows($r);
    
    print_r($num);
    $arrayAllDates = array();
    while ($page = mysqli_fetch_assoc($r)) {
        //$arrayAllDates=$page['date'];
        array_push($arrayAllDates, $page['date']);
    }
    
    print_r($arrayAllDates);
    $counts=array();
    $counts=array_count_values($arrayAllDates);
     print_r($counts);
    $num=1;
    $xml="<data> \n \t";
    
    foreach ($counts as $key => $value) {

        $xml .=" \t <item id=\"".$num."\">\n \t\t";
        $xml .= "<taskscount>".$value."</taskscount>\n\t\t";
        $xml .= "<date>". $key."</date>\n\t";
        $xml.="</item>\n\t";
        $num++;
}
$xml.="</data>";
$xmlobj=new SimpleXMLElement($xml);
$xmlobj->asXML("xml/chartTasks.xml");
mysqli_close($dbc);


