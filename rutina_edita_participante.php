<?php
//abro conexion DB
include('lib/conexion_abre.php');

if(isset($_GET['id_participante']) && $_GET['id_participante'] == "nueva_participante"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'rutinas'");
	$data = mysql_fetch_assoc($result);
	$id = $_GET['id'];
	if($_GET['t_r'] == 't')
		$t_r = "Titular";
	if($_GET['t_r'] == 'r')
		$t_r = "Reserva";
	echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id_rutina']."'/></td>
	<td></td>
	<td colspan=3'>";
	$_GET['id_nadadora'] = "";
	include ("include/nadadora_select_option.php");
/*	echo "</td>
	<td><input disabled='disabled' type='text' name='licencia' id='licencia' size='0' value=''/></td>
	<td><input disabled='disabled' type='text' name='fecha_nacimiento' id='fecha_nacimiento' size='0' value=''/></td>
	<td><input disabled='disabled' type='text' name='reserva' id='reserva' size='0' value='$t_r'/></td>
	<td><a href='javascript:' class='guarda_participante' id='$id' t_r='".$_GET['t_r']."'>Guardar</a></td>
	<td><a href='javascript:' class='cancela_nueva_participante' id='new'>Cancelar</a></td>";*/
	echo "</td>

	<td><input disabled='disabled' type='text' name='reserva' id='reserva' size='0' value='$t_r'/></td>
	<td><a href='javascript:' class='guarda_participante' num_fila='".$_GET['num_fila']."' id='new' t_r='".$_GET['t_r']."'>Guardar</a></td>
	<td><a href='javascript:' class='cancela_nueva_participante' id_club='".$_GET['id_club']."' num_fila='".$_GET['num_fila']."' id='new' t_r='".$_GET['t_r']."'>Cancelar</a></td>";
}else{


	//obtengo la rutina participante con sus datos
	$query = "select * from rutinas_participantes where id='".$_GET['id']."'";
	$rutinas_participantes = mysql_query($query);
	while ($rutina_participante = mysql_fetch_array($rutinas_participantes)){
		if($rutina_participante['reserva'] == 'no'){
			$t_r_text = "Titular";
			$t_r = 't';
		}if($rutina_participante['reserva'] == 'si'){
			$t_r_text = "Reserva";
			$t_r = 'r';
		}
		echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id_rutina']."'/></td>
		<td></td>
		<td colspan=3>";
		$_GET['id_nadadora'] = $rutina_participante['id_nadadora'];
		include ("include/nadadora_select_option.php");
		echo "</td>
		<td><input disabled='disabled' type='text' name='reserva' id='reserva' size='0' value='$t_r_text'/></td>
		<td><a href='javascript:' class='guarda_participante' id='".$rutina_participante['id']."' t_r='$t_r'>Guardar</a></td>
		<td><a href='javascript:' class='cancela_nueva_participante' id='".$rutina_participante['id']."' t_r='$t_r'>Cancelar</a></td>";
	}
}
//cierro conexion DB
include('lib/conexion_cierra.php');

?>
