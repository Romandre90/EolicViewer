<?php
session_start();
$HomeDir=substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME'])); //Rilevo Home directory "/var/www/"
require_once($HomeDir."/php/PHPModbusMaster.php"); //Includo classe PHP

$AnalogAr = $_POST['anReg'];
$DigitalAr = $_POST['diReg'];
$Values = array();

header('content-type: application/json');

// Istanzio classe modbus, definisco indirizzo IP dello SlimLine, protocollo
// timeout e tipo di endianness.

$Modbus=new ModbusMaster($_SESSION['ip_addr'], "TCP", 5, false);

// echo "<br>Read inputs: ".$Modbus->Status."<br>"; //Scommentare per debug

// Eseguo comando lettura variabile analogica.

foreach ($AnalogAr as $Reg)
{
	if (($AInputs=$Modbus->ReadMultipleRegisters(1, $Reg, 4)) === false) {
		/*echo "Read AInputs error: ".$Modbus->Status;*/ 
		$Values['error'] = 1;
		echo json_encode($Values); 
		exit();
	}
	$Values[$Reg]= $Modbus->RxREAL($AInputs, 0)*1;
}
foreach ($DigitalAr as $Reg)
{
	if (($DInputs=$Modbus->ReadCoilStatus(1, $Reg, 6)) === false) {/*echo "Read DInputs error: ".$Modbus->Status;*/
		$Values['error'] = 2;
		echo json_encode($Values); 
		exit();
	}
	$Values[$Reg]= $Modbus->RxBOOL($DInputs, 0);
}
$Values['error'] = 0;
echo json_encode($Values);
