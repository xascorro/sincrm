<?php  
//abro conexion DB
include('lib/conexion_abre.php');

if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'modalidades'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='10' value=''/></td><td><input type='text' name='numero_participantes' id='numero_participantes' size='1' value=''/></td><td><input type='text' name='numero_reservas' id='numero_reservas' size='1' value=''/></td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";	
} 

//obtengo los paneles con sus datos
$query = "select * from modalidades where id='".$_GET['id']."'";
$categorias = mysql_query($query); 
while ($categoria = mysql_fetch_array($categorias)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$categoria['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='10' value='".$categoria['nombre']."'/></td><td><input type='text' name='numero_participantes' id='numero_participantes' size='1' value='".$categoria['numero_participantes']."'/></td><td><input type='text' name='numero_reservas' id='numero_reservas' size='1' value='".$categoria['numero_reservas']."'/></td><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$categoria['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                