<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$id_rutina = $_POST['id_rutina'];
$id_panel_jueces = $_POST['id_panel_jueces'];
$nota = $_POST['nota'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from puntuaciones_jueces where id_rutina='$id_rutina' and id_panel_juez='$id_panel_jueces'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update puntuaciones_jueces SET nota='$nota' where id_rutina= '$id_rutina' and id_panel_juez='$id_panel_jueces'";
}else{
	$query = "insert into puntuaciones_jueces (id_rutina, id_panel_juez, nota) values ('$id_rutina', '$id_panel_jueces', '$nota')";
}
//echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
