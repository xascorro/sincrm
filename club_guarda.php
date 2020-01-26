<?php
include("lib/conexion_abre.php");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$nombre_corto = $_POST['nombre_corto'];
$codigo = $_POST['codigo'];
$federacion = $_POST['federacion'];
$logo = $_POST['logo'];
//comprobamos si existe o es nuevo
$consulta="select * from clubs where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update clubs SET nombre='$nombre', nombre_corto='$nombre_corto', codigo='$codigo', federacion='$federacion', logo='$logo' where id= '$id'";
}else{
	$query = "insert into clubs (nombre, nombre_corto, codigo, federacion, logo) values ('$nombre', '$nombre_corto', '$codigo', '$federacion', '$logo')";
}
mysql_query($query);
echo 'voy'.$query;
include("lib/conexion_cierra.php");

?>