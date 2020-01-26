<?php  
//include('lib/conexion_abre.php');  
    $query = "select * from inscripciones_figuras where id_fase_figuras='".$_GET['id_fase_figuras']."' order by orden";
    $result = mysql_query($query);  
    $select = "<select id='figura_baja' class='form-control'>";
    $select .= "<option>Selecciona una nadadora</option>";
    while ($registro = mysql_fetch_array($result)){  
			$query = "select apellidos, nombre from nadadoras where id = '".$registro['id_nadadora']."'";
			$nombre_nadadora = mysql_result(mysql_query($query),0).", ".mysql_result(mysql_query($query),0,1);
			$select .= "<option value=".$registro['id'].">".$registro['orden']." ".$nombre_nadadora."</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;
//include('lib/conexion_cierra.php');  
?>