var DatosPersonales={
	no_control:null,
	StructureDatosEgresado:null,
	init:function(){
		$("#frm_Datos_Personales").submit(DatosPersonales.sendDatosPersonales);
		$("#contendedor_d1").on('click keypress',".editar",DatosPersonales.loadForm);
	},
	setNoControl:function(no_control){
		DatosPersonales.no_control=no_control;
	},
	sendDatosPersonales:function(e){
		e.preventDefault();
		if(validar_Est_Mun())
		 	DatosPersonales.save_datos(DatosPersonales.no_control);
	},
	loadForm:function(){
		var inputs=document.getElementById('frm_Datos_Personales').getElementsByTagName('input');
		var length=inputs.length -1;
		for (var i = 0; i <= length; i++) {
			if (inputs[i].type == 'text' || inputs[i].type == 'email') {
				inputs[i].value=DatosPersonales.StructureDatosEgresado.getValueByName(inputs[i].getAttribute('name'));
			}
			
		}
	},
	save_datos:function(no_control){//guardar datos básicos egresado
	    try{
        $("#enviar").show();//ocultar y mostrar frm, gif de envio
		$("#frm_Datos_Personales").hide();	
		$.post("ajax/guardar_datos.php",{form:$('#frm_Datos_Personales').serialize(),no_control:no_control})
		.done(function(data){//evaluando respuesta del servidor
	        DatosPersonales.handleResponse(data,no_control,'Datos Guardados',datos.mensaje)        
		}).
		fail(function(jqXHR, textStatus, errorThrown){
           ajax_error_alert(jqXHR,textStatus);
        }).
        always(function(){
        	$("#enviar").hide();//ocultar y mostrar frm, gif de envio
			$("#frm_Datos_Personales").show();
			show();
        });    
	    }catch(e){
	        DatosPersonales.errorCatch(e);
	    }
    },
    setStructure:function(egresado){
    	DatosPersonales.StructureDatosEgresado=StructureDatosEgresado.init(egresado.no_control,
    		egresado.nombre,egresado.apellido_p,egresado.apellido_m,egresado.genero,
    		egresado.fecha_nacimiento,egresado.curp,egresado.email,egresado.ciudad,
    		egresado.calle,egresado.numero_casa,egresado.cp,egresado.colonia,egresado.telefono);
    },
    handleResponse:function(data,no_control,msn_successful,msn_error){
		datos=$.parseJSON(data);
        if(datos.respuesta == '1')//exito
            DatosPersonales.savedSuccessful(no_control,msn_successful)
        else //error desde el servidor
            DatosPersonales.errorSaving(datos.mensaje);
	},
	savedSuccessful:function(no_control,msn_successful){
		DatosPersonales.requestDatosEgresado(no_control);
		alert(msn_successful);
	},
	errorSaving:function(msn){
		alertDanger(msn);
	},
	errorCatch:function(msn){
		alertDanger(msn);
	},	
	requestDatosEgresado:function(no_control){//recuperar datos básicos egresado	
	    try{
	        $("#cargando_frm").show();
			$("#contendedor_d1").hide();
			$.post("contenidos/dt_egresado.php",{no_control:no_control})
			.done(function(data){
            	DatosPersonales.doneResponseRequestDt(data);
            })
			.fail(function(jqXHR, textStatus, errorThrown){
                ajax_error(jqXHR,textStatus);
          	})
			.always(function(){
				$('#contendedor_d1').show();
                $("#cargando_frm").hide();
			}); 
	    }catch (e){
	        DatosPersonales.errorCatch(e);
	    }
	},
	doneResponseRequestDt:function(data){
		var datos=$.parseJSON(data); 
        var contend='';  
        if(datos.resultado === '1'){
        	DatosPersonales.setStructure(datos.egresado);
            contend=DatosPersonales.viewItem(datos.egresado);
        }
        else
            contend=DatosPersonales.viweNoItem(datos.mensaje);
        document.getElementById('contendedor_d1').innerHTML=contend;
        DatosSoftware.configureViewFinal();
	}, 
	viewItem:function(egresado){
		return DatosPersonales.templateTitle() + DatosPersonales.templateDatosPersonales(egresado);
	},
	viweNoItem:function(msn){
		return DatosPersonales.templateTitle() + '<p>' + msn + '</p>';
	},
	templateTitle:function(){
		return '<h2>DATOS PERSONALES<img src="Imagenes/edit-green-64-pri.png"' +
		'class="editar margin-both-sides-10" id="img_editar" title="EDITAR PERFIL" tabindex="0"/></h2>';
	},
	templateDatosPersonales:function(egresado){
		return '<div class="display-flex data-personal"><div class="width-100">'+ 
		'<label>Nombre:<b>'+egresado.nombre+' '+egresado.apellido_p+' '
		+egresado.apellido_m +'</b></label></div><div class="display-flex data-personal width-100">'+
		'<label>CURP:<b>'+egresado.curp+'</b></label>'+
		'<label>Género:<b>'+egresado.genero+'</b></label>'+
		'<label>Teléfono:<b>'+egresado.telefono+'</b></label>'+
		'<label>Email:<b>'+egresado.email+'</b></label>'+
		'<label>Fecha de nacimiento:<b>'+egresado.fecha_nacimiento+'</b></label>'+
		'<label>Ciudad:<b>'+egresado.ciudad+'</b></label>'+
		'<label>Colonia:<b>'+egresado.colonia+'</b></label>'+
		'<label>Calle:<b>'+egresado.calle+'</b></label>'+
		'<label>No. casa:<b>'+egresado.numero_casa+'</b></label>'+
		'<label>C.P:<b>'+egresado.cp+'</b></label>'+
		'<label>Estado:<b>'+egresado.estado+'</b></label>'+
		'<label>Municipio:<b>'+egresado.municipio+'</b></label>'+
		'</div></div>';
	},

}