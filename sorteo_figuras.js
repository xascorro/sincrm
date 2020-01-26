//realiza el sorteo de la fase
$(".random").live('click', function() {
	if (confirm('¿Sortear fase de figuras?')) { 
		var id_fase_figuras = $(this).attr('id_fase_figuras_enlace');
		var corte = $("#corte"+id_fase_figuras).attr("value");
		$("#"+id_fase_figuras).load("sorteo_fase_figuras.php", "id_fase_figuras="+id_fase_figuras+"&corte="+corte);
	}
});

//trick para volver a sortear
$(".bloqueado").live('click', function() {
	//var pass_desbloqueo = prompt('Para desbloquear el sorteo necesitamos la contraseña:');
	var pass_desbloqueo = 'xas';
	var corte = $("#corte"+id_fase_figuras).attr("value");
	if (pass_desbloqueo == "xas") { 
		var id_fase_figuras = $(this).attr('id_fase_figuras_enlace');
		$("#"+id_fase_figuras).load("sorteo_fase_figuras.php", "id_fase_figuras="+id_fase_figuras+"&desbloquear=0&corte="+corte);
	}
});