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
              <?php include("./state-overview.php"); ?>

             <!-- page start-->
              <section class="panel">
	              <div class="text-center feature-head">
                      <h1><i class="fa fa-xing"></i> Figuras</h1>
                      <p>Añade las figuras</p>
                  </div>
                  <div class="panel-body">
                      <div class="adv-table editable-table ">
                          <div class="clearfix">
                              <div class="btn-group">
                                  <button id="editable-sample_new" class="btn green">
                                      Añadir <i class="icon-plus"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="space15"></div>
                             <?php
                             include ("figuras_listar.php");
                             ?>
                      </div>
                         <div class="clearfix">
                              <div class="btn-group">
                                  <button id="editable-sample_new" class="btn green">
                                      Añadir <i class="icon-plus"></i>
                                  </button>
                              </div>
                          </div>                  </div>
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
    <script src="figura.js"></script>
      <!-- END JAVASCRIPTS -->
      <script>
         /* jQuery(document).ready(function() {
              tipo("<?php echo $_GET['id_tipo'];?>");
          });*/
      </script>
  </body>
</html>
