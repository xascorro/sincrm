<?php
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF liary (search for installation path).
require_once('../tcpdf/tcpdf.php');
include('../lib/conexion_abre.php');
include('../lib/my_functions.php');

mysql_query("SET NAMES 'utf8'");

    $GLOBALS["id_competicion_activa"] = 0;
	$GLOBALS["nombre_competicion_activa"] = "No hay competición activa";
    $query = "select * from competiciones where activo='si'";     // Esta linea hace la consulta
    $result = mysql_query($query);
    while ($registro = mysql_fetch_array($result)){
	    $GLOBALS["id_competicion_activa"] = $registro['id'];
	    $GLOBALS["nombre_competicion_activa"] = $registro['nombre'];
	    $GLOBALS["lugar"] = $registro['lugar'];
	    $GLOBALS["piscina"] = $registro['piscina'];
	    $GLOBALS["fecha"] = dateAFecha($registro['fecha']);
	    $GLOBALS["organizador"] = $registro['organizador'];
	    $GLOBALS["organizador_tipo"] = $registro['organizador_tipo'];
	    $GLOBALS["hora_inicio"] = $registro['hora_inicio'];
	    $GLOBALS["hora_fin"] = $registro['hora_fin'];
	    $GLOBALS["header"] = $registro['header_informe'];
	    $GLOBALS["footer"] = $registro['footer_informe'];

	}
//****************************//
$titulo = $_GET['titulo'];
$titulo_documento = $GLOBALS['nombre_competicion_activa']."<br>$titulo";
$nombre_documento = $titulo.' '.$GLOBALS['nombre_competicion_activa'];
$GLOBALS['footer_substring'] = "Sede: ".$GLOBALS['lugar']."\n-- Fecha de la competición: ".$GLOBALS['fecha'];
$logo_header_width= 100;
$GLOBALS['header_image'] = '../'.$GLOBALS['header'];
$GLOBALS['footer_image'] = '../'.$GLOBALS['footer'];

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $this->SetFont('helvetica', 12);
        $this->WriteHTML('<img style="border-bottom:1px #cecece;" src="'.$GLOBALS['header_image'].'">', false, false, false, false, '');
        $this->SetXY(25,12);
        $this->WriteHTML('<div style="text-align:center; font-size:large; font-weight:bold">'.$GLOBALS['titulo_documento']."</div>", false, false, false, false, '');

    }

    //Page footer
    public function Footer() {
        // Logo
        $this->SetFont('helvetica', 12);
$x = 15;
$y = 275;
$w = '180';
$h = '';
        $this->Image($GLOBALS['footer_image'], $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, 'L', false, false);



        $this->SetXY(25,278);
		$pagenumtxt = $this->getAliasNumPage().' de '.$this->getAliasNbPages();
        $this->WriteHTML('<div style="text-align:center; font-size:large; font-weight:bold">'.$GLOBALS['footer_substring'].'<br>Página '.$pagenumtxt.'</div>', false, false, false, false, '');
    }
}


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//define ('PDF_HEADER_LOGO', 'kki.jpg');
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Pedro Díaz');
$pdf->SetTitle($titulo_documento);
$pdf->SetSubject($GLOBALS["nombre_competicion_activa"]);
$pdf->SetKeywords('sincro, PDF, alhama, murcia, lorca');

// set default header data
//$pdf->SetHeaderData($logo_campeonato, $logo_header_width, $titulo_documento, $header_substring);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page eaks
$pdf->SetAutoPagebreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 14);

// -----------------------------------------------------------------------------

//se imprime hoja tecnica si se necesita
if(isset($_GET['hoja_tecnica'])){
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 14);
	$html_tec = '<table style="margin-top=10px">';
	$html_tec .= "<tr><th></th><th></th><th></th><th></th></tr>";

	$html_tec .= '<tr><th style="background-color:#cecece">Competición: </th><th colspan="3">'.$GLOBALS["nombre_competicion_activa"].'</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Fecha y hora: </th><th colspan="3">'.$GLOBALS["fecha"].' de '.$GLOBALS['hora_inicio'].' a '.$GLOBALS['hora_fin'].' horas</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Lugar celebración: </th><th colspan="3">'.$GLOBALS["lugar"].'</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Piscina: </th><th colspan="3">'.$GLOBALS["piscina"].'</th></tr>';
	if($GLOBALS['organizador_tipo'] == 'Federación')
		$organizador = mysql_result(mysql_query("select nombre from federaciones where id='".$GLOBALS['organizador']."'"),0) ;
	elseif($GLOBALS['organizador_tipo'] == 'Club')
		$organizador = mysql_result(mysql_query("select nombre from clubs where id='".$GLOBALS['organizador']."'"),0) ;
	$html_tec .= '<tr><th style="background-color:#cecece">Organizador: </th><th colspan="3">'.$organizador.'</th></tr>';
	$query = "select nombre from clubs where id in (select distinct club from nadadoras where id in (select distinct id_nadadora from inscripciones_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."'))";


	$clubs_participantes = mysql_query($query);
	$clubs="";
	while($club = mysql_fetch_array($clubs_participantes)){
		$clubs .= $club['nombre']." - ";
	}
	$clubs ="".
	$html_tec .= '<tr><th style="background-color:#cecece">Clubs participanes: </th><th colspan="3">'.$clubs.'</th></tr>';
	//obtengo datos de puesto jueces
	$html_tec .= '<tr><th colspan="4"></th></tr>';
	$query = "select * from puesto_juez where id_competicion='".$GLOBALS['id_competicion_activa']."'";
	$puesto_jueces = mysql_query($query);
	while($puesto_juez = mysql_fetch_array($puesto_jueces)){
		$nombre = mysql_result(mysql_query("select nombre from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$apellidos = mysql_result(mysql_query("select apellidos from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$licencia = mysql_result(mysql_query("select licencia from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$licencia = "";
		$id_federacion = mysql_result(mysql_query("select federacion from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$federacion = mysql_query("select nombre_corto from federaciones where id = '".$id_federacion."'");
		$federacion = mysql_result($federacion,0);
		$html_tec .= '<tr style="background-color:#cecece"><th colspan="4">'.$puesto_juez['nombre'].'</th></tr>';
		$html_tec .= '<tr><th>'.$licencia.'</th><th colspan="2">'.$nombre.' '.$apellidos.'</th><th>'.$federacion.'</th></tr>';

	}
		$html_tec .= '<tr style="background-color:#cecece"><th colspan="4">Jueces de puntuación: </th></tr>';

	//obtengo datos jueces puntuacion
	$query = "select * from jueces where id in (select id_juez from panel_jueces where id_competicion='".$GLOBALS['id_competicion_activa']."')";
	$jueces = mysql_query($query);
	while($juez = mysql_fetch_array($jueces)){
		$federacion = mysql_query("select nombre_corto from federaciones where id = '".$juez['federacion']."'");
		$federacion = mysql_result($federacion,0);
		$html_tec .= '<tr><th></th><th colspan="2">'.$juez['nombre'].' '.$juez['apellidos'].'</th><th>'.$federacion.'</th></tr>';

	}



	$html_tec .= '<tr><th colspan="3"></th><th><br>Fdo. Juez Árbitro<br></th></tr>';
	$html_tec .= "</table>";
	$pdf->writeHTML($html_tec, true, false, true, false, '');
}
//

if(isset($_GET['memorial'])){

//array con puntos por posicion
$puntos = array("0", "19", "16", "14", "13","12", "11", "10", "9", "8","7", "6", "5", "4", "3","2", "1", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0",);
	// add a page
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 14);
	$html = "<h2> Clasificación por Clubs  </h2>";
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 7);
	$html = '<table align="center" border="1">';
	//$html.= '<tr><th width="10%">CLUB</th><th width="30%" colspan="10">SOLOS</th><th width="30%" colspan="10">DÚOS</th><th width="30%" colspan="12">COMBOS</th><th>T</th></tr>';
	$html.= '<tr style="background-color:#cecece;"><th width="10%"></th><th colspan="2">Sirenitas</th><th colspan="2">PreBenjamín</th><th colspan="2">Benjamín</th><th colspan="2">Alevín I</th><th colspan="2">Alevín II</th><th colspan="2">Infantil I</th><th colspan="2">Infantil II</th><th>TOTAL</th></tr>';

	$query = "select id, nombre, nombre_corto from clubs where id in (select distinct club from nadadoras where id in (select distinct id_nadadora from inscripciones_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."'))";
$clasificacion_clubs[] = "";
$i = 0;
$clubs = mysql_query($query);
while($club = mysql_fetch_array($clubs)){
	$query = "select * from resultados_figuras where id_competicion = '".$GLOBALS['id_competicion_activa']."' group by id_categoria";
	$fases = mysql_query($query);
	$html .= '<tr><td width="10%" style="background-color:#cecece;">'.$club['nombre_corto']."</td>";
	$puntos_club = "";
	while($fase = mysql_fetch_array($fases)){
		$id_fase = $fase['id'];
		$query = "select nombre, id from categorias where id = '".$fase['id_categoria']."'";
	    $nombre_categoria=mysql_result(mysql_query($query),0);
	    $id_categoria=mysql_result(mysql_query($query),0,1);
	    $query= "select * from resultados_figuras where id_categoria=$id_categoria and id_nadadora in (select id from nadadoras where club='".$club['id']."') and baja!='si' and preswimmer!='si' order by posicion asc limit 2";
	    $rutinas = mysql_query($query);
	    while($rutina = mysql_fetch_array($rutinas)){
	    	//echo $rutina['posicion']." ";
	    	if($rutina['posicion'] > '0' and $rutina['posicion'] <= '16'){
		    	$puntos_rutina = $puntos[$rutina['posicion']];
	    	}else{
	    		$puntos_rutina = "0";
	    	}
	    	//if($fase['id_modalidad'] == 3)
	    	//	$puntos_rutina = $puntos_rutina*2;
		    $html .= "<td width='2.5%'>".$puntos_rutina."</td>";
		    $puntos_club += $puntos_rutina;
	    }
	    if(mysql_num_rows($rutinas)==0)
	    	$html .= "<td width='2.5%'>X</td><td width='2.5%'>X</td>";
	    if(mysql_num_rows($rutinas)==1)
	    	$html .= "<td width='2.5%'>X</td>";

	  }

	  $clasificacion_clubs[$i]['id'] =$club['id'];
	  $clasificacion_clubs[$i]['puntos'] = $puntos_club;
	  $html .= "<td>$puntos_club</td>";
	  $html .= "</tr>";
	  $i++;

}
$html .= '</table><br><br>';
$pdf->writeHTML($html, true, false, false, false, '');
//	  print_r($clasificacion_clubs);

usort($clasificacion_clubs,"cmpPuntosDesc");
$html = "";
$html_podium = '<table><tr><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td></tr>';
$i = 1;
foreach ($clasificacion_clubs as &$club) {
    $query = "select nombre from clubs where id = '".$club['id']."'";
    $nombre_club = mysql_result(mysql_query($query),0);
    $query = "select logo from clubs where id = '".$club['id']."'";
    $logo_club = "../".mysql_result(mysql_query($query),0);
    if($logo_club == ""){
	    $logo_club = "";
    }else{
	    $logo_club = '<img height="150" style="border-bottom:1px #cecece;" src="'.$logo_club.'">';
    }
    $html .= "<h2>".$i."º con ".$club['puntos']." puntos $nombre_club</h2>";

    //creo tabla podium
    if($i == 1){
    	$html_podium .= '<tr><td></td><td><h1>1º '.$nombre_club.'<br>'.$logo_club.'</h1></td><td></td></tr>';
    }else if($i == 2){
    	$html_podium_2 = '<td><h1>2º '.$nombre_club.'<br>'.$logo_club.'</h1></td>';
    }else if($i == 3){
    	$html_podium .= '<tr>'.$html_podium_2.'<td></td><td><br><h1>3º '.$nombre_club.'<br>'.$logo_club.'</h1></td></tr>';
    }

    $i++;
}
$html_podium .= '</table>';

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->writeHTML($html_podium, true, false, false, false, '');
$html ="<br><br><br><br><h3>Para el cálculo de la clasificación por clubs se toman únicamente los dos mejores resultados de cada club en cada categoría y se valoran con un número determinado de puntos según el puesto en el que se encuentre la nadadora.</h3>
<h3>Un primer puesto se valora con 19 puntos, un segundo puesto con 16 y sucesivamente con 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2 y 1 punto para el puesto dieciseisavo.</h3>
<h3>El total de puntos de cada club es la suma de los puntos obtenidos.</h3>";
$pdf->writeHTML($html, true, false, false, false, '');
}

//Función para ordenar descendentemente
function cmpPuntosDesc($jugador1, $jugador2)
{
     //Si son iguales se devuelve 0
     if($jugador1["puntos"]==$jugador2["puntos"])
          return 0;
     //Si jugador1 > 2 se devuelve 1 y por lo contrario -1
     if($jugador1["puntos"]<$jugador2["puntos"])
          return 1;
     return -1;
}
$error_color = "#E65B5E";
$rutina_color_par = "#DEDEDE";
$rutina_color_impar = "#FFFFFF";

$condicion_ampliada = "";
if(isset($_GET['id_fase'])){
	$condicion_ampliada = "and id = '".$_GET['id_fase']."'";
	$id_fase = $_GET['id_fase'];
}

$query = "select id_categoria from resultados_figuras where id_competicion ='".$GLOBALS["id_competicion_activa"]."' group by id_categoria";
$categorias = mysql_query($query);
while($categoria = mysql_fetch_array($categorias)){
	$query = "select nombre, id from categorias where id = '".$categoria['id_categoria']."'";
    $nombre_categoria=mysql_result(mysql_query($query),0);
	// add a page
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 14);
	$html = "<h2> $nombre_categoria </h2>";
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 8);
	$html = '<table style="margin-top=10px">';
	$html .= '<thead><tr style="background-color:'.$rutina_color_par.'"><th style="width:5%">Pos.</th><th style="width:38%">Nadadora</th><th style="width:13%">Figura</th><th style="width:16%">Jueces</th><th style="width:8%">Puntos</th><th style="width:8%">Pen.</th><th style="width:8%">Total</th><th style="width:7%">Dif</th></tr></thead>';
	$par=0;
	$query = "select * from resultados_figuras where id_categoria='".$categoria['id_categoria']."' and id_competicion = '".$GLOBALS["id_competicion_activa"]."' order by posicion asc";
	$resultados_figuras = mysql_query($query);
	if(mysql_num_rows($resultados_figuras)>13)
		$pdf->SetFont('helvetica', '', 7);
	else
		$pdf->SetFont('helvetica', '', 8);

	while($resultado_figuras = mysql_fetch_array($resultados_figuras)){
		$baja=$resultado_figuras['baja'];
		$par++;
		if($par%2==0)
			$rutina_color = $rutina_color_par;
		else
			$rutina_color = $rutina_color_impar;
		$query = mysql_query("select apellidos, nombre, club from nadadoras where id='".$resultado_figuras['id_nadadora']."'");
		$nombre_nadadora = mysql_result($query, 0).", ".mysql_result($query,0,1);
		$club = mysql_result($query, 0,2);
		$query = mysql_query("select nombre from clubs where id = '$club'");
		$nombre_club = mysql_result($query,0);
		$html .= '<tr><td style="width:5%">'.$resultado_figuras['posicion'].'</td>';
		$html .= '<td style="width:38%">'.$nombre_nadadora.'<br>'.$nombre_club.'</td>';
		$html .= '<td style="width:13%">';
		// $query = "select numero, grado_dificultad from figuras, fases_figuras where id in (select id_figura from fases_figuras where id_categoria='".$categoria['id_categoria']."' and id_competicion='".$GLOBALS['id_competicion_activa']."' order by orden asc) order by orden asc";
		$query = "select numero, grado_dificultad from fases_figuras, figuras where id_figura = figuras.id and id_categoria='".$categoria['id_categoria']."' and fases_figuras.id_competicion='".$GLOBALS['id_competicion_activa']."' order by orden asc";
		$figuras = mysql_query($query);
		while($figura = mysql_fetch_array($figuras)){
			$html .= $figura['numero']." GD:".$figura['grado_dificultad']."<br>";
		}
		$html .= '</td>';
		$celda_puntuaciones_jueces = '<td style="width:16%">';
		$celda_puntuaciones_paneles = '<td style="width:8%">';
		$celda_penalizaciones_figuras = '<td style="width:8%">';
		$id_inscripcion_figuras = "";
	    $query = "select * from paneles where puntua='si' and id_competicion='".$GLOBALS['id_competicion_activa']."'";
	    $id_panel = mysql_result(mysql_query($query), 0);
	    $fases_figuras = mysql_query("select * from fases_figuras where id_categoria='".$categoria['id_categoria']."' and id_competicion='".$GLOBALS['id_competicion_activa']."'");
	    while($fase_figuras = mysql_fetch_array($fases_figuras)){
		    $query = "select * from inscripciones_figuras where id_nadadora='".$resultado_figuras['id_nadadora']."' and id_fase_figuras='".$fase_figuras['id']."' and id_competicion='".$id_competicion_activa."'";
		    $query = "select * from puntuaciones_jueces where id_inscripcion_figuras in (select id from inscripciones_figuras where id_nadadora='".$resultado_figuras['id_nadadora']."' and id_fase_figuras='".$fase_figuras['id']."' and id_competicion='".$id_competicion_activa."')";
		    $puntuaciones_jueces = mysql_query($query);
		    while($puntuacion_juez = mysql_fetch_array($puntuaciones_jueces)){
			    $celda_puntuaciones_jueces .= $puntuacion_juez['nota']." ";
		    }
		    $celda_puntuaciones_jueces .= "<br>";
		    $query = "select * from puntuaciones_paneles where id_inscripcion_figuras in (select id from inscripciones_figuras where id_nadadora='".$resultado_figuras['id_nadadora']."' and id_fase_figuras='".$fase_figuras['id']."' and id_competicion='".$id_competicion_activa."')";
		    $puntuaciones_jueces = mysql_query($query);
		    while($puntuacion_juez = mysql_fetch_array($puntuaciones_jueces)){
			    $celda_puntuaciones_paneles .= $puntuacion_juez['nota_calculada']." ";
		    }
		    $celda_puntuaciones_paneles .= "<br>";
		    $query = "select * from penalizaciones_rutinas where id_inscripcion_figuras in (select id from inscripciones_figuras where id_nadadora='".$resultado_figuras['id_nadadora']."' and id_fase_figuras='".$fase_figuras['id']."' and id_competicion='".$id_competicion_activa."')";
		    $puntuaciones_jueces = mysql_query($query);
		    while($puntuacion_juez = mysql_fetch_array($puntuaciones_jueces)){
		    	$puntos_penalizacion = mysql_result(mysql_query("select puntos from penalizaciones where id='".$puntuacion_juez['id_penalizacion']."'"),0);
			    $celda_penalizaciones_figuras .= $puntos_penalizacion." ";
		    }
		    $celda_penalizaciones_figuras .= "<br>";		}
		$celda_puntuaciones_jueces .= '</td>';
		$celda_puntuaciones_paneles .= '</td>';
		$html .= $celda_puntuaciones_jueces.$celda_puntuaciones_paneles;
		$html .= '<td style="width:8%">'.$resultado_figuras['puntos_penalizacion'].'</td>';
		if($resultado_figuras['baja']=='si'){
			$html .= '<td style="width:8%"></td>';
			$html .= '<td style="width:7%">BAJA</td></tr>';
		}else{
			$html .= '<td style="width:8%; font-weight:bold">'.$resultado_figuras['nota_final_calculada'].'</td>';
			$html .= '<td style="width:7%">'.$resultado_figuras['diferencia'].'</td></tr>';
		}




	}
	$html .= '</table>';
	$pdf->writeHTML($html, true, false, false, false, '');
}
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento, 'I');

//============================================================+
// END OF FILE
//============================================================+
