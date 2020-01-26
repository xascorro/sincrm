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




	$id_competicion = $GLOBALS['id_competicion_activa'];
	// add a page
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 14);	
	$html = "<h2> Inscripciones bla bla bla</h2>";
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 7);
	$html = '<table align="center" border="1">';
	$html.= '<tr style="width:5%; font-size:14; font-weight:bold;"><th style="width:5%;">P</th><th width="30%">Nadadora</th><th width="10%">Club</th>';
	$query = "select nombre_corto from competiciones where clave_liga like '$clave_liga' order by id asc";
	$jornadas_liga = mysql_query($query);
	while($jornada_liga = mysql_fetch_array($jornadas_liga)){
	$html .= '<th width="10%">'.$jornada_liga['nombre_corto'].'</th>';		
	}	
	$html .= '<th>Total</th></tr>';
	$query = "select año from resultados_figuras where id_competicion in (select id from competiciones where nombre like '%$clave_liga%') group by año order by año desc";
	$años = mysql_query($query);
	while($año = mysql_fetch_array($años)){
		  $i = 0;
		  $clasificacion_nadadoras[] = "";
		  $html .= '<tr style="background-color:#dedede;"><td colspan="8"><h2>Clasificación año '.$año['año'].'</h2></td>';
		  $html .= "</tr>";	
		  $query = "select distinct(id_nadadora) from resultados_figuras where año = '".$año['año']."' and id_competicion in (select id from competiciones where nombre like '%$clave_liga%')";
		  $nadadoras = mysql_query($query);
		  $numero_jornadas_liga = mysql_result(mysql_query("select count(id) from competiciones where nombre like '%$clave_liga%'"), 0);
		  while($nadadora = mysql_fetch_array($nadadoras)){
			$puntos_totales = 0;
			$query = "select apellidos from nadadoras where id = '".$nadadora['id_nadadora']."'";
			$nombre_nadadora = mysql_result(mysql_query($query),0); 			  
			$query = "select nombre from nadadoras where id = '".$nadadora['id_nadadora']."'";
			$nombre_nadadora .= ", ".mysql_result(mysql_query($query),0); 
			$clasificacion_nadadoras[$i]['nombre'] =$nombre_nadadora;
			$query = "select nombre_corto from clubs where id in (select club from nadadoras where id = '".$nadadora['id_nadadora']."')";
			$nombre_club = mysql_result(mysql_query($query),0);
			//$html .= '<tr><td>'.$nombre_nadadora.'</td><td>'.$nombre_club.'</td>';
			$clasificacion_nadadoras[$i]['nombre_club'] =$nombre_club;
			$query = "select id from competiciones where nombre like '%$clave_liga%'";
			$jornadas_liga = @mysql_query($query);
			while($jornada_liga = mysql_fetch_array($jornadas_liga)){
				$id_jornada_liga = $jornada_liga['id'];
				$query = "select coalesce(puntos,0) from resultados_figuras where id_nadadora = '".$nadadora['id_nadadora']."' and id_competicion = '".$id_jornada_liga."'";
				$puntos =@mysql_result(mysql_query($query), 0);
				if($puntos == "" or $id_jornada_liga > $GLOBALS['id_competicion_activa'])
					$puntos = 0;
				$clasificacion_nadadoras[$i][$id_jornada_liga] =$puntos;
				$puntos_totales += $puntos;

			}
			$query = "select coalesce(min(puntos),0) from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '%$clave_liga%') and id_nadadora = '".$nadadora['id_nadadora']."'";
			$puntos_minimos = @mysql_result(mysql_query($query),0);
			$query = "select count(puntos) from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '%$clave_liga%') and id_nadadora = '".$nadadora['id_nadadora']."'";
			$participacion_nadadora = @mysql_result(mysql_query($query),0);
			//echo 'puntos-minimos'.$puntos_minimos.'participacion'.$participacion_nadadora.'jornadas'.$numero_jornadas_liga.'<br>';
			if($participacion_nadadora < $numero_jornadas_liga )
				$puntos_minimos = 0;
			//$query = "select coalesce(sum(nota_final_calculada),0) - coalesce(min(nota_final_calculada),0) from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '%$clave_liga%') and id_nadadora = '".$nadadora['id_nadadora']."'";
			//$nota_totalisima = mysql_result(mysql_query($query),0);
			//$clasificacion_nadadoras[$i]['notas_totales'] = $nota_totalisima;
			$clasificacion_nadadoras[$i]['puntos_totales'] = $puntos_totales;
			$clasificacion_nadadoras[$i]['puntos_clasificacion'] = $puntos_totales-$puntos_minimos;
			if($clasificacion_nadadoras[$i]['puntos_totales'] == 0)
				unset($clasificacion_nadadoras[$i]);
			//$html .= "<td>$puntos_totales</td></tr>";		
		  $i++;
		  }
		  @usort($clasificacion_nadadoras,"cmpPuntosDesc");
		 //print_r($clasificacion_nadadoras);

		 $puntos_anterior = 1000;
		 $posicion = 0;
		 foreach($clasificacion_nadadoras as $clasificacion_nadadora){
		 	unset($clasificacion_nadadora["puntos_totales"]);

		  	 $html .= '<tr>';  
		  	if($clasificacion_nadadora['puntos_clasificacion']!=$puntos_anterior)
		  		$posicion++;
		  	$html .= '<td style="width:5%; font-size:11px; font-weight:bold;">'.$posicion.'</td>';
		  	$puntos_anterior=$clasificacion_nadadora['puntos_clasificacion'];
		  	foreach($clasificacion_nadadora as $k => $v){
			  $html .= '<td style="font-size:11px;">'.$v.'</td>';
			}

		   $html .= '</tr>';

		  }
		   unset($clasificacion_nadadoras);

	  }
	$html .= '</table>';
	$pdf->writeHTML($html, true, false, false, false, '');
	









$error_color = "#E65B5E";
$rutina_color_par = "#DEDEDE";
$rutina_color_impar = "#FFFFFF";


	
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento, 'I');

//============================================================+
// END OF FILE
//============================================================+