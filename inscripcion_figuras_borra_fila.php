<?php
include("competicion_activa_lee_nombre_id.php");
include("./lib/conexion_abre.php");
$id = $_GET['id'];
$query="select id_nadadora from inscripciones_figuras where id='$id'";
$id_nadadora = mysql_result(mysql_query($query),0);
$query = "delete from inscripciones_figuras where id_nadadora = '$id_nadadora' and id_fase_figuras in (select id from fases_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."')";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>