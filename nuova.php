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
// timeout sessione

/* SCOMMENTARE PER ABILITARE LA FUNZIONE TIMEOUT - LE INTERAZIONI CON JAVASCRIPT NON VALGONO A PROLUNGARE LA SESSIONE 
if (isset($_SESSION['last_act']) && (time() - $_SESSION['last_act'] > $_CONFIG['expire'])) {
    $_SESSION['auth'] = AUTH_EXPIRED;
	echo '<script language=javascript>document.location.href="notifica.php"</script>';
}
*/
// $_SESSION['last_act'] = time(); // aggiornamento timestamp act

if ( $_SESSION['ip_addr'] == NULL ){
	echo '<script language=javascript>document.location.href="mainpage.php"</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title><?php echo $_CONFIG['site_name'] ?> - Comandi Manuali</title>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
	<link href="/css/desktop.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-3.1.0.js"></script>	<!-- LIBRERIA JAVASCRIPT -->
	<script type="text/javascript" src="js/writingfunc.js"></script>	<!-- FILE JS PER SCRITTURE -->
	<script type="text/javascript" src="js/mancmd_refresh.js"></script> <!-- FILE JS PER AGGIORNAMENTO LETTURA -->
	
</head>
<body background=img/sfondoNavicella.png onload="checkConnection(); refreshData(); setInterval(checkConnection,10000); setInterval(refreshData,2000);">

<button type="button" id=valve-1 class=valve onclick="change('valve-1')"; ></button>
	
	<div class="header">
		<div class="logo">
			<img src="/img/logo.png" title=<?php echo $_CONFIG['logo'] ?> width="92" height="92">
		</div>
		<div class="title_container">
			<h1><?php echo $_CONFIG['site_name'] ?></h1>
			<h2>nuova - <?php echo $_SESSION['ip_addr']?> - <?php echo $_SESSION['plant_name']?></h2>
		</div>
		<span style="float:right">
			<div class="conn_icon">
				<img src="/img/pc.png" width="92" height="92">
			</div>
			<div id="client_server" class="conn_icon offline"></div>		
			<div class="conn_icon">
				<img src="/img/web_server.png" width="92" height="92">
			</div>
			<div id="server_plc" class="conn_icon offline"></div>	
			<div class="conn_icon">
				<img src="/img/plc.png" width="92" height="92">
			</div>
		</span>
		<span>
			<a href="impianto.php">Pagina Impianto</a>
			<a href="logout.php">Logout</a>
		</span>
	</div>
	
			
>
</body>
</html>