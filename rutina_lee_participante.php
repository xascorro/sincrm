<?php  
//abro conexion DB
include('lib/conexion_abre.php');


if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'rutinas_participantes'");
	$data = mysql_fetch_assoc($result);
	//$_GET['id'] = $data['Auto_increment']-1;
	$_GET['id'] = $_GET['id_participante'];
$query = "select nombre, apellidos, licencia, fecha_nacimiento, club from nadadoras where id = '".$_GET['id_nadadora']."'"; 
$nombre_nadadora=mysql_result(mysql_query($query),0,1).", ".mysql_result(mysql_query($query),0);
$licencia=mysql_result(mysql_query($query),0,2);
$fecha_nacimiento=mysql_result(mysql_query($query),0,3);
$id_club=mysql_result(mysql_query($query),0,4);
	
	
/*	"<td value=".$_GET['id']."></td><td>".$_GET['id_nadadora']."</td><td>$nombre_nadadora</td><td>$licencia</td><td>$fecha_nacimiento</td><td>".$_GET['reserva']."</td><td><a id_club='".$id_club."' t_r='t' id='".$_GET['id']."' id_participante='".$_GET['id']."' id_rutina='".$_GET['id_rutina']."' class='edit edita_participante' href='javascript:;'>Editar</a></td><td><a <a id_club='".$id_club."' t_r='t' id='".$_GET['id']."' id_participante='".$_GET['id']."' id_rutina='".$_GET['id_rutina']."' class='delete borra_participante' >"."Borrar"."</a></td>";*/
	
echo "<td>".$_GET['id_rutina']."</td><td>".$_GET['id']."</td><td>$nombre_nadadora</td><td>$licencia</td><td>$fecha_nacimiento</td><td>Titular</td><td><a id_club='".$_GET['id_club']."' t_r='t' id='".$_GET['num_fila']."' id_participante='nueva_participante' id_rutina='".$_GET['id_rutina']."' class='edit edita_participante' href='javascript:;'>Editar</a></td><td></td>";	
	
	
}else{
//obtengo los paneles con sus datos
$query = "select nombre, apellidos, licencia, fecha_nacimiento, club from nadadoras where id = '".$_GET['id_nadadora']."'"; 
$nombre_nadadora=mysql_result(mysql_query($query),0,1).", ".mysql_result(mysql_query($query),0);
$licencia=mysql_result(mysql_query($query),0,2);
$fecha_nacimiento=mysql_result(mysql_query($query),0,3);
$id_club=mysql_result(mysql_query($query),0,4);
echo "<td value=".$_GET['id']."></td><td>".$_GET['id_nadadora']."</td><td>$nombre_nadadora</td><td>$licencia</td><td>$fecha_nacimiento</td><td>".$_GET['reserva']."</td><td><a id_club='".$id_club."' t_r='t' id='".$_GET['id']."' id_participante='".$_GET['id']."' id_rutina='".$_GET['id_rutina']."' class='edit edita_participante' href='javascript:;'>Editar</a></td><td><a <a id_club='".$id_club."' t_r='t' id='".$_GET['id']."' id_participante='".$_GET['id']."' id_rutina='".$_GET['id_rutina']."' class='delete borra_participante' >"."Borrar"."</a></td>";
}
//cierro conexion DB
include('lib/conexion_cierra.php'); 

?>
                
                <a id_club="2" t_r="t" id="0" id_participante="nueva_participante" id_rutina="4" class="edit edita_participante" href="javascript:;">Editar</a>
                
                
                
 <a href="javascript:" class="guarda_participante" id="new" t_r="t">Guardar</a>