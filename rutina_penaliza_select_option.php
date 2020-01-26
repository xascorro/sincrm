<?php  
//include('lib/conexion_abre.php');  
    $query = "select * from rutinas where id_fase='".$_GET['id_fase']."' order by orden";
    $result = mysql_query($query);  
    $select = "<select id='rutina_penalizada' class='form-control'>";
    $select .= "<option>Selecciona una rutina</option>";
    while ($registro = mysql_fetch_array($result)){  
			$query = "select nombre_corto from clubs where id = '".$registro['id_club']."'";
			$nombre_club = mysql_result(mysql_query($query),0);
			$select .= "<option value=".$registro['id'].">".$registro['orden']." ".$nombre_club."</option>";
  
	    }
	   	$select .= "</select>"; 
echo $select;
//include('lib/conexion_cierra.php');  
?>