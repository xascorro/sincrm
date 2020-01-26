<?php 
include("competicion_activa_lee_nombre_id.php");

include('lib/conexion_abre.php');  
$id_fase_figuras = $_GET['id_fase_figuras'];
if(isset($_GET['corte']))
	$corte = $_GET['corte'];
if(isset($_GET['desbloquear'])){
    $query = "update fases_figuras set sorteado='no' where id='$id_fase_figuras'"; 
    mysql_query($query);
    $order_by = " order by orden";	
}else{
    $query = "update fases_figuras set sorteado='si' where id='$id_fase_figuras'"; 
    mysql_query($query); 
    $order_by = " order by rand()";	
}

    $query = "select * from fases_figuras where id='$id_fase_figuras'";
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
			$orden_rand = 0;
			$query = "select * from inscripciones_figuras where orden >= '0' and id_fase_figuras='$id_fase_figuras' $order_by"; 
		    $ordenes = mysql_query($query);  
		    $orden_listado = "";  
		    while ($orden = mysql_fetch_array($ordenes)){
			    $orden_rand++;
			    $query = "select apellidos from nadadoras where id='".$orden['id_nadadora']."'";
		    	$nombre_nadadora = mysql_result(mysql_query("select apellidos from nadadoras where id = ".$orden['id_nadadora'].""),0);
		    	$nombre_nadadora .= ", ".mysql_result(mysql_query("select nombre from nadadoras where id = ".$orden['id_nadadora'].""),0);
		    	$orden_listado .= "(#".$orden['id']." ".$nombre_nadadora.")  ";
			    $query = "update inscripciones_figuras set orden='$orden_rand' where id='".$orden['id']."'"; 
			    mysql_query($query);
			    
			    $query = "select * from inscripciones_figuras where id_competicion = '".$GLOBALS["id_competicion_activa"]."' and id_nadadora = '".$orden['id_nadadora']."'";
			    $salidas_nadadora = mysql_query($query);
			    $i = 0;
			    while ($salida_nadadora = mysql_fetch_array($salidas_nadadora)){
				    //if($i > 0){
				    	$orden_maximo = mysql_result(mysql_query("select count(id) from inscripciones_figuras where id_fase_figuras='$id_fase_figuras' and orden >= 0"),0);
				    	//echo $orden_maximo;
					    $orden_corte = $orden_rand-($i*$corte);
					    if($orden_corte < 0)
					    	$orden_corte += $orden_maximo;
					    if($orden_corte == 0)
					    	$orden_corte = $orden_maximo;
					    $query = "update inscripciones_figuras set orden='$orden_corte' where id='".$salida_nadadora['id']."'";
					    //echo "<br>".$query;
					    mysql_query($query);
				    //}
				    $i++;
			    }
			}
            echo '
                              <section class="panel">
                                  <div class="pro-img-box">
                                      <img src="" alt=""/>
                                      <a id_fase_figuras_enlace="'.$fase['id'].'" href="#" class="adtocart '.$clase.'">
                                          <i class="'.$icono.'"></i>
                                      </a>
                                  </div>

                                  <div class="panel-body text-center">
                                      <h4>
                                          <a href="./rutinas.php?id_fase_figuras='.$id_fase_figuras.'" class="pro-title">
                                              ' .$nombre_categoria.'
                                          </a>
                                      </h4>
                                      <p class="price">'.$orden_listado.'</p>Corte <input id="corte'.$fase['id'].'" type="text" size="2" value="'.$corte.'.">
                                  </div>
                              </section>';
		}  
	}
    
include('lib/conexion_cierra.php');  
?>
                
                
                
                         