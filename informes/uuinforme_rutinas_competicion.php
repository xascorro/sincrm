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



$error_color = "#E65B5E";
$rutina_color_par = "#DEDEDE";
$rutina_color_impar = "#FFFFFF";

$query = "select * from fases where id_competicion = '".$GLOBALS["id_competicion_activa"]."'";
$fases = mysql_query($query);
while($fase = mysql_fetch_array($fases)){
	$query = "select nombre, id from categorias where id = '".$fase['id_categoria']."'"; 
    $nombre_categoria=mysql_result(mysql_query($query),0);
    $id_categoria=mysql_result(mysql_query($query),0,1);
	$query = "select nombre, id from modalidades where id = '".$fase['id_modalidad']."'"; 
    $nombre_modalidad=mysql_result(mysql_query($query),0);
    $id_categoria=mysql_result(mysql_query($query),0,1);

// add a page
$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 14);	
	$html = "<br><br><h2> $nombre_modalidad $nombre_categoria </h2>";
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 12);
	
	$html = '<table style="margin-top=10px">';
	//segun titulo de documento
	if($titulo =='Orden de salida'){
		$html .= '<thead><tr><th width="50%"><h4>Nombre</h4></th><th width="25%"><h4>Licencia</h4></th><th width="25%" aling="right"><h4>Orden de salida</h4></th></tr></thead>';
		$order_by = " order by orden";
	
	}elseif($titulo =='Rutinas'){
	$html .= '<thead><tr><th width="50%"><h4>Nombre</h4></th><th width="25%"><h4>Licencia</h4></th><th width="25%" aling="right"><h4>Fecha nacimiento</h4></th></tr></thead>';
	$order_by = "";
}
	//fin segun titulo documento

	$par=1;
	$query = "select * from rutinas where id_fase='".$fase['id']."' $order_by";
	$rutinas = mysql_query($query);
	while($rutina = mysql_fetch_array($rutinas)){
		$par++;
		if($par%2==0)
			$rutina_color = $rutina_color_par;
		else
			$rutina_color = $rutina_color_impar;
		if(isset($_GET['musica']) && $_GET['musica'] == "si")
			$musica=$rutina['musica']." - ";
		else
			$musica = "";


		if($rutina['nombre'] == ""){
			$query = "select nombre_corto from clubs where id = '".$rutina['id_club']."'"; 
			$nombre_rutina=mysql_result(mysql_query($query),0);
		}else
			$nombre_rutina = $rutina['nombre'];


		//segun titulo de documento
		if($titulo =='Orden de salida'){
			if($rutina['orden']=='-1')
				$rutina['orden']="PRESWIMMER";
			$html .='<tr style="font-size:+18, font-weight:bold; background-color:'.$rutina_color.'"><td>'.$nombre_rutina.'</td><td colspan="2" style="text-align:right;">'.$musica.'<em style="">'.$rutina['orden'].'</em></td></tr>';		
		}elseif($titulo =='Rutinas'){
			$html .='<tr style="font-size:+18, font-weight:bold; background-color:'.$rutina_color.'"><td>'.$nombre_rutina.'</td><td colspan="2" style="text-align:right;">'.$musica.'</td></tr>';
	}
		//fin segun titulo documento
		
		
		//datos participantes
		$query = "select * from rutinas_participantes where id_rutina='".$rutina['id']."'";
		$participantes = mysql_query($query);
		while($participante = mysql_fetch_array($participantes)){
				$query = "select nombre, apellidos, licencia, fecha_nacimiento from nadadoras where id = '".$participante['id_nadadora']."'"; 
				$nombre_participante=mysql_result(mysql_query($query),0);
				$apellidos_participante=mysql_result(mysql_query($query),0,1);
				$licencia_participante=mysql_result(mysql_query($query),0,2);
				$fecha_nacimiento_participante=mysql_result(mysql_query($query),0,3);
				$titular = "";
				if($participante['reserva']=='si')
					$titular = "(R)";
						//segun titulo de documento
				if($titulo =='Orden de salida'){
					$html .='<tr style="background-color:'.$rutina_color.'"><td width="50%">&nbsp;&nbsp;'.$apellidos_participante.', '.$nombre_participante.' '.$titular.'</td><td width="25%">'.$licencia_participante.'</td><td width="25%" style="text-align:right;">'.$fecha_nacimiento_participante.'</td></tr>';
				}elseif($titulo =='Rutinas'){
					$html .='<tr style="background-color:'.$rutina_color.'"><td width="50%">#'.$participante['id'].' -  '.$apellidos_participante.', '.$nombre_participante.' '.$titular.'</td><td width="25%">'.$licencia_participante.'</td><td width="25%" style="text-align:right;">'.$fecha_nacimiento_participante.'</td></tr>';
			}
				//fin segun titulo documento
				
		}
	}
	/*
	$nadadoras_por_club = mysql_num_rows($nadadoras) - $nadadoras_con_error;
	$nadadoras_totales += $nadadoras_por_club;
	*/$html .= '</table><p>Hora de inicio estimada: '.$fase['hora_inicio_estimada'].'h (sujeto a modificaciones, posibles adelantos).</p>';
	$pdf->writeHTML($html, true, false, false, false, '');

}






// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento, 'I');

//============================================================+
// END OF FILE
//============================================================+