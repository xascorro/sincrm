<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los modalidades con sus datos
$query = "select * from modalidades where id='".$_GET['id']."'";
$modalidades = mysql_query($query); 
while ($modalidad = mysql_fetch_array($modalidades)){
	echo "<td>".$modalidad['id']."</td>";
	echo "<td>".$modalidad['nombre']."</td>";
	echo "<td>".$modalidad['numero_participantes']."</td>";
	echo "<td>".$modalidad['numero_reservas']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$modalidad['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$modalidad['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                