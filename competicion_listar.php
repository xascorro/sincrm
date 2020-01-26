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
<th>Lugar</th>
<th>Fecha</th>
<th>Organiza</th>
<th>Organizador</th>
<th>Activo</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los competiciones con sus datos
$query = "select * from competiciones";
$competiciones = mysql_query($query); 
while ($competicion = mysql_fetch_array($competiciones)){
	if($competicion['organizador_tipo'] == 'Federación')
		$tabla = "federaciones";
	elseif($competicion['organizador_tipo'] == 'Club')
		$tabla = "clubs";
	if($competicion['activo']=='no')
    	$activo = "<i class='fa fa-toggle-off fa-2x text-danger'></i>";
    else
       	$activo = "<i class='fa fa-toggle-on fa-2x text-success'></i>";
	$query = "select nombre_corto from $tabla where id = '".$competicion['organizador']."'"; 
    $nombre_organizador=mysql_result(mysql_query($query),0);
	echo "<tr id='fila".$competicion['id']."'>";
	echo "<td>".$competicion['id']."</td>";
	echo "<td>".$competicion['nombre']."</td>";
	echo "<td>".$competicion['lugar']."</td>";
	echo "<td>".dateAFecha($competicion['fecha'])."</td>";
	echo "<td>".$competicion['organizador_tipo']."</td>";
	echo "<td>$nombre_organizador</td>";
	echo "<td>".$activo."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$competicion['id']."'>".'<i class="fa fa-edit fa-2x "></i>'."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$competicion['id']."'>".'<i class="fa fa-trash-o fa-2x"></i>'."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
