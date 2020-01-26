<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los jueces con sus datos
$query = "select * from jueces where id='".$_GET['id']."'";
$jueces = mysql_query($query); 
while ($juez = mysql_fetch_array($jueces)){
	echo "<td>".$juez['id']."</td>";
	echo "<td>".$juez['nombre']."</td>";
	echo "<td>".$juez['apellidos']."</td>";
	//saco nombre categoria
	$r = mysql_query("SELECT nombre_corto FROM federaciones where id='".$juez['federacion']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	echo "<td>".$juez['licencia']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$juez['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$juez['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                