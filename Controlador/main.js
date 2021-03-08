function actualizar(codArticu){
    // console.log(codArticu);

    $.ajax({
		url: 'Controlador/actualizar.php',
		method: 'POST',
		data: {
			
			codArticu: codArticu
		},
		success: function(data) {
			console.log(data);
		}
	});
}