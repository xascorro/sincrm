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



//***************************//mis datos
$hostdb = "localhost";    // sera el valor de nuestra BD
$basededatos = "sincrm";    // sera el valor de nuestra BD

$usuariodb = "root";    // sera el valor de nuestra BD
$clavedb = "xas";    // sera el valor de nuestra BD

// Fin de los parametros a configurar para la conexion de la base de datos

$conexion_db = mysql_connect("$hostdb","$usuariodb","$clavedb");

if(!$conexion_db){
	$clavedb = "";    // sera el valor de nuestra BD
	$conexion_db = mysql_connect("$hostdb","$usuariodb","$clavedb");
}
    $db = mysql_select_db("$basededatos", $conexion_db);

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
	    $GLOBALS["fecha"] = $registro['fecha'];
	    $GLOBALS["organizador"] = $registro['organizador'];
	    $GLOBALS["organizador_tipo"] = $registro['organizador_tipo'];
	}
//****************************//
$titulo = $_GET['titulo'];
$titulo_documento = $GLOBALS['nombre_competicion_activa']."<br>$titulo";
$nombre_documento = $titulo.' '.$GLOBALS['nombre_competicion_activa'];
$GLOBALS['footer_substring'] = "Sede: ".$GLOBALS['lugar']."\n-- Fecha de la competición: ".$GLOBALS['fecha'];
$logo_header_width= 100;
$GLOBALS['header_image'] = '../images/header_regional.jpg';
$GLOBALS['footer_image'] = '../images/footer_regional.jpg';

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $this->SetFont('helvetica', 12);
        $this->WriteHTML('<img style="border-bottom:1px #cecece;" src="'.$GLOBALS['header_image'].'">', false, false, false, false, '');
        $this->SetXY(25,12);
        $this->WriteHTML('<div style="text-align:right; font-size:large; font-weight:bold">'.$GLOBALS['titulo_documento']."</div>", false, false, false, false, '');

    }

    //Page footer
    public function Footer() {
        // Logo
        $this->SetFont('helvetica', 12);
$x = 15;
$y = 270;
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
	$html_tec .= '<tr><th style="background-color:#cecece">Fecha: </th><th colspan="3">'.$GLOBALS["fecha"].'</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Lugar celebración: </th><th colspan="3">'.$GLOBALS["lugar"].'</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Piscina: </th><th colspan="3">'.$GLOBALS["piscina"].'</th></tr>';
	if($GLOBALS['organizador_tipo'] == 'Federación')
		$organizador = mysql_result(mysql_query("select nombre from federaciones where id='".$GLOBALS['organizador']."'"),0) ;
	elseif($GLOBALS['organizador_tipo'] == 'Club')
		$organizador = mysql_result(mysql_query("select nombre from clubs where id='".$GLOBALS['organizador']."'"),0) ;
	$html_tec .= '<tr><th style="background-color:#cecece">Organizador: </th><th colspan="3">'.$organizador.'</th></tr>';
	$query = "select nombre from clubs where id in (select id_club from rutinas where id_competicion='".$GLOBALS['id_competicion_activa']."')";
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
		$html_tec .= '<tr><th>'.$juez['licencia'].'</th><th colspan="2">'.$juez['nombre'].' '.$juez['apellidos'].'</th><th>'.$federacion.'</th></tr>';

	}



	$html_tec .= '<tr><th colspan="3"></th><th><br><br><br><br>Fdo. Juez Árbitro<br></th></tr>';
	$html_tec .= "</table>";
	$pdf->writeHTML($html_tec, true, false, true, false, '');
}
//

$error_color = "#E65B5E";
$rutina_color_par = "#DEDEDE";
$rutina_color_impar = "#FFFFFF";

//array con puntos por posicion
$puntos = array("0", "19", "16", "14", "13","12", "11", "10", "9", "8","7", "6", "5", "4", "3","2", "1", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0",);


// add a page
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 14);
	$html = "<h2>  </h2>";
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 7);
	$html = '<table align="center" border="1">';
	//$html = "<tr><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th><th>a1</th></tr>";

	$html.= '<tr><th width="10%">CLUB</th><th width="30%" colspan="10">SOLOS</th><th width="30%" colspan="10">DÚOS</th><th width="30%" colspan="12">COMBOS</th><th>T</th></tr>';
	$html.= '<tr><th></th><th colspan="2">Alevín I</th><th colspan="2">Alevín II</th><th colspan="2">Infantil</th><th colspan="2">Junior</th><th colspan="2">Absoluto</th><th colspan="2">Alevín</th><th colspan="2">Alevín II</th><th colspan="2">Infantil</th><th colspan="2">Junior</th><th colspan="2">Absoluto</th><th colspan="2">Alevín I</th><th colspan="2">Alevín II</th><th colspan="2">Infantil</th><th colspan="2">Junior</th><th colspan="2">Absoluto</th><th colspan="2">Mixto</th><th></th></tr>';

$query = "select nombre, nombre_corto, id from clubs where id in (select id_club from rutinas where id_competicion='".$GLOBALS['id_competicion_activa']."')";
$clasificacion_clubs[] = "";
$i = 0;
$clubs = mysql_query($query);
while($club = mysql_fetch_array($clubs)){
	$query = "select * from fases where id_competicion = '".$GLOBALS['id_competicion_activa']."' order by id_modalidad, id_categoria";
	$fases = mysql_query($query);
	$html .= "<tr><td width='10%'>".$club['nombre_corto']."</td>";
	$puntos_club = "";
	while($fase = mysql_fetch_array($fases)){
		$puntos_rutina = 0;
		$id_fase = $fase['id'];
		$query = "select nombre, id from categorias where id = '".$fase['id_categoria']."'";
	    $nombre_categoria=mysql_result(mysql_query($query),0);
	    $id_categoria=mysql_result(mysql_query($query),0,1);
		$query = "select nombre, id from modalidades where id = '".$fase['id_modalidad']."'";
	    $nombre_modalidad=mysql_result(mysql_query($query),0);
	    $id_categoria=mysql_result(mysql_query($query),0,1);
	    $query= "select * from rutinas where id_fase='".$id_fase."' and id_club='".$club['id']."' and orden > 0 and baja != 'si' order by posicion asc limit 2";
		$rutinas = mysql_query($query);
	    while($rutina = mysql_fetch_array($rutinas)){
	    	if($rutina['posicion'] > '0' and $rutina['posicion'] <= '16'){
		    	$puntos_rutina = $puntos[$rutina['posicion']];
	    	}else{
	    		$puntos_rutina = "0";
	    	}
	    	if($fase['id_modalidad'] == 6)
	    		$puntos_rutina = $puntos_rutina*2;
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
    $logo_club = mysql_result(mysql_query($query),0);
    if($logo_club == ""){
	    $logo_club = "";
    }else{
	    $logo_club = '<img style="border-bottom:1px #cecece;" src="../'.$logo_club.'">';
    }
    $html .= "<h2>".$i."º con ".$club['puntos']." puntos $nombre_club</h2>";

    //creo tabla podium
    if($i == 1){
    	$html_podium .= '<tr><td></td><td><h1>1º '.$nombre_club.'<br>'.$logo_club.'</h1></td><td></td></tr>';
    }else if($i == 2){
    	$html_podium_2 = '<td><h1>2º '.$nombre_club.'<br><img style="border-bottom:1px #cecece;" src="'.$logo_club.'"></h1></td>';
    }else if($i == 3){
    	$html_podium .= '<tr>'.$html_podium_2.'<td></td><td><h1>3º '.$nombre_club.'<br><img style="border-bottom:1px #cecece;" src="'.$logo_club.'"></h1></td></tr>';
    }

    $i++;
}
$html_podium .= '</table>';

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->writeHTML($html_podium, true, false, false, false, '');

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
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento, 'I');

//============================================================+
// END OF FILE
//============================================================+
