<?php
include('lib/conexion_abre.php');

$query = "select * from competiciones";     // Esta linea hace la consulta
$result = mysql_query($query);

while ($registro = mysql_fetch_array($result)){
    if($registro['organizador_tipo']=="Club")
    $tabla="clubs";
    elseif($registro['organizador_tipo']=="Federación")
    $tabla="federaciones";
    $query = "select nombre_corto from $tabla where id = '".$registro['organizador']."'";
    $nombre_organizador=mysql_result(mysql_query($query),0);
    $if($registro['activo']=='no')
    $activo = "<i class='fa fa-toggle-off text-danger'></i>";
    else
    $activo = "<i class='fa fa-toggle-on text-success'></i>";

    echo "
    <tr>
    <td>". $registro['id']."</td>
    <td>". $registro['nombre']."</td>  
    <td>".$registro['lugar']."</td>
    <td>".$registro['fecha']."</td>
    <td>".$registro['organizador_tipo']."</td>
    <td>$nombre_organizador</td>
    <td>".$activo."</td>  ";
    ?>
    <td><a class="edit edit_club" href="javascript:;">Editar</a></td>
    <td><a class="delete delete_club" id="<?php echo $registro['id']; ?>" href="">Borrar</a></td>

    <?php
    echo "
    </tr>
    ";
}
include('lib/conexion_cierra.php');
?>
