<?php
include("lib/conexion_abre.php");
include('lib/my_functions.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$club = $_POST['club'];
$licencia = $_POST['licencia'];
$fecha_nacimiento = fechaADate($_POST['fecha_nacimiento']);
//comprobamos si existe o es nuevo
$consulta="select * from nadadoras where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update nadadoras SET nombre='$nombre', apellidos='$apellidos', club='$club', licencia='$licencia', fecha_nacimiento='$fecha_nacimiento' where id= '$id'";
}else{
	$query = "insert into nadadoras (nombre, apellidos, club, licencia, fecha_nacimiento) values ('$nombre', '$apellidos', '$club', '$licencia', '$fecha_nacimiento')";
}
mysql_query($query);
include("lib/conexion_cierra.php");

?>