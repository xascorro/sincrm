<?php  
//abro conexion DB
include('lib/conexion_abre.php');
$id_rutina=$_GET['id_rutina'];  

  
//obtengo los paneles con sus datos
$query = "select * from rutinas where id='$id_rutina'";
$rutinas = mysql_query($query); 
while ($rutina = mysql_fetch_array($rutinas)){
	echo "<td>".$rutina['id']."</td>";
	echo "<td>".$rutina['nombre']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$rutina['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$rutina['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                