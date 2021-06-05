$(function(){
	
	$.ajax({
		url: "./php/redact.php",
		dataType: "json",
		type: "GET",
		success: function (page) {
			for(var i = 0; i < page.length; i++)
				$("#contenido").append($.parseHTML(page[i]));
			var tabla = $("#principal").DataTable({
				order: [],
				language: {
					url: '/new 6.json'
				}
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
});