// SU QUESTO FILE SI TROVANO LE FUNZIONI CHE GENERANO IL RINFRESCO DELLA PAGINA IMPIANTO -
// SI OCCUPANO SOLO DELLA LETTURA DEI DATI

// Carico i registri da prelevare sul plc in due vettori
// Per i valori analogici va mantenuto il prefisso 4 e il numero del registro va dimezzato

var regs = ['41102'];


//FUNZIONE DI RINFRESCO DATI PAGINA
function getData(){
	
	//RICHIESTA AL SERVER
	$.ajax({
		type: 'POST',
		url: 'php/get_data.php',
		data: {Reg:regs},
		success: function(data){
			connectionDelay = 0;
			if(data["41102"]){
				document.getElementById("wind-speed").setAttribute("value", data["41102"] + " m/s");
			}		
			
		},
		complete: function(data){
			console.log("complete");
		},
		failure: function(data){},
		timeout: 5000 // sets timeout to 5 seconds
	});

}
