<?php
include('../lib/conexion_abre.php');

$query = "SELECT nota, puntuaciones_jueces.id_inscripcion_figuras as nadadora, nota_media
FROM puntuaciones_jueces, puntuaciones_paneles
WHERE id_panel_juez in (select id from panel_jueces where id_competicion=14 and id_juez=32)
and puntuaciones_jueces.id_inscripcion_figuras = puntuaciones_paneles.id_inscripcion_figuras";
$result = mysql_query($query);
$notas_juez = array();
$notas_media = array();
while ($registro = mysql_fetch_array($result)){
    //$notas_juez .= $registro['nota'].', ';
    $notas_juez[] = $registro['nota'];
    $notas_media[] = $registro['nota_media'];
    $nadadoras[] = $registro['nadadora'];
}
?>
<?php
 /* CAT:Area Chart */

 /* pChart library inclusions */
include("../pchart/class/pData.class.php");
include("../pchart/class/pDraw.class.php");
include("../pchart/class/pImage.class.php");

/* Create and populate the pData object */
$MyData = new pData();
$MyData->addPoints($notas_juez,"Notas Juez");
$MyData->addPoints($notas_media,"Nota media");
$MyData->setAxisName(0,"NOTAS");
$MyData->addPoints($nadadoras,"Months");
$MyData->setSerieDescription("Months","Month");
$MyData->setAbscissa("Months");

/* Create the pChart object */
$myPicture = new pImage(1400,460,$MyData);

/* Turn of Antialiasing */
$myPicture->Antialias = FALSE;

/* Add a border to the picture */
$myPicture->drawGradientArea(0,0,1400,460,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
$myPicture->drawGradientArea(0,0,1400,460,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
$myPicture->drawRectangle(0,0,1400,460,array("R"=>0,"G"=>0,"B"=>0));

/* Set the default font */
$myPicture->setFontProperties(array("FontName"=>"../pchart/fonts/pf_arma_five.ttf","FontSize"=>6));

/* Define the chart area */
$myPicture->setGraphArea(60,40,1300,400);

/* Draw the scale */
$scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
$myPicture->drawScale($scaleSettings);

/* Write the chart legend */
$myPicture->drawLegend(580,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

/* Turn on shadow computing */
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

/* Draw the chart */
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
$settings = array("Surrounding"=>-30,"InnerSurrounding"=>30);
$myPicture->drawLineChart($settings);

/* Render the picture (choose the best way) */
$myPicture->autoOutput("pictures/example.drawBarChart.simple.png");
?>

?>
