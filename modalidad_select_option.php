<?php  
include('competicion_activa_lee_nombre_id.php');  

include('lib/conexion_abre.php');  
$query="";
$id_club="";
$id_modalidad=$_GET['id_modalidad'];
$query = "select * from modalidades where id_competicion = '".$id_competicion_activa."'";   

    $result = mysql_query($query);  
    $select = "<select id='modalidades' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){  
	    if($id_modalidad==$registro['id'])
	    	$select .= "<option selected value=".$registro['id'].">".$registro['nombre']."</option>";
	    else
	    	$select .= "<option value=".$registro['id'].">".$registro['nombre']."</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;
include('lib/conexion_cierra.php');  
?>