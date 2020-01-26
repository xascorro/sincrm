<!DOCTYPE html>
<html lang="en">
  <?php include("./head.php");
  //parse texto en formato markdown
  include ('./parsedown.php');
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
                      <h1><i class="fa fa-circle-o-notch"></i> ACTUALIZADOR MAGIC</h1>
                      <p>Crear actualización y cargar de forma remota</p>
                  </div>
                  <div class="actualizador-body">
<?
$updated = false;
$found = false;
$last_changelog = "";

$nombre_distribucion = 'sincrm-';
$url_release = "http://admin.clubsincroalhama.com/sincrm_updates/";
$ruta_local = $_SERVER['DOCUMENT_ROOT'].'sincrm/admin/'.'/UPDATES/';
$ruta_sincrm = $_SERVER['DOCUMENT_ROOT'].'/sincrm/admin/';




      //primero creamos la función que hace la magia
      //esta funcion recorre carpetas y subcarpetas
      //añadiendo todo archivo que encuentre a su paso
      //recibe el directorio y el zip a utilizar
      function agregar_zip($dir, $zip){ 
        //verificamos si $dir es un directorio
        if (is_dir($dir)) { 
          //abrimos el directorio y lo asignamos a $da
          if ($da = opendir($dir)) {          
            //leemos del directorio hasta que termine
            while (($archivo = readdir($da))!== false) {   
              //Si es un directorio imprimimos la ruta
              //y llamamos recursivamente esta función 
              //para que verifique dentro del nuevo directorio
              //por mas directorios o archivos
              if (is_dir($dir . $archivo) && $archivo!="." && $archivo!=".."){
                echo "<li><strong>$dir$archivo ........... CREADO</strong></li>";                                    
                agregar_zip($dir.$archivo . "/", $zip);  

              //si encuentra un archivo imprimimos la ruta donde se encuentra
              //y agregamos el archivo al zip junto con su ruta
              }elseif(is_file($dir.$archivo) && $archivo!="." && $archivo!=".." && $archivo!=".DS_Store" && $archivo!="sincrm.zip"){
                echo "<li>$archivo ........... AGREGADO</li>";                                    
                $zip->addFile($dir.$archivo, $dir.$archivo);                     
              }             
            }
            //cerramos el directorio abierto en el momento
            closedir($da); 
          }
        }       
      } //fin de la función

      //creamos una instancia de ZipArchive      
      $zip = new ZipArchive();

      //directorio a comprimir
      //la barra inclinada al final es importante
      //la ruta debe ser relativa no absoluta      
      $dir = './';

      //ruta donde guardar los archivos zip, ya debe existir
      $rutaFinal="updates_magic/";

      $archivoZip = "sincrm.zip";  

      if($zip->open($archivoZip,ZIPARCHIVE::CREATE)===true) {  
        agregar_zip($dir, $zip);
        $zip->close();

        //Muevo el archivo a una ruta
        //donde no se mezcle los zip con los demas archivos
        @rename($archivoZip, "$rutaFinal$archivoZip");

        //Hasta aqui el archivo zip ya esta creado

        //Verifico si el archivo ha sido creado
        if (file_exists($rutaFinal.$archivoZip)){
          echo "Proceso Finalizado!! <br/><br/>
                Descargar: <a href='$rutaFinal$archivoZip'>$archivoZip</a>";  
        }else{
          echo "Error, archivo zip no ha sido creado!!";
        }                    
      }
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
