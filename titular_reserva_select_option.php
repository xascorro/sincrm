<?php  

$valor_reserva = $_GET['reserva'];
$select = "<select id='reserva' class='form-control'>";
    if($valor_reserva=='no')
    	$select .= "<option selected value='no'>Titular</option><option value='si'>Reserva</option>";
    elseif($valor_reserva=='si')
    	$select .= "<option value='no'>Titular</option><option selected value='si'>Reserva</option>";
    elseif($valor_reserva=='si')
    	$select .= "<option value='no'>Titular</option><option value='si'>Reserva</option>";
$select .= "</select>"; 
echo $select;
?>