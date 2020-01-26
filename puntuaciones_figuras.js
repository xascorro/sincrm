//deshabilito todo si la fase esta puntuada o los inputs de las rutinas en baja
$( document ).ready(function() {
	if ($('#puntuada').attr('puntuada') == 'si'){
		$('#editable-sample').find('input').each(function() {
		 	$(this).prop('disabled',true);
		});
		$('#editable-sample').find('a').each(function() {
		 	$(this).hide();
		});
		$('.penalizaciones').hide();
		$('.bajas').hide();
	} else{
		$('#editable-sample').find('baja').each(function() {
			 var id_inscripcion_figuras = $(this).attr('id');
			 $('#'+id_inscripcion_figuras).find('input').each(function() {
				 $(this).prop('disabled',true);
		 });

		});
	}
});

//despuntuo y desbloqueo la fase
$("#puntuada").live('click', function() {
	if(prompt('Introduzca la contraseña para desbloquear la fase','')=='...'){
		var id_fase_figuras = $(this).attr('id_fase_figuras');
		$.post('./puntuaciones_fases_figuras_despuntuar.php',{id_fase_figuras:id_fase_figuras},
		   	function(){
				location.reload(true);
		});
	} else{
		$('.alert').show();
	}
});

//puntuo y bloqueo la fase
$("#puntuar_fase").live('click', function() {
		var id_fase = $(this).attr('id_fase');
		$.post('./puntuaciones_fases_figuras_puntuar.php',{id_fase:id_fase},
		   	function(){
				location.reload(true);
		});
});

//coloreo input activo para destacarlo
var estilo_input = '';
$('input[type="text"]').focus(function() {
	estilo_input = $(this).attr('style');
    $(this).css({'background-color':'#81B2F8', 'color':'white'});
    if(this.value == '0.0')
    	this.value = '';
});
//vuelto input a aspecto original cuando pierde el foco
$('input[type="text"]').blur(function() {
    $(this).attr("style",estilo_input);
    if(this.value == '')
    	this.value = '0.0';
});

//incremento tab index
 $("input,select").bind("keyup", function (e) {
     var keyCode = e.keyCode || e.which;
     console.log($(this).attr('value'));
     //if(keyCode === 13 || ($(this).attr('value') >= 10 && keyCode >= 96 && keyCode <= 105)){
     if(keyCode === 13 ){
         //e.preventDefault();
         $('input, select, textarea,a')
         [$('input,select,textarea,a').index(this)+1].focus();
     }
 });

//guarda una fila
$(".guarda_puntuacion").live('click', function() {
	var id_fase = $(this).attr('fase');
	var id_inscripcion_figuras =  $(this).parent().parent().attr('id');
	var nota = 0.0;
	var id_nota_media = "";
	var nota_media = 0.0000;
	var nota_calculada = 0.0000;
	var nota_menor = 10.0;
	var nota_mayor = 0.0;
	var nota_final = 0.000;
	var id_nota_menor = "";
	var id_nota_mayor = "";
	//obtengo las celdas de la fila desde la que se ha llamado
	$('#'+id_inscripcion_figuras).find('th').each(function() {
		//obtengo el input de la celda
		$(this).find('input').each(function() {
			//obtengo valores a guardar
			var id_panel_jueces = $(this).attr('panel_juez');
			var id_inscripcion_figuras = $(this).attr('id_inscripcion_figuras');
			nota = $(this).attr('value');
			nota = nota.replace(',', '.');
			if (nota > 10)
				nota = nota/10;
			nota = parseFloat(nota).toFixed(1);
			$(this).attr('value',nota);

			//envio notas de puntuaciones_jueces por post, una consulta por nota y juez	 y desabilito el input
			$.ajax({
		     type:'POST',
		      url:'./puntuaciones_figuras_jueces_guarda.php',
		      data:'id_inscripcion_figuras='+id_inscripcion_figuras+'&id_panel_jueces='+id_panel_jueces+'&nota='+nota,
		   });
		   $(this).attr('disabled','disabled');
		   //obtengo nota del panel, nota menor y nota mayor (se restaran despues)
		   if(nota < nota_menor){
			   nota_menor = nota;
			   id_nota_menor = $(this).attr('id');
		   }
		   if(nota >= nota_mayor){
			   nota_mayor = nota;
			   id_nota_mayor = $(this).attr('id');
		   }
		   nota_media = parseFloat(nota_media) + parseFloat(nota);
		   console.log(nota);
		});
		//calculo la nota media del panel restando nota mayor y menor
		if($(this).attr('class') == 'nota_media'){
			var panel = $(this).attr('panel');
		    id_nota_media = $(this).attr('id');
		    gd = $(this).attr('gd');
		    numero_jueces = $(this).attr('numero_jueces');
		    //calculo la nota calculada del panel
		    if(numero_jueces > 3){
			    nota_media = (nota_media - nota_mayor - nota_menor)/(numero_jueces-2);
			    nota_calculada = nota_media*(parseFloat(gd).toFixed(1));
			    nota_media = parseFloat(nota_media).toFixed(4);
			    nota_calculada = parseFloat(nota_calculada).toFixed(4);
			    $('#'+id_nota_media).html(nota_media+'<br>'+nota_calculada);
			    console.log('nota_calculada:'+nota_calculada+" nota_mayor:"+nota_mayor+" nota_menor:"+nota_menor);
			    //saco su valor calculado y lo sumo a la nota final
			    nota_final = parseFloat(nota_calculada) + parseFloat(nota_final);
			    nota_final = parseFloat(nota_final).toFixed(4);
			    //cambio atributos de inputs con valores menor y mayor
			    $("#"+id_nota_menor).css({'text-decoration':'underline'});
			    $("#"+id_nota_mayor).css({'text-decoration':'overline'});
			    //guardo en DB cual es la nota mayor y menor (para informes)
			    $.post('./puntuaciones_figuras_jueces_menor_mayor.php',{id_inscripcion_figuras:id_inscripcion_figuras,id_nota_menor:id_nota_menor,id_nota_mayor:id_nota_mayor,panel:panel,id_fase:id_fase},
			      function(){
			 	});
			    //envio nota media y calculada de paneles por post, una consulta por panel
				$.post('./puntuaciones_figuras_paneles_guarda.php',{id_inscripcion_figuras:id_inscripcion_figuras,id_panel:panel,nota_media:nota_media,nota_calculada:nota_calculada},
					function(){
						   console.log("gd:"+gd + " nota_calculada:"+nota_calculada + " nota_final:"+nota_final);

				});
			}else{
			    nota_media = nota_media/numero_jueces;
			    nota_calculada = nota_media*(parseFloat(gd).toFixed(1));
			    console.log('nota_media:'+nota_media+' nota_calculada:'+nota_calculada+" nota_mayor:"+nota_mayor+" nota_menor:"+nota_menor);
			    nota_media = parseFloat(nota_media).toFixed(4);
			    nota_calculada = parseFloat(nota_calculada).toFixed(4);
			    $('#'+id_nota_media).html(nota_media+'<br>'+nota_calculada);
			    //saco su valor calculado y lo sumo a la nota final
			    nota_final = parseFloat(nota_calculada) + parseFloat(nota_final);
			    nota_final = parseFloat(nota_final).toFixed(4);
			    //cambio atributos de inputs con valores menor y mayor
			    $("#"+id_nota_menor).css({'text-decoration':'underline'});
			    $("#"+id_nota_mayor).css({'text-decoration':'overline'});
			    //envio nota media y calculada de paneles por post, una consulta por panel
				$.post('./puntuaciones_figuras_paneles_guarda.php',{id_inscripcion_figuras:id_inscripcion_figuras,id_panel:panel,nota_media:nota_media,nota_calculada:nota_calculada},
					function(){
						   console.log("gd:"+gd + " nota_media:"+nota_media+ " nota_calculada:"+nota_calculada + " nota_final:"+nota_final);

				});
			}
		    //reseteo valores
		    nota = 0.0;
		    nota_media = 0.0000;
		    nota_mayor = 0.0;
		    nota_menor = 10.0;
	    }
	    if($(this).attr('class') == 'nota_final'){
		    $(this).html(nota_final);
		    //guardo nota final
		    actualizar_nota_final_guarda(id_inscripcion_figuras,nota_final);
		}
	});
	$(this).html("<i class='fa fa-lock'></i>");
});


//añado penalizaciones
$("#penaliza_figura").live('click', function() {
	var id_inscripcion_figuras = $('#figura_penalizada').val();
	var id_penalizacion = $('#rutina_penalizacion').val();
	var id_fase = $(this).attr('id_fase');
	$.post('./penalizacion_figura_guarda.php',{id_inscripcion_figuras:id_inscripcion_figuras,id_penalizacion:id_penalizacion},
      function(){
		//actualizo la celda de puntuaciones con las penalizaciones
		$("#pr_"+id_inscripcion_figuras).load("penalizacion_figuras_lee.php", "id_inscripcion_figuras="+id_inscripcion_figuras);
 	});
});


//borro penalizacion
$(".penalizacion_borrar").live('click', function() {
	var id_inscripcion_figuras = $(this).attr('id_inscripcion_figuras');
	var id_penalizacion = $(this).attr('id_penalizacion');
	//borro por ajax la penalizacion de la rutina en la db
	$.post('./penalizacion_rutina_borra.php',{id_inscripcion_figuras:id_inscripcion_figuras,id_penalizacion:id_penalizacion},
		function(){
			//oculto la fila de la tabla que la mostraba
			$('#p'+id_penalizacion).hide();
			//actualizo la celda de puntuaciones con las penalizaciones
			$("#pr_"+id_inscripcion_figuras).load("penalizacion_figuras_lee.php", "id_inscripcion_figuras="+id_inscripcion_figuras);
			//actualizo nota_final
			actualizar_nota_final(id_inscripcion_figuras);
    });
});

//añado baja
$("#baja_figura").live('click', function() {
	var id_fase_figuras = $(this).attr('id_fase_figuras');
	var id_inscripcion_figuras = $('#figura_baja').val();
	$.post('./baja_figura_guarda.php',{id_inscripcion_figuras:id_inscripcion_figuras},
	    function(){
	    	$('.bajas-body').load('bajas_figuras_listar.php', "id_fase_figuras="+id_fase_figuras);
	    });
		$('#'+id_inscripcion_figuras).find('input').each(function() {
			$(this).prop('disabled', true);
	});
});

//borro baja
$(".baja_borrar").live('click', function() {
	var id_inscripcion_figuras = $(this).attr('id_inscripcion_figuras');
	$.post('./baja_figura_borra.php',{id_inscripcion_figuras:id_inscripcion_figuras},
	   	function(){
			//oculto la fila de la tabla que la mostraba
			$('#b'+id_inscripcion_figuras).hide();
			//habilito inputs
			$('#'+id_inscripcion_figuras).find('input').each(function() {
			$(this).prop('disabled', false);
			});

	});
});

//actualiza la nota final en la DB
function actualizar_nota_final(id_inscripcion_figuras){
	   $("#nf_"+id_inscripcion_figuras).load("puntuaciones_figuras_actualiza_nota_final.php", "id_inscripcion_figuras="+id_inscripcion_figuras, function(){
	   	   var nota_final = $("#nf_"+id_inscripcion_figuras).html();
	   	   $.post('./puntuaciones_figuras_guarda.php',{id_inscripcion_figuras:id_inscripcion_figuras,nota_final:nota_final});
	   	   console.log(nota_final);
	   });
}
//actualiza la nota final en la DB
function actualizar_nota_final_guarda(id_inscripcion_figuras, nota_final){
	   $("#nf_"+id_inscripcion_figuras).load("puntuaciones_figuras_actualiza_nota_final.php", "id_inscripcion_figuras="+id_inscripcion_figuras, function(){
	   	   $.post('./puntuaciones_figuras_guarda.php',{id_inscripcion_figuras:id_inscripcion_figuras,nota_final:nota_final}, function(){
		   	 $("#nf_"+id_inscripcion_figuras).load("puntuaciones_figuras_actualiza_nota_final.php", "id_inscripcion_figuras="+id_inscripcion_figuras);
	   	   });
	   	   console.log(nota_final);
	   });
}
