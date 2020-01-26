<?php  
include('lib/conexion_abre.php');  

    $query = "select * from nadadoras";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
echo mysql_num_rows ($result);
include('lib/conexion_cierra.php');  
?>