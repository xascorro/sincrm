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
              <?php //include("./inscripcion_state-overview.php"); ?>

             <!-- page start-->
              <section class="rutinas">
	              <div class="text-center feature-head">
                      <h1>Sorteos</h1>
                      <p>Sortea el orden de salida de las distintas fases.</p>
                  </div>
                  <div class="rutinas-body">
                      <div class="adv-table editable-table ">
                          <div class="space15"></div>
                            <div class="row product-list">

                             <?php
                             include ("sorteo_listar.php");
                             ?>
                      </div>
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
    <script src="sorteo.js"></script>
      <!-- END JAVASCRIPTS -->

  </body>
</html>
