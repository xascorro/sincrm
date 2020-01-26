<?php  
include('lib/conexion_abre.php');  

//abro table, creo thead y abro tbody
echo '
<table class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>id</th>
<th>Club</th>
<th>Nadadora</th>
<th>orden</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

    $query = "select * from inscripciones_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."' and id_fase_figuras='".$_GET['id_fase_figuras']."' order by orden, id asc";
    $inscripciones_figuras = mysql_query($query);  

    while ($inscripcion_figura = mysql_fetch_array($inscripciones_figuras)){
    	$query = "select nombre, apellidos from nadadoras where id = '".$inscripcion_figura['id_nadadora']."'"; 
	    $nombre_nadadora=mysql_result(mysql_query($query),0,0);
	    $apellidos_nadadora=mysql_result(mysql_query($query),0,1);
    	$query = "select club from nadadoras where id = '".$inscripcion_figura['id_nadadora']."'"; 
	    $id_club_nadadora=mysql_result(mysql_query($query),0,0);
    	$query = "select nombre_corto from clubs where id = '$id_club_nadadora'"; 
	    $nombre_club=mysql_result(mysql_query($query),0,0);
	    $id_inscripcion_figura=$inscripcion_figura['id'];  
		echo "<thead>
		<tr class='".$id_inscripcion_figura."' id='fila".$id_inscripcion_figura."'>
		<th><h3>$id_inscripcion_figura</h3></th>
		<th>$nombre_club</th>
		<th>$apellidos_nadadora".", $nombre_nadadora</th>
		<th><h3>".$inscripcion_figura['orden']."</h3></th>
		<td><a href='javascript:' class='edita_fila' id='$id_inscripcion_figura'>"."Editar"."</a></td>
		<td><a href='javascript:' class='borra_fila' id='$id_inscripcion_figura'>"."Borrar"."</a></td>
		</tr>
		</thead> ";   
    
}  
  	   
echo '</tbody></table>';
include('lib/conexion_cierra.php');  
?>
                