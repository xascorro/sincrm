//actualiza una fila para mostrar contenido editable
$(".edita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("inscripcion_figuras_edita_fila.php", "id="+id);
	$("#nombre").focus();
});

//actualiza una fila para mostrar contenido no editable
$(".desedita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("inscripcion_figuras_desedita_fila.php", "id="+id);
});


//borra una fila y su entrada en la DB
$(".borra_fila").live('click', function() {
	if (confirm('¿Borrar participación de nadadora?')) { 
		var id = $(this).attr('id');
		//borro entrada de DB
		//TODO
		$("#fila"+id).load("inscripcion_figuras_borra_fila.php", "id="+id);
		//elimino fila
		$("#fila"+id).remove();
		$("."+id).remove();
	}
});


//crea una fila con contenido editable
$("#editable-sample_new").live('click', function() {
	var id = $(this).attr('id');
	var fila_nueva = "<tr id='nueva_fila'></tr>";
	$("#editable-sample > tbody:last").append(fila_nueva);
	$("#nueva_fila").load("inscripcion_figuras_edita_fila.php", "id=nueva_fila");
	$("#nueva_fila>#nombre").focus();
	
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
	var id_fase_figuras = GetUrlValue('id_fase_figuras');
	var id_nadadora = $('#nadadora').val();
	var orden = $('#orden').val();
	//envio por post para guardarlo
	$.ajax({
	     type:'POST',
	      url:'./inscripcion_figuras_guarda.php',
	      data:'id='+id+"&id_fase_figuras="+id_fase_figuras+"&id_nadadora="+id_nadadora+'&orden='+orden,
	   });
	//actualiza una fila para mostrar contenido no editable
	$("#fila"+id).load("inscripcion_figuras_lee_fila.php", "id="+id+"&id_fase_figuras="+id_fase_figuras+"&id_nadadora="+id_nadadora+"&orden="+orden);
	$("#nueva_fila").load("inscripcion_figuras_lee_fila.php", "id=new&id_fase_figuras="+id_fase_figuras+"&id_nadadora="+id_nadadora+"&orden="+orden);
    setTimeout(function() {
   	 var id_temp = $('#nueva_fila>td').attr('value');
   	 $('#nueva_fila').attr('id', 'fila'+id_temp);
    },100);
	
});


function GetUrlValue(VarSearch){
    var SearchString = window.location.search.substring(1);
    var VariableArray = SearchString.split('&');
    for(var i = 0; i < VariableArray.length; i++){
        var KeyValuePair = VariableArray[i].split('=');
        if(KeyValuePair[0] == VarSearch){
            return KeyValuePair[1];
        }
    }
}
