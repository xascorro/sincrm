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
	    $GLOBALS["enmascarar_licencia"] = $registro['enmascarar_licencia'];
	}
//****************************//
$titulo = $_GET['titulo'];
$titulo_documento = $GLOBALS['nombre_competicion_activa']."<br>$titulo";
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

//se imprime hoja tecnica si se necesita
if(isset($_GET['hoja_tecnica'])){
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 14);
	$html_tec = '<table  nobr="true" style="margin-top=10px">';
	$html_tec .= "<tr><th></th><th></th><th></th><th></th></tr>";

	$html_tec .= '<tr><th style="background-color:#cecece">Competición: </th><th colspan="3">'.$GLOBALS["nombre_competicion_activa"].'</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Fecha y hora: </th><th colspan="3">'.$GLOBALS["fecha"].' de '.$GLOBALS['hora_inicio'].' a '.$GLOBALS['hora_fin'].' horas</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Lugar celebración: </th><th colspan="3">'.$GLOBALS["lugar"].'</th></tr>';
	$html_tec .= '<tr><th style="background-color:#cecece">Piscina: </th><th colspan="3">'.$GLOBALS["piscina"].'</th></tr>';
	if($GLOBALS['organizador_tipo'] == 'Federación')
		$organizador = mysql_result(mysql_query("select nombre from federaciones where id='".$GLOBALS['organizador']."'"),0) ;
	$html_tec .= '<tr><th style="background-color:#cecece">Organizador: </th><th colspan="3">'.$organizador.'</th></tr>';
	$query = "select nombre, codigo from clubs where id in (select distinct club from nadadoras where id in (select distinct id_nadadora from inscripciones_figuras where id_competicion='".$GLOBALS['id_competicion_activa']."'))";


	$clubs_participantes = mysql_query($query);
	$clubs="";
	while($club = mysql_fetch_array($clubs_participantes)){
		$clubs .= $club['nombre']." (".$club['codigo'].") - ";
	}
	$clubs = substr($clubs,0,-2);
	$clubs ="".
	$html_tec .= '<tr><th style="background-color:#cecece">Clubs participanes: </th><th colspan="3">'.$clubs.'</th></tr>';
	//obtengo datos de puesto jueces
	$html_tec .= '<tr><th colspan="4"></th></tr>';
	$query = "select * from puesto_juez where id_competicion='".$GLOBALS['id_competicion_activa']."'";
	$puesto_jueces = mysql_query($query);
	$puesto_anterior = '';
	while($puesto_juez = mysql_fetch_array($puesto_jueces)){
		$nombre = mysql_result(mysql_query("select nombre from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$apellidos = mysql_result(mysql_query("select apellidos from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$licencia = mysql_result(mysql_query("select licencia from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$licencia = substr_replace($licencia, str_repeat('X',$GLOBALS["enmascarar_licencia"]), sizeof($licencia)-$GLOBALS['enmascarar_licencia']-1);

		$id_federacion = mysql_result(mysql_query("select federacion from jueces where id = '".$puesto_juez['id_juez']."'"), 0);
		$federacion = mysql_query("select nombre_corto from federaciones where id = '".$id_federacion."'");
		$federacion = mysql_result($federacion,0);
		if($puesto_anterior != $puesto_juez['nombre'])
			$html_tec .= '<tr style="background-color:#cecece"><th colspan="4">'.$puesto_juez['nombre'].'</th></tr>';
		$puesto_anterior = $puesto_juez['nombre'];
		$html_tec .= '<tr><th>'.$licencia.'</th><th colspan="2">'.$nombre.' '.$apellidos.'</th><th>'.$federacion.'</th></tr>';

	}
		$html_tec .= '<tr style="background-color:#cecece"><th colspan="4">Jueces de puntuación: </th></tr>';

	//obtengo datos jueces puntuacion
	$query = "select distinct id_juez from panel_jueces where id_competicion='".$GLOBALS['id_competicion_activa']."' order by numero_juez";
	$jueces = mysql_query($query);
	while($juez = mysql_fetch_array($jueces)){
		$licencia_juez = mysql_result(mysql_query("select licencia from jueces where id = '".$juez['id_juez']."'"), 0);
		$licencia_juez = substr_replace($licencia_juez, str_repeat('X',$GLOBALS["enmascarar_licencia"]), sizeof($licencia_juez)-$GLOBALS['enmascarar_licencia']-1);
		$nombre_juez = mysql_result(mysql_query("select nombre from jueces where id = '".$juez['id_juez']."'"),0).' '.mysql_result(mysql_query("select apellidos from jueces where id = '".$juez['id_juez']."'"), 0);
		$federacion = mysql_result(mysql_query("select federacion from jueces where id = '".$juez['id_juez']."'"),0);
		$federacion = mysql_result(mysql_query("select nombre_corto from federaciones where id = '".$federacion."'"),0);
		$html_tec .= '<tr><th>'.$licencia_juez.'</th><th colspan="2">'.$nombre_juez.'</th><th>'.$federacion.'</th></tr>';

	}



	$html_tec .= '<tr><th colspan="3"></th><th><br>Fdo. Juez Árbitro<br></th></tr>';
	$html_tec .= "</table>";
	$pdf->writeHTML($html_tec, true, false, true, false, '');
}
//

if(isset($_GET['ver_liga'])){
	$clave_liga = mysql_result(mysql_query("select clave_liga from competiciones where id = '".$GLOBALS['id_competicion_activa']."'"),0);
	// add a page
	$pdf->AddPage();
	$pdf->SetFont('helvetica', '', 11);
	$html = "<h3> Clasificación $clave_liga </h3>";
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->SetFont('helvetica', '', 5);
	$html = '<table align="center" border="1">';
	$html.= '<tr style="width:5%; font-size:14; font-weight:bold;"><th style="width:5%;">P</th><th width="30%">Nadadora</th><th width="10%">Club</th>';
	$query = "select nombre_corto from competiciones where clave_liga like '$clave_liga' order by id asc";
	$jornadas_liga = mysql_query($query);
	while($jornada_liga = mysql_fetch_array($jornadas_liga)){
	$html .= '<th width="10%">'.$jornada_liga['nombre_corto'].'</th>';
	}
	$html .= '<th>Total</th></tr>';
	$query = "select año from resultados_figuras where id_competicion in (select id from competiciones where clave_liga like '$clave_liga') group by año order by año";
	$años = mysql_query($query);
	while($año = mysql_fetch_array($años)){
		  $i = 0;
		  $clasificacion_nadadoras[] = "";
		  $query = "select distinct(id_nadadora) from resultados_figuras where año = '".$año['año']."'  and id_competicion in (select id from competiciones where clave_liga like '$clave_liga')";
		  $nadadoras = mysql_query($query);
			   $html .= '<tr style="background-color:#dedede;"><td colspan="8"><h2>Clasificación año '.$año['año'].'</h2></td>';
			   $html .= "</tr>";
		  $numero_jornadas_liga = mysql_result(mysql_query("select count(id) from competiciones where clave_liga like '$clave_liga'"), 0);
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
			$query = "select id from competiciones where clave_liga like '$clave_liga%'";
			$jornadas_liga = @mysql_query($query);
			while($jornada_liga = mysql_fetch_array($jornadas_liga)){
				$id_jornada_liga = $jornada_liga['id'];
				$query = "select coalesce(puntos,0) from resultados_figuras where id_nadadora = '".$nadadora['id_nadadora']."' and id_competicion = '".$id_jornada_liga."'";
				$puntos =@mysql_result(mysql_query($query), 0);
				if($puntos == "" or $id_jornada_liga > $GLOBALS['id_competicion_activa'])
					$puntos = 0;
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
		  	$html .= '<td style="width:5%; font-size:10px; font-weight:bold;">'.$posicion.'</td>';
		  	$puntos_anterior=$clasificacion_nadadora['puntos_clasificacion'];
		  	foreach($clasificacion_nadadora as $k => $v){
			  $html .= '<td style="font-size:10px;">'.$v.'</td>';
			}

		   $html .= '</tr>';

		  }
		   unset($clasificacion_nadadoras);

	  }
	$html .= '</table>';
/*	explicar metodo puntuacion
	$pdf->writeHTML($html, true, false, false, false, '');
	$html = "En cada jornada de liga se repartirán 19, 16, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1 y 0 puntos en función de la clasificación de dicha jornada (Primer puesto 19 puntos, segundo puesto 16 puntos ...).<br>La puntuación final de cada nadadora en la liga se obtendrá sumando los puntos obtenidos en cada jornada a excepción de la jornada con peor puntuación.<br>Si ocurriera un empate en la puntuación final se sumaran las notas finales calculadas dadas por los jueces en cada jornada de liga exceptuando la peor nota final calculada.";
	$pdf->SetFont('helvetica', 14);*/
	$pdf->writeHTML($html, true, false, false, false, '');

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





$error_color = "#E65B5E";
$rutina_color_par = "#DEDEDE";
$rutina_color_impar = "#FFFFFF";

$condicion_ampliada = "";
if(isset($_GET['id_fase'])){
	$condicion_ampliada = "and id = '".$_GET['id_fase']."'";
	$id_fase = $_GET['id_fase'];
}
/*************************/
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
// obtengo las figuras y el grado de dificultad
	$query = "select id_figura from fases_figuras where id_categoria='".$categoria['id_categoria']."' and id_competicion='".$GLOBALS['id_competicion_activa']."'";
	$figuras = mysql_query($query);
	$figuras_texto = '';
	while($figuras2 = mysql_fetch_array($figuras)){
		$query = "select numero, grado_dificultad from figuras where id ='".$figuras2['id_figura']."'";
		$figuras3 = mysql_query($query);
		$figuras4 = mysql_fetch_row($figuras3);
		$figuras_texto .= $figuras4[0].' GD:'.$figuras4[1].'<br>';
	}
	$query = "select año from resultados_figuras where id_categoria='".$categoria['id_categoria']."' and id_competicion = '".$GLOBALS["id_competicion_activa"]."' group by año order by año desc";
	$años = mysql_query($query);
	while($año = mysql_fetch_array($años)){
	$html = "<h2> Año ".$año['año']."</h2>";


$html .= '<table style="margin-top=10px">';
	$html .= '<thead><tr style="background-color:'.$rutina_color_par.'"><th style="width:5%">Pos.</th><th style="width:34%">Nadadora</th><th style="width:11%">Figura</th><th style="width:18%">Jueces</th><th style="width:7%">Nota</th><th style="width:8%">Pen.</th><th style="width:8%">Total</th><th style="width:7%">Dif</th><th style="width:7%">Puntos</th></tr></thead>';
	$par=0;
	$query = "select * from resultados_figuras where id_categoria='".$categoria['id_categoria']."' and id_competicion = '".$GLOBALS["id_competicion_activa"]."' and año='".$año['año']."' order by posicion asc";
	$resultados_figuras = mysql_query($query);
	if(mysql_num_rows($resultados_figuras)>16)
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
		$query = mysql_query("select apellidos, nombre, licencia, club from nadadoras where id='".$resultado_figuras['id_nadadora']."'");
		$nombre_nadadora = mysql_result($query, 0).", ".mysql_result($query,0,1);
		$licencia_nadadora = mysql_result($query, 0,2);
		$licencia_nadadora = substr_replace($licencia_nadadora, str_repeat('X',$GLOBALS["enmascarar_licencia"]), sizeof($licencia_nadadora)-$GLOBALS['enmascarar_licencia']-1);
		$club_nadadora = mysql_result(mysql_query("select nombre_corto from clubs where id = '".mysql_result($query, 0,3)."'"),0);
		$html .= '<tr><td style="width:5%; font-size:14; font-weight:bold;">'.$resultado_figuras['posicion'].'</td>';
		$html .= '<td style="width:34%">'.$nombre_nadadora.' ('.$licencia_nadadora.')<br>'.$club_nadadora.'</td>';
		$html .= '<td style="width:11%">';
		$html .= $figuras_texto;

		$html .= '</td>';
		$celda_puntuaciones_jueces = '<td style="width:18%">';
		$celda_puntuaciones_paneles = '<td style="width:7%">';
		$celda_penalizacion_paneles = '<td style="width:8%">';
		$id_inscripcion_figuras = "";
	    $query = "select * from paneles where puntua='si' and id_competicion='".$GLOBALS['id_competicion_activa']."'";
	    $id_panel = mysql_result(mysql_query($query), 0);
	    $fases_figuras = mysql_query("select * from fases_figuras where id_categoria='".$categoria['id_categoria']."' and id_competicion='".$GLOBALS['id_competicion_activa']."'");
	    while($fase_figuras = mysql_fetch_array($fases_figuras)){
		    $query = "select * from inscripciones_figuras where id_nadadora='".$resultado_figuras['id_nadadora']."' and id_fase_figuras='".$fase_figuras['id']."' and id_competicion='".$id_competicion_activa."'";
		    $query = "select * from puntuaciones_jueces where id_inscripcion_figuras in (select id from inscripciones_figuras where id_nadadora='".$resultado_figuras['id_nadadora']."' and id_fase_figuras='".$fase_figuras['id']."' and id_competicion='".$id_competicion_activa."') order by id_panel_juez";
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
		    $penalizacion_figura = mysql_query($query);
		    while($penalizacion = mysql_fetch_array($penalizacion_figura)){
			    $query = "select codigo as puntos from penalizaciones where id = ".$penalizacion['id_penalizacion'];
			    $puntos = mysql_fetch_array(mysql_query($query));
			    $celda_penalizacion_paneles .= $puntos['puntos'];
		    }
		    $celda_penalizacion_paneles.= "&nbsp;<br>";

		}
		$celda_puntuaciones_jueces .= '</td>';
		$celda_puntuaciones_paneles .= '</td>';
		$celda_penalizacion_paneles .= '</td>';
		$html .= $celda_puntuaciones_jueces.$celda_puntuaciones_paneles.$celda_penalizacion_paneles;
		//$html .= '<td style="width:8%">'.$resultado_figuras['puntos_penalizacion'].'</td>';
		if($resultado_figuras['baja']=='si'){
			$html .= '<td style="width:8%"></td>';
			$html .= '<td style="width:7%"></td>';
			$html .= '<td style="width:7%">BAJA</td></tr>';
		}else{
			$html .= '<td style="width:8%; font-weight:bold">'.$resultado_figuras['nota_final_calculada'].'</td>';
			$html .= '<td style="width:7%">'.$resultado_figuras['diferencia'].'</td>';
			$html .= '<td style="width:7%; font-weight:bold">'.$resultado_figuras['puntos'].'</td></tr>';
		}




	}
	$html .= '</table>';
	$pdf->writeHTML($html, true, false, false, false, '');
}



	}
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($nombre_documento.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
