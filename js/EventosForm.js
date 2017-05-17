var EventosForm={
	no_control:null,
	init:function(){
		$("#frm_Datos_Personales").submit(EventosForm.sendDatosPersonales);
		$("#frm_posgrado").submit(EventosForm.sendPosgrado);
		$("#frm_empresa").submit(EventosForm.sendEmpresa);
		$("#frm_idioma").submit(EventosForm.sendIdioma);
		$("#frm_social").submit(EventosForm.sendSocial);
		$("#frm_residencia").submit(EventosForm.sendResidencia);
		$("#frm_historial").submit(EventosForm.sendHistorial);
		//Eventos mostrar formularios
		$("#contendedor_d1").on('click keypress',".editar",EventosForm.showFormDatosEgresado);
		$("#contendedor_d1").on('click keypress',".editar",EventosForm.showFormDatosEgresado);
	},
	setNoControl:function(no_control){
		EventosForm.no_control=no_control;
	},
	sendDatosPersonales:function(e){
		e.preventDefault();
		if(validar_Est_Mun())
		 	guardar_datos(EventosForm.no_control);
	},
	sendPosgrado:function(e){
		e.preventDefault();
		if($("#select_posgrado").val()!='0' && $("#select_titulado_posgrado").val()!='0'){
			guardar_posgrado(EventosForm.no_control);
		}
		else
			alert('Datos Incompletos');
	},
	sendEmpresa:function(e){
		e.preventDefault();
		var registro=this.dataset.registro;
		if(evaluar_frm_empresa()){
		   if(registro != null){
				actualizar_empresa(EventosForm.no_control,registro);   
		   }else{
				guardar_empresa(EventosForm.no_control);
				$("#div_dt_historial_editar").show();
			}
		}
	},
	sendIdioma:function(){
		e.preventDefault();
		if($("#idiomas").val()!='1'){
			guardar_idioma(EventosForm.no_control);
		}else
			alert('Datos Incompletos');
	},
	sendSocial:function(e){
		e.preventDefault();
		var registro=this.dataset.registro;
		if($("#select_social").val()!='1'){
		if(registro != null){
			//sin implementar actualizar	
		}else{
			guardar_social(EventosForm.no_control);	
		}
		}else
		alert_('Datos Incompletos');
	},
	sendResidencia:function(e){
		e.preventDefault();
		guardar_residencia(EventosForm.no_control);
	},
	sendHistorial:function(e){
		e.preventDefault();
		var registro=this.dataset.registro;
		if(registro != null){
			actualizar_historial(EventosForm.no_control,registro);   
	    }else{
			guardar_historial(EventosForm.no_control);
		}
	},
	showFormDatosEgresado:function(e){
		if (e.originalEvent == "KeyboardEvent keypress") {
			if(e.which===13){
	            show();
	        }
	        return false;
	    }
		show();
	}
}