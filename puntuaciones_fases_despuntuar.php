<?php
include("./lib/conexion_abre.php");

$id_fase = $_POST['id_fase'];
$query = "update fases set puntuada='no' where id='$id_fase'";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
