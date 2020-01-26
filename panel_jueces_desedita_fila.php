<?php  
//abro conexion DB
include('lib/conexion_abre.php');
$fila = $_GET['fila']; 
$panel = $_GET['panel']; 
$fase = $_GET['fase']; 
$juez = $_GET['juez']; 
$panel_jueces = $_GET['panel_jueces']; 
$query = "select nombre, apellidos from jueces where id = '$juez'"; 
$nombre_juez=mysql_result(mysql_query($query),0)." ".mysql_result(mysql_query($query),0,1);
echo '<td>'.$fila.'</td>';
echo '<td>'.$nombre_juez.'</td>';
echo '<td><a class="edita_fila" fase="'.$fase.'" panel="'.$panel.'" fila="'.$fila.'" juez="'.$juez.'" id_panel_jueces="'.$panel_jueces.'" href="javascript:">Editar</a></td>';

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                