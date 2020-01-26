<?php  
//abro conexion DB
include('lib/conexion_abre.php');

$orden_select_option = "<select name='orden' id='orden'><option value='0'>Aleatorio</option><option value='-1'>Preswimmer</option></select>";

 
if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'rutinas'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td>";
	$_GET['id_club'] = "";
	include ("include/club_select_option.php");
	echo "</td><td><input type='text' name='nombre' id='nombre' size='30' value=''/></td><td colspan='2'><input type='text' name='musica' id='musica' size='30' value=''/></td><td><input disabled='disabled' type='text' name='orden' id='orden' size='15' value='0'/><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";
}
  

//obtengo los rutinas con sus datos
$query = "select * from rutinas where id='".$_GET['id']."'";
$rutinas = mysql_query($query); 
while ($rutina = mysql_fetch_array($rutinas)){
	$query = "select nombre_corto from clubs where id = '".$rutina['id_club']."'"; 
    $nombre_club=mysql_result(mysql_query($query),0);
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$rutina['id']."'/></td><td>";
	$_GET['id_club'] = $rutina['id_club'];
	include ("include/club_select_option.php");
	echo"</td><td><input type='text' name='nombre' id='nombre' size='30' value='".$rutina['nombre']."'/></td><td colspan='2'><input type='text' name='musica' id='musica' size='30' value='".$rutina['musica']."'/></td><td>".$orden_select_option."<td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$rutina['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                