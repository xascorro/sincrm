<?php 

include('lib/conexion_abre.php');  

    $query = "select * from fases where id_competicion='1'";
    $result = mysql_query($query); 
     
    if(count($result)>0){
		while ($fase = mysql_fetch_array($result)){
			$query = "select nombre from modalidades where id = '".$fase['id_modalidad']."'"; 
			$nombre_modalidad=mysql_result(mysql_query($query),0);
			$query = "select nombre from categorias where id = '".$fase['id_categoria']."'"; 
			$nombre_categoria=mysql_result(mysql_query($query),0);
			
			if($fase['sorteado'] == 'si'){
				$clase = 'bloqueado';
				$icono = "fa fa-lock";
			}else{
				$clase = 'random';
				$icono = "fa fa-random";
			}
			$query = "select nombre, orden from rutinas where id_fase='".$fase['id']."' order by orden, id"; 
		    $ordenes = mysql_query($query);  
		    $corte = floor(mysql_num_rows($ordenes)/4);
		    if ($corte == 0)
		    	$corte = 1;
		    $orden_listado = "";  
		    while ($orden = mysql_fetch_array($ordenes)){
			    $orden_listado .= "(".$orden['nombre'].")";
		    }			    
            echo '
             <div class="col-md-4" id="'.$fase['id'].'">
                              <section class="panel">
                                  <div class="pro-img-box">
                                      <img src="" alt=""/>
                                      <a id_fase_enlace="'.$fase['id'].'" href="#" class="adtocart '.$clase.'">
                                          <i class="'.$icono.'"></i>
                                      </a>
                                  </div>

                                  <div class="panel-body text-center">
                                      <h4>
                                          <a href="#" class="pro-title">
                                              '.$nombre_modalidad." ".$nombre_categoria.'
                                          </a>
                                      </h4>
                                      <p class="price">'.$orden_listado.'</p>Corte <input id="corte'.$fase['id'].'" type="text" size="2" value="'.$corte.'l">
                                  </div>
                              </section>
                          </div>';
		}  
	}
    
include('lib/conexion_cierra.php');  
?>
                
                
                
                         