<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'fases'");
	$data = mysql_fetch_assoc($result);
	echo = $data['Auto_increment'];

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                