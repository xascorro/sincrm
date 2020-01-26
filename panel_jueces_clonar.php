<?php  
    $id_competicion =  $GLOBALS["id_competicion_activa"];
	echo '<h1>Cierra esta página y actualiza la página de los paneles de jueces</h1>';
include('lib/conexion_abre.php');  
	$query = "select * from panel_jueces where id_panel='".$_GET['id_panel']."' order by numero_juez"; 
    $panel_jueces = mysql_query($query);
    while ($componentes = mysql_fetch_array($panel_jueces)){
		$valores = "";

		$sql = "SELECT id from fases where id_competicion = ".$componentes['id_competicion'].' LIMIT 1,1000';
		$fases_figuras = mysql_query($sql);
		while($fase = mysql_fetch_array($fases_figuras)){
			$valor = '('.$componentes['id_juez'].',';
			$valor .= $componentes['numero_juez'].',';
			$valor .= $componentes['id_panel'].',';
			$valor .= $fase['id'].',';
			$valor .= 'NULL,';
			$valor .= $componentes['id_competicion'].'), ';
			$valores .= $valor;

		}
		$valores = substr($valores, 0, -2);
		
		$sql_final = "INSERT INTO panel_jueces ( id_juez, numero_juez, id_panel, id_fase, id_fase_figuras, id_competicion ) VALUES $valores";
		if(mysql_num_rows(mysql_query('select id_juez from panel_jueces where id_juez='.$componentes['id_juez'].' and id_competicion = '.$id_competicion)) > 1 ) {
			echo '<br>No se clona, borra el contenido del resto de paneles para utilizar está función.<br>'.$sql_final.'<br>';
		}else{
			echo '<br>Ejecuto: '.$sql_final.'<br>';
			mysql_query($sql_final);
		}
  	   }  
include('lib/conexion_cierra.php');  
?>