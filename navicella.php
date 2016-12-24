

<?php 
//connessione al database per il recupero dei dati da visualizzare
/*
	$id = mysql_real_escape_string($_GET['id']); 					//faccio l'escape dei caratteri dannosi
	$query = "SELECT * FROM planttable WHERE plantId = '$id' ";		
	$ris = mysql_query($query, $conn) or die (mysql_error());
	$row = mysql_fetch_array($ris);
	$_SESSION['ip_addr'] = $row['ipAddr']; 
	$_SESSION['plant_name'] = $row['plantName'];
*/
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">	
</head>
<body>

<?php
 $registro;
 $registro = 10.67;
	echo "registro:" . decbin($registro); 


?>


</body>
</html>