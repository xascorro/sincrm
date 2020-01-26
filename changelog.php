<!DOCTYPE html>
<html lang="en">
  <?php include("./head.php");
  //parse texto en formato markdown
  include ('./parsedown.php');
  include ('./parsedownExtra.php');
   ?>

  <body>
  <section id="container" >

<?php include ("./header.php"); ?>
 <?php include ("./sidebar.php"); ?>
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <?php include("./inscripcion_state-overview.php"); ?>

             <!-- page start-->
              <section class="actualizador">
	              <div class="text-center feature-head">
                      <h1><i class="fa fa-file-text-o"></i> CHANGELOG</h1>
                      <p>Lista de cambios en SINCRM</p>
                  </div>
                  <div class="actualizador-body">
<?
	
		$archivo = file_get_contents('about/changelog.txt'); //Guardamos archivo.txt en $archivo
		$archivo = ucfirst($archivo); //Le damos un poco de formato
		$archivo = nl2br($archivo); //Transforma todos los saltos de linea en tag <br/>
		$ParsedownExtra = new ParsedownExtra();
		$ParsedownExtra->setBreaksEnabled(false);
		echo '<div class="alert alert-info">'.$ParsedownExtra->text($archivo).'</div>';

?>
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
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

      <!--script for this page only-->
      <!-- END JAVASCRIPTS -->

  </body>
</html>
