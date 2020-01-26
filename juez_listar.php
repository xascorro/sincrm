<?php  
//abro conexion DB
include('lib/conexion_abre.php');

  

//abro table, creo thead y abro tbody
echo '
<table class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Apellidos</th>
<th>Federación</th>
<th>Licencia</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los jueces con sus datos
$query = "select * from jueces";
$jueces = mysql_query($query); 
while ($juez = mysql_fetch_array($jueces)){
	$query = "select nombre_corto from federaciones where id = '".$juez['federacion']."'"; 
    $nombre_federacion=mysql_result(mysql_query($query),0);
	echo "<tr id='fila".$juez['id']."'>";
	echo "<td>".$juez['id']."</td>";
	echo "<td>".$juez['nombre']."</td>";
	echo "<td>".$juez['apellidos']."</td>";
	echo "<td>".$nombre_federacion."</td>";
	echo "<td>".$juez['licencia']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$juez['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$juez['id']."'>"."Borrar"."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
