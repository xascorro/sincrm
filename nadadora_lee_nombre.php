

<?php  
include('lib/conexion_abre.php');  

    $query = "select * from nadadoras where id='".$_GET['id']."'";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
    $nombre_club = "";
    while ($registro = mysql_fetch_array($result)){  
	    $nombre_club=$registro['nombre'];
  
	    }
echo $nombre_club;  
include('lib/conexion_cierra.php');  
?>