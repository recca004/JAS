<?php

$mysql_host = "mysql10.000webhost.com";
$mysql_database = "a9431445_Events";
$mysql_user = "a9431445_events";
$mysql_password = "mario004";
 
$eventsform=$_REQUEST['eventsform'];
$dateform=$_REQUEST['dateform'];
$timeform=$_REQUEST['timeform'];
$locationform=$_REQUEST['locationform'];
$information_brefform=$_REQUEST['information_brefform'];
$informationform=$_REQUEST['informationform'];

$con = mysql_connect("$mysql_host","$mysql_user","$mysql_password");
if ( ! $con) 
  die ("connection impossible"); 
  // Connecte la base 
mysql_select_db($mysql_database) or die ("pas de connection"); 

$query = "INSERT INTO `a9431445_events`.`events` VALUES ('NULL','$eventsform','$dateform','$timeform','$locationform','$information_brefform','$informationform')"; 
mysql_query($query) or die('Error ' .mysql_error()); 
echo "Database updated"; 

?>
