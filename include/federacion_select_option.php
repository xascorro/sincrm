<?php  
//include('lib/conexion_abre.php');  

    $query = "select * from federaciones";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
    $select = "<select id='federacion' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){  
	    if($_GET['id_federacion']==$registro['id'])
	    	$select .= "<option selected value=".$registro['id'].">".$registro['nombre_corto']."</option>";
	    else
	    	$select .= "<option value=".$registro['id'].">".$registro['nombre_corto']."</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;  
//include('lib/conexion_cierra.php');  
?>