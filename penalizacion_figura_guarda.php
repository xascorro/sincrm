<?php
include("./lib/conexion_abre.php");

$id_inscripcion_figuras = $_POST['id_inscripcion_figuras'];
$id_penalizacion = $_POST['id_penalizacion'];
$query = "insert into penalizaciones_rutinas (id_inscripcion_figuras, id_penalizacion) values ('$id_inscripcion_figuras', '$id_penalizacion')";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
