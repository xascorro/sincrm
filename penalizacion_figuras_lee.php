

<?php  
include('lib/conexion_abre.php');  

    $query = "select * from penalizaciones_rutinas where id_inscripcion_figuras='".$_GET['id_inscripcion_figuras']."'"; 
    $result = mysql_query($query);  
    while ($registro = mysql_fetch_array($result)){  
   	 $query = "select puntos from penalizaciones where id='".$registro['id_penalizacion']."'"; 
   	 echo mysql_result(mysql_query($query), 0)."<br>";
  
	    }
include('lib/conexion_cierra.php');  
?>