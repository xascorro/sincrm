<?php  
include('lib/conexion_abre.php');  


$fase = $_GET['id_fase'];

//miro si la fase está o no puntuada
$query = "select puntuada from fases where id='$fase'";
$puntuada = mysql_result(mysql_query($query),0);
if($puntuada == 'si'){
	echo '<div class="alert alert-block alert-danger fade in">
          <button id="puntuada" puntuada="si" id_fase="'.$fase.'"  class="close close-sm" type="button">
          ... Desbloquear <i class="fa fa-unlock-alt fa-2x"></i>
          </button>
          <strong>Ops!</strong> Esta fase está puntuada y se encuentra bloqueada.
          </div>';
}else{
	
}

//abro table, creo thead y abro tbody
echo '
<table class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>#</th>
<th>Club</th>';

    $query = "select * from paneles where puntua='si' and id_competicion='".$GLOBALS['id_competicion_activa']."'";
    $paneles = mysql_query($query);
    while($panel = mysql_fetch_array($paneles)){
	    echo "<th style='text-align:center; background-color:".$panel['color']."' colspan='".($panel['numero_jueces']+1)."'>".$panel['nombre']."  ( ".$panel['peso']."% )</th>";
    }

echo'
<th style="text-align:center;">P</th>
<th style="text-align:center; background-color:#ff6c60">Nota</th>
<th>Guardar</th>
</tr>
</thead>
<tbody id="tbody">';



//leo rutinas y creo inputs de puntuacion segun paneles_jueces
    $query = "select * from rutinas where id_competicion='".$GLOBALS['id_competicion_activa']."' and id_fase='$fase' order by orden, id";     // Esta linea hace la consulta 
    $rutinas = mysql_query($query);  

    while ($rutina = mysql_fetch_array($rutinas)){
    	$query = "select nombre_corto from clubs where id = '".$rutina['id_club']."'"; 
	    $nombre_club=mysql_result(mysql_query($query),0);
	    $id_rutina=$rutina['id'];  
	    $orden=$rutina['orden'];  
		if($rutina['baja']=='si')
			$input_disabled="disabled='true'";
		else
			$input_disabled='';
		echo "<thead>
		<tr class='".$id_rutina."' id='".$id_rutina."'>
		<th><h5>$orden</h5></th>
		<th><h5>$nombre_club</h5></th>";


	    $query = "select * from paneles where puntua='si' and id_competicion='".$GLOBALS['id_competicion_activa']."'";
	    $paneles = mysql_query($query);
	    while($panel = mysql_fetch_array($paneles)){
			$query= "select * from panel_jueces where id_fase='$fase' and id_panel='".$panel['id']."'";
			$paneles_jueces = mysql_query($query);
			$panel_tipo = "";
			while($panel_juez = mysql_fetch_array($paneles_jueces)){
				$id_panel_juez = $panel_juez['id'];
				$id_panel = $panel_juez['id_panel'];
				$color = $panel['color'];
				//saco nota juez
				$query="select coalesce((select nota from puntuaciones_jueces where id_rutina ='$id_rutina' and id_panel_juez='$id_panel_juez'),0)";
				$nota = mysql_result(mysql_query($query),0);
				$query="select coalesce((select nota_menor from puntuaciones_jueces where id_rutina ='$id_rutina' and id_panel_juez='$id_panel_juez'),0)";
				$nota_menor = mysql_result(mysql_query($query),0);
				$query="select coalesce((select nota_mayor from puntuaciones_jueces where id_rutina ='$id_rutina' and id_panel_juez='$id_panel_juez'),0)";
				$nota_mayor = mysql_result(mysql_query($query),0);
				$textdecoration = '';
				if($nota_menor == "si")	
					$textdecoration = 'underline';
				else if ($nota_mayor == "si")	
					$textdecoration='overline';			
		
				echo "<th class='nota' id_panel_jueces=".$panel_juez['id']." style='padding:0px; border-right:none; border-left:none; text-align:center; background-color:".$color."'><input id='".$id_rutina."_".$id_panel_juez."' panel_juez='$id_panel_juez' id_rutina='$id_rutina' style='pading:0px; border:none; font-size:large; height:100%; text-align:center; text-decoration:".$textdecoration."; background-color:".$color."' size=3 type='text' value='$nota' $input_disabled/></th>";
			}
				//saco nota panel media y calculada
				$query="select coalesce((select nota_media from puntuaciones_paneles where id_rutina ='$id_rutina' and id_panel='$id_panel'),0)";
				$nota_media = mysql_result(mysql_query($query),0);	
				$query="select coalesce((select nota_calculada from puntuaciones_paneles where id_rutina ='$id_rutina' and id_panel='$id_panel'),0)";
				$nota_calculada = mysql_result(mysql_query($query),0);
				echo "<th class='nota_media' numero_jueces='".$panel['numero_jueces']."' panel='".$id_panel."' peso='".$panel['peso']."' id='nota_media".$id_rutina."_".$id_panel."' style='padding:0px; text-align:center; background-color:".$color."; vertical-align:middle; font-size:medium;'>".$nota_media."<br>".$nota_calculada."</th>";
	    
	    }

		//penalizaciones
		echo '<th class="penalizacion" id="pr_'.$id_rutina.'">';
		$query = "select * from penalizaciones_rutinas where id_rutina='$id_rutina'";
	    $penalizaciones = mysql_query($query);
	    while($penalizacion = mysql_fetch_array($penalizaciones)){
			$query = "select puntos from penalizaciones where id = '".$penalizacion['id_penalizacion']."'";
			$puntos = mysql_result(mysql_query($query),0);	
			echo $puntos.'<br>';  
	    }
	    echo '</th>';
		//notas finales	
		//saco nota final de la rutina
		$query="select coalesce((select nota_final from rutinas where id ='$id_rutina'),0)";
		$nota_final = mysql_result(mysql_query($query),0);			
		
		echo "<th class='nota_final' id='nf_".$id_rutina."' style='padding:0px; text-align:center; background-color:#ff6c60; vertical-align:middle; font-size:medium;'>".$nota_final."</th>
		<td style='padding:0px; text-align:center; background-color:; vertical-align:middle; font-size:x-large;'><a href='javascript:' class='guarda_puntuacion' fase='$fase' id='$id_rutina'><i style='padding:0px' class='fa fa-save'></i></a></td>
		</tr>
		</thead> ";   
    
  
  	   }  
  	   
echo '</tbody></table>';

if($puntuada == 'no'){
	echo '<button id="puntuar_fase" id_fase="'.$fase.'" type="button" class="btn btn-success btn-lg btn-block">Cerrar y calificar fase</button>';
}
include('lib/conexion_cierra.php');  
?>
                