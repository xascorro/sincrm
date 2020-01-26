<?php
include("lib/conexion_abre.php");
include("lib/my_functions.php");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$lugar = $_POST['lugar'];
$fecha = fechaADate($_POST['fecha']);
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
echo '<h1>'.$fecha.'</h1>';
$organizador_tipo = $_POST['organizador_tipo'];
$organizador = $_POST['organizador'];
$activo = $_POST['activo'];
if($activo == 'si'){
	mysql_query("update competiciones set activo='no'");
}
//comprobamos si existe o es nuevo
$consulta="select * from competiciones where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update competiciones SET nombre='$nombre', lugar='$lugar', fecha='$fecha', organizador_tipo='$organizador_tipo', organizador='$organizador', activo='$activo' where id= '$id'";
}else{
	$query = "insert into competiciones (nombre, lugar, fecha, organizador_tipo, organizador, activo) values ('$nombre', '$lugar', '$fecha', '$organizador_tipo', '$organizador', '$activo')";
}
mysql_query($query);
include("lib/conexion_cierra.php");

?>