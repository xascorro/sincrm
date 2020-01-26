<?php  
include('competicion_activa_lee_nombre_id.php');  

include('lib/conexion_abre.php');  
$query="";
$id_club="";
$id_categoria=$_GET['id_categoria'];
$query = "select * from categorias where id_competicion = '".$id_competicion_activa."'";   

    $result = mysql_query($query);  
    $select = "<select id='categorias' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){  
	    if($id_categoria==$registro['id'])
	    	$select .= "<option selected value=".$registro['id'].">".$registro['nombre']."</option>";
	    else
	    	$select .= "<option value=".$registro['id'].">".$registro['nombre']."</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;
include('lib/conexion_cierra.php');  
?>