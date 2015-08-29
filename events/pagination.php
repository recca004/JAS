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

/*
include 'connect_myql.php';
*/
$par_page=3;

$page_query= mysql_query("SELECT  'Event', COUNT(  'ID' )
FROM  `events` ");

$pages=ceil(mysql_result($page_query, 0));

$page=(isset($_GET['page'])) ? (int)$_GET['page']:1;
$start=($page -1)*$par_page;


$query = mysql_query("SELECT  `Event` ,  `date` ,  `time` ,  `Location` ,  `information_bref` ,  `information` 
FROM  `events` LIMIT $start,$par_page");

while($query_row=mysql_fetch_assoc($query)){
	
	echo '<h3>',$query_row['Event'],'</h3>';
	echo '<p class="dates">',$query_row['date'],'</p>';
	echo '<p class="times">',$query_row['time'],'</p>';
	echo '<p>',$query_row['Location'], ' </p>';
	echo '<p> <hr /> </p>';
	
 
}
if ($pages >=1 && $page <= $pages){
	for($x=1; $x<=$pages; $x++){
	
echo ($x == $page)? '<strong><a href="?page='.$x.'">'.$x.'</a></strong>' : '<a href="?page='.$x.'">'.$x.'</a>';
	}
}


?>
