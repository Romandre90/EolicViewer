<?php
$_CONFIG['host'] = "localhost";
$_CONFIG['user'] = "root";
$_CONFIG['pass'] = "khunken";
$_CONFIG['dbname'] = "supervisioneeolico";
$_CONFIG['logo'] = "KhunkenTecnology";
$_CONFIG['site_name'] = "Supervisione Impianti Eolici";
$_CONFIG['expire'] = 1800; //Durata sessione - se implementata

//--------------
define('AUTH_DENIED', 96);
define('AUTH_EXPIRED', 97);
define('AUTH_NOT_LOGGED', 98);
define('AUTH_DUP_USER', 99);
define('AUTH_LOGGED', 100);

define('AUTH_USE_COOKIE', 101);
define('AUTH_USE_LINK', 103);
define('AUTH_INVALID_PARAMS', 104);
define('AUTH_LOGEDD_IN', 105);
define('AUTH_FAILED', 106);

//--------------

$conn = mysql_connect($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass']) or die('Impossibile stabilire una connessione');
mysql_select_db($_CONFIG['dbname']);

ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>