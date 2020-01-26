<?php  
//abro conexion DB
include('lib/conexion_abre.php');

  

//abro table, creo thead y abro tbody
echo '
<table class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>ID</th>
<th>Número</th>
<th>Nombre</th>
<th>Grado de dificultad</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los paneles con sus datos
$query = "select * from figuras where id_competicion ='0' order by numero";
//$query = "select * from figuras where id_competicion ='".$GLOBALS['id_competicion_activa']."'";
$figuras = mysql_query($query); 
while ($figura = mysql_fetch_array($figuras)){
	echo "<tr id='fila".$figura['id']."'>";
	echo "<td>".$figura['id']."</td>";
	echo "<td>".$figura['numero']."</td>";
	echo "<td>".$figura['nombre']."</td>";
	echo "<td>".$figura['grado_dificultad']."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$figura['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$figura['id']."'>"."Borrar"."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
