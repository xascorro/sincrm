<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$id_inscripcion_figuras = $_POST['id_inscripcion_figuras'];
$id_nota_menor = substr($_POST['id_nota_menor'],strpos($_POST['id_nota_menor'],'_')+1);
$id_nota_mayor = substr($_POST['id_nota_mayor'],strpos($_POST['id_nota_mayor'],'_')+1);
$id_fase = $_POST['id_fase'];
$id_panel = $_POST['panel'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
$query = "update puntuaciones_jueces SET nota_menor='no', nota_mayor='no' where id_inscripcion_figuras= '$id_inscripcion_figuras' and id_panel_juez in (select id from panel_jueces where id_panel='$id_panel' and id_fase='$id_fase')";
echo $query;
mysql_query($query);
$query = "update puntuaciones_jueces SET nota_menor='si' where id_inscripcion_figuras= '$id_inscripcion_figuras' and id_panel_juez='$id_nota_menor'";
echo $query;
mysql_query($query);
$query = "update puntuaciones_jueces SET nota_mayor='si' where id_inscripcion_figuras= '$id_inscripcion_figuras' and id_panel_juez='$id_nota_mayor'";
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
