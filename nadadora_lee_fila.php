<?php  
//abro conexion DB
include('lib/conexion_abre.php');

if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'nadadoras'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment']-1;
}  

//obtengo los paneles con sus datos
$query = "select nombre_corto from clubs where id = '".$_GET['club']."'"; 
$nombre_club=mysql_result(mysql_query($query),0);
echo "<td value=".$_GET['id'].">".$_GET['id']."</td><td>".$_GET['nombre']."</td><td>".$_GET['apellidos']."</td><td>$nombre_club</td><td>".$_GET['licencia']."</td><td>".$_GET['fecha_nacimiento']."</td><td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'>Editar</a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'>Borrar</a></td>";

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                