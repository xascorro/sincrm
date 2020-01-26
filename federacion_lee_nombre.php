

<?php  
include('lib/conexion_abre.php');  

    $query = "select * from federaciones where id='".$_GET['id']."'";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
    $nombre_federacion = "";
    while ($registro = mysql_fetch_array($result)){  
	    $nombre_federacion=$registro['nombre_corto'];
  
	    }
echo $nombre_federacion;  
include('lib/conexion_cierra.php');  
?>