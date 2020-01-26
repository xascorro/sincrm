<?php
$fase = $_GET['id_fase'];

include("./lib/conexion_abre.php");

echo "<div class='col-md-2'>";
include('rutina_baja_select_option.php');  
echo "</div>";
echo "<div class='col-md-4'>";
echo "<h2><a href='javascript:' id='baja_rutina' id_fase='$fase' id_rutina='' ><i class='fa fa-thumbs-down'></i></a> Dar de baja rutina</h2>";
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



	//leo penalizaciones
    $query = "select * from rutinas where id_fase = '".$_GET['id_fase']."' and baja='si' order by orden";
    $bajas = mysql_query($query);  

    while ($baja = mysql_fetch_array($bajas)){
    	$query = "select nombre_corto from clubs where id = '".$baja['id_club']."'";
    	$nombre_club = mysql_result(mysql_query($query),0);
	    $id_rutina=$baja['id'];  
	    $orden=$baja['orden'];
		echo "<thead>
		<tr class='b".$baja['id']."' id='b".$baja['id']."'>
		<th><h5>$orden</h5></th>
		<th><h5>$nombre_club</h5></th>";
		echo "
		<td style='padding:0px; text-align:center; background-color:; vertical-align:middle; font-size:x-large;'><a href='javascript:' class='baja_borrar' id_rutina='$id_rutina'><i class='fa fa-times-circle-o'></i></a></td>
		</tr>
		</thead> ";   

	}

		
    
  
  	   
echo '</tbody></table>';

include('lib/conexion_cierra.php');  
?>
                