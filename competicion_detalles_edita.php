<?php
//abro conexion DB
include('lib/conexion_abre.php');
include('class/competiciones_model.php');
$competicion = new competicion($GLOBALS['id_competicion_activa']);
$competicion->get();
//obtengo los competiciones con sus datos
if(isset($_POST['nombre']) && $_POST['nombre'] != ''){
	foreach($_POST as $nombre_campo => $valor){ 
	   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	   eval($asignacion); 
	}
	$competicion = $competicion->edit($_POST);
	$competicion = new competicion($GLOBALS['id_competicion_activa']);
	$competicion->get();}

?>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Configura y edita la competición
            </header>
            <div class="panel-body">
	             <form class="form-horizontal" role="form" method="post">
	                <input type="hidden" name="id" value="<?php echo $GLOBALS['id_competicion_activa'];?>">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nombre" value="<?php echo $competicion->nombre; ?>"</>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Lugar</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="lugar" placeholder="Lugar de celebración" value="<?php echo $competicion->lugar; ?>"</>
                        </div>
                        <label class="col-sm-1 control-label">Piscina</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="piscina" placeholder="Piscina" value="<?php echo $competicion->piscina; ?>"</>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Fecha</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="" name="fecha" data-mask="99-99-2099" class="form-control" value="<?php echo $competicion->fecha; ?>"</>
                            <span class="help-inline">dd-mm-yyyy</span>
                        </div>
                        <div class="col-sm-1">
                        </div>
                        <label class="col-sm-2 control-label">Hora inicio</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="" name="hora_inicio" data-mask="99:99" class="form-control" value="<?php echo $competicion->hora_inicio; ?>"</>
                            <span class="help-inline">HH-MM</span>
                        </div>
                        <label class="col-sm-1 control-label">Hora fin</label>
                        <div class="col-sm-2">
                            <input type="text" placeholder="" name="hora_fin" data-mask="99:99" class="form-control" value="<?php echo $competicion->hora_fin; ?>"</>
                            <span class="help-inline">HH-MM</span>
                        </div>
                    </div>
                    <div class="checkboxes">
	                    	<?php 
		                    if($competicion->no_federado == 'si'){
			                    $check1 = 'checked';
			                    
		                    }
		                    if($competicion->figuras == 'si'){
			                    $check2 = 'checked';
			                    
		                    }
		                    ?>
                            <label><input name="no_federado" type="checkbox" value="si" <?php echo $check1; ?>> Competición No Federada</label>
                            <label><input name="figuras" type="checkbox" value="si" <?php echo $check2; ?>> Competición de figuras</label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Clave de liga</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="clave_liga" value="<?php echo $competicion->clave_liga; ?>"</>
                        </div>
                        <label class="col-sm-2 control-label">Nombre corto</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="nombre_corto" value="<?php echo $competicion->nombre_corto; ?>"</>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Header para informes</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="header_informe" value="<?php echo $competicion->header_informe; ?>"</>
                            <img src="<?php echo $competicion->header_informe?>" alt="La imagen no existe" class="img-thumbnail">
                        </div>
                        <label class="col-sm-2 control-label">Footer para informes</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="footer_informe" value="<?php echo $competicion->footer_informe; ?>"</>
                            <img src="<?php echo $competicion->footer_informe?>" alt="La imagen no existe" class="img-thumbnail">
                        </div>
                    </div>

                    <button type="submit" class="col-sm-12 btn btn-info">Guardar</button>
                </form>

            </div>
        </section>
    </div>
</div>
<?php
//cierro conexion DB
include('lib/conexion_cierra.php');

?>
