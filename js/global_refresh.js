// QUESTO FILE E' DA MODIFICARE PER LA PAGINA DEL SINOTTICO

var analogRegisters = ["41100","41102","41104","41200","41202","41204","41206",
	                       		"41208","41210","41212","41214","41230","41232","41234","41248","41250"];
var digitalRegisters = ["42051","42052","42058","42089","42810",
	                        "42094","42100","42104","42105","42800","42801","42828","42832","42842"];
//"42810",
var reqCount = 0, stopRequest = 0, noConnection = 1, connectionDelay = 0, check = 1;

var windNew = 0, windOld = 0;
var img = new Image;
img.src = 'img/cmp-needle2.png';

function refreshData(){
	if(!stopRequest)
	{
		reqCount++;
		if(reqCount>4){
			stopRequest = 1;
			connectionDelay = 1;
		}
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
						$('#emergency').addClass("led_red");
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
						
					// VERIFICA FEEDBACK INTERRUTTORE INTERFACCIA
					
					if(data['42100'] == '0'){
						$('#enable_state').removeClass("led_red");
						$('#enable_state').addClass("led_black");	
					} else if(data['42100'] == '1'){
						$('#enable_state').removeClass("led_black");
						$('#enable_state').addClass("led_red");
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
					
					// VERIFICA ESCLUSIONE RIFASAMENTO RESISTENZE
						
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
				
					
					document.getElementById("direz_n").setAttribute("value",data['41100'].toFixed(2) + ' deg');
					windDirection(data['41100'].toFixed(0));
					document.getElementById("anemometro").setAttribute("value",data['41102'].toFixed(2) + ' m/s');
					windSpeed(data['41102'].toFixed(2));
					document.getElementById("vel_motore").setAttribute("value",data['41104'].toFixed(2) + ' rpm');
					document.getElementById("pot_att_gen").setAttribute("value",data['41200'].toFixed(2) + ' kW');
					document.getElementById("pot_rea_gen").setAttribute("value",data['41202'].toFixed(2) + ' kVar');
					document.getElementById("cos_phi_gen").setAttribute("value",data['41204'].toFixed(2));
					document.getElementById("volt_gen").setAttribute("value",data['41206'].toFixed(2) + ' Volt');
					document.getElementById("pot_att_res").setAttribute("value",data['41208'].toFixed(2) + ' kW');
					document.getElementById("pot_rea_res").setAttribute("value",data['41210'].toFixed(2) + ' kVar');
					document.getElementById("cos_phi_res").setAttribute("value",data['41212'].toFixed(2));
					document.getElementById("volt_res").setAttribute("value",data['41214'].toFixed(2) + ' Volt');
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
}

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

function windSpeed(value){
	if(!isNaN(value)){
		Gauge.Collection.get('wind_speed').setValue(value);
	}
}

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

