<?php  
//abro conexion DB
include('lib/conexion_abre.php');

if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'competiciones'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];
}  

//obtengo las competiciones con sus datos
if($_GET['organizador_tipo']=="Club")
	$tabla="clubs";
elseif($_GET['organizador_tipo']=="Federación")
	$tabla="federaciones";
if($_GET['activo']=='no')
    	$activo = "<i class='fa fa-toggle-off fa-2x text-danger'></i>";
   else
       	$activo = "<i class='fa fa-toggle-on fa-2x text-success'></i>";
$query = "select nombre_corto from $tabla where id = '".$_GET['organizador']."'"; 
$nombre_organizador=mysql_result(mysql_query($query),0);

echo "<td value=".$_GET['id'].">".$_GET['id']."</td><td>".$_GET['nombre']."</td><td>".$_GET['lugar']."</td><td>".$_GET['fecha']."</td><td>".$_GET['organizador_tipo']."</td><td>$nombre_organizador</td><td>".$activo."</td><td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'><i class='fa fa-edit fa-2x'></i></a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'><i class='fa fa-trash-o fa-2x'></i></a></td>";

//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                