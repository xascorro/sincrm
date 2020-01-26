<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los rutinas con sus datos
$query = "select * from rutinas where id='".$_GET['id']."'";
$rutinas = mysql_query($query); 
while ($rutina = mysql_fetch_array($rutinas)){
    	$query = "select nombre_corto from clubs where id = '".$rutina['id_club']."'"; 
	    $nombre_club=mysql_result(mysql_query($query),0);
	    $id_rutina=$rutina['id'];  
		echo "
		<th><h3>$id_rutina</h3></th>
		<th><h3>$nombre_club</h3></th>
		<th><h3>".$rutina['nombre']."</h3></th>
		<th colspan='2'><h3>".$rutina['musica']."</h3></th>
		<th><h3>".$rutina['orden']."</h3></th>
		<td><a href='javascript:' class='edita_fila' id='$id_rutina'>"."Editar"."</a></td>
		<td><a href='javascript:' class='borra_fila' id='$id_rutina'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                