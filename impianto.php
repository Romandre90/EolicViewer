<?php
session_start();
include_once("config.php");

//controllo se la sessione è attiva

if (!(isset($_SESSION['auth']) && $_SESSION['auth'] == AUTH_LOGGED)) {
	$_SESSION['auth'] = AUTH_NOT_LOGGED;
	echo '<script language=javascript>document.location.href="notifica.php"</script>'; 
} else {

	$cod = $_SESSION['cod']; 
}

//timeout sessione

/* SCOMMENTARE PER ABILITARE LA FUNZIONE TIMEOUT - LE INTERAZIONI CON JAVASCRIPT NON VALGONO A PROLUNGARE LA SESSIONE 
if (isset($_SESSION['last_act']) && (time() - $_SESSION['last_act'] > $_CONFIG['expire'])) {
    $_SESSION['auth'] = AUTH_EXPIRED;
	echo '<script language=javascript>document.location.href="notifica.php"</script>';
}
*/
// $_SESSION['last_act'] = time(); // aggiornamento timestamp act

if ( $_SESSION['ip_addr'] == NULL ){
	$id = mysql_real_escape_string($_GET['id']); //faccio l'escape dei caratteri dannosi
	$query = "SELECT * FROM planttable WHERE plantId = '$id' ";
	$ris = mysql_query($query, $conn) or die (mysql_error());
	$row = mysql_fetch_array($ris);
	$_SESSION['ip_addr'] = $row['ipAddr']; 
	$_SESSION['plant_name'] = $row['plantName'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title><?php echo $_CONFIG['site_name'] ?> - Pagina Impianto</title>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-3.1.0.js"></script>	<!-- LIBRERIA JAVASCRIPT -->
	<script type="text/javascript" src="js/writingfunc.js"></script>	<!-- FILE JS PER SCRITTURA -->
	<script type="text/javascript" src="js/plant_refresh.js"></script> 	<!-- FILE JS PER AGGIORNAMENTO LETTURA -->
	<script>var CANV_GAUGE_FONTS_PATH = 'fonts'</script>
	<script src="js/gauge.js"></script>
	
</head>
<body onload="checkConnection(); refreshData(); setInterval(refreshData,2000); setInterval(checkConnection,10000);">
	
	<div class="header">
		<div class="logo">
			<img src="/img/logo.png" title=<?php echo $_CONFIG['logo'] ?> width="92" height="92">
		</div>
		<div class="title_container">
			<h1><?php echo $_CONFIG['site_name'] ?></h1>
			<h2>Pagina Impianto - <?php echo $_SESSION['ip_addr']?> - <?php echo $_SESSION['plant_name']?></h2>
		</div>
		<span style="float:right">
			<div class="conn_icon">
				<img src="/img/pc.png" width="92" height="92">
			</div>
			<div id="client_server" class="conn_icon offline"></div>		
			<div class="conn_icon">
				<img src="/img/web_server.png" width="92" height="92">
			</div>
			<div id="server_plc" class="conn_icon offline"></div>	
			<div class="conn_icon">
				<img src="/img/plc.png" width="92" height="92">
			</div>
		</span>
		<span>
			<a href="mainpage.php">Sinottico</a>
			<a href="mancmd.php">Pagina Configurazione</a>
			<a href="logout.php">Logout</a>
			<a href="nuova.php">nuova</a>
		</span>
	</div>
		
	<div class="container">
		<table align="left">
			<tr>
				<td>
					<div id="selauto" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Automatico<br>Inserito</label>
						</div>
					</div>
				</td>
				<td>
					<div id="alarm" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Allarme</label>
						</div>
					</div>
				</td>
				<td>
					<div id="emergency" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Emergenza</label>
						</div>
					</div>
				</td>
				<td>
				<div id="q2_chiuso" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Stato<br>Interrutore<br>SPI</label>
						</div>
					</div>
				</td>
				<td>
					<div id="Interfaccia" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Stato<br>Protezione<br>Interfaccia</label>
						</div>
					</div>
				</td>
				<td>
				<div id="ban_on" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Stato<br>messa a<br>Bandiera</label>
						</div>
					</div>
				</td>
				<td>	
			</tr>
			<tr>
				<td>
					<div id="abilita_impianto" class="switch sel_off" state="0" ref="42800" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">ABILITAZIONE<br>IMPIANTO</label>
						</div>
					</div>
				</td>
				<td>
					<div id="interfaccia" class="switch sel_off" state="0" ref="42832" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Comando<br>Interfaccia</label>
						</div>
					</div>
				</td>
				<td>
					<div id="rif_gen_off" class="switch sel_off" state="0" ref="42104" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Rifasamento<br>Generatore<br>Escluso</label>
						</div>
					</div>
				</td>
				<td>
				
				
					<div id="pilz_reset" class="switch button_blue" value="1" ref="42826" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Reset<br>Anomalie</label>
						</div>
					</div>
				</td>
				<td>
				<div id="a_bandiera" class="switch sel_off" state="0" ref="42808" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Messa<br>a<br>Bandiera</label>
						</div>
					</div>
				</td>
				<td>
				<div id="in_gen" class="switch sel_off" state="0" ref="42810" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Inserimento<br>Generatore<br>In Rete</label>
						</div>
					</div>
				</td>
				<td>
			</tr>
			<tr>
				
				<td>
				<div id="bypass_softstart" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Bypass<br>Soft-start</label>
						</div>	
					</div>
				</td>
				<td>
					<div id="k2_chiuso" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Teleruttore<br>K2<br>Chiuso</label>
						</div>
					</div>
				</td>
				<td>
					<div id="f_rot" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Stato<br>Freno<br>Rotazione</label>
						</div>
					</div>
				</td>
				<td>
					<div id="r_sx" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Gondola<br>Gira<br>Sinistra</label>
						</div>
					</div>
				</td>
				<td>
					<div id="r_dx" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Gondola<br>Gira<br>Desta</label>
						</div>
					</div>
				</td>
				<td>
					<div id="dir_on" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Segue<br>Il<br>Vento</label>
						</div>
					</div>
				</td>
				<td>
				</tr>
				<tr>
				<td>
				
					<div id="ric_ferm" class="switch button_blue" value="1" ref="42811" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Richiesta<br>di<br>Fermata</label>
						</div>
					</div>
				</td>
				<td>
				
			</tr>
			<tr>
				
				<!-- Scommentare per 60kW - Selettore esclusione rifasamento resistenze e selettore esclusione resistenze 
				<td>
					<div id="rif_res_off" class="switch sel_off" state="0" ref="42105" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Rifasamento<br>Resistenze<br>Escluso</label>
						</div>
					</div>
				</td>
				<td>
					<div id="escl_fren" class="switch sel_off" state="0" ref="42842" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Frenatura<br>Esclusa</label>
						</div>
					</div>
				</td>
				-->
			</tr>
		</table>
		<table align="right">
			<tr>
				<td>
					<canvas id="pot_gauge" width="190" height="190"
					data-type="canv-gauge"
					data-min-value="-180"
					data-max-value="180"
					data-major-ticks="-180 -150 -120 -90 -60 -30 0 30 60 90 120 150 180"
					data-minor-ticks="2"
					data-stroke-ticks="true"
					data-units="kW"
					data-value-format="3.2"
					data-glow="true"
					data-animation-duration="1000"
					data-animation-fn="linear"
					data-colors-needle-start="rgba(240, 128, 128, 1)"
					data-colors-needle-end="rgba(255, 160, 122, .9)"
					data-valuebox-visible="false"
					data-valuetext-visible="false"
					data-highlights="-180 180 #fff">
					>
					</canvas>
				</td>
				<td>
					<canvas id="wind_direction" class="wind_dir" width="190" height="190">
					</canvas>
				</td>
				<td>
					<canvas id="wind_speed" width="190" height="190"
					data-type="canv-gauge"
					data-min-value="0"
					data-max-value="50"
					data-major-ticks="0 5 10 15 20 25 30 35 40 45 50"
					data-minor-ticks="2"
					data-stroke-ticks="true"
					data-units="m/s"
					data-value-format="3.2"
					data-glow="true"
					data-animation-duration="1000"
					data-animation-fn="linear"
					data-colors-needle-start="rgba(240, 128, 128, 1)"
					data-colors-needle-end="rgba(255, 160, 122, .9)"
					data-valuebox-visible="false"
					data-valuetext-visible="false"
					data-highlights="0 20 #0f0, 20 25 #ff0, 25 50 #f00">
					</canvas>
				</td>
				<td>
					<canvas id="generator_speed" width="190" height="190"
					data-type="canv-gauge"
					data-min-value="0"
					data-max-value="2000"
					data-major-ticks="0 200 400 600 800 1000 1200 1400 1600 1800 2000"
					data-minor-ticks="2"
					data-stroke-ticks="true"
					data-units="rpm"
					data-value-format="3.2"
					data-glow="true"
					data-animation-duration="1000"
					data-animation-fn="linear"
					data-colors-needle-start="rgba(240, 128, 128, 1)"
					data-colors-needle-end="rgba(255, 160, 122, .9)"
					data-valuebox-visible="false"
					data-valuetext-visible="false"
					data-highlights="0 1600 #0f0, 1600 1800 #ff0, 1800 2000 #f00">
					</canvas>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Direzionale</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="direz_n" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">	
								<label class="display_label">Anemometro</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="anemometro" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Giri Motore</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="vel_motore" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Potenza Attiva<br>Generatore</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="pot_att_gen" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Potenza Reattiva<br>Generatore</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="pot_rea_gen" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Cos &#966 <br>Generatore</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="cos_phi_gen" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Tensione<br>Generatore</label>
							</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="volt_gen" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<!-- Scommentare per pale 60kW
			<tr>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Potenza<br>Attiva<br>Resistenze</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="pot_att_res" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Potenza Reattiva<br>Resistenze</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="pot_rea_res" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">					
							<div class="display_label_box">
								<label class="display_label">Cos &#966 <br>Resistenze</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="cos_phi_res" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Tensione<br>Resistenze</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="volt_res" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
			</tr>
			-->
			<tr>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Temperatura<br>Riduttore</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="temp_rid" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Temperatura<br>Motore</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="temp_mot" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Temperatura<br>Cuscinetto 1</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="temp_c1" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Temperatura<br>Cuscinetto 2</label>
							</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="temp_c2" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Potenza<br>Giornaliera</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="pot_giorn" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Potenza<br>Totale</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="pot_tot" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Disponibile<br>1</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="disp_1" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Disponibile<br>2</label>
							</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="disp_2" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>