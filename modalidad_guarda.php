<?php
include('competicion_activa_lee_nombre_id.php');

include("./lib/conexion_abre.php");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$numero_participantes = $_POST['numero_participantes'];
$numero_reservas = $_POST['numero_reservas'];
$id_competicion = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from modalidades where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update modalidades SET nombre='$nombre', numero_participantes='$numero_participantes', numero_reservas='$numero_reservas' where id= '$id'";
}else{
	$query = "insert into modalidades (nombre, numero_participantes, numero_reservas, id_competicion) values ('$nombre', '$numero_participantes', '$numero_reservas', '$id_competicion')";
}
mysql_query($query);
echo $query;

include("./lib/conexion_cierra.php");

?>
