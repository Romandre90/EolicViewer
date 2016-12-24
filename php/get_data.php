<?php

/*IN  QUESTA PAGINA VENGONO LETTI I REGISTRI DAL PLC ED INVIATI ALLA PAGINA "get_data.js" LA QUALE PROVVEDE
AD AGGIORNARE LA PAGINA "nuova.php" */

//////////////////////////////////////////////////////////////////////////////////////////
/*      						ATTENZIONE AL TIPO										*/
/*  la lista dei registri per ora è solo una e legge solo tipi real						*/
/* se si vuole leggere tipi bool bisogna dire di leggere $Modbus->RxBOOL($DInputs, 0);	*/
//////////////////////////////////////////////////////////////////////////////////////////


session_start();
$HomeDir=substr($_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME'])); //Rilevo Home directory "/var/www/"
require_once($HomeDir."/php/PHPModbusMaster.php"); //Includo classe PHP

$reg_list = $_POST['Reg'];;  // lista dei registri da interrogare per aggiungere registri vai in "get_data.js"

$Values = array();

header('content-type: application/json');

$Modbus=new ModbusMaster("37.99.209.123", "TCP", 10, false);

foreach($reg_list as $reg){	//lettura dati dai registri
	$input = $Modbus->ReadMultipleRegisters(1, $reg, 4);
	$Values[$reg] = $Modbus->RxREAL($input, 0)*1 ;
}
	
echo json_encode($Values);		// trasmissione del dato alla pagina get_data.js
?>

	
	
	