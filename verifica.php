<?php
session_start(); //inizio la sessione
//includo i file necessari a collegarmi al db con relativo script di accesso
include_once("config.php");
 
//variabili POST con anti sql Injection
$username=mysql_real_escape_string($_POST['username']); //faccio l'escape dei caratteri dannosi
$password=mysql_real_escape_string(sha1($_POST['password'])); //sha1 cifra la password anche qui in questo modo corrisponde con quella del db
 
 $query = "SELECT * FROM usertable WHERE userName = '$username' AND password = '$password' ";
 $ris = mysql_query($query, $conn) or die (mysql_error());
 $row=mysql_fetch_array($ris);  
 
//Prelevo l'identificativo dell'utente

$id=$row['userId'];
$cod=$row['userName'];
$isLogged=$row['isLogged'];
 
// Effettuo il controllo
if ($cod == NULL) $check = 0;
else $check = 1;  
 
// Username e password corrette

if($check === 1) {
	// if($isLogged === '0') {
		// Registro la sessione, il codice utente e inizializzo la durata
		$_SESSION['auth'] = AUTH_LOGGED;
		$_SESSION['id'] = $id;
		$_SESSION['cod'] = $cod;
		$_SESSION['last_act'] = time();
		$query = "UPDATE usertable SET isLogged = '1' WHERE userId = '$id' ";
		mysql_query($query, $conn) or die (mysql_error());
		
		// Redirect alla pagina riservata
		echo '<script language=javascript>document.location.href="mainpage.php"</script>';
		
	// } else {
 
	// User già connesso su altra postazione
	
	// $_SESSION['auth'] = AUTH_DUP_USER;
	// echo '<script language=javascript>document.location.href="notifica.php"</script>';
	// }
} else {
 
/* Username e password errati */
  $_SESSION['auth'] = AUTH_DENIED;
 echo '<script language=javascript>document.location.href="notifica.php"</script>';
 
}
?>