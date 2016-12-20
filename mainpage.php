<?php
session_start();
include_once("config.php");

//controllo se la sessione è attiva

if (!(isset($_SESSION['auth']) && $_SESSION['auth'] == AUTH_LOGGED)) {
	$_SESSION['auth'] = AUTH_NOT_LOGGED;
	echo '<script language=javascript>document.location.href="notifica.php"</script>'; 
} else {
	
	$cod = $_SESSION['cod']; 
}

//timeout sessione

/* SCOMMENTARE PER ABILITARE LA FUNZIONE TIMEOUT - LE INTERAZIONI CON JAVASCRIPT NON VALGONO A PROLUNGARE LA SESSIONE
if (isset($_SESSION['last_act']) && (time() - $_SESSION['last_act'] > $_CONFIG['expire'])) {
    $_SESSION['auth'] = AUTH_EXPIRED;
	echo '<script language=javascript>document.location.href="notifica.php"</script>';
}
*/
// $_SESSION['last_act'] = time(); // aggiornamento timestamp act

$_SESSION['ip_addr'] = NULL;
$_SESSION['plant_name'] = NULL;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title><?php echo $_CONFIG['site_name'] ?> - Impianti</title>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-3.1.0.js"></script>
	<script type="text/javascript" src="js/check_conn.js"></script>	
	<!-- <script type="text/javascript" src="js/global_refresh.js"></script> FILE JS PER AGGIORNAMENTO LETTURA - SCOMMENTARE A JS PRONTO -->
	<script>var CANV_GAUGE_FONTS_PATH = 'fonts'</script>
	<script src="js/gauge.js"></script>
	
</head>
<body onload="checkConnection(); setInterval(checkConnection,10000);">
	
	<div class="header">
		<div class="logo">
			<img src="/img/logo.png" title=<?php echo $_CONFIG['logo'] ?> width="92" height="92">
		</div>
		<div class="title_container">
			<h1><?php echo $_CONFIG['site_name'] ?></h1>
			<h2>Impianti</h2>
		</div>
		<span style="float:right">
			<div class="conn_icon">
				<img src="/img/pc.png" width="92" height="92">
			</div>
			<div id="client_server" class="conn_icon offline"></div>		
			<div class="conn_icon">
				<img src="/img/web_server.png" width="92" height="92">
			</div>
		</span>
		<span>
			<!-- AGGIUNGERE PALE NEL DATABASE E CREARE LINK CON GLI ID COME ES PALA1 -->
			<a href="impianto.php?id=plant1">Pala</a>
			<a href="impianto.php?id=plant2">Pala5</a>
			<a href="logout.php">Logout</a>
		</span>
	</div>
</body>
</html>