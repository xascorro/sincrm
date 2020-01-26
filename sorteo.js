//realiza el sorteo de la fase
$(".random").live('click', function() {
	if (confirm('¿Sortear fase?')) { 
		var id_fase = $(this).attr('id_fase_enlace');
		$("#"+id_fase).load("sorteo_fase.php", "id_fase="+id_fase);
	}
});

//trick para volver a sortear
$(".bloqueado").live('click', function() {
	//var pass_desbloqueo = prompt('Para desbloquear el sorteo necesitamos la contraseña:');
	var pass_desbloqueo = 'xas';
	if (pass_desbloqueo == "xas") { 
		var id_fase = $(this).attr('id_fase_enlace');
		$("#"+id_fase).load("sorteo_fase.php", "id_fase="+id_fase+"&desbloquear");
	}
});