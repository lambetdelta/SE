<?php
class ManufactureView{
	private $no_control;
	
	function __construct($no_control){
		$this->no_control=$no_control;
	}

	public function viewDatosEgresado($data){
		if($data != FALSE){
			if($data->num_rows > 0){
				$row = $data->fetch_assoc();
				$div = $this->divDatosEgresado($row);
				echo $div;	
			}else
				echo $GLOBALS['not_found'];
		}else
			echo $GLOBALS['db_faild'];
			
	}
	private function divDatosEgresado($data){
		$html = $this->templateTitleData('Datos Personales','editar margin-both-sides-10','img_editar','Editar','Imagenes/edit-green-64-pri.png').
				$this->divDatoEgresadoNombre($data).
				$this->divDatoGeneralEgresado($data);
		return $this->templateDiv($html,'display-flex form-format');
	}
	private function divDatoGeneralEgresado($data){
		return $this->templateDiv($this->makeLabelsDatosEgresado($data),
			'display-flex form-format width-100 justify-between');
	}
	private function divDatoEgresadoNombre($data){
		return $this->templateDiv($this->makeNombreEgresado($data),'width-100');
	}
	private function makeNombreEgresado($data){
		$nombre = $data['nombre'].' '.$data['apellido_p'].' '.$data['apellido_m']; 
		return  $this->templateLabel('Nombre:',$nombre);
	}
	private function makeLabelsDatosEgresado($data){
		$labels='';
		$labels = $labels.$this->templateLabel('CURP:',$data['curp']);
		$labels = $labels.$this->templateLabel('Género:',$data['genero']);
		$labels = $labels.$this->templateLabel('Teléfono:',$data['telefono']);
		$labels = $labels.$this->templateLabel('Email:',$data['email']);
		$labels = $labels.$this->templateLabel('Fecha de nacimiento:',$data['fecha_nacimiento']);
		$labels = $labels.$this->templateLabel('Ciudad:',$data['ciudad_localidad']);
		$labels = $labels.$this->templateLabel('Colonia:',$data['colonia']);
		$labels = $labels.$this->templateLabel('Calle:',$data['calle']);
		$labels = $labels.$this->templateLabel('No. casa:',$data['numero_casa']);
		$labels = $labels.$this->templateLabel('C.P:',$data['cp']);
		$labels = $labels.$this->templateLabel('Estado:',$data['estado']);
		$labels = $labels.$this->templateLabel('Municipio:',$data['municipio']);
		return $labels;
	}
	private function templateLabel($name,$contend,$css='',$data_attributes=''){
		return '<label class="'.$css.'" '.$data_attributes.' >'.$name.'<b>'.$contend.'</b></label>';
	}
	private function templateDiv($contend,$css='',$data_attributes=''){
		return '<div class="'.$css.'" '.$data_attributes.'>'.$contend.'</div>';
	}
	private function templateTitleData($contend,$css_img,$id_img,$title,$src='Imagenes/mask.png'){
		return '<h2>'.$contend.'<img src="'.$src.'" class="'.$css_img.'" id="'.$id_img.'" title="'.$title.'" tabindex="0"/></h2>';
	}
} 