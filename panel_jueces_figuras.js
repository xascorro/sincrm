//actualiza una fila para mostrar contenido editable
$(".edita_fila").live('click', function() {
	var fila = $(this).attr('fila');
	var panel = $(this).attr('panel');
	var fase = $(this).attr('fase');
	var id_juez = $(this).attr('id_juez');
	var id_panel_jueces = $(this).attr('id_panel_jueces');
	$("#fila_"+fila+"_panel_"+panel+"_fase"+fase).load("panel_jueces_edita_fila.php", "id_juez="+id_juez+"&fila="+fila+"&panel="+panel+"&fase="+fase+"&id_panel_jueces="+id_panel_jueces);
	$("#nombre").focus();
});

//guarda una fila
$(".guarda_fila").live('click', function() {
	//leo variables
	var fila = $(this).attr('fila');
	var panel = $(this).attr('panel');
	var fase = $(this).attr('fase');
	var juez = $('#juez').val();
	var panel_jueces = $(this).attr('panel_jueces');
	//envio por post para guardarlo
	$.ajax({
	     type:'POST',
	      url:'./panel_jueces_figuras_guarda.php',
	      data:'fila='+fila+'&panel='+panel+'&fase='+fase+'&juez='+juez+'&panel_jueces='+panel_jueces,
	      success:function(data) {
	        if(data) {               
		        console.log('carga ajax edita ok');
	        } else {  
	        	console.log('carga ajax edita error');
	      }}
	   });
	   
	   $("#fila_"+fila+"_panel_"+panel+"_fase"+fase).load("panel_jueces_desedita_fila.php", "juez="+juez+"&fila="+fila+"&panel="+panel+"&fase="+fase+"&panel_jueces="+panel_jueces);
	//actualiza una fila para mostrar contenido no editable
	//var ultima_fila_id = $("#editable-sample tr:last").attr("value");                
/*	$("#fila"+id).load("panel_lee_fila.php", "id="+id+"&nombre="+nombre+"&numero_jueces="+numero_jueces+"&peso="+peso+"&descripcion="+descripcion);
	$("#nueva_fila").load("panel_lee_fila.php", "id=new&nombre="+nombre+"&numero_jueces="+numero_jueces+"&peso="+peso+"&descripcion="+descripcion);
    setTimeout(function() {
   	 var id_temp = $('#nueva_fila>td').attr('value');
   	 $('#nueva_fila').attr('id', 'fila'+id_temp);
    },100); 
*/	
});
