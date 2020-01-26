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
	}
//****************************//
//$titulo = $_GET['titulo'];
$titulo = 'hoja puntuacion';
$titulo_documento = $GLOBALS['nombre_competicion_activa']."<br>$titulo";
$nombre_documento = $titulo.' '.$GLOBALS['nombre_competicion_activa'];
$GLOBALS['footer_substring'] = "Sede: ".$GLOBALS['lugar']."\n-- Fecha de la competición: ".$GLOBALS['fecha'];
$logo_header_width= 100;
$GLOBALS['header_image'] = '../images/header_regional.jpg';
$GLOBALS['footer_image'] = '../images/footer_regional.jpg';

// Extend the TCPDF class to create custom Header and Footer

class MYPDF extends TCPDF {

    //Page header
    public function Header() {/*
        // Logo
        $this->SetFont('helvetica', 12);
        $this->WriteHTML('<img style="border-bottom:1px #cecece;" src="'.$GLOBALS['header_image'].'">', false, false, false, false, ''); 
        $this->SetXY(25,12);
        $this->WriteHTML('<div style="text-align:center; font-size:large; font-weight:bold">'.$GLOBALS['titulo_documento']."</div>", false, false, false, false, ''); 
*/
    }
    
    //Page footer
    public function Footer() {
        // Logo
        /*
        $this->SetFont('helvetica', 12);
$x = 15;
$y = 270;
$w = '180';
$h = '';
        $this->Image($GLOBALS['footer_image'], $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, 'L', false, false);



        $this->SetXY(25,278);
		$pagenumtxt = $this->getAliasNumPage().' de '.$this->getAliasNbPages();
        $this->WriteHTML('<div style="text-align:center; font-size:large; font-weight:bold">'.$GLOBALS['footer_substring'].'<br>Página '.$pagenumtxt.'</div>', false, false, false, false, ''); 
    */
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
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(1,5,5);
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
//saco fases_figuras
$query = "select id_categoria, id_figura, id, orden from fases_figuras where id_competicion ='".$GLOBALS["id_competicion_activa"]."' order by orden limit 8";
$fases_figuras = mysql_query($query);
while($fase_figura = mysql_fetch_array($fases_figuras)){	
	$query = "select nombre, id from categorias where id = '".$fase_figura['id_categoria']."'"; 
    $nombre_categoria=mysql_result(mysql_query($query),0);
	$query = "select nombre, id from figuras where id = '".$fase_figura['id_figura']."'"; 
    $nombre_figura=mysql_result(mysql_query($query),0);
    //saco numeros de juez
   	$query = "select numero_juez from panel_jueces where id_fase_figuras = '".$fase_figura['id']."' order by numero_juez"; 
   	$jueces = mysql_query($query);
   	while($juez = mysql_fetch_array($jueces)){
	   	//saco orden de salida nadadoras
	   	$query = "select orden from inscripciones_figuras where id_fase_figuras = '".$fase_figura['id']."' order by orden"; 
	   	$ordenes = mysql_query($query);
	   	while($orden = mysql_fetch_array($ordenes)){		
		
		
			$pdf->AddPage();
			//imprimo
			$pdf->SetFont('helvetica', '', 14);	
			$html = '<table align="center" border="2">';
			$html .= '<tr><th colspan="2"><h1 style="font-size:30px">'.$GLOBALS["nombre_competicion_activa"].'</h1></th></tr>';
			$html .= '<tr><th colspan="2">'.'<span style="font-size:50px">'.$nombre_categoria.'</span>'.'</th></tr>';
			$html .= '<tr><th colspan="2">'.'<span style="font-size:40px">'.$fase_figura['orden'].' - '.$nombre_figura.'</span>'.'</th></tr>';
			$html .= '<tr><th>'.'<h2>JUEZ</h2><br><span style="font-size:120px">'.$juez['numero_juez'].'</span>'.'</th><th>'.'<h2>ORDEN</h2><br><span style="font-size:120px">'.$orden['orden'].'</span>'.'</th></tr>';
			$html .= '<tr><th colspan="2">'.'<span style="font-size:50px">NOTA <br><br><br><br><br></span>'.'</th></tr>';
			$html .= '<tr><th colspan="2" style="text-align:left; margin-left:5%;">'.'<span style="font-size:50px">FIRMA<br><br></span>'.'</th></tr>';
			$html .= '</table>';
			$pdf->writeHTML($html, true, false, false, false, '');
		}
	}
}
	
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output('test', 'I');

//============================================================+
// END OF FILE
//============================================================+