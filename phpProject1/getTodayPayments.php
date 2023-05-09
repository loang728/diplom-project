<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$userid=$_SESSION['userid'];
include('setup.php');

$q = "SELECT * FROM incomes WHERE DATE= CURDATE() AND userid='$userid'";
$r = mysqli_query($dbc, $q);
//$page = mysqli_fetch_assoc($r);

$xml="<rows> \n \t";
$xml.="<head> \n \t\t" ;
$xml.="<column width=\"100\" type=\"ro\" align=\"left\" sort=\"str\"> Номер </column> \n \t\t";
$xml.="<column width=\"100\" type=\"ro\" align=\"left\" sort=\"str\"> Вид </column> \n \t\t";
$xml.="<column width=\"100\" type=\"ro\" align=\"left\" sort=\"str\"> Дата </column> \n \t\t";
$xml.="<column width=\"400\" type=\"ro\" align=\"left\" sort=\"str\"> Описание </column> \n \t";
$xml.="<column width=\"100\" type=\"ro\" align=\"left\" sort=\"str\"> Размер </column> \n \t";
$xml.="<column width=\"150\" type=\"ro\" align=\"left\" sort=\"str\"> Задължителен </column> \n \t";
$xml.="<column width=\"150\" type=\"ro\" align=\"left\" sort=\"str\"> Приключен </column> \n \t";
$xml.="</head>\n";
//$xml="";

$num=1;
while($page = mysqli_fetch_assoc($r))
{
   
   
    if($page['urgent']==1) $urgent="Да"; else $urgent="Не";
    if($page['completed']==1) $completed="Да"; else $completed="Не";
    if($page['type']==1) $type="Приход"; else $type="Разход";
    
    $xml .=" \t <row id=\"".$num."\">\n \t\t";
    $xml .= "<cell>".$page['id']."</cell>\n\t\t";
    $xml .= "<cell>".$type."</cell>\n\t\t";
    $xml .= "<cell>".$page['date']."</cell>\n\t";
    $xml .= "<cell>".$page['description']."</cell>\n\t";
    $xml .= "<cell>".$page['amount']."</cell>\n\t\t";
    $xml .= "<cell>".$urgent."</cell>\n\t";
    $xml .= "<cell>".$completed."</cell>\n\t";
    $xml.="</row>\n\t";
    $num++;
   
}
$xml.="</rows>";
$xmlobj=new SimpleXMLElement($xml);
$xmlobj->asXML("xml/todayPayments.xml");
mysqli_close($dbc);


?>