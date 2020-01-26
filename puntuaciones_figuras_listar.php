<?php
include('lib/conexion_abre.php');


$fase_figuras = $_GET['id_fase_figuras'];

//miro si la fase está o no puntuada
$query = "select puntuada from fases_figuras where id='$fase_figuras'";
$puntuada = mysql_result(mysql_query($query),0);
if($puntuada == 'si'){
	echo '<div class="alert alert-block alert-danger fade in">
          <button id="puntuada" puntuada="si" id_fase_figuras="'.$fase_figuras.'"  class="close close-sm" type="button">
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
<th>Nadadora</th>';
	$query = mysql_query("select color, numero_jueces from paneles where id_competicion='".$GLOBALS['id_competicion_activa']."'");
	$color = mysql_result($query, 0);
	$numero_jueces = mysql_result($query, 0,1);
	$query = "select * from fases_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."' and id='$fase_figuras'";
    $r_fases_figuras = mysql_query($query);
    while($r_fase_figuras = mysql_fetch_array($r_fases_figuras)){
    	$grado_dificultad = mysql_result(mysql_query("select grado_dificultad from figuras where id='".$r_fase_figuras['id_figura']."'"), 0);
			$numero_figura = mysql_result(mysql_query("select numero from figuras where id='".$r_fase_figuras['id_figura']."'"), 0);
			$nombre_figura = mysql_result(mysql_query("select nombre from figuras where id='".$r_fase_figuras['id_figura']."'"), 0);
	    echo "<th style='text-align:center; background-color:".$color."' colspan='".($numero_jueces+1)."'>".$numero_figura." - ".$nombre_figura." GD:".$grado_dificultad."</th>";
    }

echo'
<th style="text-align:center;">P</th>
<th style="text-align:center; background-color:#ff6c60">Nota</th>
<th>Guardar</th>
</tr>
</thead>
<tbody id="tbody">';



//leo inscripciones_figuras y creo inputs de puntuacion segun paneles_jueces
    $query = "select * from inscripciones_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."' and id_fase_figuras='$fase_figuras' order by orden, id";     // Esta linea hace la consulta
    $inscripciones_figuras = mysql_query($query);

    while ($inscripcion_figuras = mysql_fetch_array($inscripciones_figuras)){
    	$query = "select apellidos, nombre from nadadoras where id = '".$inscripcion_figuras['id_nadadora']."'";
	    $nombre_nadadora=mysql_result(mysql_query($query),0).", ".mysql_result(mysql_query($query),0,1);
	    $id_inscripcion_figuras=$inscripcion_figuras['id'];
	    $orden=$inscripcion_figuras['orden'];
		if($inscripcion_figuras['baja']=='si'){
			$input_disabled="disabled='true'";
		}
		else
			$input_disabled='';
		echo "<thead>
		<tr class='".$id_inscripcion_figuras."' id='".$id_inscripcion_figuras."'>
		<th><h5>$orden</h5></th>
		<th><h5>$nombre_nadadora</h5></th>";


	    $query = "select * from paneles where puntua='si' and id_competicion='".$GLOBALS['id_competicion_activa']."'";
	    $paneles = mysql_query($query);
	    $color = '';
	    while($panel = mysql_fetch_array($paneles)){
	    		    $color = '';

			$query= "select * from panel_jueces where id_fase_figuras='$fase_figuras' and id_panel='".$panel['id']."'";
			$paneles_jueces = mysql_query($query);
			$panel_tipo = "";
			while($panel_juez = mysql_fetch_array($paneles_jueces)){
				$id_panel_juez = $panel_juez['id'];
				$id_panel = $panel_juez['id_panel'];
				$color = $panel['color'];
			if($inscripcion_figuras['baja']=='si'){
				$input_disabled="disabled='true'";
				$color = '#ff6c60';
			}
				//saco nota juez
				$query="select coalesce((select nota from puntuaciones_jueces where id_inscripcion_figuras ='$id_inscripcion_figuras' and id_panel_juez='$id_panel_juez'),0)";
				$nota = mysql_result(mysql_query($query),0);
				$query="select coalesce((select nota_menor from puntuaciones_jueces where id_inscripcion_figuras ='$id_inscripcion_figuras' and id_panel_juez='$id_panel_juez'),0)";
				$nota_menor = mysql_result(mysql_query($query),0);
				$query="select coalesce((select nota_mayor from puntuaciones_jueces where id_inscripcion_figuras ='$id_inscripcion_figuras' and id_panel_juez='$id_panel_juez'),0)";
				$nota_mayor = mysql_result(mysql_query($query),0);
				$textdecoration = '';
				if($nota_menor == "si"){
					$textdecoration = 'underline';
					$color = '#ff6c60';
				} else if ($nota_mayor == "si"){
					$textdecoration='overline';
					$color = 'lightgreen';

				}



				echo "<th class='nota' id_panel_jueces=".$panel_juez['id']." style='padding:0px; border-right:none; border-left:none; text-align:center; background-color:".$color."'><input id='".$id_inscripcion_figuras."_".$id_panel_juez."' panel_juez='$id_panel_juez' id_inscripcion_figuras='$id_inscripcion_figuras' style='pading:0px; border:none; font-size:large; height:100%; text-align:center; text-decoration:".$textdecoration."; background-color:".$color."' size=3 type='text' value='$nota' $input_disabled/></th>";
					    $color = '';

			}
				//saco nota panel media y calculada
				$query="select coalesce((select nota_media from puntuaciones_paneles where id_inscripcion_figuras ='$id_inscripcion_figuras' and id_panel='$id_panel'),0)";
				$nota_media = mysql_result(mysql_query($query),0);
				$query="select coalesce((select nota_calculada from puntuaciones_paneles where id_inscripcion_figuras ='$id_inscripcion_figuras' and id_panel='$id_panel'),0)";
				$nota_calculada = mysql_result(mysql_query($query),0);
				echo "<th class='nota_media' numero_jueces='".$panel['numero_jueces']."' panel='".$id_panel."' gd='".$grado_dificultad."' id='nota_media".$id_inscripcion_figuras."_".$id_panel."' style='padding:0px; text-align:center; background-color:".$color."; vertical-align:middle; font-size:medium;'>".$nota_media."<br>".$nota_calculada."</th>";

	    }

		//penalizaciones
		echo '<th class="penalizacion" id="pr_'.$id_inscripcion_figuras.'">';
		$query = "select * from penalizaciones_rutinas where id_inscripcion_figuras='$id_inscripcion_figuras'";
	    $penalizaciones = mysql_query($query);
	    while($penalizacion = mysql_fetch_array($penalizaciones)){
			$query = "select puntos from penalizaciones where id = '".$penalizacion['id_penalizacion']."'";
			$puntos = mysql_result(mysql_query($query),0);
			echo $puntos.'<br>';
	    }
	    echo '</th>';
		//notas finales
		//saco nota final de la rutina
		$query="select coalesce((select nota_final from inscripciones_figuras where id ='$id_inscripcion_figuras'),0)";
		$nota_final = mysql_result(mysql_query($query),0);

		echo "<th class='nota_final' id='nf_".$id_inscripcion_figuras."' style='padding:0px; text-align:center; background-color:#ff6c60; vertical-align:middle; font-size:medium;'>".$nota_final."</th>
		<td style='padding:0px; text-align:center; background-color:; vertical-align:middle; font-size:x-large;'><a href='javascript:' class='guarda_puntuacion' fase='$fase_figuras' id='$id_inscripcion_figuras'><i class='fa fa-save'></i></a></td>
		</tr>
		</thead> ";


  	   }

echo '</tbody></table>';

include('lib/conexion_cierra.php');
?>
