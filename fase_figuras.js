//actualiza una fila para mostrar contenido editable
$(".edita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("fase_figuras_edita_fila.php", "id="+id);
	$("#id_figura").focus();
});

//actualiza una fila para mostrar contenido no editable
$(".desedita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("fase_figuras_desedita_fila.php", "id="+id);
});


//borra una fila y su entrada en la DB
$(".borra_fila").live('click', function() {
	var id = $(this).attr('id');
	//borro entrada de DB
	//TODO
	$("#fila"+id).load("fase_figuras_borra_fila.php", "id="+id);
	//elimino fila
	$("#fila"+id).remove();
});


//crea una fila con contenido editable
$("#editable-sample_new").live('click', function() {
	var id = $(this).attr('id');
	var fila_nueva = "<tr id='nueva_fila'></tr>";
	$("#editable-sample > tbody:last").append(fila_nueva);
	$("#nueva_fila").load("fase_figuras_edita_fila.php", "id=nueva_fila");
	$("#modalidades").focus();
	
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
	var id_figura = $('#figuras').val();
	var id_categoria = $('#categorias').val();
	var orden = $('#orden').val();
	//envio por post para guardarlo
	$.ajax({
	     type:'POST',
	      url:'./fase_figuras_guarda.php',
	      data:'id='+id+'&id_categoria='+id_categoria+'&id_figura='+id_figura+'&orden='+orden,
	      success:function(data) {
	        if(data) {               
		        console.log('carga ajax edita ok');
	        } else {  
	        	console.log('carga ajax edita error');
	      }}
	   });
	//actualiza una fila para mostrar contenido no editable
	$("#fila"+id).load("fase_figuras_lee_fila.php", "id="+id+"&id_categoria="+id_categoria+"&id_figura="+id_figura+"&orden="+orden);
	$("#nueva_fila").load("fase_figuras_lee_fila.php", "id=new&id_categoria="+id_categoria+"&id_figura="+id_figura+"&orden="+orden);
    setTimeout(function() {
   	 var id_temp = $('#nueva_fila>td').attr('value');
   	 $('#nueva_fila').attr('id', 'fila'+id_temp);
    },100); 
});

