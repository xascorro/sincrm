<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los fases_figuras con sus datos
$query = "select * from fases_figuras where id='".$_GET['id']."'";
$fases_figuras = mysql_query($query); 
while ($fase_figura = mysql_fetch_array($fases_figuras)){
	echo "<td>".$fase_figura['id']."</td>";
	//saco nombre modalidad
	$r = mysql_query("SELECT nombre FROM categorias where id='".$fase_figura['id_categoria']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	//saco nombre categoria
	$r = mysql_query("SELECT numero FROM figuras where id='".$fase_figura['id_figura']."'");
	$re = mysql_query("SELECT nombre FROM figuras where id='".$fase_figura['id_figura']."'");
	echo "<td>".mysql_result($r,0)." - ".mysql_result($re,0)."</td>";
	echo "<td>".$fase_figura['orden']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$fase_figura['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$fase_figura['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                