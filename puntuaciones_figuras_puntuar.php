<?php
include("./lib/conexion_abre.php");

$id_competicion = $_GET['id_competicion'];
mysql_query("delete from resultados_figuras where id_competicion='".$id_competicion."'");
//variables
$posicion = 1;
//obtengo las categorias de la competicion
$query = "select * from fases_figuras where id_competicion='$id_competicion' group by id_categoria order by orden asc ";
echo $query;
$fases_figuras = mysql_query($query);
while($fase_figuras = mysql_fetch_array($fases_figuras)){
	$gd_acumulado = mysql_result(mysql_query("select sum(grado_dificultad) from figuras where id in (select id_figura from fases_figuras where id_categoria='".$fase_figuras['id_categoria']."')"),0);
	$query = "select id_nadadora, sum(nota_final) as sum_nota_final, baja, preswimmer, id from inscripciones_figuras where id_fase_figuras in (select id from fases_figuras where id_categoria='".$fase_figuras['id_categoria']."' and id_competicion='$id_competicion') group by id_nadadora";
	$resultados_nadadoras = mysql_query($query);
	while($resultado_nadadora = mysql_fetch_array($resultados_nadadoras)){
		$anio_nadadora = mysql_result(mysql_query("select fecha_nacimiento from nadadoras where id='".$resultado_nadadora['id_nadadora']."'"),0);
		

		$query = "select sum(puntos) from penalizaciones where id in (select id_penalizacion from penalizaciones_rutinas where id_inscripcion_figuras in (select id from inscripciones_figuras where id_nadadora='".$resultado_nadadora['id_nadadora']."' and id_competicion='".$id_competicion."'))";
		$puntos_penalizacion = mysql_result(mysql_query($query),0);	
		if($puntos_penalizacion == 0)
			$puntos_penalizacion = "";	
		
		$nota_final_calculada = (($resultado_nadadora['sum_nota_final']/$gd_acumulado)*10) + $puntos_penalizacion;
		$query = "insert into resultados_figuras (id_nadadora, id_categoria, año, gd_acumulado, puntos_penalizacion, nota_final, nota_final_calculada, baja, preswimmer, id_competicion) values ('".$resultado_nadadora['id_nadadora']."', '".$fase_figuras['id_categoria']."', '$anio_nadadora', '$gd_acumulado"."', '$puntos_penalizacion', '".$resultado_nadadora['sum_nota_final']."', '$nota_final_calculada', '".$resultado_nadadora['baja']."','".$resultado_nadadora['preswimmer']."','$id_competicion' )";
		echo "<br>".$query;
		mysql_query($query);
	}
}

//ordeno y reparto puntos


$puntos = array("0", "19", "16", "14", "13","12", "11", "10", "9", "8","7", "6", "5", "4", "3","2", "1", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0",);

$query = "select año from resultados_figuras where id_competicion='$id_competicion' group by año order by id";
echo $query;
$categorias = mysql_query($query);
while($categoria = mysql_fetch_array($categorias)){
$posicion = 1;
$empatados = 0;
$empate = false;
$nota_ganador;
	$query = "select * from resultados_figuras where año='".$categoria['año']."' and id_competicion='$id_competicion' order by nota_final_calculada desc";
	$resultados_nadadoras = mysql_query($query);
	while($resultado_nadadora = mysql_fetch_array($resultados_nadadoras)){
		if($posicion == 1)
			$nota_ganador = $resultado_nadadora['nota_final_calculada'];
	$result = mysql_query("select nota_final_calculada from resultados_figuras where año='".$categoria['año']."' and id_competicion='$id_competicion' and nota_final_calculada = ".$resultado_nadadora['nota_final_calculada']."");
	if(mysql_num_rows($result) == '1'){
		echo "<br>Posicion $posicion -> ".$resultado_nadadora['id_nadadora'];
		$empate = false;
	}else{
		if($empate)
			$posicion--;
		$empate=true;
		echo "<br><b>Empate posicion $posicion -> ".$resultado_nadadora['id_nadadora']." - empatados - ".$empatados."</b>";
	}
   	if($resultado_nadadora['baja'] != 'no' and $resultado_nadadora['preswimmer'] != 'no' and $posicion <= '16'){
    	$puntos_nadadora = $puntos[$posicion];
	}else{
		$puntos_nadadora = "0";
	}	
	$query = "update resultados_figuras set posicion='".($posicion-$empatados)."', diferencia='".($nota_ganador - $resultado_nadadora['nota_final_calculada'])."', puntos='$puntos_nadadora' where id = ".$resultado_nadadora['id'];
	echo "<br>".$query;
	$posicion++;
	mysql_query($query);
	}		
}
$query = "update resultados_figuras set puntos='0' where (baja='si' or preswimmer='si') and id_competicion='$id_competicion'";
echo "<br>".$query;
mysql_query($query);





$query = "update fases_figuras set puntuada='si' where id_competicion='$id_competicion'";
echo "<br>".$query;
mysql_query($query);
include("./lib/conexion_cierra.php");

?>
