<?php  
//abro conexion DB
include('lib/conexion_abre.php');
 
if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'clubs'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
	echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value=''/></td><td><input type='text' name='nombre_corto' id='nombre_corto' size='15' value=''/></td><td><input name='codigo' id='codigo' type='text' size='15' value=''/></td><td>";
	$_GET['id_federacion'] = "";
	include ("include/federacion_select_option.php");	
	echo "</td><td><input type='text' name='logo' id='logo' size='25' value=''/></td>";	
	echo "<td><a href='javascript:' class='guarda_fila' id='new'><i class='fa fa-save fa-2x'></i></a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'><i class='fa fa-reply fa-2x'></i></a></td>";	
}
  

//obtengo los clubs con sus datos
$query = "select * from clubs where id='".$_GET['id']."'";
$clubs = mysql_query($query); 
while ($club = mysql_fetch_array($clubs)){
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$club['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value='".$club['nombre']."'/></td><td><input type='text' name='nombre_corto' id='nombre_corto' size='15' value='".$club['nombre_corto']."'/></td><td><input name='codigo' id='codigo' type='text' size='15' value='".$club['codigo']."'/></td><td>";
	$_GET['id_federacion'] = $club['federacion'];
	include ("include/federacion_select_option.php");
	echo "</td><td><input type='text' name='logo' id='logo' size='25' value='".$club['logo']."'/></td><td><a href='javascript:' class='guarda_fila' id='new'><i class='fa fa-save fa-2x'></i></a></td><td><a href='javascript:' class='desedita_fila' id='".$club['id']."'><i class='fa fa-reply fa-2x'></i></a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                