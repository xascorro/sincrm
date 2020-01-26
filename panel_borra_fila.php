<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  

//obtengo los paneles con sus datos
$query = "delete from paneles where id='".$_GET['id']."'";
mysql_query($query);

/*
$paneles = mysql_query($query); 
while ($panel = mysql_fetch_array($paneles)){
	echo "<td>".$panel['id']."</td>";
	echo "<td>".$panel['nombre']."</td>";
	echo "<td>".$panel['numero_jueces']."</td>";
	echo "<td>".$panel['peso']."</td>";
	echo "<td>".$panel['descripcion']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$panel['id']."'>"."Guardar"."</a></td>";
	echo "<td><a href='javascript:' class='desedita_fila' id='".$panel['id']."'>"."Cancelar"."</a></td>";
}*/

//cierro conexion DB
include('lib/conexion_cierra.php'); 
?>
                
                