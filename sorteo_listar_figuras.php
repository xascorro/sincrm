<?php 

include('lib/conexion_abre.php');  

    $query = "select * from fases_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."' group by id_categoria";
    $result = mysql_query($query);  
    if(count($result)>0){
		while ($fase = mysql_fetch_array($result)){
			$query = "select nombre from categorias where id = '".$fase['id_categoria']."'"; 
			$nombre_categoria=mysql_result(mysql_query($query),0);
			
			if($fase['sorteado'] == 'si'){
				$clase = 'bloqueado';
				$icono = "fa fa-lock";
			}else{
				$clase = 'random';
				$icono = "fa fa-random";
			}
			$query = "select id, orden, id_nadadora from inscripciones_figuras where id_fase_figuras='".$fase['id']."' order by orden, id"; 
		    $ordenes = mysql_query($query);  
		    $corte = floor(mysql_num_rows($ordenes)/4);
		    if ($corte == 0)
		    	$corte = 1;
		    $orden_listado = "";  
		    while ($orden = mysql_fetch_array($ordenes)){
		    	if($orden['id_nadadora']!=""){
		    		$nombre_nadadora = mysql_result(mysql_query("select apellidos from nadadoras where id = ".$orden['id_nadadora'].""),0);
		    		$nombre_nadadora .= ", ".mysql_result(mysql_query("select nombre from nadadoras where id = ".$orden['id_nadadora'].""),0);
			    	$orden_listado .= "(".$nombre_nadadora.")";
			    }else{
			    	$query = "select nombre_corto from clubs where id = '".$orden['id_club']."'"; 
			    	$nombre_club=mysql_result(mysql_query($query),0);
			    	$orden_listado .= "(#".$orden['id']." ".$nombre_club.")  ";
			    }
		    }			    
            echo '
             <div class="col-md-4" id="'.$fase['id'].'">
                              <section class="panel">
                                  <div class="pro-img-box">
                                      <img src="" alt=""/>
                                      <a id_fase_figuras_enlace="'.$fase['id'].'" href="#" class="adtocart '.$clase.'">
                                          <i class="'.$icono.'"></i>
                                      </a>
                                  </div>

                                  <div class="panel-body text-center">
                                      <h4>
                                          <a href="./inscripcion_figuras.php?id_fase_figuras='.$fase['id'].'" class="pro-title">
                                              '.$nombre_categoria.'
                                          </a>
                                      </h4>
                                      <p class="price">'.$orden_listado.'</p>Corte <input id="corte'.$fase['id'].'" type="text" size="2" value="'.$corte.'">
                                  </div>
                              </section>
                          </div>';
		}  
	}
    
include('lib/conexion_cierra.php');  
?>
                
                
                
                         