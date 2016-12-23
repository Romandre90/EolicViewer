<?php
session_start();
include_once("config.php");

//controllo se la sessione è attiva

// timeout sessione

/* SCOMMENTARE PER ABILITARE LA FUNZIONE TIMEOUT - LE INTERAZIONI CON JAVASCRIPT NON VALGONO A PROLUNGARE LA SESSIONE 
if (isset($_SESSION['last_act']) && (time() - $_SESSION['last_act'] > $_CONFIG['expire'])) {
    $_SESSION['auth'] = AUTH_EXPIRED;
	echo '<script language=javascript>document.location.href="notifica.php"</script>';
}
*/
// $_SESSION['last_act'] = time(); // aggiornamento timestamp act

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title><?php echo $_CONFIG['site_name'] ?> - Comandi Manuali</title>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
	<link href="/css/desktop.css" rel="stylesheet" type="text/css">
	
	<script>
		function change(i){
			var el=document.getElementById(i);
			if(el.style.backgroundImage=="url(../img/Valve_Close.png)")
				el.style.backgroundImage="url('../img/Valve_Open.png')";
			else
				el.style.backgroundImage="url('../img/Valve_Close.png')";
		}
	</script>
	
</head>
<body>
	
	
	
	<div class="header">
		<div class="logo">
			<img src="/img/logo.png" title=<?php echo $_CONFIG['logo'] ?> width="92" height="92">
		</div>
		<div class="title_container">
			<h1><?php echo $_CONFIG['site_name'] ?></h1>
			<h2>nuova - <?php echo "37.99.209.123:502"?> - <?php echo "pala 5"?></h2>
		</div>
		<span style="float:right">
			<div class="conn_icon">
				<img src="/img/pc.png" width="92" height="92">
			</div>
			<div id="client_server" class="conn_icon online"></div>		
			<div class="conn_icon">
				<img src="/img/web_server.png" width="92" height="92">
			</div>
			<div id="server_plc" class="conn_icon online"></div>	
			<div class="conn_icon">
				<img src="/img/plc.png" width="92" height="92">
			</div>
		</span>
		<span>
			
		</span>
	</div>
	
	<div class=nav >
		<a href="impianto.php">Pagina Impianto</a>
		<a href="logout.php">Logout</a>
	</div>
	
	<div class=section id=plant >
		<button type="button" id="valve_1" class="valve" ></button>
		<button type="button" id="valve_2" class="valve" ></button>
		<button type="button" id="valve_3" class="valve" ></button>
		<button type="button" id="valve_4" class="valve" ></button>
		<button type="button" id="valve_5" class="valve" ></button>
		<button type="button" id="freno" ></button>
		<button type="button" id="spinholder" ></button>
		<button type="button" id="flap_position" ></button>
		
		<input type="text" class="display_value" id="cuscinetto_t1" readonly >
		<input type="text" class="display_value" id="cuscinetto_t2" readonly >
		<input type="text" class="display_value" id="distr_t" readonly >
		<input type="text" class="display_value" id="ridut_t" readonly >
		<input type="text" class="display_value" id="ridut_giri" readonly >
		<input type="text" class="display_value" id="navicella_t" readonly >
		<input type="text" class="display_value" id="engine_t1" readonly >
		<input type="text" class="display_value" id="engine_t2" readonly >
		<input type="text" class="display_value" id="engine_t3" readonly >
		<input type="text" class="display_value" id="engine_prod" readonly >
		<input type="text" class="display_value" id="wind-speed" readonly >
		
		<button type="button" id="distr_lvl" class="led_alarm" ></button>
		<button type="button" id="ridut_lvl" class="led_alarm" ></button>
		<button type="button" id="freno_FC_A" class="led_working" ></button>
		<button type="button" id="freno_FC_C" class="led_working" ></button>
		<button type="button" id="contadenti_1" class="led_working" ></button>
		<button type="button" id="contadenti_2" class="led_working" ></button>
		<button type="button" id="sensore_0" class="led_working" ></button>
		
		<button type="button" id="spin_motor_status" class="semaphore" ></button>
		<button type="button" id="engine_status" class="semaphore" ></button>
		
		<button type="button" id="spin_dx" class="arrow" ></button>
		<button type="button" id="spin_sx" class="arrow" ></button>
		
	</div>

</body>
</html>