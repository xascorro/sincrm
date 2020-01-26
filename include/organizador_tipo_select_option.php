<?php  
//include('lib/conexion_abre.php');  

    $query = "select organizador_tipo from competiciones where id='".$_GET["id"]."'";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
    $select = "<select id='organizador_tipo' name='organizador_tipo' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){  
	    if($registro['organizador_tipo'] == 'Federación')
	    	$select .= "<option selected value='Federación'>Federación</option><option value='Club'>Club</option>";
	    else
	    	$select .= "<option value='Federación'>Federación</option><option selected value='Club'>Club</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;  
//include('lib/conexion_cierra.php');  
?>