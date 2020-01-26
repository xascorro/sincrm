<?php  
include('lib/conexion_abre.php');  

	$query = "select * from fases_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."' order by orden";  
    $fases = mysql_query($query);
        $clona = true;

    while ($fase = mysql_fetch_array($fases)){
		$id_categoria=$fase['id_categoria'];
		$query="select nombre from categorias where id = '".$id_categoria."'";
		$categoria=mysql_result(mysql_query($query),0);
		$id_figura=$fase['id_figura'];
		$query="select numero from figuras where id = '".$id_figura."'";
		$figura=mysql_result(mysql_query($query),0);		
		echo "<div class='border-head'>
                <h1>$categoria $figura</h1>";              
        $query = "select * from paneles where id_competicion='".$GLOBALS['id_competicion_activa']."' and puntua = 'si'";
        $paneles = mysql_query($query);
        while ($panel = mysql_fetch_array($paneles)){
			//abro tabla con jueces modalidad, creo thead y abro tbody
			echo '<div class="col-lg-12">

			<table class="table table-striped table-hover table-bordered" id="editable-sample">
			<thead>
			<tr>
			<th colspan="3"><h2>'.$panel['nombre'];
			if ($clona) {
				echo ' <a target="_blank" href="panel_jueces_figuras_clonar.php?id_panel='.$panel['id'].'">Clonar panel</a>';
				$clona = false;
				}
			echo '</h2></th></tr>
			</thead>
			<tbody id="tbody">';
			//saco jueces con nombre modalidad
			$numero_jueces_panel = $panel['numero_jueces'];
			$conteo_juez = 1;
			while ($conteo_juez <= $numero_jueces_panel){

				$query="select id, id_juez from panel_jueces where id_fase_figuras = '".$fase['id']."' and id_panel = '".$panel['id']."' and numero_juez = '".$conteo_juez."'";
				$id_panel_jueces=@mysql_result(mysql_query($query),0,0);
				$id_juez=@mysql_result(mysql_query($query),0,1);

				$query="select nombre, apellidos from jueces where id ='$id_juez'";

				$nombre_juez=@mysql_result(mysql_query($query),0,0)." ".@mysql_result(mysql_query($query),0,1);

				echo '<tr id="fila_'.$conteo_juez.'_panel_'.$panel['id'].'_fase'.$fase['id'].'"><td>'.$conteo_juez.'</td>';
				echo '<td>'.$nombre_juez.'</td>';
				echo '<td><a class="edita_fila" id_panel_jueces="'.$id_panel_jueces.'" fase="'.$fase['id'].'" panel="'.$panel['id'].'" fila="'.$conteo_juez.'" id_juez="'.$id_juez.'" href="javascript:"><i class="fa fa-edit fa-2x "></i></a></td></tr>';
				
				//paso al juez siguiente
				$conteo_juez++;		
			}	
			//cierro tabla con jueces modalidad
			echo '</tbody></table></div>';
			}
        
        echo "</div>";
  	   }  
  	   
include('lib/conexion_cierra.php');  
?>
                