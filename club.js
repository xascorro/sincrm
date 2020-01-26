//actualiza una fila para mostrar contenido editable
$(".edita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("club_edita_fila.php", "id="+id);
	$("#nombre").focus();
});

//actualiza una fila para mostrar contenido no editable
$(".desedita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("club_desedita_fila.php", "id="+id);
});


//borra una fila y su entrada en la DB
$(".borra_fila").live('click', function() {
	var id = $(this).attr('id');
	//borro entrada de DB
	//TODO
	$("#fila"+id).load("club_borra_fila.php", "id="+id);
	//elimino fila
	$("#fila"+id).remove();
});


//crea una fila con contenido editable
$("#editable-sample_new").live('click', function() {
	var id = $(this).attr('id');
	var fila_nueva = "<tr id='nueva_fila'></tr>";
	$("#editable-sample > tbody:last").append(fila_nueva);
	$("#nueva_fila").load("club_edita_fila.php", "id=nueva_fila");
	setTimeout( function() { $("#nombre").focus(); }, 500 );
	window.location.href='#nueva_fila';
});

//cancela una fila nueva
$(".cancela_nueva_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#nueva_fila").remove();
});

//guarda una fila
$(".guarda_fila").live('click', function() {
	//leo variables
	var id = $('#id').val();
	if(id == "undefined")
	id = "nueva_fila";
	var nombre = $('#nombre').val();
	var nombre_corto = $('#nombre_corto').val();
	var codigo = $('#codigo').val();
	var federacion = $('#federacion').val();
	var logo = $('#logo').val();
	//envio por post para guardarlo
	$.ajax({
		type:'POST',
		url:'./club_guarda.php',
		data:'id='+id+'&nombre='+nombre+'&nombre_corto='+nombre_corto+'&codigo='+codigo+'&federacion='+federacion+'&logo='+logo,
		success:function(data) {
			if(data) {
				console.log('carga ajax edita ok');
			} else {
				console.log('carga ajax edita error');
			}}
		});
		//actualiza una fila para mostrar contenido no editable
		//var ultima_fila_id = $("#editable-sample tr:last").attr("value");
		$("#fila"+id).load("club_lee_fila.php", "id="+id+"&nombre="+nombre+"&nombre_corto="+nombre_corto+"&codigo="+codigo+'&federacion='+federacion+"&logo="+logo);
		$("#nueva_fila").load("club_lee_fila.php", "id=new&nombre="+nombre+"&nombre_corto="+nombre_corto+"&codigo="+codigo+'&federacion='+federacion+"&logo="+logo);
		setTimeout(function() {
			var id_temp = $('#nueva_fila>td').attr('value');
			$('#nueva_fila').attr('id', 'fila'+id_temp);
		},100);

	});
