<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$id_inscripcion_figuras = $_POST['id_inscripcion_figuras'];
$nota_final = $_POST['nota_final'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from inscripciones_figuras where id='$id_inscripcion_figuras'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update inscripciones_figuras SET nota_final='$nota_final' where id= '$id_inscripcion_figuras'";
}else{
	//$query = "insert into puntuaciones_inscripciones_figuras (id_inscripcion_figuras, nota_final) values ('$id_inscripcion_figuras', '$nota_final')";
}
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
