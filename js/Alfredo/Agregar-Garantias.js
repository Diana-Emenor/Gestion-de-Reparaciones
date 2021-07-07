$(function(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	today = dd + '/' + mm + '/' + yyyy;
	
	var regexpnum = /[0-9]+/;
	
	function BorrarPDF(archivo){
		$.ajax({
			url: "../php/BorrarArchivo.php",
			datatype: "json",
			data: {
				Archivo: archivo
			},
			type: "POST",
			success: function (archivo, textStatus, xhr) {
				console.log("Archivo Borrado con exito");
			},
			error: function (x, estado, exception) {
				alert("Error.");
				console.log(x);
				console.log(estado);
				console.log(exception);
			}
		});
	}
	
	$("#Submit").click(function() {
		event.preventDefault();
		if($("#Nombre").val() == '') {
			alert("El campo 'Nombre' es requerido.");
		} else if($("#Telefono1").val() == '') {
			alert("El campo 'Telefono 1' es requerido.");
		} else if($("#Concepto").val() == '') {
			alert("El campo 'Concepto' es requerido.");
		} else if($("#Costo").val() == '') {
			alert("El campo 'Costo' es requerido.");
		} else if($("#Dias").val() == '') {
			alert("El campo 'Días' es requerido.");
		} else if($("#Garantia").val() == '') {
			alert("El campo 'Garantia' es requerido.");
		} else {
			$.ajax({
				url: "../php/Alfredo/GenerarGarantia.php",
				datatype: "json",
				data: {
					Nombre: $("#Nombre").val(),
					Apellido: $("#Apellido").val(),
					Direccion: $("#Direccion").val(),
					Telefono1: $("#Telefono1").val(),
					Telefono2: $("#Telefono2").val(),
					Concepto: $("#Concepto").val(),
					Costo: $("#Costo").val(),
					Dias: $("#Dias").val(),
					Fecha: $("#Fecha").val(),
					Garantia: $("#Garantia").val(),
					Ancho: 555*0.64,
					FechaActual: today
				},
				type: "POST",
				success: function (archivo, textStatus, xhr) {
					var a = document.createElement("a");
					a.style.display = "none";
					document.body.appendChild(a);
					a.href = new URL("http://notas.taller/Archives/" + archivo);
					//a.href = new URL("https://notas-taller.000webhostapp.com/Archives/" + archivo); //Versión de producción
					a.setAttribute("download", './' + archivo);
					a.click();
					window.URL.revokeObjectURL(a.href);
					document.body.removeChild(a);
					alert("El archivo " + archivo + " se ha descargado adecuadamente.");
					BorrarPDF(archivo);
				},
				error: function (x, estado, exception) {
					alert("Error, el archivo PDF no pudo generarse.");
					console.log(x);
					console.log(estado);
					console.log(exception);
				}
			});
		}
		
	});
	
	
});