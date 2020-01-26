//actualiza una fila para mostrar contenido editable
$(".edita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("competicion_edita_fila.php", "id="+id);
	$("#nombre").focus();
});

//actualiza una fila para mostrar contenido no editable
$(".desedita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("competicion_desedita_fila.php", "id="+id);
});


//borra una fila y su entrada en la DB
$(".borra_fila").live('click', function() {
	var id = $(this).attr('id');
	//borro entrada de DB
	//TODO
	$("#fila"+id).load("competicion_borra_fila.php", "id="+id);
	//elimino fila
	$("#fila"+id).remove();
});


//crea una fila con contenido editable
$("#editable-sample_new").live('click', function() {
	var id = $(this).attr('id');
	var fila_nueva = "<tr id='nueva_fila'></tr>";
	$("#editable-sample > tbody:last").append(fila_nueva);
	$("#nueva_fila").load("competicion_edita_fila.php", "id=nueva_fila");
	$("#nombre").focus();
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
	var lugar = $('#lugar').val();
	var fecha = $('#fecha').val();
	var activo = $('#activo').val();
	var organizador_tipo = $('#organizador_tipo').val();
		console.log(organizador_tipo);
	if(organizador_tipo == 'Federación')
		var organizador = $('#federacion').val();
	if(organizador_tipo == 'Club')
		var organizador = $('#club').val();

	//envio por post para guardarlo
	$.ajax({
	     type:'POST',
	      url:'./competicion_guarda.php',
	      data:'id='+id+'&nombre='+nombre+'&lugar='+lugar+'&fecha='+fecha+'&organizador_tipo='+organizador_tipo+'&organizador='+organizador+'&activo='+activo,
	      success:function(data) {
	        if(data) {               
		        console.log('carga ajax edita ok');
	        } else {  
	        	console.log('carga ajax edita error');
	      }}
	   });
	//actualiza una fila para mostrar contenido no editable
	//var ultima_fila_id = $("#editable-sample tr:last").attr("value");                
	$("#fila"+id).load("competicion_lee_fila.php", "id="+id+"&nombre="+nombre+"&lugar="+lugar+"&fecha="+fecha+'&organizador_tipo='+organizador_tipo+"&organizador="+organizador+'&activo='+activo);
	$("#nueva_fila").load("competicion_lee_fila.php", "id=new&nombre="+nombre+"&lugar="+lugar+"&fecha="+fecha+'&organizador_tipo='+organizador_tipo+"&organizador="+organizador+'&activo='+activo);
    setTimeout(function() {
   	 var id_temp = $('#nueva_fila>td').attr('value');
   	 $('#nueva_fila').attr('id', 'fila'+id_temp);
    },100); 
	
});