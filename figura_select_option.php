<?php  
include('competicion_activa_lee_nombre_id.php');  

include('lib/conexion_abre.php');  
$query="";
$id_club="";
$id_figura=$_GET['id_figura'];
$query = "select * from figuras where id_competicion = '0' order by numero";   
//$query = "select * from figuras where id_competicion = '".$id_competicion_activa."'";   

    $result = mysql_query($query);  
    $select = "<select id='figuras' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){  
	    if($id_figura==$registro['id'])
	    	$select .= "<option selected value=".$registro['id'].">".$registro['numero']." - ".$registro['nombre']."</option>";
	    else
	    	$select .= "<option value=".$registro['id'].">".$registro['numero']." - ".$registro['nombre']."</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;
include('lib/conexion_cierra.php');  
?>