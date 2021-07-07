$(function(){
	$("#Submit").click(function() {
		event.preventDefault();
		switch($("#nombre").val()) {
			case 'alfredo':
				window.location.replace("./Alfredo/Menu.html");
				break;
			case 'jared':
				window.location.replace("./Jared/Menu.html");
				break;
			default:
				alert("Opción no válida.");
		}
	});
});