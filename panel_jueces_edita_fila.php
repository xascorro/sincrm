<?php  
//abro conexion DB
include('lib/conexion_abre.php');
$fila = $_GET['fila']; 
$panel = $_GET['panel']; 
$fase = $_GET['fase']; 
$juez = $_GET['id_juez']; 
$panel_jueces = $_GET['id_panel_jueces']; 

echo '<td>'.$fila.'</td>';
echo '<td>';
include('juez_select_option.php');
echo '</td>';
echo '<td><a class="guarda_fila" fase="'.$fase.'" panel="'.$panel.'" fila="'.$fila.'" juez="'.$juez.'" panel_jueces="'.$panel_jueces.'" href="javascript:">Guardar</a></td>';

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                