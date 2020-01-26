<?php  
//abro conexion DB
include('lib/conexion_abre.php');
 
if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'jueces'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value=''/></td><td><input type='text' name='apellidos' id='apellidos' size='30' value=''/></td><td>";
	$_GET['id_federacion'] = "";
	include ("include/federacion_select_option.php");	
	echo "</td><td><input type='text' name='licencia' id='licencia' size='15' value=''/></td>";	
	echo "<td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";	
}
  

//obtengo los jueces con sus datos
$query = "select * from jueces where id='".$_GET['id']."'";
$jueces = mysql_query($query); 
while ($juez = mysql_fetch_array($jueces)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$juez['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value='".$juez['nombre']."'/></td><td><input type='text' name='apellidos' id='apellidos' size='30' value='".$juez['apellidos']."'/></td><td>";
	$_GET['id_federacion'] = $juez['federacion'];
	include ("include/federacion_select_option.php");
	echo "</td><td><input type='text' name='licencia' id='licencia' size='15' value='".$juez['licencia']."'/></td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$juez['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                