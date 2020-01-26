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
<th>Club</th>
<th>Licencia</th>
<th>Fecha de nacimiento</th>
<th>Editar</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';

//obtengo los nadadoras con sus datos
$query = "select * from nadadoras";
$nadadoras = mysql_query($query); 
while ($nadadora = mysql_fetch_array($nadadoras)){
	$query = "select nombre_corto from clubs where id = '".$nadadora['club']."'"; 
    $nombre_club=mysql_result(mysql_query($query),0);
	echo "<tr id='fila".$nadadora['id']."'>";
	echo "<td>".$nadadora['id']."</td>";
	echo "<td>".$nadadora['nombre']."</td>";
	echo "<td>".$nadadora['apellidos']."</td>";
	echo "<td>".$nombre_club."</td>";
	echo "<td>".$nadadora['licencia']."</td>";
	echo "<td>".dateAFecha($nadadora['fecha_nacimiento'])."</td>";
	echo "<td><a href='javascript:' class='edita_fila' id='".$nadadora['id']."'>"."Editar"."</a></td>";
	echo "<td><a href='javascript:' class='borra_fila' id='".$nadadora['id']."'>"."Borrar"."</a></td>";
	echo "</tr>";  
}
//cierro tbody y tabla
echo '
</tbody>
</table>'; 


//cierro conexion DB
include('lib/conexion_cierra.php');  
?>
