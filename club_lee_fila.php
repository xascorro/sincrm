<?php  
//abro conexion DB
include('lib/conexion_abre.php');

if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'clubs'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
}  

//obtengo los paneles con sus datos
$query = "select nombre_corto from federaciones where id = '".$_GET['federacion']."'"; 
$nombre_federacion=mysql_result(mysql_query($query),0);
echo "<td value=".$_GET['id'].">".$_GET['id']."</td><td>".$_GET['nombre']."</td><td>".$_GET['nombre_corto']."</td><td>".$_GET['codigo']."</td><td>$nombre_federacion</td><td><img style='max-width:100px; max-height:100px' src='".$_GET['logo']."' alt='..' class='img-thumbnail'></td><td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'><i class='fa fa-edit fa-2x'></i></a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'><i class='fa fa-trash fa-2x'></i></a></td>";

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                