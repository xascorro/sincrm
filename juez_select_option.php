<?php


	$id_juez=$_GET['id_juez'];

//$query = "select * from jueces where id_competicion='".$GLOBALS['id_competicion_activa']."' order by apellidos";
$query = "select * from jueces where activo='si' order by nombre";
    $result = mysql_query($query);
    $select = "<select id='juez' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){
	    if($id_juez==$registro['id'])
	    	$select .= "<option selected value=".$registro['id'].">".$registro['nombre']." ".$registro['apellidos']."</option>";
	    else
	    	$select .= "<option value=".$registro['id'].">".$registro['nombre']." ".$registro['apellidos']."</option>";

	    }
	   	$select .= "</select>";
echo $select;
//include('lib/conexion_cierra.php');
?>
