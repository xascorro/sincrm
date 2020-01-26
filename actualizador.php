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
                      <h1>ACTUALIZADOR SINCRM</h1>
                      <p>Actualizar la aplicación de forma remota</p>
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
//miramos si existe una actualizacion
$getVersions = file_get_contents($url_release.'current-release-versions.php') or die ('ERROR');
if ($getVersions != ''){
	echo '<div class="alert alert-success ">
             <h2>VERSIÓN ACTUAL: <strong>'.getVersion().'</strong></h2></div>';
	echo '<div class="alert alert-success "><h4>Comprobando actualizaciones <i class="fa fa-check"></i></h4></div>';
	$versionList = explode("\n", $getVersions);
	foreach ($versionList as $aV){
		//echo $aV;
		//$aV = substr($aV,0,-1);
		if ( $aV > getVersion()) {
			$tamaño_actualizacion = fileSizeConvert(remote_filesize($url_release.$nombre_distribucion.$aV.'.zip'));
			echo '<div class="alert alert-success "><h4>Se ha encontrado una nueva actualización: <strong>v'.$aV.'</strong> de '.$tamaño_actualizacion.' <i class="fa fa-check"></i></h4></div>';
			$found = true;

			//Descargamos el archivo si no lo tenemos
			if ( !is_file($ruta_local.$nombre_distribucion.$aV.'.zip' )) {
				echo '<div class="alert alert-info "><h4></i>Descargando actualización <i class="fa fa-cloud-download"></i></4></div>';
				$newUpdate = file_get_contents($url_release.$nombre_distribucion.$aV.'.zip');
				if ( !is_dir( $ruta_local.'/' ) ) mkdir ( $ruta_local.'/' );
				$dlHandler = fopen($ruta_local.$nombre_distribucion.$aV.'.zip', 'w');
				if ( !fwrite($dlHandler, $newUpdate) ) {
				 echo '<div class="alert alert-danger"><h4>No se ha podido guardar la actualización. Operación cancelada <i class="fa fa-meh-o"></i></h4></div>'; exit();
				 }
				fclose($dlHandler);
				echo '<div class="alert alert-success "><h4>Actualización descargada</h4></div>';
			} else echo '<div class="alert alert-success "><h4>La actualización ya se encuentra descargada.</h4></div>';

			if (isset($_GET['doUpdate']) && $_GET['doUpdate'] == true) {
				//Descomprimimos el archivo And Do Stuff
				$zipHandle = zip_open($ruta_local.$nombre_distribucion.$aV.'.zip');
				echo '<div class="alert alert-warning"><h4>';
				while ($aF = zip_read($zipHandle) )
				{
					$thisFileName = zip_entry_name($aF);
					$thisFileDir = dirname($thisFileName);
					//Continue if its not a file
					if ( substr($thisFileName,-1,1) == '/') continue;


					//Si lo necesitamos creamos el directorio...
					if ( !is_dir ( $ruta_sincrm.'/'.$thisFileDir ) )
					{
						 mkdir ( $ruta_sincrm.'/'.$thisFileDir );
						 echo '<li>'.$thisFileDir.'/ ........... DIRECTORIO CREADO</li>';
					}

					//Sobreescribimos el archivo
					if ( !is_dir($ruta_sincrm.'/'.$thisFileName) ) {
						echo '<li>'.$thisFileName.' ........... ';
						$contents = zip_entry_read($aF, zip_entry_filesize($aF));
						$contents = str_replace("\r\n", "\n", $contents);
						$updateThis = '';

						//Si tenemos algo que hacer, por ejemplo en DB, lo hacemos.
						if ($thisFileName == 'upgrade.php'){
							$upgradeExec = fopen ('upgrade.php','w');
							fwrite($upgradeExec, $contents);
							fclose($upgradeExec);
							include ('upgrade.php');
							unlink('upgrade.php');
							echo 'EJECUTADO</li>';
							setVersion($aV);
							echo '<li>Número de versión ........... ACTUALIZADO</li>';
						}
						else{
							$updateThis = fopen($ruta_sincrm.'/'.$thisFileName, 'w');
							fwrite($updateThis, $contents);
							fclose($updateThis);
							unset($contents);
							echo 'ACTUALIZADO</li>';
						}
						if($thisFileName == 'about/last_changelog.txt'){
							//$last_changelog = $thisFileName;
							$last_changelog = 'about/last_changelog_copy.txt';
						}
					}
				}
				echo '</h4></div>';
				$updated = TRUE;
			}
			else echo '<div class="alert alert-info"><h4>Actualización preparada <a href="?doUpdate=true"><i class="fa fa-angle-double-right"></i> ¿Instalar ahora?</a></h4></div>';
			break;
		}
	}

	if ($updated == true){
		$archivo = file_get_contents($last_changelog); //Guardamos archivo.txt en $archivo
		$archivo = ucfirst($archivo); //Le damos un poco de formato
		$archivo = nl2br($archivo); //Transforma todos los saltos de linea en tag <br/>
		$Parsedown = new Parsedown();
		echo '<div class="alert alert-info"><h4>CORRECCIONES Y NOVEDADES</h4>'.$Parsedown->text($archivo).'</div>';
		echo '<div class="alert alert-info"><h4>SINCRM actualizado a v'.$aV.' <i class="fa fa-rocket"></i></h4></div>';
	}else if ($found != true)
		echo '<div class="alert alert-info"><h4>La aplicación se encuentra en su última versión <i class="fa fa-check"></i></h4></div>';

}
else echo '<p>Error al comprobar las actualizaciones<i class="fa fa-close"></i></p>';
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
