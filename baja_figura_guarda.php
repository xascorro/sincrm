<?php
include("./lib/conexion_abre.php");

$id_inscripcion_figuras = $_POST['id_inscripcion_figuras'];
$query = "update inscripciones_figuras set baja='si' where id='$id_inscripcion_figuras'";
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
