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
<th>Nombre corto</th>
<th>Código</th>
<th>Comunidad</th>
<th>logo</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los federaciones con sus datos
$query = "select * from federaciones";
$federaciones = mysql_query($query); 
while ($federacion = mysql_fetch_array($federaciones)){
	echo "<tr id='fila".$federacion['id']."'>";
	echo "<td>".$federacion['id']."</td>";
	echo "<td>".$federacion['nombre']."</td>";
	echo "<td>".$federacion['nombre_corto']."</td>";
	echo "<td>".$federacion['codigo']."</td>";
	echo "<td>".$federacion['comunidad']."</td>";
	echo "<td><img style='max-width:100px; max-height:100px' src='".$federacion['logo']."' alt='...' class='img-thumbnail'></td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$federacion['id']."'>"."<i class='fa fa-edit fa-2x '></i>"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$federacion['id']."'>"."<i class='fa fa-trash fa-2x '></i>"."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
