//actualiza una fila para mostrar contenido editable
$(".edita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("rutina_edita_fila.php", "id="+id);
	$("#nombre").focus();
});

//actualiza una fila para mostrar contenido no editable
$(".desedita_fila").live('click', function() {
	var id = $(this).attr('id');
	$("#fila"+id).load("rutina_desedita_fila.php", "id="+id);
});


//borra una fila y su entrada en la DB
$(".borra_fila").live('click', function() {
	if (confirm('¿Borrar rutina?')) { 
		var id = $(this).attr('id');
		//borro entrada de DB
		//TODO
		$("#fila"+id).load("rutina_borra_fila.php", "id="+id);
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
	$("#nueva_fila").load("rutina_edita_fila.php", "id=nueva_fila");
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
	var nombre = $('#nombre').val();
	var musica = $('#musica').val();
	var id_fase = GetUrlValue('id_fase');
	var id_club = $('#club').val();
	var nombre = $('#nombre').val();
	var orden = $('#orden').val();
	var peso = $('#peso').val();
	var descripcion = $('#descripcion').val();
	//envio por post para guardarlo
	$.ajax({
	     type:'POST',
	      url:'./rutina_guarda.php',
	      data:'id='+id+'&nombre='+nombre+'&musica='+musica+"&id_fase="+id_fase+"&id_club="+id_club+'&orden='+orden,
	      success:function(data) {
	        if(data) {               
		        console.log('carga ajax edita ok');
	        } else {  
	        	console.log('carga ajax edita error');
	      }}
	   });
	//actualiza una fila para mostrar contenido no editable
	//var ultima_fila_id = $("#editable-sample tr:last").attr("value");                
	$("#fila"+id).load("rutina_lee_fila.php", "id="+id+"&id_fase="+id_fase+"&id_club="+id_club+"&nombre="+nombre+"&musica="+musica+"&orden="+orden);
	$("#nueva_fila").load("rutina_lee_fila.php", "id=new&id_fase="+id_fase+"&id_club="+id_club+"&nombre="+nombre+"&musica="+musica+"&orden="+orden);
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
