

<?php  
include('lib/conexion_abre.php');  

    $query = "select * from modalidades where id='".$_GET['id_tipo']."'";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
    $nombre_club = "";
    while ($registro = mysql_fetch_array($result)){  
	    $nombre=$registro['nombre'];
  
	    }
echo $nombre;  
include('lib/conexion_cierra.php');  
?>