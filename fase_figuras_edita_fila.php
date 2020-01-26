<?php  
//abro conexion DB
include('./lib/conexion_abre.php');
if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'fases_figuras'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
 	echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='nueva_fila' type='text' size='1' value='".$_GET['id']."'/></td><td>";
	$_GET['id_categoria'] = 0;
	include ("categoria_select_option.php");
	echo "</td><td>";
	$_GET['id_figura'] = 0;
	include ("figura_select_option.php");
 	echo "</td><td><input name='orden' id='orden' type='text' size='1' value=''/></td>";
	echo "<td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";	
}



//obtengo los paneles con sus datos
$query = "select * from fases_figuras where id='".$_GET['id']."'";
$fases = mysql_query($query); 
while ($fase = mysql_fetch_array($fases)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$fase['id']."'/></td><td>";
	$_GET['id_categoria'] = $fase['id_categoria'];
	include ("categoria_select_option.php");
	echo "</td><td>";
	$_GET['id_figura'] = $fase['id_figura'];
	include ("figura_select_option.php");
 	echo "</td><td><input name='orden' id='orden' type='text' size='1' value='".$fase['orden']."'/></td>";
	echo "<td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$fase['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('./lib/conexion_cierra.php'); 

?>
                
                