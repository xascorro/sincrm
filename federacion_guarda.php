<?php
include("./lib/conexion_abre.php");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$nombre_corto = $_POST['nombre_corto'];
$codigo = $_POST['codigo'];
$comunidad = $_POST['comunidad'];
$logo = $_POST['logo'];
//comprobamos si existe o es nuevo
$consulta="select * from federaciones where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update federaciones SET nombre='$nombre', nombre_corto='$nombre_corto', codigo='$codigo', comunidad='$comunidad', logo='$logo' where id= '$id'";
}else{
	$query = "insert into federaciones (nombre, nombre_corto, codigo, comunidad, logo) values ('$nombre', '$nombre_corto', '$codigo', '$comunidad', '$logo')";
}
mysql_query($query);
include("./lib/conexion_cierra.php");

?>