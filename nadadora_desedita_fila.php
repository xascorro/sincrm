<?php  
//abro conexion DB
include('lib/conexion_abre.php');
include('lib/my_functions.php');

if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los nadadoras con sus datos
$query = "select * from nadadoras where id='".$_GET['id']."'";
$nadadoras = mysql_query($query); 
while ($nadadora = mysql_fetch_array($nadadoras)){
	echo "<td>".$nadadora['id']."</td>";
	echo "<td>".$nadadora['nombre']."</td>";
	echo "<td>".$nadadora['apellidos']."</td>";
	//saco nombre categoria
	$r = mysql_query("SELECT nombre_corto FROM clubs where id='".$nadadora['club']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	echo "<td>".$nadadora['licencia']."</td>";
	echo "<td>".dateAFecha($nadadora['fecha_nacimiento'])."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$nadadora['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$nadadora['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                