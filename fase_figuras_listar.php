<?php  
//abro conexion DB
include('lib/conexion_abre.php');

  

//abro table, creo thead y abro tbody
echo '
<table class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>ID</th>
<th>Categoria</th>
<th>Figura</th>
<th>Orden</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los fases con sus datos
$query = "select * from fases_figuras where id_competicion ='".$GLOBALS['id_competicion_activa']."' order by orden, id";
$fases = mysql_query($query); 
while ($fase = mysql_fetch_array($fases)){
	echo "<tr id='fila".$fase['id']."'>";
	echo "<td>".$fase['id']."</td>";
	//saco nombre categoria
	$r = mysql_query("SELECT nombre FROM categorias where id='".$fase['id_categoria']."'");
	echo "<td>".mysql_result($r,0)."</td>";
	//saco numero figura
	$r = mysql_query("SELECT numero FROM figuras where id='".$fase['id_figura']."'");
	$re = mysql_query("SELECT nombre FROM figuras where id='".$fase['id_figura']."'");
	echo "<td>".mysql_result($r,0)." - ".mysql_result($re,0)."</td>";
	echo "<td>".$fase['orden']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$fase['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$fase['id']."'>"."Borrar"."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
