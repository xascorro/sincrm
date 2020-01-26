<?php  
//abro conexion DB
include('lib/conexion_abre.php');
 
if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'federaciones'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	echo "<td value='".$_GET['id']."><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='30' value=''/></td><td><input type='text' name='nombre_corto' id='nombre_corto' size='10' value=''/></td><td><input type='text' name='codigo' id='codigo' size='10' value=''/></td><td><input type='text' name='comunidad' id='comunidad' size='30' value=''/></td><td><input type='text' name='logo' id='logo' size='10' value=''/></td>";	
	echo "</td><td><a href='javascript:' class='guarda_fila' id='new'><i class='fa fa-save fa-2x '></i></a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'><i class='fa fa-reply fa-2x '></i></a></td>";	
}
  

//obtengo los federaciones con sus datos
$query = "select * from federaciones where id='".$_GET['id']."'";
echo $query;
$federaciones = mysql_query($query); 
while ($federacion = mysql_fetch_array($federaciones)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$federacion['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='30' value='".$federacion['nombre']."'/></td><td><input type='text' name='nombre_corto' id='nombre_corto' size='10' value='".$federacion['nombre_corto']."'/></td><td><input type='text' name='codigo' id='codigo' size='10' value='".$federacion['codigo']."'/></td><td><input type='text' name='comunidad' id='comunidad' size='30' value='".$federacion['comunidad']."'/></td><td><input type='text' name='logo' id='logo' size='30' value='".$federacion['logo']."'/></td><td><a href='javascript:' class='guarda_fila' id='new'><i class='fa fa-save fa-2x '></i></a></td><td><a href='javascript:' class='desedita_fila' id='".$federacion['id']."'><i class='fa fa-reply fa-2x '></i></a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                