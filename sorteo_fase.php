<?php 

include('lib/conexion_abre.php');  

$id_fase = $_GET['id_fase'];
if(isset($_GET['desbloquear'])){
    $query = "update fases set sorteado='no' where id='$id_fase'"; 
    mysql_query($query);
    $order_by = " order by orden";	
}else{
    $query = "update fases set sorteado='si' where id='$id_fase'"; 
    mysql_query($query); 
    $order_by = " order by rand()";	
}

    $query = "select * from fases where id='$id_fase'";
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
			$orden_rand = 0;
			$query = "select id, nombre, id_club, orden from rutinas where orden >= '0' and id_fase='$id_fase' $order_by"; 
		    $ordenes = mysql_query($query); 
		    //$corte = floor(mysql_num_rows($ordenes)/4);
		   // if ($corte == 0)
		    //	$corte = 1; 
		    $orden_listado = "";  
		    while ($orden = mysql_fetch_array($ordenes)){
			    $orden_rand++;
			    $query = "select nombre_corto from clubs where id='".$orden['id_club']."'";
			    $nombre_club = mysql_result(mysql_query($query),0);
			    $orden_listado .= "(#".$orden['id']." ".$nombre_club.")  ";
			    $query = "update rutinas set orden='$orden_rand' where id='".$orden['id']."'"; 
			    mysql_query($query);
			}			    
            echo '
                              <section class="panel">
                                  <div class="pro-img-box">
                                      <img src="" alt=""/>
                                      <a id_fase_enlace="'.$fase['id'].'" href="#" class="adtocart '.$clase.'">
                                          <i class="'.$icono.'"></i>
                                      </a>
                                  </div>

                                  <div class="panel-body text-center">
                                      <h4>
                                          <a href="./rutinas.php?id_fase='.$id_fase.'" class="pro-title">
                                              '.$nombre_modalidad." ".$nombre_categoria.'
                                          </a>
                                      </h4>
                                      <p class="price">'.$orden_listado.'</p>
                                  </div>
                              </section>';
		}  
	}
    
include('lib/conexion_cierra.php');  
?>
                
                
                
                         