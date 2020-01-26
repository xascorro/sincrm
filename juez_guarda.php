<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$federacion = $_POST['federacion'];
$licencia = $_POST['licencia'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];

//comprobamos si existe o es nuevo
$consulta="select * from jueces where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update jueces SET nombre='$nombre', apellidos='$apellidos', federacion='$federacion', licencia='$licencia' where id= '$id'";
}else{
	$query = "insert into jueces (nombre, apellidos, federacion, licencia, id_competicion) values ('$nombre', '$apellidos', '$federacion', '$licencia', '$id_competicion_activa')";
}
mysql_query($query);
include("./lib/conexion_cierra.php");

?>