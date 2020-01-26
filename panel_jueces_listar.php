<?php  
include('lib/conexion_abre.php');  


	//obtenemos el numero maximo de nadadoras y reservas de la modalidad
   // $query = "select numero_participantes, numero_reservas from modalidades where id='".$_GET['id_modalidad']."'"; 
   // $max_nadadoras = mysql_fetch_array(mysql_query($query));

    $query = "select * from fases where id_competicion='".$GLOBALS['id_competicion_activa']."' order by orden, id";  
    $fases = mysql_query($query);
        $clona = true;
    while ($fase = mysql_fetch_array($fases)){
		$id_modalidad=$fase['id_modalidad'];
		$id_categoria=$fase['id_categoria'];
		$query="select nombre from modalidades where id = '".$id_modalidad."'";
		$modalidad=mysql_result(mysql_query($query),0);
		$query="select nombre from categorias where id = '".$id_categoria."'";
		$categoria=mysql_result(mysql_query($query),0);
		
		echo "<div class='border-head'>
                <h1>$modalidad $categoria</h1>";              
        $query = "select * from paneles where id_competicion='".$GLOBALS['id_competicion_activa']."' and puntua = 'si'";
        $paneles = mysql_query($query);
        while ($panel = mysql_fetch_array($paneles)){
			//abro tabla con jueces modalidad, creo thead y abro tbody
			echo '<div class="col-lg-4">

			<table class="table table-striped table-hover table-bordered" id="editable-sample">
			<thead>
			<tr>
			<th colspan="3"><h2>'.$panel['nombre'];
			if ($clona) {
				echo ' <a target="_blank" href="panel_jueces_clonar.php?id_panel='.$panel['id'].'">Clonar panel</a>';
				$clona = false;
				}
			echo '</h2></th></tr>
			</thead>
			<tbody id="tbody">';
			//saco jueces con nombre modalidad
			$numero_jueces_panel = $panel['numero_jueces'];
			$conteo_juez = 1;
			while ($conteo_juez <= $numero_jueces_panel){

				$query="select id, id_juez from panel_jueces where id_fase = '".$fase['id']."' and id_panel = '".$panel['id']."' and numero_juez = '".$conteo_juez."'";
				$id_panel_jueces=@mysql_result(mysql_query($query),0,0);
				$id_juez=@mysql_result(mysql_query($query),0,1);
				
				$query="select nombre, apellidos from jueces where id ='$id_juez'";
				$nombre_juez=@mysql_result(mysql_query($query),0,0)." ".@mysql_result(mysql_query($query),0,1);

				echo '<tr id="fila_'.$conteo_juez.'_panel_'.$panel['id'].'_fase'.$fase['id'].'"><td>'.$conteo_juez.'</td>';
				echo '<td>'.$nombre_juez.'</td>';
				echo '<td><a class="edita_fila" id_panel_jueces="'.$id_panel_jueces.'" fase="'.$fase['id'].'" panel="'.$panel['id'].'" fila="'.$conteo_juez.'" id_juez="'.$id_juez.'" href="javascript:">Editar</a></td></tr>';
				
				//paso al juez siguiente
				$conteo_juez++;		
			}	
			//cierro tabla con jueces modalidad
			echo '</tbody></table></div>';
			}
        
        echo "</div>";
           
/*		echo "<thead>
		<tr class='".$id_rutina."' id='fila".$id_rutina."'>
		<th><h3>$id_rutina</h3></th>
		<th><h3>$nombre_club</h3></th>
		<th><h3>".$rutina['nombre']."</h3></th>
		<th colspan='2'><h5>".$rutina['musica']."</h5></th>
		<th><h3>".$rutina['orden']."</h3></th>
		<td><a href='javascript:' class='edita_fila' id='$id_rutina'>"."Editar"."</a></td>
		<td><a href='javascript:' class='borra_fila' id='$id_rutina'>"."Borrar"."</a></td>
		</tr>
		</thead> ";   
    
	   
//titulares
	    $query = "select * from rutinas_participantes where id_rutina='".$rutina['id']."' and reserva='no'";
	    $participantes = mysql_query($query);  
	    while ($participante = mysql_fetch_array($participantes)){
	    	$query = "select * from nadadoras where id='".$participante['id_nadadora']."'";
	    	$id_rutina_participante = $participante["id"];
	    	$nadadoras = mysql_query($query);		    
	    	while ($nadadora = mysql_fetch_array($nadadoras)){
		    	echo "<tr id='participante_t_".$id_rutina_participante."_$id_rutina' class='".$id_rutina."'><td>$id_rutina_participante</td><td>".$nadadora['id']."</td><td>".$nadadora['apellidos'].", ".$nadadora['nombre']."</td><td>".$nadadora['licencia']."</td><td>".$nadadora['fecha_nacimiento']."</td><td>Titular</td><td><a id_club='".$rutina['id_club']."' t_r='t' id='$id_rutina_participante' id_participante='$id_rutina_participante' id_rutina='".$rutina['id']."' class='edit edita_participante' href='javascript:;'>Editar</a></td><td><a class='delete borra_participante' t_r='t' id='".$id_rutina_participante."' id_rutina='".$rutina['id']."' href='javascript:;'>"."Borrar"."</a></td></tr>";
		    } 
		}
  	    	//añadimos las filas de plazas vacias
  	    	$num_nadadoras = mysql_num_rows($participantes);
  	    	if($num_nadadoras < $max_nadadoras['numero_participantes']){
  	    	while ($num_nadadoras < $max_nadadoras['numero_participantes']){
	  	    	echo "<tr id='participante_t_$num_nadadoras"."_$id_rutina' class='".$id_rutina."'><td>$id_rutina</td><td></td><td>$nombre_club</td><td></td><td></td><td>Titular</td><td><a id_club='".$rutina['id_club']."' t_r='t' id='$num_nadadoras' id_participante='nueva_participante' id_rutina='".$rutina['id']."' class='edit edita_participante' href='javascript:;'>Editar</a></td><td></td></tr>";
	  	    	$num_nadadoras++;
  	    	}
  	    	}    
	      

//reservas
	    $query = "select * from rutinas_participantes where id_rutina='".$rutina['id']."' and reserva='si'";
	    $participantes = mysql_query($query);  
	    while ($participante = mysql_fetch_array($participantes)){
	    	$query = "select * from nadadoras where id='".$participante['id_nadadora']."'";
	    	$id_rutina_participante = $participante["id"];
	    	$nadadoras = mysql_query($query);		    
	    	while ($nadadora = mysql_fetch_array($nadadoras)){
		    	echo "<tr id='participante_r_".$id_rutina_participante."_$id_rutina' class='".$id_rutina."'><td>$id_rutina_participante</td><td>".$nadadora['id']."</td><td>".$nadadora['apellidos'].", ".$nadadora['nombre']."</td><td>".$nadadora['licencia']."</td><td>".$nadadora['fecha_nacimiento']."</td><td>Reserva</td><td><a id_club='".$rutina['id_club']."' t_r='r' id='$id_rutina_participante' id_participante='$id_rutina_participante' id_rutina='".$rutina['id']."' class='edit edita_participante' href='javascript:;'>Editar</a></td><td><a class='delete borra_participante' t_r='r' id='".$id_rutina_participante." id_rutina='".$rutina['id']."' href='javascript:;'>"."Borrar"."</a></td></tr>";
		    }
	    }
	      	//añadimos las filas de plazas vacias
  	    	$num_nadadoras = mysql_num_rows($participantes);
  	    	if($num_nadadoras < $max_nadadoras['numero_reservas']){
  	    	while ($num_nadadoras < $max_nadadoras['numero_reservas']){
	  	    	echo "<tr id='participante_r_$num_nadadoras"."_$id_rutina' class='".$id_rutina."'><td>$id_rutina</td><td></td><td>$nombre_club</td><td></td><td></td><td>Reserva</td><td><a id_club='".$rutina['id_club']."' t_r='r' id='$num_nadadoras' id_participante='nueva_participante' id_rutina='".$rutina['id']."' class='edit edita_participante' href='javascript:;'>Editar</a></td><td></td></tr>";
	  	    	$num_nadadoras++;
  	    	}
  	    	}    */
  	   }  
  	   
include('lib/conexion_cierra.php');  
?>
                