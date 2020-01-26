<div class="space15"></div>
<?php                          
include('lib/conexion_abre.php');  
    $query = "select * from fases where id_competicion='".$GLOBALS['id_competicion_activa']."'";
    $result = mysql_query($query);  
    if(count($result)>0){
		while ($fase = mysql_fetch_array($result)){
			$query = "select nombre from modalidades where id = '".$fase['id_modalidad']."'"; 
			$nombre_modalidad=mysql_result(mysql_query($query),0);
			$query = "select nombre from categorias where id = '".$fase['id_categoria']."'"; 
			$nombre_categoria=mysql_result(mysql_query($query),0);
			if($fase['puntuada']=='si'){
				echo '<div class="col-md-4" id="'.$fase['id'].'"><h2>'.$nombre_modalidad." ".$nombre_categoria.'<a  target="_blank" href="./informes/informe_puntuaciones.php?titulo=Clasificación detallada&id_fase='.$fase['id'].'">  <i class="fa fa-file-o"></i></a></h2></div>';  
			}else{
				echo '<div class="col-md-4" id="'.$fase['id'].'"><h2>'.$nombre_modalidad." ".$nombre_categoria.'<a  target="_blank" href="./puntuaciones_rutinas.php?id_fase='.$fase['id'].'">  <i class="fa fa-pencil"></i></a></h2></div>';  
				
			}
		}  
	}    
include('lib/conexion_cierra.php');  
?>
<div class="col-md-4"><h2>Memorial:<a target=_blank href="./informes/informe_memorial.php?titulo=Memorial Alfonso J. Aznar"> <i class='fa fa-files-o'></i></a></h2></div>
<div class="col-md-4"><h2>Completo:<a target=_blank href="./informes/informe_puntuaciones.php?titulo=Clasificación detallada&hoja_tecnica=si&memorial=si"> <i class='fa fa-files-o'></i></a></h2></div>
