<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$id_inscripcion_figuras = $_POST['id_inscripcion_figuras'];
$id_panel_jueces = $_POST['id_panel_jueces'];
$nota = $_POST['nota'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from puntuaciones_jueces where id_inscripcion_figuras='$id_inscripcion_figuras' and id_panel_juez='$id_panel_jueces'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update puntuaciones_jueces SET nota='$nota' where id_inscripcion_figuras= '$id_inscripcion_figuras' and id_panel_juez='$id_panel_jueces'";
}else{
	$query = "insert into puntuaciones_jueces (id_inscripcion_figuras, id_panel_juez, nota) values ('$id_inscripcion_figuras', '$id_panel_jueces', '$nota')";
}
//echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
