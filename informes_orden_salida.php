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
                          <h2>Orden de salida:</h2><h4>Informe con las rutinas listadas por orden de salida. <a target=_blank href="./informes/informe_rutinas.php?titulo=Orden de salida&musica=no">Generar</a></h4>
                          <h2>Orden de salida con músicas:</h2><h4>Informe con las rutinas listadas por orden de salida, incluye la música de cada rútina. <a target=_blank href="./informes/informe_rutinas.php?titulo=Orden de salida&musica=si">Generar</a></h4>
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
