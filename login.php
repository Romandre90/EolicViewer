<?php
session_start();
include_once("config.php");
//se non c'è la sessione registrata
if (isset($_SESSION['stato']) && $_SESSION['stato'] == AUTH_LOGGED) {
echo '<script language=javascript>document.location.href="plant.php"</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
	<link href="/css/login.css" rel="stylesheet" type="text/css">
    <title><?php echo $_CONFIG['site_name'] ?> - Login</title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<img src="/img/logo.png" title="Khunken Tecnology" width="92" height="92">
		</div>
		<div class="title_container">
			<h1><?php echo $_CONFIG['site_name'] ?></h1>
			<h2>Pagina di Autenticazione</h2>
		</div>
	</div>
    <div class="login">
		<form id="login" action="verifica.php" method="post">
			<fieldset id="inputs">
				<input id="username" name="username" type="text" placeholder="Username" autofocus required>
				<input id="password" name="password" type="password" placeholder="Password" required>
				<input type="reset" id="reset" value="Reset">
				<input type="submit" id="submit" value="Accedi">
			</fieldset>
		</form>
	</div>
 
</body>
</html>