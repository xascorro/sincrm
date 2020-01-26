<?php
include("./lib/conexion_abre.php");

$id_fase_figuras = $_POST['id_fase_figuras'];
$query = "update fases_figuras set puntuada='no' where id='$id_fase_figuras'";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
