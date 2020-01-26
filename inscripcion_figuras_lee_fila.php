<?php  
//abro conexion DB
include('lib/conexion_abre.php');


if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'inscripciones_figuras'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment']-1;
}  

//obtengo los paneles con sus datos
$query = "select nombre, apellidos, club from nadadoras where id = '".$_GET['id_nadadora']."'"; 
$nombre_nadadora=mysql_result(mysql_query($query),0,0);
$apellidos_nadadora=mysql_result(mysql_query($query),0,1);
$id_club=mysql_result(mysql_query($query),0,2);
$query = "select nombre_corto from clubs where id = '".$id_club."'"; 
$nombre_club=mysql_result(mysql_query($query),0,0);
echo "<td value=".$_GET['id']."><h3>".$_GET['id']."</h3></td><td>$nombre_club</td><td>$apellidos_nadadora".", $nombre_nadadora</td><td><h3>".$_GET['orden']."</h3></td><td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'>Editar</a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'>Borrar</a></td>";

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                