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
<th>Número de Jueces</th>
<th>% Peso Nota</th>
<th>Descripción</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los paneles con sus datos
$query = "select * from paneles where id_competicion = '".$GLOBALS['id_competicion_activa']."'";
$paneles = mysql_query($query); 
while ($panel = mysql_fetch_array($paneles)){
	echo "<tr id='fila".$panel['id']."'>";
	echo "<td>".$panel['id']."</td>";
	echo "<td>".$panel['nombre']."</td>";
	echo "<td>".$panel['numero_jueces']."</td>";
	echo "<td>".$panel['peso']."</td>";
	echo "<td>".$panel['descripcion']."</td>";
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
