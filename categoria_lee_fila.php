<?php  
//abro conexion DB
include('lib/conexion_abre.php');

if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'categorias'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
}  

//obtengo los paneles con sus datos
echo "<td value='".$_GET['id']."'>".$_GET['id']."</td><td>".$_GET['nombre']."</td><td>".$_GET['edad_desde']."</td><td>".$_GET['edad_hasta']."</td><td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'>Editar</a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'>Borrar</a></td>";

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                