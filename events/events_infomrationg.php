<?php

$mysql_host = "mysql10.000webhost.com";
$mysql_database = "a9431445_Events";
$mysql_user = "a9431445_events";
$mysql_password = "mario004";




$con = mysql_connect("$mysql_host","$mysql_user","$mysql_password");



if ( ! $con) 
  die ("connection impossible"); 
  // Connecte la base 
  mysql_select_db($mysql_database) or die ("pas de connection"); 

mysql_query("INSERT INTO Persons (FirstName, LastName, Age)
VALUES ('Peter', 'Griffin',35)");



mysql_query("INSERT INTO  `a9431445_events`.`events` (
`Event` ,
`date` ,
`time` ,
`Location` ,
`information_bref` ,
`information`)
VALUES ( 'Nyon shoping' ,'01/05/2013' ,'8:30-16:30' ,'Nyon' ,'information_bref', 'information')");

mysql_query("INSERT INTO Persons (FirstName, LastName, Age) 
VALUES ('Glenn', 'Quagmire',33)");

  $requete="SELECT * from user"; // requête 
  mysql_query($requete,$con); // envoi de la requête 
 
 
 
?>