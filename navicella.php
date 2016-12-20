<?php include_once("config.php"); ?>

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
	<title><?php echo $_CONFIG['site_name'] ?> Navicella</title>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
	<link href="/css/desktop.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-3.1.0.js"></script>	<!-- LIBRERIA JAVASCRIPT -->
	<script type="text/javascript" src="js/writingfunc.js"></script>	<!-- FILE JS PER SCRITTURA -->
	<script type="text/javascript" src="js/plant_refresh.js"></script> 	<!-- FILE JS PER AGGIORNAMENTO LETTURA -->
	<script>var CANV_GAUGE_FONTS_PATH = 'fonts'</script>
	<script src="js/gauge.js"></script>
	
</head>
<body>

<image



</body>
</html>