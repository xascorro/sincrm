<?php
$fase = $_GET['id_fase'];

include("./lib/conexion_abre.php");

echo "<div class='col-md-2'>";
include('rutina_penaliza_select_option.php');  
echo "</div>";
echo "<div class='col-md-2'>";
include('penalizacion_select_option.php');  
echo "</div>";
echo "<div class='col-md-4'>";
echo "<h2><a href='javascript:' id='penaliza_rutina' id_fase='$fase' id_rutina='' id_penalizacion=''><i class='fa fa-exclamation-circle'></i></a> Penalizar rutina</h2>";
echo "</div>";



//abro table, creo thead y abro tbody
echo '
<table id="table-penalizaciones" class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>#</th>
<th>Club</th>
<th style="text-align:center;">Código</th>
<th style="text-align:center;">Descripción</th>
<th>Puntos</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';



	//leo penalizaciones
    $query = "select * from penalizaciones_rutinas where id_rutina in (select id from rutinas where id_fase = '".$_GET['id_fase']."') order by id_rutina";
    $penalizaciones = mysql_query($query);  

    while ($penalizacion = mysql_fetch_array($penalizaciones)){
    	$query = "select nombre_corto from clubs where id in (select id_club from rutinas where id = '".$penalizacion['id_rutina']."')"; 
	    $nombre_club=mysql_result(mysql_query($query),0);
	    $id_rutina=$penalizacion['id_rutina'];  
	    $query = "select orden from rutinas where id = '".$id_rutina."'";
	    $orden=mysql_result(mysql_query($query),0);
		echo "<thead>
		<tr class='p".$penalizacion['id']."' id='p".$penalizacion['id']."'>
		<th><h5>$orden</h5></th>
		<th><h5>$nombre_club</h5></th>";
		$query = "select codigo, descripcion, puntos from penalizaciones where id = '".$penalizacion['id_penalizacion']."'"; 
	    $codigo_penalizacion=mysql_result(mysql_query($query),0);
	    $descripcion_penalizacion=mysql_result(mysql_query($query),0,1);
	    $puntos_penalizacion=mysql_result(mysql_query($query),0,2);
	    echo "
		<th><h5>".$codigo_penalizacion."</h5></th>
		<th>".$descripcion_penalizacion."</th>
		<th><h5>".$puntos_penalizacion."</h5></th>";
		echo "
		<td style='padding:0px; text-align:center; background-color:; vertical-align:middle; font-size:x-large;'><a href='javascript:' class='penalizacion_borrar' id_rutina='$id_rutina' id_penalizacion='".$penalizacion['id']."'><i class='fa fa-times-circle-o'></i></a></td>
		</tr>
		</thead> ";   


	   	}

		
    
  
  	   
echo '</tbody></table>';

include('lib/conexion_cierra.php');  
?>
                