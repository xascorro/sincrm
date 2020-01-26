<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los fases con sus datos
$query = "select * from fases where id='".$_GET['id']."'";
$fases = mysql_query($query); 
while ($fase = mysql_fetch_array($fases)){
	echo "<td>".$fase['id']."</td>";
	//saco nombre modalidad
	$r = mysql_query("SELECT nombre FROM modalidades where id='".$fase['id_modalidad']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	//saco nombre categoria
	$r = mysql_query("SELECT nombre FROM categorias where id='".$fase['id_categoria']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	echo "<td>".$fase['orden']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$fase['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$fase['id']."'>"."Borrar"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                