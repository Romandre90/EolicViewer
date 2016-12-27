// SU QUESTO FILE SI TROVANO LE FUNZIONI CHE GENERANO IL RINFRESCO DELLA PAGINA IMPIANTO -
// SI OCCUPANO SOLO DELLA LETTURA DEI DATI

// Carico i registri da prelevare sul plc in due vettori
// Per i valori analogici va mantenuto il prefisso 4 e il numero del registro va dimezzato

//////////////////////////////////////////////////////////////////////////////////////////
/*      								PARTENZA										*/
/* Per ora è stata implementata solo la parte per la visualizzazione in tempo reale dei	*/
/* dati principali																		*/
/* -> velocità vento																	*/
/* -> rotazione pale																	*/
/* -> potenza prodotta																	*/
//////////////////////////////////////////////////////////////////////////////////////////

var regs = ['41102','41200','41104'];
//var alarms =[]


//FUNZIONE DI RINFRESCO DATI PAGINA
function getData(){
	
	//RICHIESTA AL SERVER
	$.ajax({
		type: 'POST',
		url: 'php/get_data.php',
		data: {Reg:regs},
		// la funzione sotto prende il vettore che arriva dalla pagina "get_data.php" ed aggiorna i valori della pagina "nuova.php"
		success: function(data){
			//VELCITà DEL VENTO
				/* il metodo getElementById prende in ingresso l'id del tag da modificare. Sotto prende il valore letto 
				dalla pagina "get_data.php" e salvato nel vettore "data[]" e lo mette come value nel tag selezionato*/
				document.getElementById("wind-speed").setAttribute("value", data["41102"].toFixed(2) + " m/s");
			//POTENZA PRODOTTA
				document.getElementById("engine_prod").setAttribute("value", data["41200"].toFixed(2) + " kW");
			//VELOCITà ROTORE
				document.getElementById("ridut_giri").setAttribute("value", data["41104"].toFixed(2) + " rpm");
		},
		complete: function(data){
			console.log("complete");
		},
		failure: function(data){},
		timeout: 600000 // sets timeout to 10 seconds
	});

}
