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
	    $GLOBALS["fecha"] = $registro['fecha'];  
	    $GLOBALS["organizador"] = $registro['organizador'];  
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
        $this->WriteHTML('<div style="text-align:center; font-size:large; font-weight:bold">'.$GLOBALS['footer_substring'].'<br>Página '.$pagenumtxt.'</div>', false, false, false, false, ''); 
    }
}
 

// create new PDF document
$pdf = new MYPDF('landscape', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//define ('PDF_HEADER_LOGO', 'kki.jpg');
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Pedro Díaz');
$pdf->SetTitle($titulo_documento);
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
// add a page
$pdf->AddPage();
// -----------------------------------------------------------------------------


$pdf->setCellHeightRatio(1.7);

$error_color = "#E65B5E";
$rutina_color_par = "#DEDEDE";
$rutina_color_impar = "#FFFFFF";

$query = "select * from fases where id_competicion = '".$GLOBALS["id_competicion_activa"]."'";
$fases = mysql_query($query);
$html = '<table style="margin-top=10px">';
$contando = 0;
$numero_fases = mysql_num_rows($fases);
while($fase = mysql_fetch_array($fases)){
	$contando++;
	$query = "select nombre, id from categorias where id = '".$fase['id_categoria']."'"; 
    $nombre_categoria=mysql_result(mysql_query($query),0);
    $id_categoria=mysql_result(mysql_query($query),0,1);
	$query = "select nombre, id from modalidades where id = '".$fase['id_modalidad']."'"; 
    $nombre_modalidad=mysql_result(mysql_query($query),0);
    $id_categoria=mysql_result(mysql_query($query),0,1);


	//$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 11);
	

	//encabezado
	$query = "select * from clubs";
	$clubs = mysql_query($query);
	if($contando == 1){	
		$html .= "<tr><th></th>";	
		while($club = mysql_fetch_array($clubs)){
			$html .='<th>'.$club['nombre_corto'].'</th>';		
		}
		$html .= "<th>TOTAL</th></tr>";
	}
	//fila
	$clubs = mysql_query($query);
	$html .= "<tr><td>$nombre_modalidad $nombre_categoria</td>";
	$cantidad_por_fila = 0;	
	while($club = mysql_fetch_array($clubs)){
		$query = "select count(id) from rutinas where id_fase ='".$fase['id']."' and id_club='".$club['id']."'";
		$cantidad=mysql_result(mysql_query($query),0);
		$html .='<th>'.$cantidad.'</th>';	
		$cantidad_por_fila += $cantidad;	
	}
	$html .= "<td>$cantidad_por_fila</td></tr>";		
	//ultima fila
	if($numero_fases == $contando){
	$html .= "<tr><td>TOTAL</td>";	
	$query = "select * from clubs";
	$clubs = mysql_query($query);
	while($club = mysql_fetch_array($clubs)){
		$query = "select count(id) from rutinas where id_club='".$club['id']."'";
		$cantidad=mysql_result(mysql_query($query),0);
		$html .='<th>'.$cantidad.'</th>';		
	}
		$html .= "</tr>";		

	}

}
	$html .= '</table><p>Por favor, compruebe que el número de rutinas inscritas y sus participantes son correctos.</p>';
	$pdf->writeHTML($html, true, false, false, false, '');




// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento, 'I');

//============================================================+
// END OF FILE
//============================================================+