// SU QUESTO FILE SI TROVANO LE FUNZIONI CHE GENERANO IL RINFRESCO DELLA PAGINA IMPIANTO - SI OCCUPANO SOLO DELLA LETTURA DEI DATI

// Carico i registri da prelevare sul plc in due vettori
// Per i valori analogici va mantenuto il prefisso 4 e il numero del registro va dimezzato

var analogRegisters = ["41100","41102","41104","41200","41202","41204","41206","41230","41232","41234","41248","41250","41290"];
						//"41208","41210","41212","41214", PARAMETRI RESISTENZE FRENATURA  - VERIFICARE SUL PROGRAMMA PLC I REGISTRI
var digitalRegisters = ["42051","42052","42058","42082","42085","42086","42087","42089","42094","42100","42104","42105","42254","42800","42801"
,"42807","42808","42809","42810","42832"];
						//"42105" VERIFICA ESCLUSIONE RESISTENZE  - VERIFICARE SUL PROGRAMMA PLC I REGISTRI
						//"42842" VERIFICA SELETTORE ESCLUSIONE FRENATURA  - VERIFICARE SUL PROGRAMMA PLC I REGISTRI
				        //"42810" COMANDO INSERIMENTO GENERATORE
//VARIABILI GLOBALI PER LA GESTIONE DELLA CONNESSIONE SERVER - PLC
var reqCount = 0, stopRequest = 0, noConnection = 1, connectionDelay = 0, check = 1;

//VARIABILI GLOBALI PER LA GESTIONE DELL'INDICATORE DIREZIONALE
var windNew = 0, windOld = 0;
var img = new Image;
//IMMAGINE DELL'AGO DELL'INDICATORE DIREZIONALE
img.src = 'img/cmp-needle2.png';

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
					
					if(data['42801'] == '0'){
						$('#selauto').removeClass("led_green");
						$('#selauto').addClass("led_black");	
					} else if(data['42801'] == '1'){
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
						$('#emergency').addClass("led_green");
					}
					// VERIFICA STATO INTERFACCIA
						
					if(data['42105'] == '0'){
						$('#Interfaccia').removeClass("led_green");
						$('#Interfaccia').addClass("led_black");	
					} else if(data['42105'] == '1'){
						$('#Interfaccia').removeClass("led_black");
						$('#Interfaccia').addClass("led_green");
					}
					
						// VERIFICA FRENO ROTAZIONE
						
					if(data['42254'] == '0'){
						$('#f_rot').removeClass("led_green");
						$('#f_rot').addClass("led_black");	
					} else if(data['42254'] == '1'){
						$('#f_rot').removeClass("led_black");
						$('#f_rot').addClass("led_black");
					}
					
					// VERIFICA ROTAZIONE SINISTRA
						
					if(data['42086'] == '0'){
						$('#r_sx').removeClass("led_blue");
						$('#r_sx').addClass("led_black");	
					} else if(data['42086'] == '1'){
						$('#r_sx').removeClass("led_black");
						$('#r_sx').addClass("led_blue");
					}
					
					// VERIFICA ROTAZIONE DESTRA
						
					if(data['42085'] == '0'){
						$('#r_dx').removeClass("led_blue");
						$('#r_dx').addClass("led_black");	
					} else if(data['42085'] == '1'){
						$('#r_dx').removeClass("led_black");
						$('#r_dx').addClass("led_blue");
					}
						// VERIFICA INSEGUIMENTO DIREZIONALE VENTO
						
					if(data['42807'] == '0'){
						$('#dir_on').removeClass("led_yellow");
						$('#dir_on').addClass("led_black");	
					} else if(data['42807'] == '1'){
						$('#dir_on').removeClass("led_black");
						$('#dir_on').addClass("led_yellow");
					}
					
						// VERIFICA SEGNALAZIONE A BANDIERA
						
					if(data['42809'] == '0'){
						$('#ban_on').removeClass("led_yellow");
						$('#ban_on').addClass("led_black");	
					} else if(data['42809'] == '1'){
						$('#ban_on').removeClass("led_black");
						$('#ban_on').addClass("led_yellow");
					}
					// VERIFICA BYPASS SOFTSTART
					
					if(data['42058'] == '0'){
						$('#bypass_softstart').removeClass("led_red");
						$('#bypass_softstart').addClass("led_black");	
					} else if(data['42058'] == '1'){
						$('#bypass_softstart').removeClass("led_black");
						$('#bypass_softstart').addClass("led_red");
					}
					
					// VERIFICA ABILITAZIONE IMPIANTO
					
					if(data['42800'] == '0'){
						document.getElementById("abilita_impianto").setAttribute("state",'0');
						$('#abilita_impianto').removeClass("sel_on");
						$('#abilita_impianto').addClass("sel_off");
					} else if(data['42800'] == '1'){
						document.getElementById("abilita_impianto").setAttribute("state",'1');
						$('#abilita_impianto').removeClass("sel_off");
						$('#abilita_impianto').addClass("sel_on");
					}			
					
					// VERIFICA STATO INTERRUTTORE INTERFACCIA
						
					if(data['42832'] == '0'){
						document.getElementById("interfaccia").setAttribute("state",'0');
						$('#interfaccia').removeClass("sel_on");
						$('#interfaccia').addClass("sel_off");
					} else if(data['42832'] == '1'){
						document.getElementById("interfaccia").setAttribute("state",'1');
						$('#interfaccia').removeClass("sel_off");
						$('#interfaccia').addClass("sel_on");
					}			
						
					// VERIFICA Q2 CHIUSO modificato
					
					if(data['42082'] == '1'){
						$('#q2_chiuso').removeClass("led_green");
						$('#q2_chiuso').addClass("led_red");	
					} else if(data['42087'] == '1'){
						$('#q2_chiuso').removeClass("led_red");
						$('#q2_chiuso').addClass("led_green");
					}
					
					// VERIFICA Q2 APERTO
					
					if(data['42082'] == '0'){
						$('#q2_aperto').removeClass("led_red");
						$('#q2_aperto').addClass("led_black");	
					} else if(data['42082'] == '1'){
						$('#q2_aperto').removeClass("led_black");
						$('#q2_aperto').addClass("led_red");
					}
					
					// VERIFICA K2 CHIUSO
					
					if(data['42100'] == '0'){
						$('#k2_chiuso').removeClass("led_red");
						$('#k2_chiuso').addClass("led_black");	
					} else if(data['42100'] == '1'){
						$('#k2_chiuso').removeClass("led_black");
						$('#k2_chiuso').addClass("led_red");
					}
											
					// VERIFICA ESCLUSIONE RIFASAMENTO GENERATORE
					
					if(data['42104'] == '0'){
						document.getElementById("rif_gen_off").setAttribute("state",'0');
						$('#rif_gen_off').removeClass("sel_on");
						$('#rif_gen_off').addClass("sel_off");
					} else if(data['42104'] == '1'){
						document.getElementById("rif_gen_off").setAttribute("state",'1');
						$('#rif_gen_off').removeClass("sel_off");
						$('#rif_gen_off').addClass("sel_on");	
					}
					
						// VERIFICA IMPOSTARE MOVIMENTO A BANDIERA
					
					if(data['42808'] == '0'){
						document.getElementById("a_bandiera").setAttribute("state",'0');
						$('#a_bandiera').removeClass("sel_on");
						$('#a_bandiera').addClass("sel_off");
					} else if(data['42808'] == '1'){
						document.getElementById("a_bandiera").setAttribute("state",'1');
						$('#a_bandiera').removeClass("sel_off");
						$('#a_bandiera').addClass("sel_on");	
					}
						// VERIFICA IMPOSTARE INSERIMENTO GENERATORE
					
					if(data['42810'] == '0'){
						document.getElementById("in_gen").setAttribute("state",'0');
						$('#in_gen').removeClass("sel_on");
						$('#in_gen').addClass("sel_off");
					} else if(data['42810'] == '1'){
						document.getElementById("in_gen").setAttribute("state",'1');
						$('#in_gen').removeClass("sel_off");
						$('#in_gen').addClass("sel_on");	
					}
					// VERIFICA ESCLUSIONE RIFASAMENTO RESISTENZE
					/*	Scommentare per 60kW  - VERIFICARE SUL PROGRAMMA PLC I REGISTRI
					if(data['42105'] == '0'){
						document.getElementById("rif_res_off").setAttribute("state",'0');
						$('#rif_res_off').removeClass("sel_on");
						$('#rif_res_off').addClass("sel_off");
					} else if(data['42105'] == '1'){
						document.getElementById("rif_res_off").setAttribute("state",'1');
						$('#rif_res_off').removeClass("sel_off");
						$('#rif_res_off').addClass("sel_on");
					}
					
					// VERIFICA ESCLUSIONE FRENATURA
						
					if(data['42842'] == '0'){
						document.getElementById("escl_fren").setAttribute("state",'0');
						$('#escl_fren').removeClass("sel_on");
						$('#escl_fren').addClass("sel_off");
					} else if(data['42842'] == '1'){
						document.getElementById("escl_fren").setAttribute("state",'1');
						$('#escl_fren').removeClass("sel_off");
						$('#escl_fren').addClass("sel_on");	
					}
					*/
				
					document.getElementById("direz_n").setAttribute("value",data['41100'].toFixed(2) + ' deg');
					windDirection(data['41100'].toFixed(0));
					document.getElementById("anemometro").setAttribute("value",data['41102'].toFixed(2) + ' m/s');
					windSpeed(data['41102'].toFixed(2));
					document.getElementById("vel_motore").setAttribute("value",data['41104'].toFixed(2) + ' rpm');
					genSpeed(data['41104'].toFixed(2));
					document.getElementById("pot_att_gen").setAttribute("value",data['41200'].toFixed(2) + ' kW');
					potGauge(data['41290'].toFixed(2));
					document.getElementById("pot_rea_gen").setAttribute("value",data['41202'].toFixed(2) + ' kVar');
					document.getElementById("cos_phi_gen").setAttribute("value",data['41204'].toFixed(2));
					document.getElementById("volt_gen").setAttribute("value",data['41206'].toFixed(2) + ' Volt');
					/* Scommentare per 60 kW - VERIFICARE SUL PROGRAMMA PLC I REGISTRI
					document.getElementById("pot_att_res").setAttribute("value",data['41208'].toFixed(2) + ' kW');
					document.getElementById("pot_rea_res").setAttribute("value",data['41210'].toFixed(2) + ' kVar');
					document.getElementById("cos_phi_res").setAttribute("value",data['41212'].toFixed(2));
					document.getElementById("volt_res").setAttribute("value",data['41214'].toFixed(2) + ' Volt');
					*/
					//CORREGGERE I VALORI DEI REGISTRI NELLE RIGHE SEGUENTI
					/*
					document.getElementById("temp_rid").setAttribute("value",data['41208'].toFixed(2) + ' C');
					document.getElementById("temp_mot").setAttribute("value",data['41210'].toFixed(2) + ' C');
					document.getElementById("temp_c1").setAttribute("value",data['41212'].toFixed(2) + ' C');
					document.getElementById("temp_c2").setAttribute("value",data['41214'].toFixed(2) + ' C');
					document.getElementById("pot_giorn").setAttribute("value",data['41208'].toFixed(2) + ' kW');
					document.getElementById("pot_tot").setAttribute("value",data['41210'].toFixed(2) + ' kW');
					document.getElementById("disp_1").setAttribute("value",data['41212'].toFixed(2));
					document.getElementById("disp_2").setAttribute("value",data['41214'].toFixed(2));
					*/
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
			timeout: 30000 // sets timeout to 10 seconds
		});
	}
}

//FUNZIONE CHE IMPOSTA IL VALORE DELL'INDICATORE POTENZA
function potGauge(value){
	if(!isNaN(value)){
		Gauge.Collection.get('pot_gauge').setValue(value);
	}
}

//FUNZIONE PER LA GRAFICA DELL'INDICATORE DIREZIONALE - RUOTA L'IMMAGINE DELL'INDICATORE
function windDirection(value){
	var c = document.getElementById("wind_direction");
	var ctx=c.getContext("2d");
	var windNew = value - windOld;
	windOld = value;
	ctx.clearRect(0, 0, c.width, c.height);
	ctx.translate(c.width/2, c.height/2);
	ctx.rotate(windNew*Math.PI / 180);
	ctx.translate(-c.width/2, -c.height/2);
	ctx.drawImage(img,0,0);
}

//FUNZIONE CHE IMPOSTA IL VALORE DELL'INDICATORE DI VELOCITA' DEL VENTO 
function windSpeed(value){
	if(!isNaN(value)){
		Gauge.Collection.get('wind_speed').setValue(value);
	}
}

//FUNZIONE CHE IMPOSTA IL VALORE DELL'INDICATORE DI VELOCITA' DEL MOTORE 
function genSpeed(value){
	if(!isNaN(value)){
		Gauge.Collection.get('generator_speed').setValue(value);
	}
}

//FUNZIONE CHE VERIFICA LO STATO DELLA CONNESSIONE TRA PC E SERVER
function checkConnection(){

	var randomValue = Math.floor((1 + Math.random()) * 0x10000);
	$.ajax({
		type: 'HEAD',
		url: 'test_connection.txt?rand=' + randomValue,
		error: function(){ 
				noConnection = 1;
				iconChange();
				},
		success: function(){
				noConnection = 0;
				iconChange();
				},
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

