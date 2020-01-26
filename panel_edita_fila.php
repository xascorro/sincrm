<?php  
//abro conexion DB
include('lib/conexion_abre.php');
 
if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'paneles'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='10' value=''/></td><td><input type='text' name='numero_jueces' id='numero_jueces' size='1' value=''/></td><td><input type='text' name='peso' id='peso' size='1' value=''/></td><td><textarea rows='5' cols='70' name='descripcion' id='descripcion' value=''></textarea></td>";	
	echo "</td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";	
}
  

//obtengo los paneles con sus datos
$query = "select * from paneles where id='".$_GET['id']."'";
$paneles = mysql_query($query); 
while ($panel = mysql_fetch_array($paneles)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$panel['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='10' value='".$panel['nombre']."'/></td><td><input type='text' name='numero_jueces' id='numero_jueces' size='1' value='".$panel['numero_jueces']."'/></td><td><input type='text' name='peso' id='peso' size='1' value='".$panel['peso']."'/></td><td><textarea rows='5' cols='70' name='descripcion' id='descripcion' value=''>".$panel['descripcion']."</textarea></td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$panel['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                