<?php
include('competicion_activa_lee_nombre_id.php');

include("./lib/conexion_abre.php");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$edad_desde = $_POST['edad_desde'];
$edad_hasta = $_POST['edad_hasta'];
$id_competicion = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from categorias where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update categorias SET nombre='$nombre', edad_desde='$edad_desde', edad_hasta='$edad_hasta' where id= '$id'";
}else{
	$query = "insert into categorias (nombre, edad_desde, edad_hasta, id_competicion) values ('$nombre', '$edad_desde', '$edad_hasta', '$id_competicion')";
}
mysql_query($query);
echo $query;

include(".lib/conexion_cierra.php");

?>
