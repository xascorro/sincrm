<?php
include('competicion_activa_lee_nombre_id.php');

include("./lib/conexion_abre.php");
$id = $_POST['id'];
$id_modalidad = $_POST['id_modalidad'];
$id_categoria = $_POST['id_categoria'];
$orden = $_POST['orden'];
$id_competicion = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from fases where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update fases SET id_modalidad='$id_modalidad', id_categoria='$id_categoria', orden='$orden' where id= '$id'";
}else{
	$query = "insert into fases (id_modalidad, id_categoria, id_competicion, orden) values ('$id_modalidad', '$id_categoria', '$id_competicion', '$orden')";
}
mysql_query($query);
echo $query;
include("./lib/conexion_cierra.php");

?>
