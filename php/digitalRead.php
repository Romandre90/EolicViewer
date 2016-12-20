<?php

$HomeDir=substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME'])); //Rilevo Home directory "/var/www/"
require_once($HomeDir."/php/PHPModbusMaster.php"); //Includo classe PHP
$json = array();
// Istanzio classe modbus, definisco indirizzo IP dello SlimLine, protocollo
// timeout e tipo di endianness.

$Modbus=new ModbusMaster($_SESSION['ip_addr'], "TCP", 5, false);

// echo "<br>Read inputs: ".$Modbus->Status."<br>"; //Scommentare per debug

// Eseguo comando lettura variabile Bool;

if (($DInputs=$Modbus->ReadCoilStatus(1, $_POST['reg'], 6)) === false) {echo "Read DInputs error: ".$Modbus->Status; exit;}

header('content-type: application/json');
$json['value']= $Modbus->RxBOOL($DInputs, 0);
echo json_encode($json);
