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

//obtengo los competiciones con sus datos
$query = "select * from competiciones where id='".$_GET['id']."'";
$competiciones = mysql_query($query); 
while ($competicion = mysql_fetch_array($competiciones)){
	echo "<td>".$competicion['id']."</td>";
	echo "<td>".$competicion['nombre']."</td>";
	echo "<td>".$competicion['lugar']."</td>";
	echo "<td>".dateAFecha($competicion['fecha'])."</td>";
	echo "<td>".$competicion['organizador_tipo']."</td>";
	//saco nombre organizador
	if($competicion['organizador_tipo'] == 'Federación')
		$tabla = "federaciones";
	elseif($competicion['organizador_tipo'] == 'Club')
		$tabla = "clubs";
	if($competicion['activo']=='no')
    	$activo = "<i class='fa fa-toggle-off fa-2x text-danger'></i>";
    else
       	$activo = "<i class='fa fa-toggle-on fa-2x text-success'></i>";	//$query = "select nombre_corto from $tabla where id = '".$competicion['organizador']."'"; 
	$r = mysql_query("select nombre_corto from $tabla where id = '".$competicion['organizador']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	echo "<td>".$activo."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$competicion['id']."'>".'<i class="fa fa-edit fa-2x"></i>'."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$competicion['id']."'>".'<i class="fa fa-trash-o fa-2x"></i>'."</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
                