<?php
//Import the PhpJasperLibrary
include_once('phpjasperxml_0.9d/class/tcpdf/tcpdf.php');
include_once("phpjasperxml_0.9d/class/PHPJasperXML.inc.php");
//database connection details
$server="localhost";
$db="softcaisse";
$user="root";
$pass="";
// $version="0.8b";
// $pgport=5432;
// $pchartfolder="./class/pchart2";
//display errors should be off in the php.ini file
ini_set('display_errors', 1);
//setting the path to the created jrxml file
// $xml=  simplexml_load_file("PhpJasperLibrary/bill.jrxml");
$PHPJasperXML= new  PHPJasperXML();
$PHPJasperXML->debugsql=true;
echo "oo";
$PHPJasperXML->arrayParameter=array("parameter1"=>1);
$PHPJasperXML->load_xml_file("PhpJasperLibrary/bill.jrxml");
echo "oo";
// $PHPJasperXML->xml_dismantle($xml);
print_r($PHPJasperXML->transferDBtoArray($server,$user,$pass,$db));
echo "oo";
// echo "oo";
$PHPJasperXML->outpage("D");    //page output method I:standard output  D:Download file
?>