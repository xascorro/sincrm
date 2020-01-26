<?php
include("./lib/conexion_abre.php");
$id = $_GET['id'];
$query = "delete from rutinas_participantes where id = '$id'";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>