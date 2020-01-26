<?php  
//abro conexion DB
include('lib/conexion_abre.php');
$id_inscripcion_figuras=$_GET['id_inscripcion_figuras'];  

$nota_final = "0.0000";
//obtengo las notas calculadas de los paneles
$query = "select * from puntuaciones_paneles where id_inscripcion_figuras='$id_inscripcion_figuras'";
$puntuaciones_paneles = mysql_query($query); 
while ($puntuacion_panel = mysql_fetch_array($puntuaciones_paneles)){
	$nota_final += $puntuacion_panel['nota_calculada'];
}

//obtengo las penalizaciones de la rutina
$query = "select * from penalizaciones_rutinas where id_inscripcion_figuras='$id_inscripcion_figuras'";
$penalizaciones_rutina = mysql_query($query); 
while ($penalizacion_rutina = mysql_fetch_array($penalizaciones_rutina)){
	//obtengo los puntos de penalizacion peso del panel
	$query = "select puntos from penalizaciones where id = '".$penalizacion_rutina['id_penalizacion']."'";
	$puntos = mysql_result(mysql_query($query),0);
	$nota_final += $puntos;
}

echo $nota_final;

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                