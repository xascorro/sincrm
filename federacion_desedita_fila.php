<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los federaciones con sus datos
$query = "select * from federaciones where id='".$_GET['id']."'";
$federaciones = mysql_query($query); 
while ($federacion = mysql_fetch_array($federaciones)){
	echo "<td>".$federacion['id']."</td>";
	echo "<td>".$federacion['nombre']."</td>";
	echo "<td>".$federacion['nombre_corto']."</td>";
	echo "<td>".$federacion['codigo']."</td>";
	echo "<td>".$federacion['comunidad']."</td>";
	echo "<td>".$federacion['logo']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$federacion['id']."'>"."<i class='fa fa-edit fa-2x '></i>"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$federacion['id']."'>"."<i class='fa fa-trash fa-2x '></i>"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                