<?php
include("lib/conexion_abre.php");
$id = $_POST['id'];
$query = "delete from competiciones where ID = $id";
mysql_query($query);
include("lib/conexion_cierra.php");
?>
