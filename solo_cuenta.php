<?php  
include('lib/conexion_abre.php');  

    $query = "select * from rutinas where id_fase in (select id from fases where id_modalidad = '1' and id_competicion='".$GLOBALS['id_competicion_activa']."')";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
echo mysql_num_rows($result);
include('lib/conexion_cierra.php');  
?>