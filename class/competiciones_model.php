<?php
require_once('db_abstract_model.php');
class competicion extends DBAbstractModel {
	public $id;
	public $nombre;
	public $lugar;
	public $piscina;
	public $fecha;
	public $organizador_tipo;
	public $organizador;
	public $activo;
	public $figuras;
	public $no_federado;
	public $contacto;
	public $email;
	public $telefono;
	public $clave_liga;
	public $nombre_corto;
	public $hora_inicio;
	public $hora_fin;
	public $header_informe;
	public $footer_informe;
	public $table = 'competiciones';
	public $mensaje;

	function __construct($id){
		$this->id = $id;
	}
	# Traer datos de una competicion
	public function get() {
		if($this->id != ''){
			$this->query = "
			SELECT *
			FROM $this->table
			WHERE id = '$this->id'
			";
			$this->get_results_from_query();

		}

		if(count($this->rows) ==1){
			foreach ($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad = $valor;
			}
				$this->fecha = dateAFecha($this->fecha);
			//$this->mensaje = $nombre_mensaje.' encontrada';
		}else{
			$this->mensaje = $nombre_mensaje.' no encontrada';
		}
	}
	
	# Crear una competición
	public function set($user_data=array()) {
		if(array_key_exists('id', $user_data)){
			$this->get($user_data['id']);
			if($user_data['id'] != $this->id){
				foreach ($user_data as $campo=>$valor){
					$$campo = $valor;
					echo $valor;
				}
				$this->fecha = fechaADate($this->fecha);
				$this->query = "
				INSERT INTO competiciones
				(nombre, lugar, piscina, fecha, organizador_tipo, organizador, activo, figuras, no_federado, contacto, email, telefono, clave_liga, nombre_corto, hora_inicio, hora_fin, header_informe, footer_informe)
				VALUES
				('$nombre', '$lugar', '$piscina', '$fecha', '$organizador_tipo', '$organizador', '$activo', '$figuras', '$no_federado', '$contacto', '$email', '$telefono', '$clave_liga', '$nombre_corto', '$hora_inicio', '$hora_fin', '$header_informe', '$footer_informe')
				";
				$this->execute_single_query();
				$this->mensaje = 'Competición agregada exitosamente';
			} else{
				$this->mensaje = 'La competición ya exite';
			}
		} else{
			$this->mensaje = 'No se ha agregado la competición';
		}
	}

	# Modificar una competición
	public function edit($user_data=array()) {
		foreach ($user_data as $campo=>$valor){
			$$campo = $valor;
		}
		$fecha = fechaADate($fecha);
		$this->query = "
		UPDATE competiciones
		SET nombre='$nombre',
		lugar='$lugar',
		piscina='$piscina',
		fecha='$fecha',
		figuras='$figuras',
		no_federado='$no_federado',
		clave_liga='$clave_liga',
		nombre_corto='$nombre_corto',
		hora_inicio='$hora_inicio',
		hora_fin='$hora_fin',
		header_informe='$header_informe',
		footer_informe='$footer_informe'
		WHERE id = '$id'";
		$this->execute_single_query();
	}

	# Borrar una competición
	public function delete($id='') {
		$this->query = "
		DELETE FROM $this->table
		WHERE id = '$id'
		";
		$this->execute_single_query();
		$this->mensaje = $this->nombre_mensaje.' eliminada';
	}

	function __destruct() {
		unset($this);
	}
}
?>
