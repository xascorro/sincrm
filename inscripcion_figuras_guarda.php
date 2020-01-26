<?php
include("./competicion_activa_lee_nombre_id.php");
include("./lib/conexion_abre.php");
$id = $_POST['id'];
$id_fase_figuras = $_POST['id_fase_figuras'];
$id_nadadora = $_POST['id_nadadora'];
$orden = $_POST['orden'];
$id_competicion = $GLOBALS['id_competicion_activa'];

//comprobamos si existe o es nuevo
$consulta="select * from inscripciones_figuras where id='$id'";
$resultado=mysql_query($consulta) or die (mysql_error());
if (mysql_num_rows($resultado)>0){	
	$id_nadadora_ant = mysql_result(mysql_query("select id_nadadora from inscripciones_figuras where id='$id'"),0);
	$query = "update inscripciones_figuras SET id_nadadora='$id_nadadora', orden='$orden' where id_nadadora='$id_nadadora_ant' and id_competicion='$id_competicion'";
	echo $query;
	mysql_query($query);
}else{
	$query = "select id from fases_figuras where id_categoria in (select id_categoria from fases_figuras where id = '$id_fase_figuras' and id_competicion = '$id_competicion')";
	$fases_figuras = mysql_query($query);
	while($fase = mysql_fetch_array($fases_figuras)){
		$query = "insert into inscripciones_figuras (id_fase_figuras, id_nadadora, orden, id_competicion) values ('".$fase['id']."', '$id_nadadora', '$orden', '$id_competicion')";
		mysql_query($query);
	}
}
include("./lib/conexion_cierra.php");

?>