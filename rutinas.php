<!DOCTYPE html>
<html lang="en">
  <?php include("./head.php"); ?>

  <body>
  <section id="container" >

<?php include ("./header.php"); ?>
 <?php include ("./sidebar.php"); ?>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <?php include("./inscripcion_state-overview.php"); ?>

             <!-- page start-->
                  <?php
                  //obtengo la modalidad y la categoria de la fase
                  	include("./lib/conexion_abre.php"); 
					$query="select id_modalidad, id_categoria from fases where id = '".$_GET["id_fase"]."'";
					$id_modalidad=mysql_result(mysql_query($query),0);
					$id_categoria=mysql_result(mysql_query($query),0,1);
					$_GET['id_modalidad'] = $id_modalidad;
					$_GET['id_categoria'] = $id_categoria;
					
					$query="select nombre from modalidades where id = '".$id_modalidad."'";
					$modalidad=mysql_result(mysql_query($query),0);
					$query="select nombre from categorias where id = '".$id_categoria."'";
					$categoria=mysql_result(mysql_query($query),0);
                  
                   ?>
              <section class="rutinas">
	              <div class="text-center feature-head">
                      <h1>Rutinas <?php echo $modalidad." ".$categoria; ?></h1>
                      <p>Crea y configura los Rutinas.</p>
                  </div>
                  <div class="rutinas-body">
                      <div class="adv-table editable-table ">
                          <div class="clearfix">
                              <div class="btn-group">
                                  <button id="editable-sample_new" class="btn green">
                                      Añadir <i class="icon-plus"></i>
                                  </button>
                              </div>
                              <div class="btn-group pull-right">
                                  <button class="btn dropdown-toggle" data-toggle="dropdown">Herramientas <i class="icon-angle-down"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-right">
                                      <li><a href="#">Imprimir</a></li>
                                      <li><a href="#">Guardar como PDF</a></li>
                                      <li><a href="#">Exportar a Excel</a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="space15"></div>
                             <?php
                             include ("rutina_listar.php");
                             ?>
                      </div>
                                                    <div class="btn-group">
                                  <button id="editable-sample_new" class="btn green">
                                      Añadir <i class="icon-plus"></i>
                                  </button>
                              </div>
                  </div>
              </section>
              <!-- page end-->

          </section>
      </section>
      <!--main content end-->
<?php include ("./footer.php");?>

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
     <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

      <!--script for this page only-->
    <script src="rutina.js"></script>
    <script src="rutina_participante.js"></script>
      <!-- END JAVASCRIPTS -->

  </body>
</html>
