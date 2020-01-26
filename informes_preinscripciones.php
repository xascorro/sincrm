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
              <section class="rutinas">
	              <div class="text-center feature-head">
                      <h1>Informes para preinscripciones</h1>
                      <p></p>
                  </div>
                  <div class="rutinas-body">

                          <div class="space15"></div>
                          <h2>Preinscripción extricta:</h2><h4>Informe de nadadoras listadas por nombre de club en el que se detectan errores de fecha errónea o número de licencia no númerico. <a target=_blank href="./informes/informe_preinscripciones.php?titulo=Preinscripciones&extricto=si">Generar</a></h4>
                          <h2>Preinscripción:</h2><h4>Informe de nadadoras listadas por nombre de club, no se comprueban posibles errores. <a target=_blank href="./informes/informe_preinscripciones.php?titulo=Preinscripciones&extricto=no">Generar</a></h4>
                          <h2>Rútinas:</h2><h4>Informe de rutinas listadas por fases de la competición y club. <a target=_blank href="./informes/informe_rutinas.php?titulo=Rutinas&musica=no">Generar</a></h4>
                         <!--  <h2>Rútinas:</h2><h4>Informe de rutinas listadas por fases de la competición y club. Incluye la múscia de cada rútina <a target=_blank href="./informes/informe_rutinas.php?titulo=Rutinas&musica=si">Generar</a></h4>-->
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
      <!-- END JAVASCRIPTS -->

  </body>
</html>
