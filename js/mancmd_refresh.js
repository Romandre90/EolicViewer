// SU QUESTO FILE SI TROVANO LE FUNZIONI CHE GENERANO IL RINFRESCO DELLA PAGINA COMANDI MANUALI - SI OCCUPANO SOLO DELLA LETTURA DEI DATI

// Carico i registri da prelevare sul plc in due vettori
// Per i valori analogici va mantenuto il prefisso 4 e il numero del registro va dimezzato

var analogRegisters = ["41230","41232","41248","41250","41290"];
var digitalRegisters = ["42051","42052","42055","42070","42084","42085","42086","42100","42252","42253","42254","42806","43021","43047"];
						//"42087", VERIFICA VENTILATORE RESISTENZE - VERIFICARE I REGISTRI SUL SOFTWARE
						
//VARIABILI GLOBALI PER LA GESTIONE DELLA CONNESSIONE SERVER - PLC
var reqCount = 0, stopRequest = 0, noConnection = 1, connectionDelay = 0, check = 1;

//FUNZIONE DI RINFRESCO DATI PAGINA
function refreshData(){
	if(!stopRequest)
	{
		// CONTEGGIO DELLE RICHIESTE PENDENTI CON LIMITAZIONE A UN VALORE MASSIMO
		reqCount++;
		if(reqCount>4){
			stopRequest = 1;
			connectionDelay = 1;
		}
		//RICHIESTA AL SERVER
		$.ajax({
			type: 'POST',
			url: 'php/refreshData.php',
			data: {anReg:analogRegisters, diReg:digitalRegisters},
			success: function(data){
				connectionDelay = 0;
				check = data['error'];			
				if(check == 0){
					
					// VERIFICA MODO AUTOMATICO
					
					if(data['42055'] == '0'){
						$('#selauto').removeClass("led_green");
						$('#selauto').addClass("led_black");	
					} else if(data['42055'] == '1'){
						$('#selauto').removeClass("led_black");
						$('#selauto').addClass("led_green");
					}
						
					// VERIFICA ALLARMI
						
					if(data['42051'] == '0'){
						$('#alarm').removeClass("led_red");
						$('#alarm').addClass("led_black");	
					} else if(data['42051'] == '1'){
						$('#alarm').removeClass("led_black");
						$('#alarm').addClass("led_red");
					}
						
					// VERIFICA EMERGENZA
						
					if(data['42052'] == '0'){
						$('#emergency').removeClass("led_red");
						$('#emergency').addClass("led_black");	
					} else if(data['42052'] == '1'){
						$('#emergency').removeClass("led_black");
						$('#emergency').addClass("led_red");
					}
					
					// VERIFICA SOFTSTART AVVIATO
					
					if(data['42070'] == '0'){
						$('#softstart_avv').removeClass("led_red");
						$('#softstart_avv').addClass("led_black");	
					} else if(data['42070'] == '1'){
						$('#softstart_avv').removeClass("led_black");
						$('#softstart_avv').addClass("led_red");
					}
					
					// VERIFICA K2 CHIUSO
					
					if(data['42100'] == '0'){
						$('#k2_chiuso').removeClass("led_red");
						$('#k2_chiuso').addClass("led_black");	
					} else if(data['42100'] == '1'){
						$('#k2_chiuso').removeClass("led_black");
						$('#k2_chiuso').addClass("led_red");
					}
					
					// VERIFICA POMPA IDRAULICA
						
					if(data['42084'] == '0'){
						$('#pompa_idraulica').removeClass("led_red");
						$('#pompa_idraulica').addClass("led_black");	
					} else if(data['42084'] == '1'){
						$('#pompa_idraulica').removeClass("led_black");
						$('#pompa_idraulica').addClass("led_red");
					}
					
					// VERIFICA FRENO IDRAULICO
						
					if(data['42253'] == '0'){
						$('#freno_idr').removeClass("led_red");
						$('#freno_idr').addClass("led_black");	
					} else if(data['42253'] == '1'){
						$('#freno_idr').removeClass("led_black");
						$('#freno_idr').addClass("led_red");
					}
					
					// VERIFICA FRENO ROTAZIONE
						
					if(data['42254'] == '0'){
						$('#freno_rotazione').removeClass("led_red");
						$('#freno_rotazione').addClass("led_black");	
					} else if(data['42254'] == '1'){
						$('#freno_rotazione').removeClass("led_black");
						$('#freno_rotazione').addClass("led_red");
					}
					
					// VERIFICA ROTAZIONE SINISTRA
						
					if(data['42086'] == '0'){
						$('#rot_sx').removeClass("led_red");
						$('#rot_sx').addClass("led_black");	
					} else if(data['42086'] == '1'){
						$('#rot_sx').removeClass("led_black");
						$('#rot_sx').addClass("led_red");
					}
					
					// VERIFICA ROTAZIONE DESTRA
						
					if(data['42085'] == '0'){
						$('#rot_dx').removeClass("led_red");
						$('#rot_dx').addClass("led_black");	
					} else if(data['42085'] == '1'){
						$('#rot_dx').removeClass("led_black");
						$('#rot_dx').addClass("led_red");
					}
					
					// VERIFICA K2 CHIUSO
					
					if(data['42100'] == '0'){
						$('#k2_chiuso').removeClass("led_red");
						$('#k2_chiuso').addClass("led_black");	
					} else if(data['42100'] == '1'){
						$('#k2_chiuso').removeClass("led_black");
						$('#k2_chiuso').addClass("led_red");
					}
					
					// VERIFICA VENTILATORE RESISTENZE
					/*	
					if(data['42087'] == '0'){
						$('#ventil_res').removeClass("led_red");
						$('#ventil_res').addClass("led_black");	
					} else if(data['42087'] == '1'){
						$('#ventil_res').removeClass("led_black");
						$('#ventil_res').addClass("led_red");
					}
					*/
					
					// VERIFICA ESCLUSIONE SOFTSTART
					
					if(data['42806'] == '0'){
						document.getElementById("escl_softstart").setAttribute("state",'0');
						$('#escl_softstart').removeClass("sel_on");
						$('#escl_softstart').addClass("sel_off");
					} else if(data['42806'] == '1'){
						document.getElementById("escl_softstart").setAttribute("state",'1');
						$('#escl_softstart').removeClass("sel_off");
						$('#escl_softstart').addClass("sel_on");
					}
					
					// VERIFICA FRENO IDRAULICO MODERATO
					
					if(data['43047'] == '0'){
						document.getElementById("freno_idr_mod").setAttribute("state",'0');
						$('#freno_idr_mod').removeClass("sel_on");
						$('#freno_idr_mod').addClass("sel_off");
					} else if(data['43047'] == '1'){
						document.getElementById("freno_idr_mod").setAttribute("state",'1');
						$('#freno_idr_mod').removeClass("sel_off");
						$('#freno_idr_mod').addClass("sel_on");
					}
					
					// VERIFICA ESCLUSIONE ROTAZIONE AUTOMATICA
					
					if(data['43021'] == '0'){
						document.getElementById("escl_rotazione").setAttribute("state",'0');
						$('#escl_rotazione').removeClass("sel_on");
						$('#escl_rotazione').addClass("sel_off");
					} else if(data['43021'] == '1'){
						document.getElementById("escl_rotazione").setAttribute("state",'1');
						$('#escl_rotazione').removeClass("sel_off");
						$('#escl_rotazione').addClass("sel_on");
					}
					/*
					document.getElementById("sp_pot_erog").setAttribute("value",data['41248'].toFixed(2) + ' kW');
					document.getElementById("sp_pot_erog_off").setAttribute("value",data['41250'].toFixed(2) + ' kW');
					*/
					document.getElementById("pot_gen").setAttribute("value",data['41290'].toFixed(2) + ' kW');
					document.getElementById("vento_min").setAttribute("value",data['41230'].toFixed(2) + ' m/s');
					document.getElementById("vento_max").setAttribute("value",data['41232'].toFixed(2) + ' m/s');
				}
			},
			complete: function(data){
				console.log("complete");
				reqCount--;
				if(reqCount<1){
						stopRequest = 0;
				}
			},
			failure: function(data){},
			timeout: 10000 // sets timeout to 10 seconds
		});
	}
	iconChange();
}

//FUNZIONE CHE VERIFICA LO STATO DELLA CONNESSIONE TRA PC E SERVER
function checkConnection(){

	var randomValue = Math.floor((1 + Math.random()) * 0x10000);
	$.ajax({
		type: 'HEAD',
		url: 'test_connection.txt?rand=' + randomValue,
		error: function() { noConnection = 1; },
		success: function() { noConnection = 0; },
		timeout: 10000
	});
}	

//FUNZIONE CHE CAMBIA LE ICONE DI STATO CONNESSIONE IN BASE AI RISULTATI DELLE FUNZIONI DI TEST DELLA CONNESSIONE
function iconChange(){
	if(!noConnection){
		$('#client_server').removeClass("offline");
		$('#client_server').addClass("online");
	} else {
		$('#client_server').removeClass("online");
		$('#client_server').addClass("offline");
	}
	
	if(!check && !connectionDelay && !noConnection){
		$('#server_plc').removeClass("offline");
		$('#server_plc').addClass("online");
	} else {
		$('#server_plc').removeClass("online");
		$('#server_plc').addClass("offline");
	}
}

