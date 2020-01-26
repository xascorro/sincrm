<?php  
//abro conexion DB
include('lib/conexion_abre.php');


if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'rutinas'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment']-1;
}  

//obtengo los paneles con sus datos
$query = "select nombre_corto from clubs where id = '".$_GET['id_club']."'"; 
$nombre_club=mysql_result(mysql_query($query),0);
echo "<td value=".$_GET['id']."><h3>".$_GET['id']."</h3></td><td><h3>$nombre_club</h3></td><td><h3>".$_GET['nombre']."</h3></td><td colspan='2'><h5>".$_GET['musica']."</h5></td><td><h3>".$_GET['orden']."</h3></td><td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'>Editar</a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'>Borrar</a></td>";

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                