<?php
session_start();
include_once("config.php");

//se non c'è la sessione registrata

if (!isset($_SESSION['auth'])) {
	$_SESSION['auth'] = AUTH_NOT_LOGGED;
}
switch($_SESSION['auth']){
	case AUTH_NOT_LOGGED:
		$msg = 'AREA RISERVATA';
	break;
	case AUTH_EXPIRED:
		$id = $_SESSION['id'];
		$query = "UPDATE usertable SET isLogged = '0' WHERE userId = '$id' ";
		mysql_query($query, $conn) or die (mysql_error());
		$msg = 'SESSIONE SCADUTA';
		session_unset();     // unset $_SESSION variable for the run-time 
		session_destroy();   // destroy session data in storage
	break;
	case AUTH_DENIED:
		$msg = 'ACCESSO NEGATO';
		$_SESSION['auth'] = AUTH_NOT_LOGGED;
		break;
	case AUTH_DUP_USER:
		$msg = 'UTENTE CONNESSO SU ALTRA POSTAZIONE';
	break;
	case AUTH_LOGGED:
		$msg = 'UTENTE CONNESSO';
	break;
}
?>



<!DOCTYPE html>
<html>
<head>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
    <title><?php echo $sito_internet ?> - LOGIN</title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<img src="/img/logo.png" title="Khunken Tecn" width="92" height="92">
		</div>
		<div class="title_container">
			<h1><?php echo $_CONFIG['site_name'] ?></h1>
			<h2><?php echo $msg ?></h2>
			<h3><a href='login.php'><font color='blue'>INDIETRO</font></a></h3>
		</div>
	</div> 
</body>
</html>