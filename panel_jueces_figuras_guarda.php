<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$juez = $_POST['juez'];
$fase = $_POST['fase'];
$panel = $_POST['panel'];
$numero_juez = $_POST['fila'];
$panel_jueces = $_POST['panel_jueces'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from panel_jueces where id='$panel_jueces'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update panel_jueces SET id_juez='$juez' where id= '$panel_jueces'";
}else{
	$query = "insert into panel_jueces (id_juez, id_panel, id_fase_figuras, numero_juez, id_competicion) values ('$juez', '$panel', '$fase', '$numero_juez', '$id_competicion_activa')";
}
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
