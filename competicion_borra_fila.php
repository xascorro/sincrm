<?php
include("lib/conexion_abre.php");
$id = $_GET['id'];
$query = "delete from competiciones where ID = $id";
mysql_query($query);
include("lib/conexion_cierra.php");

?>