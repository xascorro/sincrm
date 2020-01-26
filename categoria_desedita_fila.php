<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los categoriaes con sus datos
$query = "select * from categorias where id='".$_GET['id']."'";
$categorias = mysql_query($query); 
while ($categoria = mysql_fetch_array($categorias)){
	echo "<td>".$categoria['id']."</td>";
	echo "<td>".$categoria['nombre']."</td>";
	echo "<td>".$categoria['edad_desde']."</td>";
	echo "<td>".$categoria['edad_hasta']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$categoria['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$categoria['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                