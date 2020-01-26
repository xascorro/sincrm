<?php
//abro conexion DB
include('lib/conexion_abre.php');

$orden_select_option = "<select name='orden' id='orden'><option value='0'>Aleatorio</option><option value='-1'>Preswimmer</option></select>";


if($_GET['id'] == "nueva_fila"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'inscripciones_figuras'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment'];

	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td>";
	echo "<td></td>";
	echo "<td>";
	$_GET['id_nadadora'] = "";
	include ("include/nadadora_select_option.php");
	echo "</td><td><input disabled='disabled' type='text' name='orden' id='orden' size='15' value='0'/><td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'>Cancelar</a></td>";
}


//obtengo los inscripciones_figuras con sus datos
$query = "select * from inscripciones_figuras where id='".$_GET['id']."'";
$inscripciones_figuras = mysql_query($query);
while ($inscripcion_figuras = mysql_fetch_array($inscripciones_figuras)){
	$query = "select nombre, apellidos from nadadoras where id = '".$inscripcion_figuras['id_nadadora']."'";
    $nombre_nadadora=mysql_result(mysql_query($query),0,0);
    $apellidos_nadadora=mysql_result(mysql_query($query),0,1);
	$query = "select club from nadadoras where id = '".$inscripcion_figuras['id_nadadora']."'";
    $id_club_nadadora=mysql_result(mysql_query($query),0,0);
	$query = "select nombre_corto from clubs where id = '$id_club_nadadora'";
    $nombre_club=mysql_result(mysql_query($query),0,0);
   	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$inscripcion_figuras['id']."'/></td>";
   	echo "<td><input disabled='disabled' name='id_club' id='id_club' type='text' size='10' value='".$nombre_club."'/></td><td>";
	$_GET['id_nadadora'] = $inscripcion_figuras['id_nadadora'];
	include ("include/nadadora_select_option.php");
	echo"</td><td>".$orden_select_option."<td><a href='javascript:' class='guarda_fila' id='new'>Guardar</a></td><td><a href='javascript:' class='desedita_fila' id='".$inscripcion_figuras['id']."'>Cancelar</a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');

?>
