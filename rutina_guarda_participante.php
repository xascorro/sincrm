<?php
include("./competicion_activa_lee_nombre_id.php");
include("./lib/conexion_abre.php");
$id = $_POST['id'];
$id_rutina = $_POST['id_rutina'];
$id_nadadora = $_POST['id_nadadora'];
if($_POST['reserva']=='Titular')
$reserva ='no';
elseif($_POST['reserva']=='Reserva')
$reserva ='si';
$id_competicion = $GLOBALS['id_competicion_activa'];

//comprobamos si existe o es nuevo
$consulta="select * from rutinas_participantes where id='$id'";
echo $consulta."<br>";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update rutinas_participantes SET id_nadadora='$id_nadadora' where id= '$id'";
}else{
	$query = "insert into rutinas_participantes (id_rutina, id_nadadora, reserva, id_competicion) values ('$id_rutina', '$id_nadadora', '$reserva', '$id_competicion')";
}
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>