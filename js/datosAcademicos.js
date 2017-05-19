var DatosAcademicos={
	no_control:null,
	init:function(){
		$("#datos_academicos").on('click',"img.symbol-delete",DatosAcademicos.Eliminar);
		$("#datos_academicos").on('click keypress','img.symbol-edit',DatosAcademicos.configurarDatosAcademicosEdicion);
		$("#datos_academicos").on('click keypress','#agregar_carrera',DatosAcademicos.configurarDatosAcademicosNuevo);
		$("#frm_dt_academico").submit(DatosAcademicos.sendDatosAcademicos);
	},
	setNoControl:function(no_control){
		DatosAcademicos.no_control=no_control;
	},
	Eliminar:function(){
		var registro=this.dataset.registro;
		var carrera=this.dataset.carrera;
		// DatosAcademicos.confirmar(DatosAcademicos.no_control,registro);
		confirmarEliminacion('Deseas borrar esta carrera ?'+carrera,DatosAcademicos.borrar_carrera,DatosAcademicos.no_control,registro)
	},
  	borrar_carrera:function(no_control,registro){//borrar carrera
    try{
	    var msn_bloqueado=alertBloqueado('BORRANDO...');
	    $.post('ajax/eliminar_carrera.php',{registro:registro,no_control:no_control})
	    .done(function(data){
	        datos=$.parseJSON(data);
	        var msn='';
            if(datos.respuesta=='1'){//exito
                msn='BORRADO EXITOSO';
                DatosAcademicos.dt_academicos(no_control);
            }
            else
                msn="Error"+datos.mensaje;
            msn_bloqueado.changeMsn(msn);
        	msn_bloqueado.modal('hide');
	    }).
	    fail(function(jqXHR, textStatus, errorThrown){
	        ajax_error_alert(jqXHR,textStatus);
	    });//fin de done    
    }catch(e){
        alert("Informe"+e);   
    	}
	},
	dt_academicos:function(no_control){//cargar datos academicos
	try{
	    DatosAcademicos.configurarVista();
	  	var frag = document.createDocumentFragment();
        var p=$('<h2>Datos Academicos<img tabindex="0" id="agregar_carrera" src="Imagenes/mask.png" class="symbol-add margin-both-sides-10"  title="Agregar carrera" /></h2>');            
        frag.appendChild(p[0]);
	  	$.post('ajax/dt_academicos.php',{no_control:no_control}).
	  	done(function(data){
            DatosAcademicos.doneResponseDtAcademico(frag,data);
            }).
	  	fail(function(jqXHR, textStatus, errorThrown){
      		ajax_error(jqXHR,textStatus,$('#datos_academicos'));
        });    
        }catch(e){
            frag=DatosAcademicos.vistaError(frag,e);
            $('#datos_academicos').append(frag);
            DatosAcademicos.configurarVistaFinal();
        }
	},
	doneResponseDtAcademico:function(frag,data){
		datos=$.parseJSON(data);   
        if(datos.respuesta==='1')
            frag=DatosAcademicos.vistaDatosAcademicos(frag,datos.carrera);
        else
            frag=DatosAcademicos.vistaSinDatos(frag,datos.mensaje);
     	$('#datos_academicos').append(frag);
        DatosAcademicos.configurarVistaFinal();
	},
	vistaDatosAcademicos:function(frag,datos){
        $.each(datos,function(){
            var div=$('<div class="div_carrera" data-registro="'+this.no_registro+'"/>');
            div.append(DatosAcademicos.plantillaDatoAcademico(this));
            frag.appendChild(div[0]);
        });
        return frag;
	},
	vistaSinDatos:function(frag,msn){
        p=$('<p>Informe:'+msn+'</p>'); 
        frag.appendChild(p[0]);
        return frag;
	},
	vistaError:function(frag,e){
        p=$('<p>Informe:'+e+'</p>'); 
        frag.appendChild(p[0]);
        return frag;
	},
	plantillaDatoAcademico:function(json){
		return template='<div class="display-flex-justify-end" ><img data-titulado="'+json.titulado+'" data-inicio="'+json.fecha_inicio+'" data-fin="'+json.fecha_fin+'" data-codigo_especilidad="'+json.codigo_especialidad+'" data-codigo_carrera="'+json.codigo_carrera+'" data-carrera="'+json.carrera+'" data-registro="'+json.no_registro+'" src="Imagenes/mask.png"  title="EDITAR" class="symbol-edit margin-both-sides-10" tabindex="0"/><img tabindex="0" data-registro="'+json.no_registro+'" data-carrera="'+json.carrera+'" src="Imagenes/mask.png"  title="ELIMINAR" class="symbol-delete margin-both-sides-10" /></div><p>Carrera:<b>'+json.carrera+'</b></p><p>Especialidad:<b>'+json.especialidad+'</b></p><p>Fecha de inicio:<b>'+json.fecha_inicio+'</b></p><p>Fecha de finalización:<b>'+json.fecha_fin+'</b></p><p>Titulado:<b>'+json.titulado+'</b></p>'; 
	},
	configurarVista:function(){
	    $("#datos_academicos").hide();
	    $("#datos_academicos").html('');
	  	$("#img_cargando_dt_academicos").show();
	},
	configurarVistaFinal:function(){
		$('#img_cargando_dt_academicos').hide();
		$('#datos_academicos').show();
	},		
	configurarDatosAcademicosEdicion:function(){
		document.getElementById('frm_dt_academico').dataset.registro=this.dataset.registro;
		DatosAcademicos.configurarFormDatosAcademicosEdicion(this.dataset);
        
	},
	configurarFormDatosAcademicosEdicion:function(dataset){
		document.getElementById('select_titulado').value=(dataset.titulado.length > 1) ? dataset.titulado.length : '0';
		document.getElementById('dp_academico_inicio').value=dataset.inicio;
		document.getElementById('dp_academico_fin').value=dataset.fin;
	},
	configurarDatosAcademicosNuevo:function(){
        document.getElementById('frm_dt_academico').dataset.registro=null;
	},
	sendDatosAcademicos:function(e){
		e.preventDefault();
		if(val_carrera() && $("#select_titulado").val()!='0'){
			var inicio=$('#dp_academico_inicio').val();
			var fin=$('#dp_academico_fin').val();
		 	if (validar_fechas(inicio,fin)){
		 		var registro=this.dataset.registro;
				if(this.dataset.registro != 'null')
					DatosAcademicos.actualizar_carrera(DatosAcademicos.no_control,registro);	
				else
					DatosAcademicos.guardar_dt_academicos(DatosAcademicos.no_control);	
			}else
				alertWarnig('Datos Incompletos');
	 	}else
		 	alertWarnig('Datos Incompletos');
	},
	guardar_dt_academicos:function(no_control){//guarda nueva carrera
        try{
            $("#img_enviar_academico").show();
			$("#frm_dt_academico").hide();
			$.post('ajax/guardar_academico.php',{form:$('#frm_dt_academico').serialize(),no_control:no_control})
			.done(function(data){
		        DatosAcademicos.handleResponse(data,no_control,'Guardado');
			})
	        .fail(function(jqXHR, textStatus, errorThrown){
	            ajax_error_alert(jqXHR, textStatus);
	        })
	        .always(function(){
	        	DatosAcademicos.responseFinalView();
	        });
	    }
	    catch(e){
	        DatosAcademicos.errorThrown(e);   
			DatosAcademicos.responseFinalView(); 
	    }
	},	
	actualizar_carrera:function(no_control,registro){
		try{
		    $("#img_enviar_academico").show();
			$("#frm_dt_academico").hide();
			$.post('ajax/actualizar_academico.php',{form:$('#frm_dt_academico').serialize(),no_control:no_control,registro:registro})
				.done(function(data){//evaluando respuesta del servidor
				    DatosAcademicos.handleResponse(data,no_control,'Actualización Exitosa');
				})
				.fail(function(jqXHR, textStatus, errorThrown){
			    	ajax_error_alert(jqXHR,textStatus);
				})
				.always(function(){
		        	DatosAcademicos.responseFinalView();
		        });
		}catch(e){
			DatosAcademicos.errorThrown(e);   
			DatosAcademicos.responseFinalView(); 
		}
	},
	handleResponse:function(data,no_control,msn,msn_ofrecord=''){
		var datos=$.parseJSON(data);
		if(datos.respuesta=='1')
	        DatosAcademicos.savedSuccessful(no_control,msn);
	    else if(datos.respuesta=='3')
	    	DatosAcademicos.limitOfRecords(msn_ofrecord)
	    else
	        DatosAcademicos.errorSaving(datos.mensaje);
	},
	savedSuccessful:function(no_control,msn){
		limpiaForm($("#frm_dt_academico"));	//exito!!!
		DatosAcademicos.dt_academicos(no_control);
		alert(msn);
	},
	errorSaving:function(msn){
		alert(msn);
	},
	errorCatch:function(msn){
		alert(msn);
	},
	limitOfRecords:function(msn){
		alert(msn);	
	},
	responseFinalView:function(){
		limpiaForm($("#frm_dt_academico"));	
		$("#img_enviar_academico").hide();
		$("#frm_dt_academico").show();
		show_dt_academicos();
	}
}