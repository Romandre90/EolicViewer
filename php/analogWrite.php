<?php
session_start();
$HomeDir=substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME'])); //Rilevo Home directory "/var/www/"
require_once($HomeDir."/php/PHPModbusMaster.php"); //Includo classe PHP
$json = array();
// Istanzio classe modbus, definisco indirizzo IP dello SlimLine, protocollo
// timeout e tipo di endianness.

$Modbus=new ModbusMaster($_SESSION['ip_addr'], "TCP", 5, false);

// "<br>Read inputs: ".$Modbus->Status."<br>"; //Scommentare per debug

// Eseguo comando scrittura variabile analogica.

if (isset($_POST['reg'])) if ($Modbus->WriteMultipleRegisters(1, $_POST['reg'], 2, $Modbus->TxREAL($_POST['val'])) == false) {echo "Write AOutputs error: ".$Modbus->Status; exit;}

