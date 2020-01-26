<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  

//obtengo los paneles con sus datos
$query = "delete from figuras where id='".$_GET['id']."'";
mysql_query($query);

//cierro conexion DB
include('lib/conexion_cierra.php'); 
?>
                
                