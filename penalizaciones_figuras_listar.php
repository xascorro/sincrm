<?php
$fase_figuras = $_GET['id_fase_figuras'];

include("./lib/conexion_abre.php");

echo "<div class='col-md-2'>";
include('figura_penaliza_select_option.php');
echo "</div>";
echo "<div class='col-md-2'>";
include('penalizacion_select_option.php');
echo "</div>";
echo "<div class='col-md-4'>";
echo "<h2><a href='javascript:' id='penaliza_figura' id_fase='$fase_figuras' id_rutina='' id_penalizacion=''><i class='fa fa-exclamation-circle'></i></a> Penalizar figura</h2>";
echo "</div>";



//abro table, creo thead y abro tbody
echo '
<table id="table-penalizaciones" class="table table-striped table-hover table-bordered" id="editable-sample">
<thead>
<tr>
<th>#</th>
<th>Club</th>
<th style="text-align:center;">Código</th>
<th style="text-align:center;">Descripción</th>
<th>Puntos</th>
<th>Borrar</th>
</tr>
</thead>
<tbody id="tbody">';



//leo penalizaciones
$query = "select * from penalizaciones_rutinas where id_inscripcion_figuras in (select id from inscripciones_figuras where id_fase_figuras = '".$_GET['id_fase_figuras']."') order by id_inscripcion_figuras";
$penalizaciones = mysql_query($query);

while ($penalizacion = mysql_fetch_array($penalizaciones)){
    $query = "select apellidos, nombre from nadadoras where id in (select id_nadadora from inscripciones_figuras where id = '".$penalizacion['id_inscripcion_figuras']."')";
    $nombre_nadadora=mysql_result(mysql_query($query),0).", ".mysql_result(mysql_query($query),0,1);
    $id_inscripcion_figuras=$penalizacion['id_inscripcion_figuras'];
    $query = "select orden from inscripciones_figuras where id = '".$id_inscripcion_figuras."'";
    $orden=mysql_result(mysql_query($query),0);
    echo "<thead>
    <tr class='p".$penalizacion['id']."' id='p".$penalizacion['id']."'>
    <th><h5>$orden</h5></th>
    <th><h5>$nombre_nadadora</h5></th>";
    $query = "select codigo, descripcion, puntos from penalizaciones where id = '".$penalizacion['id_penalizacion']."'";
    $codigo_penalizacion=mysql_result(mysql_query($query),0);
    $descripcion_penalizacion=mysql_result(mysql_query($query),0,1);
    $puntos_penalizacion=mysql_result(mysql_query($query),0,2);
    echo "
    <th><h5>".$codigo_penalizacion."</h5></th>
    <th>".$descripcion_penalizacion."</th>
    <th><h5>".$puntos_penalizacion."</h5></th>";
    echo "
    <td style='padding:0px; text-align:center; background-color:; vertical-align:middle; font-size:x-large;'><a href='javascript:' class='penalizacion_borrar' id_inscripcion_figuras='$id_inscripcion_figuras' id_penalizacion='".$penalizacion['id']."'><i class='fa fa-times-circle-o'></i></a></td>
    </tr>
    </thead> ";


}





echo '</tbody></table>';

include('lib/conexion_cierra.php');
?>
