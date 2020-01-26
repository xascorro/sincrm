<?php
include("./lib/conexion_abre.php");

$id_rutina = $_POST['id_rutina'];
$id_penalizacion = $_POST['id_penalizacion'];
$query = "insert into penalizaciones_rutinas (id_rutina, id_penalizacion) values ('$id_rutina', '$id_penalizacion')";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
