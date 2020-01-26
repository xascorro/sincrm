//actualiza una participante para mostrar contenido editable
$(".edita_participante").live('click', function() {
	var id = $(this).attr('id');
	var id_rutina = $(this).attr('id_rutina');
	var t_r = $(this).attr('t_r');
	var id_club = $(this).attr('id_club');
	var id_participante = $(this).attr('id_participante');
	$("#participante_"+t_r+"_"+id+"_"+id_rutina).load("rutina_edita_participante.php", "id="+id+"&t_r="+t_r+"&id_club="+id_club+"&id_participante="+id_participante+"&id_rutina="+id_rutina+"&num_fila="+id);


    setTimeout(function() {
    //    $('#nadadora').attr('size',$('#nadadora option').length);
        $('#nadadora').focus();
    },200);



});

//actualiza una participante para mostrar contenido no editable
$(".desedita_participante").live('click', function() {
	var id = $(this).attr('num_fila');
	var t_r = $(this).attr('t_r');
	var id_rutina = $('#id').val();
	alert("#participante_"+t_r+"_"+id+"_"+id_rutina);
	$("#participante_"+t_r+"_"+id+"_"+id_rutina).load("rutina_desedita_participante.php", "id="+id);
});


//borra una participante y su entrada en la DB
$(".borra_participante").live('click', function() {
	if (confirm('¿Borrar participante?')) {
		var id = $(this).attr('id');
		var t_r = $(this).attr('t_r');
		var id_club = $(this).attr('id_club');
		var id_rutina = $(this).attr('id_rutina');
		//borro entrada de DB
		//TODO
		$("#participante_"+t_r+"_"+id+"_"+id_rutina).load("rutina_borra_participante.php", "id="+id);
		//elimino participante
		$("#participante_"+t_r+"_"+id+"_"+id_rutina).remove();
		//******************************************** hacer que salga fila nueva con el load en vez de cargarsela//
	}
});


//crea una participante con contenido editable
/*$("#editable-sample_new").live('click', function() {
	var id = $(this).attr('id');
	var participante_nueva = "<tr id='nueva_participante'></tr>";
	$("#editable-sample > tbody:last").append(participante_nueva);
	$("#nueva_participante").load("rutina_edita_participante.php", "id=nueva_participante");
	$("#nueva_participante>#nombre").focus();

});*/

//cancela una participante nueva
$(".cancela_nueva_participante").live('click', function() {
	var t_r = $(this).attr('t_r');
	var id = $(this).attr("id");
	if(id == "undefined")
		id = "new";
	var id_participante = $('#nadadora').val();
	num_fila = $(this).attr('num_fila');
	id_club = $(this).attr('id_club');
	var id_rutina = $('#id').val();
	var id_nadadora = $('#nadadora').val();
	var reserva = $('#reserva').val();	//var id = $(this).attr('id');
   //$("#nueva_participante").remove();
    $("#participante_"+t_r+"_"+id+"_"+id_rutina).load("rutina_lee_participante.php", "id="+id+"&id_rutina="+id_rutina+"&id_nadadora="+id_nadadora+"&id_participante="+id_participante+"&reserva="+reserva);
    $("#participante_"+t_r+"_"+num_fila+"_"+id_rutina).load("rutina_lee_participante.php", "id="+id+"&id_rutina="+id_rutina+"&id_nadadora="+id_nadadora+"&id_participante="+id_participante+"&reserva="+reserva+"&num_fila="+num_fila+"&id_club="+id_club);

});

//guarda una participante
$(".guarda_participante").live('click', function() {
	//leo variables
	var t_r = $(this).attr('t_r');
	var id = $(this).attr("id");
	if(id == "undefined")
		id = "new";
	var num_fila = $(this).attr("num_fila");
	var id_participante = $('#nadadora').val();
	var id_rutina = $('#id').val();
	var id_nadadora = $('#nadadora').val();
	var reserva = $('#reserva').val();
	var	num_fila = $(this).attr('num_fila');
	var id_club = $(this).attr('id_club');
	//envio por post para guardarlo
	$.ajax({
	     type:'POST',
	      url:'./rutina_guarda_participante.php',
	      data:'id='+id+'&id_rutina='+id_rutina+"&id_nadadora="+id_participante+"&reserva="+reserva,
	      success:function(data) {
	        if(data) {
		        console.log('carga ajax edita ok');
	        } else {
	        	console.log('carga ajax edita error');
	      }}
	   });
	//actualiza una participante para mostrar contenido no editable
	$("#participante_"+t_r+"_"+id+"_"+id_rutina).load("rutina_lee_participante.php", "id="+id+"&id_rutina="+id_rutina+"&id_nadadora="+id_nadadora+"&id_participante="+id_participante+"&reserva="+reserva+"&num_fila="+num_fila);

	//descomentar mas abajo
	$("#participante_"+t_r+"_"+num_fila+"_"+id_rutina).load("rutina_lee_participante.php", "id="+id+"&id_rutina="+id_rutina+"&id_nadadora="+id_nadadora+"&id_participante="+id_participante+"&reserva="+reserva+"&num_fila="+num_fila+"&id_club="+id_club);
   // setTimeout(function() {
  // 	 var id_temp = $('#nueva_participante>td').attr('value');
 //  	 $('#nueva_participante').attr('id', 'participante'+id_temp);
 //   },100);

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
