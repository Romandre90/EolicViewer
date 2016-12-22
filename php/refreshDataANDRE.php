<?php
session_start();
$HomeDir=substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME'])); //Rilevo Home directory "/var/www/"
require_once($HomeDir."/php/PHPModbusMaster.php"); //Includo classe PHP

$AnalogAr = "41102";

$Values = array();

header('content-type: application/json');

// Istanzio classe modbus, definisco indirizzo IP dello SlimLine, protocollo
// timeout e tipo di endianness.

$Modbus=new ModbusMaster("37.99.209.123", "TCP", 10, false);

//echo "<br>Read inputs: ".$Modbus->Status."<br>"; //Scommentare per debug

	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
	$input = $Modbus->ReadMultipleRegisters(1, $AnalogAr, 4);
	echo "vento: " . $Modbus->RxREAL($input, 0)*1 ." / ";
	usleep(500000);
?>

	
	
	