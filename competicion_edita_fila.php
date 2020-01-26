<?php
//abro conexion DB
include('lib/conexion_abre.php');
include('lib/my_functions.php');

if($_GET['id'] == "nueva_fila"){
    $result = mysql_query("SHOW TABLE STATUS WHERE `Name` = 'competiciones'");
    $data = mysql_fetch_assoc($result);
    $_GET['id'] = $data['Auto_increment'];
    echo "<td value='".$_GET['id']."'><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$_GET['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value=''/></td><td><input type='text' name='lugar' id='lugar' size='30' value=''/></td><td><input name='fecha' id='fecha' type='text' size='15' value=''/></td><td>";
    include("include/organizador_tipo_select_option.php");
    echo "</td><td>";
    $_GET['id_federacion'] = "";
    include ("include/federacion_select_option.php");
    echo "</td><td>";
    include("include/activo_select_option.php");
    echo "</td><td><a href='javascript:' class='guarda_fila' id='new'><i class='fa fa-save fa-2x'></i></a></td><td><a href='javascript:' class='cancela_nueva_fila' id='new'><i class='fa fa-reply fa-2x'></i></a></td>";
}


//obtengo los competiciones con sus datos
$query = "select * from competiciones where id='".$_GET['id']."'";
$competiciones = mysql_query($query);
while ($competicion = mysql_fetch_array($competiciones)){
    echo "<td><input disabled='disabled' name='id' id='id' type='text' size='1' value='".$competicion['id']."'/></td><td><input name='nombre' id='nombre' type='text' size='15' value='".$competicion['nombre']."'/></td><td><input type='text' name='lugar' id='lugar' size='30' value='".$competicion['lugar']."'/></td><td><input name='fecha' id='fecha' type='text' size='15' value='".dateAFecha($competicion['fecha'])."'/></td><td>";
    include("include/organizador_tipo_select_option.php");
    echo "</td><td>";
    if($competicion['organizador_tipo']=="Club"){
        $_GET['id_club'] = $competicion['organizador'];
        include ("include/club_select_option.php");
    }elseif($competicion['organizador_tipo']=="Federación"){
        $_GET['id_federacion'] = $competicion['organizador'];
        include ("include/federacion_select_option.php");
    }

    echo "</td><td>";
    include("include/activo_select_option.php");
    echo "</td><td><a href='javascript:' class='guarda_fila' id='new'><i class='fa fa-save fa-2x'></i></a></td><td><a href='javascript:' class='desedita_fila' id='".$competicion['id']."'><i class='fa fa-reply fa-2x'></a></td>";
}

//cierro conexion DB
include('lib/conexion_cierra.php');

?>
