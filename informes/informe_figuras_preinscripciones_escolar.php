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
	    $GLOBALS["fecha"] = dateAFecha($registro['fecha']);
	    $GLOBALS["organizador"] = $registro['organizador'];
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
$y = 270;
$w = '180';
$h = '';
        $this->Image($GLOBALS['footer_image'], $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, 'L', false, false);



        $this->SetXY(25,278);
		$pagenumtxt = $this->getAliasNumPage().' de '.$this->getAliasNbPages();
        $this->WriteHTML('<div style="text-align:right; font-size:large; font-weight:bold">'.$GLOBALS['footer_substring'].'<br>Página '.$pagenumtxt.'</div>', false, false, false, false, '');
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
$pdf->SetFont('helvetica', 'B', 12);

// -----------------------------------------------------------------------------

// add a page
$pdf->AddPage();

$error_color = "#E65B5E";
$rutina_color_par = "#DEDEDE";
$rutina_color_impar = "#FFFFFF";


$query = "select * from fases_figuras where id_competicion = '".$GLOBALS["id_competicion_activa"]."' group by id_categoria";
$fases = mysql_query($query);
while($fase = mysql_fetch_array($fases)){
	$query = "select nombre, id from categorias where id = '".$fase['id_categoria']."'";
    $nombre_categoria=mysql_result(mysql_query($query),0);

	$pdf->SetFont('helvetica', '', 10);

	$html = '<table nobr="true" style="margin-top=10px">';
	//segun titulo de documento
		$html .= '<thead><tr><th><h2>'.$nombre_categoria.'</h2></th></tr><tr><th width="70%"><h4>Nombre</h4></th><th width="30%" aling="right"><h4>Club</h4></th></tr></thead>';

	$par=1;
	$numero_rutinas = 0;
	$query = "select * from inscripciones_figuras where id_fase_figuras='".$fase['id']."' order by id";

	$rutinas = mysql_query($query);
	while($rutina = mysql_fetch_array($rutinas)){
		$numero_rutinas++;
		$par++;
		if($par%2==0)
			$rutina_color = $rutina_color_par;
		else
			$rutina_color = $rutina_color_impar;


 			$query = "select apellidos from nadadoras where id = '".$rutina['id_nadadora']."'";
			$nombre_nadadora=mysql_result(mysql_query($query),0);
			$query = "select nombre from nadadoras where id = '".$rutina['id_nadadora']."'";
			$nombre_nadadora .= ", ".mysql_result(mysql_query($query),0);
			$query = "select licencia from nadadoras where id = '".$rutina['id_nadadora']."'";
			$licencia = mysql_result(mysql_query($query),0);
            $query = "select fecha_nacimiento from nadadoras where id = '".$rutina['id_nadadora']."'";
			$año = substr(mysql_result(mysql_query($query),0),0,4);
			$query = "select nombre from clubs where id in (select club from nadadoras where id = '".$rutina['id_nadadora']."')";
			$nombre_club = mysql_result(mysql_query($query),0);

		if($numero_rutinas < 10)
			$numero = '0'.$numero_rutinas.' - ';
		else
			$numero = $numero_rutinas.' - ';

		$html .='<tr style="background-color:'.$rutina_color.'"><td width="60%">'.$numero.$nombre_nadadora.' ('.$año.')</td><td width="40%" style="text-align:right;">'.$nombre_club. '</td></tr>';
	}
	$html .= '</table>';

	$pdf->writeHTML($html, true, false, false, false, '');

}




include('../lib/conexion_cierra.php');

// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
