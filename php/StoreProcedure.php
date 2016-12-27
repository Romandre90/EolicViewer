<?php
ini_set('max_execution_time', 0);

include("../config.php");
require_once("PHPModbusMaster.php"); 
/*
$id = mysql_real_escape_string($_GET['id']); 					//faccio l'escape dei caratteri dannosi
	$query = "SELECT * FROM planttable WHERE plantId = '$id' ";		
	$ris = mysql_query($query, $conn) or die (mysql_error());
	$row = mysql_fetch_array($ris);
	$_SESSION['ip_addr'] = $row['ipAddr']; 
	$_SESSION['plant_name'] = $row['plantName'];
	
*/

$Modbus=new ModbusMaster("37.99.209.123", "TCP", 10, false);

for(;;){

	$m_s=0; //velocità vento
	$rpm=0; //velocità rotore
	$kW=0; //potenza prodotta

	for($i=0;$i<90;$i++){ // questa routine dura più o meno 10sec
		// leggo velocità vento
		try{
			$input = $Modbus->ReadMultipleRegisters(1, '41102', 4);
			echo "V:".$Modbus->RxREAL($input, 0)*1 ."\n";
			$m_s+=$Modbus->RxREAL($input, 0)*1 ;
		}catch(Exception $e){
			echo "Errore nella lettura della velocità vento. Errore: ", $e->getMessage(), "\n";
		}
		// leggo velocità rotore
		try{
			$input = $Modbus->ReadMultipleRegisters(1, '41200', 4);
			$rpm+=$Modbus->RxREAL($input, 0)*1 ;
		}catch(Exception $e){
			echo "Errore nella lettura della velocità rotore. Errore: ", $e->getMessage(), "\n";
		}
		// leggo potenza istantanea
		try{
			$input = $Modbus->ReadMultipleRegisters(1, '41104', 4);
			$kW+=$Modbus->RxREAL($input, 0)*1 ;
		}catch(Exception $e){
			echo "Errore nella lettura della potenza istantanea. Errore: ", $e->getMessage(), "\n";
		}
		sleep(7);
	}
	
	
	$query = "INSERT INTO `letture`(`Impianto`, `Valore`, `Dato`) VALUES (1,".$m_s/90 .",1)";	
	try{
		mysql_query($query, $conn);
	}catch(Exception $e){
		echo "errore salvataggio velocità vento medio". $e->getMessage() . "\n";
	}
	$query = "INSERT INTO `letture`(`Impianto`, `Valore`, `Dato`) VALUES (1,".$rpm/90 .",2)";	
	try{
		mysql_query($query, $conn);
	}catch(Exception $e){
		echo "errore salvataggio velocità vento medio". $e->getMessage() . "\n";
	}
	$query = "INSERT INTO `letture`(`Impianto`, `Valore`, `Dato`) VALUES (1,".$kW/90 .",3)";	
	try{
		mysql_query($query, $conn);
	}catch(Exception $e){
		echo "errore salvataggio velocità vento medio". $e->getMessage() . "\n";
	}
}

?>