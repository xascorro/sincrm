//actualiza una fila para mostrar contenido editable
$(".edita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("figura_edita_fila.php", "id="+id);
	$("#nombre").focus();
});

//actualiza una fila para mostrar contenido no editable
$(".desedita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("figura_desedita_fila.php", "id="+id);
});


//borra una fila y su entrada en la DB
$(".borra_fila").live('click', function() {
	var id = $(this).attr('id');
	//borro entrada de DB
	//TODO
	$("#fila"+id).load("figura_borra_fila.php", "id="+id);
	//elimino fila
	$("#fila"+id).remove();
});


//crea una fila con contenido editable
$("#editable-sample_new").live('click', function() {
	var id = $(this).attr('id');
	var fila_nueva = "<tr id='nueva_fila'></tr>";
	$("#editable-sample > tbody:last").append(fila_nueva);
	$("#nueva_fila").load("figura_edita_fila.php", "id=nueva_fila");
    setTimeout( function() { $("#numero").focus(); }, 500 );
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
	var numero = $('#numero').val();
	var grado_dificultad = $('#grado_dificultad').val();
	//envio por post para guardarlo
	$.post('./figura_guarda.php',{id:id,nombre:nombre,numero:numero,grado_dificultad:grado_dificultad},
	   	function(){	
		   	//actualiza una fila para mostrar contenido no editable
		   	$("#fila"+id).load("figura_lee_fila.php", "id="+id+"&nombre="+nombre+"&numero="+numero+"&grado_dificultad="+grado_dificultad);
		   	$("#nueva_fila").load("figura_lee_fila.php", "id=new&nombre="+nombre+"&numero="+numero+"&grado_dificultad="+grado_dificultad);	
		    setTimeout(function() {
		   	 var id_temp = $('#nueva_fila>td').attr('value');
		   	 $('#nueva_fila').attr('id', 'fila'+id_temp);
		    },100); 
		}); 	
	
	
});

