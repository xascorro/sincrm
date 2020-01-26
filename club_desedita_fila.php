<?php  
//abro conexion DB
include('lib/conexion_abre.php');
  
if($_GET['id'] == "nueva_fila"){
	$query = "SELECT LAST_INSERT_ID() as id";
	$resultado = mysql_query($query);
	$ultima_id = mysql_fetch_row($resultado);
	$_GET['id'] = $ultima_id[0];
}

//obtengo los clubs con sus datos
$query = "select * from clubs where id='".$_GET['id']."'";
$clubs = mysql_query($query); 
while ($club = mysql_fetch_array($clubs)){
	echo "<td>".$club['id']."</td>";
	echo "<td>".$club['nombre']."</td>";
	echo "<td>".$club['nombre_corto']."</td>";
	echo "<td>".$club['codigo']."</td>";
	//saco nombre categoria
	$r = mysql_query("SELECT nombre_corto FROM federaciones where id='".$club['federacion']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	echo "<td><img style='max-width:100px; max-height:100px' src='".$club['logo']."' alt='images/logo_cnlorga.jpg' class='img-thumbnail'></td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$club['id']."'>"."<i class='fa fa-edit fa-2x'></i>"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$club['id']."'>"."<i class='fa fa-trash fa-2x'></i>"."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                