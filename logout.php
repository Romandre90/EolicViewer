<?php
session_start();
include_once("config.php");
$id = $_SESSION['id'];
$query = "UPDATE usertable SET isLogged = '0' WHERE userId = '$id' ";
mysql_query($query, $conn) or die (mysql_error());
session_destroy(); //distruggo tutte le sessioni
 
//creo una varibiale con un messaggio
$msg = "Informazioni: log-out effettuato con successo.";
 
//la codifico via urlencode informazioni-logout-effettuato-con-successo
$msg = urlencode($msg); // invio il messaggio via get
 
//ritorno a login.php usando GET posso recuperare e stampare a schermo il messaggio di avvenuto logout
header("location: login.php");
exit();
?>