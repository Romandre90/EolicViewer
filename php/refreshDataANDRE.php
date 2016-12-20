<?php
session_start();
$HomeDir=substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME'])); //Rilevo Home directory "/var/www/"
require_once($HomeDir."/php/PHPModbusMaster.php"); //Includo classe PHP

$AnalogAr = ["41100","41102","41104","41200","41202","41204","41206","41230","41232","41234","41248","41250","41290"];
$DigitalAr = ["42051","42052","42058","42082","42085","42086","42087","42089","42094","42100","42104","42105","42254","42800","42801"
,"42807","42808","42809","42810","42832"];
$Values = array();

header('content-type: application/json');

// Istanzio classe modbus, definisco indirizzo IP dello SlimLine, protocollo
// timeout e tipo di endianness.

$Modbus=new ModbusMaster("37.99.209.123", "TCP", 10, false);

echo "<br>Read inputs: ".$Modbus->Status."<br>"; //Scommentare per debug

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
