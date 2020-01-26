<?php  
//abro conexion DB
include('lib/conexion_abre.php');

if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'federaciones'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment']-1;
}  

//obtengo los paneles con sus datos
echo "<td value=".$_GET['id'].">".$_GET['id']."</td><td>".$_GET['nombre']."</td><td>".$_GET['nombre_corto']."</td><td>".$_GET['codigo']."</td><td>".$_GET['comunidad']."</td><td><img style='max-width:100px; max-height:100px' src='".$_GET['logo']."' alt='...' class='img-thumbnail'></td><td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'><i class='fa fa-edit fa-2x '></i></a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'><i class='fa fa-trash fa-2x '></i></a></td>";

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                