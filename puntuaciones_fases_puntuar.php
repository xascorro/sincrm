<?php
include("./lib/conexion_abre.php");

$id_fase = $_POST['id_fase'];
mysql_query("truncate table calculos_clasificacion");
//variables
$modalidad_fase = mysql_result(mysql_query("select id_modalidad from fases where id='$id_fase'"),0);
$result = mysql_query("select prioridad_panel_1, prioridad_panel_2 from modalidades where id = '$modalidad_fase'");
$prioridad_panel_1 = mysql_result($result,0);
$prioridad_panel_2 = mysql_result($result,0,1);
echo $prioridad_panel_1.$prioridad_panel_2."<br>";
$posicion = 1;
$nota_calculada_impresion = 0;
//obtengo las rutinas de la fase
$query = "select * from rutinas where id_fase='$id_fase' order by nota_final desc";
$rutinas = mysql_query($query);
while($rutina = mysql_fetch_array($rutinas)){
	$nota_final = $rutina['nota_final'];
	$id_rutina = $rutina['id'];
	echo " ".$id_rutina." ";
	$baja = $rutina['baja'];
	$preswimmer = $rutina['preswimmer'];
	$orden = $rutina['orden'];
	$nota_calculada_ejecucion = mysql_result(mysql_query("select nota_calculada from puntuaciones_paneles where id_panel = '1' and id_rutina='$id_rutina'"),0);
	$nota_calculada_impresion = mysql_result(mysql_query("select nota_calculada from puntuaciones_paneles where id_panel = '2' and id_rutina='$id_rutina'"),0);
	$nota_calculada_dificultad = mysql_result(mysql_query("select nota_calculada from puntuaciones_paneles where id_panel = '3' and id_rutina='$id_rutina'"),0);
	$query = "insert into calculos_clasificacion (id_rutina, orden, id_fase, nota_final, nota_calculada_ejecucion, nota_calculada_impresion, nota_calculada_dificultad, baja, preswimmer, id_competicion) values ('$id_rutina', '$orden', '$id_fase', '$nota_final', '$nota_calculada_ejecucion', '$nota_calculada_impresion', '$nota_calculada_dificultad', '$baja', '$preswimmer', '1')";
	mysql_query($query);
}

$posicion = 1;
$empatados = 0;
$empate = false;
$nota_ganador;
$query = "select * from calculos_clasificacion where id_fase = '$id_fase' order by baja, preswimmer, nota_final desc, nota_calculada_ejecucion desc";
$rutinas_calculos_clasificacion = mysql_query($query);
echo "#".mysql_num_rows($rutinas_calculos_clasificacion)."<br>";
while($rutina = mysql_fetch_array($rutinas_calculos_clasificacion)){
	if($posicion == 1)
		$nota_ganador = $rutina['nota_final'];

	$result = mysql_query("select nota_final from calculos_clasificacion where id_fase = '$id_fase' and nota_final = ".$rutina['nota_final']."");
	if(mysql_num_rows($result) == '1'){
		echo "<br>Posicion $posicion -> ".$rutina['orden'];
		$empate = false;
	}else{
		$result = mysql_query("select nota_final from calculos_clasificacion where id_fase = '$id_fase' and nota_final = ".$rutina['nota_final']." and nota_calculada_ejecucion=".$rutina['nota_calculada_ejecucion']);
		if(mysql_num_rows($result) == '1'){
			echo "<br>Desempate 1 posicion $posicion -> ".$rutina['orden'];
			$empate = false;
		}else{
			$result = mysql_query("select nota_final from calculos_clasificacion where id_fase = '$id_fase' and nota_final = ".$rutina['nota_final']." and nota_calculada_ejecucion=".$rutina['nota_calculada_ejecucion']." and nota_calculada_impresion=".$rutina['nota_calculada_impresion']);
			if(mysql_num_rows($result) == '1'){
				echo "<br>Desempate final posicion $posicion -> ".$rutina['orden'];
				$empate = false;
			}else{
				if($empate)
					$posicion--;
				$empate=true;
				echo "<br>Empate posicion $posicion -> ".$rutina['orden']." - empatados - ".$empatados;
			}
		}
	}
	$query = "update rutinas set posicion='".($posicion-$empatados)."', diferencia='".($nota_ganador - $rutina['nota_final'])."' where id = ".$rutina['id_rutina'];
	echo "<br>".$query;
	$posicion++;
	mysql_query($query);
}


$query = "update fases set puntuada='si' where id='$id_fase'";
echo "<br>".$query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
