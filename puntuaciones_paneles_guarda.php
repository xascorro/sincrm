<?php
include('./competicion_activa_lee_nombre_id.php');
include("./lib/conexion_abre.php");

$id_rutina = $_POST['id_rutina'];
$id_panel = $_POST['id_panel'];
$nota_media = $_POST['nota_media'];
$nota_calculada = $_POST['nota_calculada'];
$id_competicion_activa = $GLOBALS['id_competicion_activa'];
//comprobamos si existe o es nuevo
$consulta="select * from puntuaciones_paneles where id_rutina='$id_rutina' and id_panel='$id_panel'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$query = "update puntuaciones_paneles SET nota_media='$nota_media', nota_calculada='$nota_calculada' where id_rutina= '$id_rutina' and id_panel='$id_panel'";
}else{
	$query = "insert into puntuaciones_paneles (id_rutina, id_panel, nota_media, nota_calculada) values ('$id_rutina', '$id_panel', '$nota_media', '$nota_calculada')";
}
echo $query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
