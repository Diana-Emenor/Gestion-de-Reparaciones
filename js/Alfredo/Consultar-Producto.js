$(function(){
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	today = dd + '/' + mm + '/' + yyyy;
	
	var tabla;
	
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
	
	$.ajax({
		url: "../php/Alfredo/ObtenerProductos.php",
		dataType: "json",
		type: "GET",
		success: function (page) {
			for(var i = 0; i < page.length; i++)
				$("#contenido").append($.parseHTML(page[i]));
			tabla = $("#principal").DataTable({
				order: [],
				language: {
					url: '/new 6.json'
				},
				responsive: true
			});
			jQuery.fn.DataTable.ext.type.search.string = function ( data ) {
				return ! data ? '' :
				typeof data === 'string' ?
					data
						.replace( /\n/g, ' ' )
						.replace( /[áâàä]/g, 'a' )
						.replace( /[éêèë]/g, 'e' )
						.replace( /[íîìï]/g, 'i' )
						.replace( /[óôòö]/g, 'o' )
						.replace( /[úûùü]/g, 'u' )
					.replace( /ç/g, 'c' ) :
					data;
			};
		},
		error: function (a, statuss, excepcion) {
			console.log(a);
		}
	});
	
	$('#principal tbody').on( 'click', 'tr', function() {
		$.ajax({
			url: "../php/Alfredo/DescargarProducto.php",
			datatype: "json",
			data: {
				IDProducto: tabla.row(this).data()[0],
				IDCliente: tabla.row(this).data()[2],
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
		console.log(tabla.row(this).data()[0]);
		console.log(tabla.row(this).data()[2]);
	});
});