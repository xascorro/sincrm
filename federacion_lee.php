<?php  
include('lib/conexion_abre.php');  

    $query = "select * from federaciones";     // Esta linea hace la consulta 
    $result = mysql_query($query);  

    while ($registro = mysql_fetch_array($result)){  
echo "  
    <tr>  
      <td>". $registro['id']."</td>  
      <td>". $registro['nombre']."</td>  
      <td>".$registro['nombre_corto']."</td>  
      <td>".$registro['comunidad']."</td>  
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