$(function(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	var Cable = false;
	
	today = dd + '/' + mm + '/' + yyyy;
	
	$("#fecha").append(today);
	
	function BorrarPDF(archivo){
		$.ajax({
			url: "https://notas-taller.000webhostapp.com/php/BorrarArchivo.php",
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
	
	
	$.ajax({
		url: "https://notas-taller.000webhostapp.com/php/Alfredo/ObtenerID-Recibo.php",
		datatype: "json",
		data: {
		},
		type: "GET",
		success: function (data, textStatus, xhr) {
			$("#id").append("Folio: " + data);
		},
		error: function (x, estado, exception) {
			alert(estado + ": " + x);
		}
	});
	
	$(':input').on("input", function() {
		var Cliente = $("#Nombre").val();
		if($("#Apellido").val() !== '') {
			Cliente+= " " + $("#Apellido").val();
		}
		var Descripcion = '';
		var Tipo = $("#Tipo").val();
		var Marca;
		var Modelo;
		var Fallo = $("#Fallo").val();
		var Control;
		var Otras;
		Cable = $('#Cable').is(":checked");
		console.log(Cable);
		
		if($("#Marca").val() !== '') {
			Marca = $("#Marca").val();
		} else {
			Marca = "sin marca";
		}
		if($("#Modelo").val() !== '') {
			Modelo = $("#Modelo").val();
		} else {
			Modelo = "sin modelo";
		}
		if($("#Control").val() === '') {
			Control = false;
		} else {
			Control = $("#Control").val();
		}
		if($("#Caracteristicas").val() === '') {
			Otras = false;
		} else {
			Otras = $("#Caracteristicas").val();
		}
		Descripcion+= 'Dispositivo de ' + Cliente + " de tipo " + Tipo + ', ' + Marca + ', ' + Modelo + ' con fallo de ' + $("#Fallo").val() + '. ';
		if(!Cable && !Control && !Otras){
			Descripcion += 'No contiene elementos adicionales.';
		} else {
			Descripcion+= 'Contiene:';
			if(Cable) {
				Descripcion+= ' cable de luz';
				if(Control != false) {
					Descripcion += ', ' + $("#Control").val();
				}
				if(Otras != false) {
					Descripcion += ', ' + $("#Caracteristicas").val();
				}
			} else if(Control != false) {
				Descripcion += ' ' + $("#Control").val();
				if(Otras != false) {
					Descripcion += ', ' + $("#Caracteristicas").val();
				}
			} else if(Otras != false) {
				Descripcion += ' ' + $("#Caracteristicas").val();
			}
			Descripcion+='.';
		}
		$("#General").val(Descripcion);
		console.log(Descripcion);
	});
	
	$("#Submit").click(function() {
		event.preventDefault();
		if($("#Nombre").val() == '') {
			alert("El campo 'Nombre' es requerido.");
		} else if($("#Telefono1").val() == '') {
			alert("El campo 'Telefono 1' es requerido.");
		} else if($("#Servicio").val() == '') {
			alert("El campo 'Servicio' es requerido.");
		} else if($("#Tipo").val() == '') {
			alert("El campo 'Tipo' es requerido.");
		} else if($("#Fallo").val() == '') {
			alert("El campo 'Fallo' es requerido.");
		} else { 
			$.ajax({
				url: "https://notas-taller.000webhostapp.com/php/Alfredo/GenerarProducto.php",
				datatype: "json",
				data: {
					Nombre: $("#Nombre").val(),
					Apellido: $("#Apellido").val(),
					Direccion: $("#Direccion").val(),
					Telefono1: $("#Telefono1").val(),
					Telefono2: $("#Telefono2").val(),
					Servicio: $("#Servicio").val(),
					Anticipado: $("#Anticipado").val(),
					Tipo: $("#Tipo").val(),
					Marca: $("#Marca").val(),
					Modelo: $("#Modelo").val(),
					Fallo: $("#Fallo").val(),
					Cable: $('#Cable').is(":checked"),
					Control: $("#Control").val(),
					Caracteristicas: $("#Caracteristicas").val(),
					General: $("#General").val(),
					Ancho: 555*0.64,
					FechaActual: today
				},
				type: "POST",
				success: function (archivo, textStatus, xhr) {
					var a = document.createElement("a");
					a.style.display = "none";
					document.body.appendChild(a);
					//a.href = new URL("http://notas.taller/Archives/" + archivo);
					a.href = new URL("https://notas-taller.000webhostapp.com/Archives/" + archivo); //Versión de producción
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