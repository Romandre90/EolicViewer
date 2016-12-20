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
// timeout sessione

/* SCOMMENTARE PER ABILITARE LA FUNZIONE TIMEOUT - LE INTERAZIONI CON JAVASCRIPT NON VALGONO A PROLUNGARE LA SESSIONE 
if (isset($_SESSION['last_act']) && (time() - $_SESSION['last_act'] > $_CONFIG['expire'])) {
    $_SESSION['auth'] = AUTH_EXPIRED;
	echo '<script language=javascript>document.location.href="notifica.php"</script>';
}
*/
// $_SESSION['last_act'] = time(); // aggiornamento timestamp act

if ( $_SESSION['ip_addr'] == NULL ){
	echo '<script language=javascript>document.location.href="mainpage.php"</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
	<title><?php echo $_CONFIG['site_name'] ?> - Comandi Manuali</title>
	<link href="/css/basic.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-3.1.0.js"></script>	<!-- LIBRERIA JAVASCRIPT -->
	<script type="text/javascript" src="js/writingfunc.js"></script>	<!-- FILE JS PER SCRITTURE -->
	<script type="text/javascript" src="js/mancmd_refresh.js"></script> <!-- FILE JS PER AGGIORNAMENTO LETTURA -->
	
</head>
<body onload="checkConnection(); refreshData(); setInterval(checkConnection,10000); setInterval(refreshData,2000);">
	
	<div class="header">
		<div class="logo">
			<img src="/img/logo.png" title=<?php echo $_CONFIG['logo'] ?> width="92" height="92">
		</div>
		<div class="title_container">
			<h1><?php echo $_CONFIG['site_name'] ?></h1>
			<h2>Comandi Manuali - <?php echo $_SESSION['ip_addr']?> - <?php echo $_SESSION['plant_name']?></h2>
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
			<a href="impianto.php">Pagina Impianto</a>
			<a href="logout.php">Logout</a>
		</span>
	</div>
	
			
	<div class="container">
		<table align="left">
			<tr>
				<td>
				
					<div id="softstart_avv" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Softstart<br>Avviato</label>
						</div>
					</div>
				</td>
				<td>
					<div id="k2_chiuso" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Teleruttore<br>K2<br>CHIUSO</label>
						</div>
					</div>
				</td>
				<td>
					<div id="pompa_idraulica" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Pompa<br>Idraulica</label>
						</div>
					</div>
				</td>
				<td>
					<div id="freno_idr" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Freno<br>Idraulico<br>Rilasciato</label>
						</div>
					</div>
				</td>
				<td>
					<div id="freno_rotazione" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Freno<br>Rotazione<br>Rilasciato</label>
						</div>
					</div>
				</td>
				<td>
        			<div id="freno_rotazione" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Prova<br>Rotazione<br>Rilasciato</label>
						</div>
					</div>
				</td>
				<td>	<!-- aggiunto-->
				
					<div id="rot_sx" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Rotazione<br>Sinistra</label>
						</div>
					</div>
				</td>
				<td>
					
					<div id="rot_dx" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Rotazione<br>Destra</label>
						</div>
					</div>
				</td>
				<td>
				<!-- Scommentare per pale 60kW - Indicatore Stato ventilatore resistenze -->
				<td>
					<div id="ventil_res" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Ventilatore<br>Resistenze<br>Attivo</label>
						</div>
					</div>
				</td>
				<td>
			</tr>
			<tr>
			
				<td>    <!-- Inizio seconda fila di pulsanti -->
					<div id="softstart_man_on" class="switch button_green" value="1" ref="42822" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Softstart<br>ON</label>
						</div>
					</div>
				</td>
				<td>
					<div id="k2_man_on" class="switch button_green" value="1" ref="42852" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">K2<br>ON</label>
						</div>
					</div>
				</td>
				<td>
					<div id="start_pompa_idraulica" class="switch button_green" value="1" ref="43002" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Pompa<br>Idraulica<br>START</label>
						</div>
					</div>
				</td>
				<td>
					<div id="sblocco_freno_idraulico" class="switch button_green" value="1" ref="43042" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Freno<br>Idraulico<br>RILASCIO<br></label>
						</div>
					</div>
				</td>
				<td>
					<div id="sblocco_freno_rotazione" class="switch button_green" value="1" ref="43052" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Freno<br>Rotazione<br>RILASCIO</label>
						</div>
					</div>
				</td>
				<td>
					<div id="aerof_dec" class="switch button_green" value="1" ref="43035" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Aerofreno<br>-</label>
						</div>
					</div>
				</td>
				<td>
					<div id="aerof_inc" class="switch button_green" value="1" ref="43034" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Aerofreno<br>+</label>
						</div>
					</div>
				</td>
				<td>
					<div id="sx_rot" class="switch button_green" value="1" ref="43015" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Rotazione<br>Sinistra<br>START</label>
						</div>
					</div>
				</td>
				<td>
					
					<div id="rot_dx" class="switch button_green" value="1" ref="43014" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Rotazione<br>Destra<br>START</label>
						</div>
					</div>
				</td>
				<td>

					
					<div id="rot_dx" class="switch button_green" value="1" ref="43014" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">aaaa<br>Destra<br>START</label>
						</div>
					</div>
				</td>
				<td>
				<!--scommentare per pale 60kW - Comando START ventilatore resistenze
				<td>
					<div id="start_ventil_res" class="switch button_green" value="1" ref="43007" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Ventilatore<br>Resistenze<br>START</label>
						</div>
					</div>
				</td>
				-->
			</tr>
			<tr>
				<td>
					<div id="softstart_man_off" class="switch button_red" value="1" ref="42823" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Softstart<br>OFF</label>
						</div>
					</div>
				</td>
				<td>
					<div id="k2_off" class="switch button_red" value="1" ref="42853" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">K2<br>OFF</label>
						</div>
					</div>
				</td>
				<td>
					<div id="stop_pompa_idraulica" class="switch button_red" value="1" ref="43003" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Pompa<br>Idraulica<br>STOP</label>
						</div>
					</div>
				</td>
				<td>
					<div id="blocco_freno_idraulico" class="switch button_red" value="1" ref="43043" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Freno<br>Idraulico<br>BLOCCO</label>
						</div>
					</div>
				</td>
				<td>
					<div id="blocco_freno_rotazione" class="switch button_red" value="1" ref="43053" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Freno<br>Rotazione<br>BLOCCO</label>
						</div>
					</div>
				</td>
				<td align="center">
					<div id="stop_aerofreno" class="switch button_red" value="1" ref="43036" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Aerofreno<br>STOP</label>
						</div>
					</div>
				</td>
				<td align="center">
					<div id="stop_rotazione" class="switch button_red" value="1" ref="43016" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Rotazione<br>STOP</label>
						</div>
					</div>
				</td>
				<!-- Scommentare per pale 60kW - Comando STOP ventilatore resistenze
				<td>
					<div id="stop_ventil_res" class="switch button_red" value="1" ref="43008" onclick="pushButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Ventilatore<br>Resistenze<br>STOP</label>
						</div>
					</div>
				</td>
				-->
			</tr>
			<tr>
				<td>
					<div id="escl_softstart" class="switch sel_off" state="0" ref="42806" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Softstart<br>Automatico<br>Escluso</label>
						</div>
					</div>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td>
					<div id="freno_idr_mod" class="switch sel_off" state="0" ref="43047" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Freno<br>Idraulico<br>Moderato</label>
						</div>
					</div>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td align="center">
					<div id="escl_rotazione" class="switch sel_off" state="0" ref="43021" onclick="toggleButton(this);">
						<div class="switch_label_box">
							<label class="switch_label">Rotazione<br>Automatica<br>Esclusa</label>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<table align="right">
			<tr>
				<td>
					<div id="selauto" class="switch led_black">
						<div class="switch_label_box">
							<label class="switch_label">Automatico<br>Inserito</label>
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
			</tr>
			<tr>
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
			</tr>
		</table>
		<table align="right">
			<!--
			<tr>
				<td>
					<div class="display_edit_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Setpoint Potenza<br>Erogata</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_edit_box">
								<input type="text" class="display_value" id="sp_pot_erog" size="12" readonly>
								<input type="text" class="display_edit_value" id="edit_sp_pot_erog" size="12" placeholder="Nuovo Valore" onclick="this.style.color='black';">
								<input type="button" class="send_value" value="Invia" onclick="setValue('edit_sp_pot_erog','41248')">
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_edit_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Setpoint Potenza<br>Erogata<br>Offset</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_edit_box">
								<input type="text" class="display_value" id="sp_pot_erog_off" size="12" readonly>
								<input type="text" class="display_edit_value" id="edit_sp_pot_erog_off" size="12" placeholder="Nuovo Valore" onclick="this.style.color='black';">
								<input type="button" class="send_value" value="Invia" onclick="setValue('edit_sp_pot_erog_off','41250')">
							</div>
						</div>
					</div>
				</td>
			</tr>
			-->
			<tr>
				<td>
				</td>
				<td>
					<div class="display_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Potenza<br>Generatore</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_box">
								<input type="text" class="display_value" id="pot_gen" size="12" readonly>
							</div>
						</div>
					</div>
				</td>
			<tr>
				<td>
					<div class="display_edit_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Vento<br>Minimo</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_edit_box">
								<input type="text" class="display_value" id="vento_min" size="12" readonly>
								<input type="text" class="display_edit_value" id="edit_vento_min" size="12" placeholder="Nuovo Valore" onclick="this.style.color='black';">
								<input type="button" class="send_value" value="Invia" onclick="setValue('edit_vento_min','41230')">
							</div>
						</div>
					</div>
				</td>
				<td>
					<div class="display_edit_box">
						<div class="container">
							<div class="display_label_box">
								<label class="display_label">Vento<br>Massimo</label>
							</div>
						</div>
						<div class="container">
							<div class="display_value_edit_box">
								<input type="text" class="display_value" id="vento_max" size="12" readonly>
								<input type="text" class="display_edit_value" id="edit_vento_max" size="12" placeholder="Nuovo Valore" onclick="this.style.color='black';">
								<input type="button" class="send_value" value="Invia" onclick="setValue('edit_vento_max','41232')">
							</div>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>