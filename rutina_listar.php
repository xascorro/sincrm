<?php  
include('lib/conexion_abre.php');  

//abro table, creo thead y abro tbody
echo '
<table class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>id</th>
<th>id_club</th>
<th colspan="3">nombre</th>
<th>orden</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';


	//obtenemos el numero maximo de nadadoras y reservas de la modalidad
    $query = "select numero_participantes, numero_reservas from modalidades where id='".$_GET['id_modalidad']."'"; 
    $max_nadadoras = mysql_fetch_array(mysql_query($query));

    $query = "select * from rutinas where id_competicion='".$GLOBALS['id_competicion_activa']."' and id_fase='".$_GET['id_fase']."' order by orden, id";     // Esta linea hace la consulta 
    $rutinas = mysql_query($query);  

    while ($rutina = mysql_fetch_array($rutinas)){
    	$query = "select nombre_corto from clubs where id = '".$rutina['id_club']."'"; 
	    $nombre_club=mysql_result(mysql_query($query),0);
	    $id_rutina=$rutina['id'];  
		echo "<thead>
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
  	    	}    
  	   }  
  	   
echo '</tbody></table>';
include('lib/conexion_cierra.php');  
?>
                