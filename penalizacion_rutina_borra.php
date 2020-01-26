<?php
include("./lib/conexion_abre.php");

$id_penalizacion = $_POST['id_penalizacion'];
$query = "delete from penalizaciones_rutinas where id='$id_penalizacion'";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
