<?php
$fase_figuras = $_GET['id_fase_figuras'];

include("./lib/conexion_abre.php");

echo "<div class='col-md-2'>";
include('figura_baja_select_option.php');  
echo "</div>";
echo "<div class='col-md-4'>";
echo "<h2><a href='javascript:' id='baja_figura' id_fase_figuras='$fase_figuras' id_inscripcion_figuras='' ><i class='fa fa-thumbs-down'></i></a> Dar de baja figura</h2>";
echo "</div>";



//abro table, creo thead y abro tbody
echo '
<table id="table-bajas" class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>#</th>
<th>Club</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';



	//leo bajass
    $query = "select * from inscripciones_figuras where id_fase_figuras = '".$_GET['id_fase_figuras']."' and baja='si' order by orden";
    $bajas = mysql_query($query);  

    while ($baja = mysql_fetch_array($bajas)){
    	$query = "select apellidos, nombre from nadadoras where id = '".$baja['id_nadadora']."'";
    	$nombre_nadadora = mysql_result(mysql_query($query),0).", ".mysql_result(mysql_query($query),0,1);
	    $id_inscripcion_figuras=$baja['id'];  
	    $orden=$baja['orden'];
		echo "<thead>
		<tr class='b".$baja['id']."' id='b".$baja['id']."'>
		<th><h5>$orden</h5></th>
		<th><h5>$nombre_nadadora</h5></th>";
		echo "
		<td style='padding:0px; text-align:center; background-color:; vertical-align:middle; font-size:x-large;'><a href='javascript:' class='baja_borrar' id_inscripcion_figuras='$id_inscripcion_figuras'><i class='fa fa-times-circle-o'></i></a></td>
		</tr>
		</thead> ";   

	}

		
    
  
  	   
echo '</tbody></table>';

include('lib/conexion_cierra.php');  
?>
                