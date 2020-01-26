<?php
include('competicion_activa_lee_nombre_id.php');

include("./lib/conexion_abre.php");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$numero = $_POST['numero'];
$grado_dificultad = $_POST['grado_dificultad'];
//$id_competicion = $GLOBALS['id_competicion_activa'];
$id_competicion = 0;
//comprobamos si existe o es nuevo
$consulta="select * from figuras where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update figuras SET nombre='$nombre', numero='$numero', grado_dificultad='$grado_dificultad' where id= '$id'";
}else{
	$query = "insert into figuras (nombre, numero, grado_dificultad, id_competicion) values ('$nombre', '$numero', '$grado_dificultad', '$id_competicion')";
}
mysql_query($query);
echo $query;

include("./lib/conexion_cierra.php");

?>
