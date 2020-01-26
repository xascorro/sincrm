<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los inscripcion_figurass con sus datos
$query = "select * from inscripciones_figuras where id='".$_GET['id']."'";
$inscripciones_figuras = mysql_query($query); 
while ($inscripcion_figuras = mysql_fetch_array($inscripciones_figuras)){
    	$query = "select nombre, apellidos, club from nadadoras where id = '".$inscripcion_figuras['id_nadadora']."'"; 
echo $query;
	    $r = mysql_query($query);
	    $nombre_nadadora=mysql_result($r,0,0);
	    $apellidos_nadadora=mysql_result($r,0,1);
	    $id_club=mysql_result($r,0,2);
    	$query = "select nombre_corto from clubs where id = '".$id_club."'"; 
	    $nombre_club=mysql_result(mysql_query($query),0);
	    $id_inscripcion_figuras=$inscripcion_figuras['id'];  
		echo "
		<th><h3>$id_inscripcion_figuras</h3></th>
		<th>$nombre_club</th>
		<th>$apellidos_nadadora".", "."$nombre_nadadora</th>
		<th><h3>".$inscripcion_figuras['orden']."</h3></th>
		<td><a href='javascript:' class='edita_fila' id='$id_inscripcion_figuras'>"."Editar"."</a></td>
		<td><a href='javascript:' class='borra_fila' id='$id_inscripcion_figuras'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                