<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los paneles con sus datos
$query = "select * from paneles where id='".$_GET['id']."'";
$paneles = mysql_query($query); 
while ($panel = mysql_fetch_array($paneles)){
	echo "<td>".$panel['id']."</td>";
	echo "<td>".$panel['nombre']."</td>";
	echo "<td>".$panel['numero_jueces']."</td>";
	echo "<td>".$panel['peso']."</td>";
	echo "<td>".$panel['descripcion']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$panel['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$panel['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                