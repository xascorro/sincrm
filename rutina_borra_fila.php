<?php
include("./lib/conexion_abre.php");
$id = $_GET['id'];
$query = "delete from rutinas where ID = $id";
mysql_query($query);
$query = "delete from rutinas_participantes where id_rutina = $id";
mysql_query($query);
include("./lib/conexion_cierra.php");

?>