<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$id_rutina = $_POST['id_rutina'];
$nota_final = $_POST['nota_final'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from rutinas where id='$id_rutina'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update rutinas SET nota_final='$nota_final' where id= '$id_rutina'";
}else{
	//$query = "insert into puntuaciones_rutinas (id_rutina, nota_final) values ('$id_rutina', '$nota_final')";
}
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
