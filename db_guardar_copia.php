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
              <section class="guardar_copia">
	              <div class="text-center feature-head">
                      <h1><i class="fa fa-save"></i> Guardar</h1>
                      <p>Guarda toda la base de datos en un archivo sql.</p>
                  </div>
                 <h3>Se va a proceder a realizar una copia de la base de datos en un archivo, este archivo puede utilizarse después para volver al estado actual. Por favor, completa el siguiente formulario</h3>
              <section class="panel">
 <?php 
if(isset($_POST['guarda'])){
$descripcion = $_POST['descripcion'];
$host='localhost';
$user='root';
$pass='xas';
$name='sincrm';
$tables='*';

/* backup the db OR just a table */
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	//inlcuimos el comentario para identificar el archivo
	$return = "/*$descripcion*/\n\n";
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return .= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = preg_replace("#\n#", "\\n", $row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";

	}
	
	//save file
	$handle = fopen('db_copia_seguridad/sincrm-backup-'.date('Ymd').'_'.date('Hi').'_'.date('s').'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
echo '<div class="alert alert-success fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="fa fa-times"></i>
                                  </button>
                                  <strong>Bien hecho!</strong> La copia de seguridad se ha realizado correctamente.
                              </div>';
}?> 
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h4 class="modal-title">Guardar DB a archivo</h4>
                                          </div>
                                          <div class="modal-body">

                                              <form role="form" method="POST" action="./db_guardar_copia.php">
                                                  <div class="form-group">
                                                      <label for="descripcion">Descripción</label>
                                                      <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Introduzca una descripción del momento de guardado">
                                                      <input type="hidden" name="guarda" id="guarda" value="si">
                                                  </div>
 
                                                  <button type="submit" class="btn btn-default">Guardar</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                  </section>
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
    <script src="nadadora.js"></script>
      <!-- END JAVASCRIPTS -->

  </body>
</html>
