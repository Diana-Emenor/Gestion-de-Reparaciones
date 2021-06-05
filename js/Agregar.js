$(function(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	
	today = dd + '/' + mm + '/' + yyyy;
	
	//agregar validacion de ,
	
	//agregar validación de datos
	
	//mejorar el sistema de busqueda
	
	
	var regexpnum = /[0-9|,]+(.?)[0-9]+/;
	
	$("#Submit").click(function() {
		if(regexpnum.test($("#Costo").val()) 
			&& $("#Cliente").val()!=="" 
			&& $("#Direccion").val()!=="" 
			&& $("#Telefono").val()!==""
			&& $("#Concepto").val()!==""
			&& $("#Dias").val()!==""
			&& $("#Fecha").val()!==""
			&& $("#Garantia").val()!==""){
			$.ajax({
				url: "./php/GenerarPDF.php",
				datatype: "json",
				data: {
					Cliente: $("#Cliente").val(),
					Direccion: $("#Direccion").val(),
					Telefono: $("#Telefono").val(),
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
					a.href = new URL("https://notas-taller.000webhostapp.com/Archives/" + archivo)
					a.setAttribute("download", './' + archivo);
					a.click();
					window.URL.revokeObjectURL(a.href);
					document.body.removeChild(a);
					alert("El archivo " + archivo + " se ha descargado adecuadamente.");
				},
				error: function (x, estado, exception) {
					alert("Error, el archivo PDF no pudo generarse.");
					console.log(x);
					console.log(estado);
					console.log(exception);
				}
			});
		} else {
			alert("Error en la evaluación de la expresión regular. Puede tratarse de un error humano o de la propia expresión.");
		}
	});
});