<?php
include("./lib/conexion_abre.php");

$id_rutina = $_POST['id_rutina'];
$query = "update rutinas set baja='no' where id = '$id_rutina'";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
