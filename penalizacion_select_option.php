<?php  
//include('lib/conexion_abre.php');  
    $query = "select * from penalizaciones";
    $result = mysql_query($query);  
    $select = "<select id='rutina_penalizacion' class='form-control'>";
    $select .= "<option>Selecciona una penalización</option>";
    while ($registro = mysql_fetch_array($result)){  
			$select .= "<option value=".$registro['id'].">".$registro['codigo']."</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;
//include('lib/conexion_cierra.php');  
?>