// FUNZIONI DI SCRITTURA - GESTISCONO PULSANTI - SELETTORI - VALORI ANALOGICI

// FUNZIONE PER SCRITTURA VALORI DA PULSANTI - SU PLC SI DEVE FARE IL RESET DEL COMANDO PER AVERE FUNZIONE IMPULSIVA
function pushButton(obj){
	var register = obj.getAttribute('ref');
	var value = obj.getAttribute('value');
	digitalWrite(register, value);
}

// FUNZIONE PER SCRITTURA VALORI DA SELETTORE - INVERTE IL VALORE DI PARTENZA - IL COMANDO E' STABILE
function toggleButton(obj){
	var register = obj.getAttribute('ref');
	var actstate = obj.getAttribute('state');
	
	if (actstate == '0'){
		var value = '1';
	} else if (actstate == '1'){
		var value = '0';
	}
	digitalWrite(register,value);
}

// FUNZIONE PER LA SCRITTURA DI VALORI ANALOGICI

function setValue(id,reg){
	var value = document.getElementById(id).value;
	var register = reg;
	
	if(!isNaN(value)){	
		analogWrite(register,value);
		document.getElementById(id).value = "";
	} else {
		document.getElementById(id).style.color = 'red';
	}
}
	
// QUESTE FUNZIONI VENGONO RICHIAMATE DALLE PRECEDENTI PER ESEGUIRE I COMANDI DI SCRITTURA
// LE RICHIESTE SONO ASINCRONE E BASATE SU AJAX

function digitalWrite(register, value){
				
	$.ajax({
		type: 'POST',
		url: '../php/digitalWrite.php',
		data: {reg:register, val:value},
		success: function(data){},
		complete: function(data){},
		failure: function(data){
			alert('FAIL')
		}
	});
}

function analogWrite(register, value){
		
	$.ajax({
		type: 'POST',
		url: '../php/analogWrite.php',
		data: {reg:register, val:value},
		success: function(data){},
		complete: function(data){},
		failure: function(data){
			alert('FAIL')
		}
	});
}	