      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <li>
                      <a class="active" href="index.php">
                          <i class="fa fa-home"></i>
                          <span>Inicio</span>
                      </a>
                  </li>


                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-list-alt"></i>
                          <span>Datos</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="competiciones.php"><i class="fa fa-flag-checkered"></i> Competiciones</a></li>
                          <li><a  href="federaciones.php"><i class="fa fa-flag"></i> Federaciones</a></li>
                          <li><a  href="clubs.php"><i class="fa fa-group"></i> Clubs</a></li>
                          <li><a  href="nadadoras.php"><i class="fa fa-female"></i> Nadadoras</a></li>
                          <li><a  href="jueces.php"><i class="fa fa-legal"></i> Jueces</a></li>
                          <?php
                          if($GLOBALS['competicion_figuras']=='si'){
                          	echo '<li><a  href="figuras.php"><i class="fa fa-xing"></i> Figuras</a></li>';
                          }else{
                          	echo '<li><a  href="modalidades.php"> Modalidades</a></li>';
                          }
                          ?>
                          <li><a  href="jueces.php"><i class="fa fa-image"></i> Imágenes</a></li>
                      </ul>
                  </li>



                  <!--multi level menu start-->
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-flag-checkered"></i>
                          <span>Competición</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="competicion_detalles.php"><i class="fa fa-tag"></i> Detalles competición</a></li>
                          <li><a  href="paneles.php"><i class="fa fa-th-large"></i> Paneles</a></li>
                          <li><a  href="categorias.php"><i class="fa fa-signal"></i> Categorias</a></li>
                              <?php
								include('lib/conexion_abre.php');
								if($GLOBALS['competicion_figuras']=='si'){
									echo '<li><a  href="fases_figuras.php"><i class="fa fa-sitemap"></i> Fases</a></li>';
									echo '<li><a href="paneles_jueces_figuras.php"><i class="fa fa-legal"></i> Paneles de Jueces</a></li>';
									//echo '<li><a href="nadadoras_importar.php">Importación masiva</a></li>';
									echo '<li class="sub-menu">';
									echo '<a  href="#"><i class="fa fa-list-ul"></i> Inscribir figuras</a>';
								    $query = "select * from fases_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."' group by id_categoria";
								    $result = mysql_query($query);
								    if(count($result)>0){
										while ($fase = mysql_fetch_array($result)){
											$query = "select nombre from categorias where id = '".$fase['id_categoria']."'";
											$nombre_categoria=mysql_result(mysql_query($query),0);
											$query = "select numero from figuras where id = '".$fase['id_figura']."'";
											$nombre_figura=mysql_result(mysql_query($query),0);
											echo '<ul class="sub-menu">
											<li class="sub">
											<a  href="./inscripcion_figuras.php?id_fase_figuras='.$fase['id'].'">'.$nombre_categoria." ".'</a></li></ul>';
										}
									}
									echo '</li>
									<li><a  href="sorteos_figuras.php"><i class="fa fa-retweet"></i> Sorteos</a></li>
									</ul>
									</li>';
								}else{
									echo '<li><a  href="fases.php"><i class="fa fa-sitemap"></i> Fases</a></li>';
									echo '<li><a  href="paneles_jueces.php"><i class="fa fa-th-large"></i> Paneles de Jueces</a></li>';
									//echo '<li><a  href="nadadoras_importar.php">NOImportación masiva</a></li>';
									echo '<li class="sub-menu">';
									echo '<a  href="#">Rutinas</a>';
									$query = "select * from fases where id_competicion='".$GLOBALS['id_competicion_activa']."' order by orden";
								    $result = mysql_query($query);
								    if(count($result)>0){
										while ($fase = mysql_fetch_array($result)){
											$query = "select nombre from modalidades where id = '".$fase['id_modalidad']."'";
											$nombre_modalidad=mysql_result(mysql_query($query),0);
											$query = "select nombre from categorias where id = '".$fase['id_categoria']."'";
											$nombre_categoria=mysql_result(mysql_query($query),0);
											echo '<ul class="sub-menu">
											<li class="sub">
											<a  href="./rutinas.php?id_fase='.$fase['id'].'">'.$nombre_modalidad." ".$nombre_categoria.'</a></li></ul>';
										}
									}
									echo '</li>
									<li><a  href="sorteos.php">Sorteos</a></li>
									</ul>
									</li>';
								}

								include('lib/conexion_cierra.php');
								?>


                  <!--multi level menu end-->
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-sort-numeric-asc"></i>
                          <span>Puntuación</span>
                      </a>
                      <ul class="sub">
						<?php
						include('lib/conexion_abre.php');
						if($GLOBALS['competicion_figuras']=='si'){
						$query = "select * from fases_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."' order by orden";
						$result = mysql_query($query);
						if(count($result)>0){
							while ($fase = mysql_fetch_array($result)){
								$query = "select nombre from categorias where id = '".$fase['id_categoria']."'";
								$nombre_categoria=mysql_result(mysql_query($query),0);
								$query = "select numero from figuras where id = '".$fase['id_figura']."'";
								$nombre_figura=mysql_result(mysql_query($query),0);
                $query = "select nombre from figuras where id = '".$fase['id_figura']."'";
								$nombre_figura.="<br>".mysql_result(mysql_query($query),0);
                echo '
								<li class="sub">
								<a  href="./puntuaciones_figuras.php?id_fase_figuras='.$fase['id'].'"><i class="fa fa-calculator"></i>'.$nombre_categoria.' '.$nombre_figura.'</a>
						        </li>';
							}
						}
						}
						else{
						    $query = "select * from fases where id_competicion='".$GLOBALS['id_competicion_activa']."'";
						    $result = mysql_query($query);
						    if(count($result)>0){
								while ($fase = mysql_fetch_array($result)){
									$query = "select nombre from modalidades where id = '".$fase['id_modalidad']."'";
									$nombre_modalidad=mysql_result(mysql_query($query),0);
									$query = "select nombre from categorias where id = '".$fase['id_categoria']."'";
									$nombre_categoria=mysql_result(mysql_query($query),0);
									echo '
									<li class="sub">
									<a  href="./puntuaciones_rutinas.php?id_fase='.$fase['id'].'">'.$nombre_modalidad." ".$nombre_categoria.'</a>
						            </li>';
								}
							}
						}

						include('lib/conexion_cierra.php');
						?>


                          </li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-folder-open-o"></i>
                          <span>Informes</span>
                      </a>
                      <ul class="sub">
						<?php
						include('lib/conexion_abre.php');
						if($GLOBALS['competicion_figuras']=='si'){
							if($GLOBALS['no_federado']=='si'){
								echo '<li><a target="_blank" href="informes/informe_figuras_preinscripciones_escolar.php?titulo=Preinscripciones"><i class="fa fa-edit"></i>Preinscripciones</a></li>
								<li><a target="_blank"  href="informes/orden_salida_figuras_escolar.php?titulo=Orden de salida"><i class="fa fa-sort"></i>Orden de salida</a></li>';
								echo '<li><a  href="informes_figuras_clasificaciones.php"><i class="fa fa-trophy"></i>Clasificaciones</a></li>';

							}else{
								echo '<li><a target="_blank" href="informes/informe_figuras_preinscripciones.php?titulo=Preinscripciones"><i class="fa fa-edit"></i>Preinscripciones</a></li>
								<li><a target="_blank"  href="informes/orden_salida_figuras.php?titulo=Orden de salida"><i class="fa fa-sort"></i>Orden de salida</a></li>';
								echo '<li><a  href="informes_figuras_clasificaciones.php"><i class="fa fa-trophy"></i>Clasificaciones</a></li>';
							}
							echo '<li><i class="fa fa-file-powerpoint-o"></i>HOJAS DE PUNTUACIÓN</li>';
							$query="select distinct id_categoria, nombre from fases_figuras, categorias where fases_figuras.id_categoria = categorias.id and fases_figuras.id_competicion = '".$GLOBALS['id_competicion_activa']."'";
							$categorias = mysql_query($query);
							while($categoria = mysql_fetch_array($categorias)){
								echo '<li><a target="_blank" href="informes/hojas_puntuacion_figuras.php?id_categoria='.$categoria['id_categoria'].'">Categoría '.$categoria['nombre'].'</a></li>';
								//echo '<li><a  href="hojas_puntuacion.php?id_categoria='.$categoria['id_categoria'].'"><i class="fa fa-file-powerpoint-o"></i>Hojas '.$categoria['nombre'].'</a></li>'
							}
						}else{
							echo '<li><a  href="informes_preinscripciones.php"><i class="fa fa-edit"></i>Preinscripciones</a></li>
							<li><a  href="informes_tiempos.php"><i class="fa fa-clock-o"></i>Tiempos</a></li>
							<li><a  href="informes_orden_salida.php"><i class="fa fa-sort"></i>Orden de salida</a></li>
							<li><a  href="informes_clasificaciones.php"><i class="fa fa-trophy"></i>Clasificaciones</a></li>';

						}
						?>
                      </ul>
                  </li>

                   <li class="sub-menu">
                      <a href="javascript:;" >
                          <span><i class="fa fa-database"></i>
                          Base de datos</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="db_cargar_copia.php"><i class="fa fa-th"></i> Cargar</a></li>
                          <li><a  href="db_guardar_copia.php"><i class="fa fa-save"></i> Guardar</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-dashboard"></i>
                          <span>Sistema</span>
                      </a>
                      <ul class="sub">
                      <li><a href="documentation/"><i class="fa fa-question-circle"></i> Ayuda</a></li>
                      <li><a href="actualizador.php"><i class="fa fa-spinner"></i> Actualizar</a></li>
                      <li><a href="actualizador_magic.php"><i class="fa fa-circle-o-notch"></i> Generar actualización</a></li>
                      <li><a href="configurador.php"><i class="fa fa-gears"></i> Configurar</a></li>
                      <li><a href="changelog.php"><i class="fa fa-file-text-o"></i> Changelog</a></li>
                      <li><a href="about.php"><i class="fa fa-info-circle"></i> About</a></li>
                      </ul>
                  </li>


              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
