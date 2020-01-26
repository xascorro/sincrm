<?php  
include('lib/conexion_abre.php');  

    $query = "select * from clubs";     // Esta linea hace la consulta 
    $result = mysql_query($query);  

    while ($registro = mysql_fetch_array($result)){
    $query = "select nombre_corto from federaciones where id = '".$registro['federacion']."'"; 
    $nombre_federacion=mysql_result(mysql_query($query),0);
echo "  
    <tr>  
      <td>". $registro['id']."</td>  
      <td>". $registro['nombre']."</td>  
      <td>".$registro['nombre_corto']."</td>  
      <td>$nombre_federacion</td>  
      <td>".$registro['logo']."</td>  ";
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