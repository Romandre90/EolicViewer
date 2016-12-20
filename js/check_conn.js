// FILE DA UTILIZZARE SOLO PER MAINPAGE - LA STESSA FUNZIONE E' IMPLEMENTATA NEI FILE DI LETTURA DELLE SINGOLE PAGINE
// E' POSSIBILE INCLUDERLA NEL FILE GLOBAL_REFRESH UNA VOLTA ULTIMATO

var noConnection = 1;

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
}