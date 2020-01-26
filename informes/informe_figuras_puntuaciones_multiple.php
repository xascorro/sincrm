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
	    $GLOBALS["header"] = $registro['header_informe'];
	    $GLOBALS["footer"] = $registro['footer_informe'];
	    $GLOBALS["clave_liga"] = $registro['clave_liga'];
	    $GLOBALS["temporada"] = $registro['temporada'];
	    $GLOBALS["año"] = '';
	}
//****************************//
$titulo = $_GET['titulo'];
$titulo_documento = $GLOBALS['temporada'].'<br>'.$GLOBALS['clave_liga']." de Natación Artística FNRM<br>$titulo";
$nombre_documento = $titulo.' '.$GLOBALS['nombre_competicion_activa'];
$GLOBALS['footer_substring'] = "Sede: ".$GLOBALS['lugar']."<br> Fecha de la competición: ".$GLOBALS['fecha'];
$logo_header_width= 100;
$GLOBALS['header_image'] = '../'.$GLOBALS['header'];
$GLOBALS['footer_image'] = '../'.$GLOBALS['footer'];

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $this->SetFont('helvetica', 16);
        $this->WriteHTML('<img style="border-bottom:1px #cecece;" src="'.$GLOBALS['header_image'].'">', false, false, false, false, '');
        $this->SetXY(25,12);
        $this->WriteHTML('<div style="text-align:center; font-size:19px; font-weight:bold">'.$GLOBALS['titulo_documento']." ".$GLOBALS['ano']."</div>", false, false, false, false, '');

    }

    //Page footer
    public function Footer() {
        // Logo
        $this->SetFont('helvetica', 12);
$x = 100;
        $y = 180;
$w = '180';
$h = '';
        $this->Image($GLOBALS['footer_image'], $x, $y, $w, $h, 'JPG', '', '', false, 300, '', false, false, 0, 'L', false, false);



        $this->SetXY(25,278);
		$pagenumtxt = $this->PageNo().' de '.($this->getAliasNbPages());
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
$pdf->SetFont('helvetica', 'B', 14);

// -----------------------------------------------------------------------------
if(isset($_GET['ver_liga'])){
    $j1_color = '#FFCDD2';
    $j2_color = '#F8BBD0';
    $j3_color = '#E1BEE7';
    $j4_color = '#C5CAE9';
    $total_color = '#DCEDC8';
	$clave_liga = $GLOBALS['clave_liga'];
	$query = "select año from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '$clave_liga') group by año order by año desc";
	$años = mysql_query($query);
	while($año = mysql_fetch_array($años)){
        $query = "select nombre_corto, fecha, lugar, color from competiciones where clave_liga like '$clave_liga' order by id asc";
	$jornadas_liga = mysql_query($query);
        // add a page
        $GLOBALS['ano'] = $año['año'];
	$pdf->AddPage('L');
	$pdf->SetFont('helvetica', '', 14);
	$html = "<br>";
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 12);
	$html = '<table align="center" border="1" cellpadding="4">';
	$html.= '<tr style= "font-weight:bold;"><th style="width:3%;"><span>&nbsp;</span><br><span style="font-size:18px">P</span></th><th style="width:30%"><span>&nbsp;</span><br><span style="font-size:18px">Nadadora</span></th><th width="23%"><span>&nbsp;</span><br><span style="font-size:18px">Club</span></th>';		 
	while($jornada_liga = mysql_fetch_array($jornadas_liga)){
	   $html .= '<th width="9%" style="background-color:'.$jornada_liga['color'].'">'.$jornada_liga['nombre_corto'].'<br><span style="font-size:10px">'.dateAFecha($jornada_liga['fecha']).'</span><br><span style="font-size:10px">'.$jornada_liga['lugar'].'</span></th>';
	}
	$html .= '<th width="6%" style="background-color:'.$total_color.'"><span>&nbsp;</span><br><span style="font-size:18px">Total</span></th></tr>';
	 $i = 0;
		  $clasificacion_nadadoras[] = "";
		  $query = "select distinct(id_nadadora) from resultados_figuras where año = '".$año['año']."'  and id_competicion in (select id from competiciones where clave_liga like '$clave_liga')";
		  $nadadoras = mysql_query($query);
			   
		  $numero_jornadas_liga = mysql_result(mysql_query("select count(id) from competiciones where clave_liga like '$clave_liga'"), 0);
		  while($nadadora = mysql_fetch_array($nadadoras)){
			$puntos_totales = 0;
			$query = "select apellidos from nadadoras where id = '".$nadadora['id_nadadora']."'";
			$nombre_nadadora = mysql_result(mysql_query($query),0);
			$query = "select nombre from nadadoras where id = '".$nadadora['id_nadadora']."'";
			$nombre_nadadora .= ", ".mysql_result(mysql_query($query),0);
			$clasificacion_nadadoras[$i]['nombre'] =$nombre_nadadora;
			$query = "select nombre from clubs where id in (select club from nadadoras where id = '".$nadadora['id_nadadora']."')";
			$nombre_club = mysql_result(mysql_query($query),0);
			//$html .= '<tr><td>'.$nombre_nadadora.'</td><td>'.$nombre_club.'</td>';
			$clasificacion_nadadoras[$i]['nombre_club'] =$nombre_club;
			$query = "select id, color from competiciones where clave_liga like '$clave_liga'";
			$jornadas_liga = @mysql_query($query);
			while($jornada_liga = mysql_fetch_array($jornadas_liga)){
				$id_jornada_liga = $jornada_liga['id'];
				$query = "select coalesce(puntos,0) from resultados_figuras where id_nadadora = '".$nadadora['id_nadadora']."' and id_competicion = '".$id_jornada_liga."'";
				$puntos =@mysql_result(mysql_query($query), 0);
				if($puntos == "" or $id_jornada_liga > $GLOBALS['id_competicion_activa'])
					$puntos = 0;
				$clasificacion_nadadoras[$i]['c'.$id_jornada_liga] =$jornada_liga['color'];
				$clasificacion_nadadoras[$i][$id_jornada_liga] =$puntos;
				$puntos_totales = $puntos_totales+$puntos;

			}
      if(isset($_GET['resta_peor_puntuacion'])){
        $query = "select coalesce(min(puntos),0) from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '$clave_liga') and id_nadadora = '".$nadadora['id_nadadora']."'";
  			$puntos_minimos = @mysql_result(mysql_query($query),0);
      }else{
        $puntos_minimos = 0;
      }
      $query = "select count(puntos) from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '$clave_liga') and id_nadadora = '".$nadadora['id_nadadora']."'";
			$participacion_nadadora = @mysql_result(mysql_query($query),0);
			//echo 'puntos-minimos'.$puntos_minimos.'participacion'.$participacion_nadadora.'jornadas'.$numero_jornadas_liga.'<br>';
			if($participacion_nadadora < $numero_jornadas_liga )
				$puntos_minimos = 0;
			//$query = "select coalesce(sum(nota_final_calculada),0) - coalesce(min(nota_final_calculada),0) from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '%$clave_liga%') and id_nadadora = '".$nadadora['id_nadadora']."'";
			//$nota_totalisima = mysql_result(mysql_query($query),0);
			//$clasificacion_nadadoras[$i]['notas_totales'] = $nota_totalisima;
			$clasificacion_nadadoras[$i]['c_puntos_totales'] = $total_color ;
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
        $bgcolor1= '#cecece';
        $bgcolor2 = '#ffffff';
		 foreach($clasificacion_nadadoras as $clasificacion_nadadora){
		 	unset($clasificacion_nadadora["puntos_totales"]);

		  	if($clasificacion_nadadora['puntos_clasificacion']!=$puntos_anterior){
		  		$posicion++;
                $bgcolor = $bgcolor1;
                $bgcolor1 = $bgcolor2;
                $bgcolor2 = $bgcolor;
            }
            $html .= '<tr style="background-color:'.$bgcolor.'">';
		  	$html .= '<td style="width:3%; font-size:14px; font-weight:bold; background-color:'.$bgcolor.'">'.$posicion.'</td>';
		  	$puntos_anterior=$clasificacion_nadadora['puntos_clasificacion'];
             $color = '';
		  	foreach($clasificacion_nadadora as $k => $v){
                if(strpos($v, '#') === false){
                    $html .= '<td style="font-size:14px; background-color:'.$color.'">'.$v.'</td>';
                    $color = '';
                }else{
                    $color = $v;
                }
//                print_r($clasificacion_nadadora);
			}

		   $html .= '</tr>';

		  }
		   unset($clasificacion_nadadoras);
		   	$html .= '</table>';
	$pdf->writeHTML($html, true, false, false, false, '');
        /*	explicar metodo puntuacion */
	$html = "En cada jornada de liga se repartirán 19, 16, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1 y 0 puntos en función de la clasificación de dicha jornada (Primer puesto 19 puntos, segundo puesto 16 puntos y así sucesivamente).<br>La puntuación final de cada nadadora en la liga se obtendrá sumando los puntos obtenidos en cada jornada y restando los puntos de la jornada con peor puntuación.";
//        <br>Si ocurriera un empate en la puntuación final se sumaran las notas finales calculadas dadas por los jueces en cada jornada de liga exceptuando la peor nota final calculada.
	$pdf->SetFont('helvetica', 14);
        	$pdf->writeHTML($html, true, false, false, false, '');


	  }
}



//Función para ordenar clasificacion descendentemente
function cmpPuntosDesc($jugador1, $jugador2)
{
     //Si son iguales se devuelve 0
     if($jugador1["puntos_clasificacion"]==$jugador2["puntos_clasificacion"]){
   	    if($jugador1["puntos_totales"]==$jugador2["puntos_totales"])
	         return 0;
   	     if($jugador1["puntos_totales"]<$jugador2["puntos_totales"])
	         return 1;
	     return -1;
     }
     //Si jugador1 > 2 se devuelve 1 y por lo contrario -1
     if($jugador1["puntos_clasificacion"]<$jugador2["puntos_clasificacion"])
          return 1;
     return -1;
}
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
