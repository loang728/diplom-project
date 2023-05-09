<?php
//session_start();

$userid=$_SESSION['userid'];
include('setup.php');

$q = "SELECT * FROM usertasks WHERE userid='$userid'";
$r = mysqli_query($dbc, $q);
//$page = mysqli_fetch_assoc($r);

$xml="<rows> \n \t";
$xml.="<head> \n \t\t" ;
$xml.="<column width=\"70\" type=\"ro\" align=\"left\" sort=\"str\"> Номер </column> \n \t\t";
$xml.="<column width=\"100\" type=\"ro\" align=\"left\" sort=\"str\"> Дата </column> \n \t\t";
$xml.="<column width=\"100\" type=\"ro\" align=\"left\" sort=\"str\"> Заглавие </column> \n \t";
$xml.="<column width=\"400\" type=\"ro\" align=\"left\" sort=\"str\"> Описание </column> \n \t";
$xml.="<column width=\"150\" type=\"ro\" align=\"left\" sort=\"str\"> Задължителна </column> \n \t";
$xml.="<column width=\"150\" type=\"ro\" align=\"left\" sort=\"str\"> Приключена </column> \n \t";
$xml.="</head>\n";
//$xml="";

$num=1;
while($page = mysqli_fetch_assoc($r))
{
    
    if($page['urgent']==1) $urgent="Да"; else $urgent="Не";
    if($page['completed']==1) $completed="Да"; else $completed="Не";
    if($page['date']=="0000-00-00") $date="Безсрочна"; else $date=$page['date'];
    $xml .=" \t <row id=\"".$num."\">\n \t\t";
    $xml .= "<cell>".$page['id']."</cell>\n\t\t";
    $xml .= "<cell>".$date."</cell>\n\t\t";
    $xml .= "<cell>".$page['title']."</cell>\n\t\t";
    $xml .= "<cell>".$page['description']."</cell>\n\t";
    $xml .= "<cell>".$urgent."</cell>\n\t";
    $xml .= "<cell>".$completed."</cell>\n\t";
    $xml.="</row>\n\t";
    $num++;
}
$xml.="</rows>";
$xmlobj=new SimpleXMLElement($xml);
$xmlobj->asXML("xml/text.xml");

mysqli_close($dbc);


?>