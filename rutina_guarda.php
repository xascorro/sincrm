<?php
include("./competicion_activa_lee_nombre_id.php");
include("./lib/conexion_abre.php");
$id = $_POST['id'];
$id_fase = $_POST['id_fase'];
$id_club = $_POST['id_club'];
$nombre = $_POST['nombre'];
$musica = $_POST['musica'];
$orden = $_POST['orden'];
$id_competicion = $GLOBALS['id_competicion_activa'];

//comprobamos si existe o es nuevo
$consulta="select * from rutinas where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update rutinas SET nombre='$nombre', musica='$musica', orden='$orden' where id= '$id'";
}else{
	$query = "insert into rutinas (id_fase, id_club, nombre, musica, orden, id_competicion) values ('$id_fase', '$id_club', '$nombre', '$musica', '$orden', '$id_competicion')";
}
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>