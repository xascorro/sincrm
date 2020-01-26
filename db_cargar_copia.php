<!DOCTYPE html>
<html lang="en">
  <?php include("./head.php");  ?>

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
                      <h1><i class="fa fa-th"></i> Cargar</h1>
                      <p>Carga la base de datos con los valores almacenados en un archivo sql.</p>
                  </div>
                 
              <section class="panel">
              <h3>Desde aquí puedes gestionar los diferentes archivos que contienen la base de datos. Selecciona el que quieres cargar a la base de datos, descargar a tu equipo o eliminar del siguiente listado.</h3>
<?php 
if(isset($_POST['adjuntar'])){
	$uploaddir = './db_copia_seguridad/';
	$tipo = $_FILES['archivo']['type'];
	$tamano = $_FILES['archivo']['size'];
	$nombre = $_FILES['archivo']['name'];
	$ext_permitidas = array('sql');
	$partes_nombre = explode('.', $nombre);
	$extension = end( $partes_nombre );
	$ext_correcta = in_array($extension, $ext_permitidas);
	$tipo_correcto = preg_match('/^text\/(x-sql)$/', $tipo);
	$limite = 2000 * 1024;
	
	if( $ext_correcta && $tipo_correcto && $tamano <= $limite ){
		echo "sisisis";
	}else{
		echo "nononon";
	}
	$uploadfile = $uploaddir . basename($_FILES['archivo']['name']);
	if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){
		echo '<div class="alert alert-success fade in">
             <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
             <strong>Bien hecho!</strong> El archivo se ha adjuntado satisfactoriamente.</div>';
	} else{
		echo '<div class="alert alert-danger fade in">
             <button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
             <strong>Error!</strong> Ha habido un error al adjuntar el archivo.</div>';	}
}

if(isset($_GET['borrar'])){
	unlink($_GET['archivo']);
}

if(isset($_GET['restaurar'])){
/*
 * Restore MySQL dump using PHP
 * (c) 2006 Daniel15
 * Last Update: 9th December 2006
 * Version: 0.2
 * Edited: Cleaned up the code a bit. 
 *
 * Please feel free to use any part of this, but please give me some credit :-)
 */  
// Name of the archivo
$archivo = $_GET['archivo'];
// MySQL host
$mysql_host = 'localhost';
// MySQL username
$mysql_username = 'root';
// MySQL password
$mysql_password = 'xas';
// Database name
$mysql_database = 'sincrm';
 
//////////////////////////////////////////////////////////////////////////////////////////////
 
// Connect to MySQL server
mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
 
// Temporary variable, used to store current query
$templine = '';
// Read in entire archivo
$lines = file($archivo);
// Loop through each line
foreach ($lines as $line)
{
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;
 
    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        // Perform the query
        mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
        // Reset temp variable to empty
        $templine = '';
    }
}
	echo '<div class="alert alert-success fade in">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="fa fa-times"></i>
                                  </button>
                                  <strong>Bien hecho!</strong> Los datos de SINCRM han sido remplazados con los que has seleccionado.
                              </div>';
}?> 

<?php


$ruta = "./db_copia_seguridad/";              // indico la ruta de donde se extraerán los txt
 
$archivohandle = opendir($ruta);      // abro archivos
while ($archivo = readdir($archivohandle)) {
        if ($archivo != "." && $archivo != ".." && $archivo != ".DS_Store") {
        $dirs[] = $archivo;
        } 
} 
closedir($archivohandle);                    // Fin lectura de archivos
$dirs = array_reverse($dirs);
echo '<div class="task-content">
<ul>';
foreach ($dirs as $archivo) {
    echo '<li><div class="task-checkbox" style="margin-top:20px"><div class="task-title">
         <a href="db_cargar_copia.php?restaurar=si&archivo='.$ruta.$archivo.'"><button class="btn btn-success btn-s"><i class=" fa fa-check"></i></button></a>
         <a href="'.$ruta.$archivo.'" download="'.$archivo.'"><button class="btn btn-primary btn-s"><i class="fa fa-download "></i></button> </a> 
         <a href="db_cargar_copia.php?borrar=si&archivo='.$ruta.$archivo.'"><button class="btn btn-danger btn-s"><i class="fa fa-trash-o "></i></button> </a>
         <span class="task-title-sp">Creado el '.substr($archivo,20,-12).'-'.substr($archivo,18,-14).'-'.substr($archivo,14,-16).' a las '.substr($archivo,23,-9).':'.substr($archivo,25,-7).':'.substr($archivo,28,-4).' </span>';
    echo '<span class="badge badge-sm label-primary">'.substr(fgets(fopen($ruta.$archivo,'r')),2,-3).'</span></div></div>';
    echo "</li>";
}
echo "</ul>";
?>

                              </div>
                              
                              
                              
                           <h3>Si tienes un archivo y quieres incorporarlo a las copias de seguridad adjuntalo con el siguiente formulario</h3>   
                           
                           
                           

                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h4 class="modal-title">Adjuntar archivo a DB</h4>
                                          </div>
                                          <div class="modal-body">

                                              <form role="form" method="POST" enctype="multipart/form-data" action="./db_cargar_copia.php">
                                                  <div class="form-group">
                                                 
                                                      <input type="hidden" name="adjuntar" id="adjuntar" value="si">
                                                  </div>
                                                <div class="form-group">
                                                      <label for="archivo">Archivo a adjuntar</label>
                                                      <input type="file" name="archivo" id="archivo">
                                                      <p class="help-block">Solo archivos SQL</p>
                                                  </div>
                                                  <button type="submit" class="btn btn-default">Adjuntar</button>
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
