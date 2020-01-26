<?php  
//abro conexion DB
include('./lib/conexion_abre.php');
  
if($_GET['id'] == "new"){
	$result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'fases_figuras'");
	$data = mysql_fetch_assoc($result);
	$_GET['id'] = $data['Auto_increment']-1;
}
//obtengo los paneles con sus datos
echo "<td value='".$_GET['id']."'>".$_GET['id']."</td>";
//saco nombre modalidad
$r = mysql_query("SELECT nombre FROM categorias where id='".$_GET['id_categoria']."'");
echo "<td>".mysql_result($r,0)."</td>";
//saco nombre categoria
$r = mysql_query("SELECT numero FROM figuras where id='".$_GET['id_figura']."'");
$re = mysql_query("SELECT nombre FROM figuras where id='".$_GET['id_figura']."'");
echo "<td>".mysql_result($r,0)." - ".mysql_result($re,0)."</td>";
echo "<td value=''>".$_GET['orden']."</td>";
echo "<td><a href='javascript:' class='edita_fila' id='".$_GET['id']."'>Editar</a></td><td><a href='javascript:' class='borra_fila' id='".$_GET['id']."'>Borrar</a></td>";

//cierro conexion DB
include('./lib/conexion_cierra.php'); 

?>
                
                