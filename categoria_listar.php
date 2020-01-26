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
<th>Edad mínima</th>
<th>Edad máxima</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los paneles con sus datos
$query = "select * from categorias where id_competicion ='".$GLOBALS['id_competicion_activa']."'";
$paneles = mysql_query($query); 
while ($panel = mysql_fetch_array($paneles)){
	echo "<tr id='fila".$panel['id']."'>";
	echo "<td>".$panel['id']."</td>";
	echo "<td>".$panel['nombre']."</td>";
	echo "<td>".$panel['edad_desde']."</td>";
	echo "<td>".$panel['edad_hasta']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$panel['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$panel['id']."'>"."Borrar"."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
