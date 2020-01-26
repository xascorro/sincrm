<?php  
    $query = "select activo from competiciones where id='".$_GET["id"]."'";     // Esta linea hace la consulta 
    $result = mysql_query($query);  
    $select = "<select id='activo' name='activo' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){  
	    if($registro['activo'] == 'si')
	    	$select .= "<option selected value='si'><i class='fa fa-toggle-on fa-2x text-success'>SI</i></option><option value='no'><i class='fa fa-toggle-off fa-2x text-danger'>NO</i></option>";
	    else
	    	$select .= "<option value='si'><i class='fa fa-toggle-on fa-2x text-success'>SI</i></option><option selected value='no'><i class='fa fa-toggle-off fa-2x text-danger'>NO</i></option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;  
?>