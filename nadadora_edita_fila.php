<?php  
//abro conexion DB
include('lib/conexion_abre.php');
include('lib/my_functions.php'); 
if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'nadadoras'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value=''/></td><td><input type='text' name='apellidos' id='apellidos' size='30' value=''/></td><td>";
	$_GET['id_club'] = "";
	include ("include/club_select_option.php");	
	echo "</td><td><input type='text' name='licencia' id='licencia' size='15' value=''/></td><td><input type='text' name='fecha_nacimiento' id='fecha_nacimiento' size='15' value=''/></td>";	
	echo "<td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";	
}
  

//obtengo los nadadoras con sus datos
$query = "select * from nadadoras where id='".$_GET['id']."'";
$nadadoras = mysql_query($query); 
while ($nadadora = mysql_fetch_array($nadadoras)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$nadadora['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value='".$nadadora['nombre']."'/></td><td><input type='text' name='apellidos' id='apellidos' size='30' value='".$nadadora['apellidos']."'/></td><td>";
	$_GET['id_club'] = $nadadora['club'];
	include ("include/club_select_option.php");
	echo "</td><td><input type='text' name='licencia' id='licencia' size='15' value='".$nadadora['licencia']."'/></td><td><input type='text' name='fecha_nacimiento' id='fecha_nacimiento' size='15' value='".dateAFecha($nadadora['fecha_nacimiento'])."'/></td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$nadadora['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                