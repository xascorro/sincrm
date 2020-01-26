<?php  
include('./lib/conexion_abre.php');  
    $GLOBALS["id_competicion_activa"] = 0; 
	$GLOBALS["nombre_competicion_activa"] = "No hay competición activa";
    $query = "select * from competiciones where activo='si'";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
    while ($registro = mysql_fetch_array($result)){  
	    $GLOBALS["id_competicion_activa"] = $registro['id']; 
	    $GLOBALS["nombre_competicion_activa"] = $registro['nombre'];  
	    $GLOBALS["competicion_figuras"] = $registro['figuras'];  
	    $GLOBALS["no_federado"] = $registro['no_federado'];  
	}

include('./lib/conexion_cierra.php');  
?>