<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$numero_jueces = $_POST['numero_jueces'];
$peso = $_POST['peso'];
$descripcion = $_POST['descripcion'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from paneles where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update paneles SET nombre='$nombre', numero_jueces='$numero_jueces', peso='$peso', descripcion='$descripcion' where id= '$id'";
}else{
	$query = "insert into paneles (nombre, numero_jueces, peso, descripcion, id_competicion) values ('$nombre', '$numero_jueces', '$peso', '$descripcion', '$id_competicion_activa')";
}
echo $query;
mysql_query($query);

include("./lib/conexion_cierra.php");

?>
