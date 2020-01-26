<?php  
//abro conexion DB
include('lib/conexion_abre.php');

if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'figuras'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='numero' id='numero' type='text' size='5' value=''/></td><td><input type='text' name='nombre' id='nombre' size='25' value=''/></td><td><input type='text' name='grado_dificultad' id='grado_dificultad' size='5' value=''/></td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";	
} 

//obtengo los paneles con sus datos
$query = "select * from figuras where id='".$_GET['id']."'";
$figuras = mysql_query($query); 
while ($figura = mysql_fetch_array($figuras)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$figura['id']."'/></td><td><input name='numero' id='numero' type='text' size='5' value='".$figura['numero']."'/></td><td><input type='text' name='nombre' id='nombre' size='25' value='".$figura['nombre']."'/></td><td><input type='text' name='grado_dificultad' id='grado_dificultad' size='5' value='".$figura['grado_dificultad']."'/></td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$figura['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                