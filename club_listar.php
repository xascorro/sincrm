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
<th>Federación</th>
<th>Logo</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los clubs con sus datos
$query = "select * from clubs";
$clubs = mysql_query($query); 
while ($club = mysql_fetch_array($clubs)){
	$query = "select nombre_corto from federaciones where id = '".$club['federacion']."'"; 
    $nombre_federacion=mysql_result(mysql_query($query),0);
	echo "<tr id='fila".$club['id']."'>";
	echo "<td>".$club['id']."</td>";
	echo "<td>".$club['nombre']."</td>";
	echo "<td>".$club['nombre_corto']."</td>";
	echo "<td>".$club['codigo']."</td>";
	echo "<td>$nombre_federacion</td>";
	echo "<td><img style='max-width:100px; max-height:100px' src='".$club['logo']."' alt='images/logo_cnlorga.jpg' class='img-thumbnail'></td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$club['id']."'>"."<i class='fa fa-edit fa-2x'></i>"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$club['id']."'>"."<i class='fa fa-trash fa-2x'></i>"."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
