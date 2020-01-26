<?php
//include('lib/conexion_abre.php');
$query="";
if(isset($_GET['id_club'])){
	$id_club=$_GET['id_club'];
	$query = "select * from nadadoras where club='$id_club' order by apellidos";
}else{
	$query = "select * from nadadoras order by apellidos";
}
$id_nadadora=$_GET['id_nadadora'];

    $result = mysql_query($query);
    $select = "<select id='nadadora' class='form-control'>";
    while ($registro = mysql_fetch_array($result)){
	    if($_GET['id_nadadora']==$registro['id'])
	    	$select .= "<option selected value=".$registro['id'].">".$registro['apellidos'].", ".$registro['nombre']."</option>";
	    else
	    	$select .= "<option value=".$registro['id'].">".$registro['apellidos'].", ".$registro['nombre']."</option>";

	    }
	   	$select .= "</select>";
echo $select;
//include('lib/conexion_cierra.php');
?>
