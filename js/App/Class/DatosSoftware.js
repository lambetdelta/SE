var DatosSoftware={
	no_control:null,
	init:function(){
		$("#frm_sw").submit(DatosSoftware.sendSw);
		$("#div_dt_software").on('click',"img.symbol-delete",DatosSoftware.delete);
	},
	setNoControl:function(no_control){
		DatosSoftware.no_control=no_control;
	},
	sendSw:function(e){
		e.preventDefault();
		DatosSoftware.guardar_sw(EventosForm.no_control);
	},
	delete:function(){
		var registro=this.dataset.registro;
		var description=this.dataset.description;
		// DatosAcademicos.confirmar(DatosAcademicos.no_control,registro);
		confirmarEliminacion('Deseas borrar este elemento ' + description + ' ?',DatosSoftware.deleteSoftware,DatosSoftware.no_control,registro)
	},
	deleteSoftware:function(no_control,registro){//borrar sw
		try{
	        var msn_bloqueado=alertBloqueado('BORRANDO...');
	        $.post('ajax/eliminar_sw.php',{registro:registro,no_control:no_control})
	        .done(function(data){
	            var datos=$.parseJSON(data);
                DatosSoftware.handleResponseLocked(datos.respuesta,msn_bloqueado,'BORRADO EXITOSO',datos.mensaje,no_control)
            }).
	        fail(function(jqXHR, textStatus, errorThrown){
	            ajax_error_alert(jqXHR,textStatus);
	        });
		}catch(e){
		   DatosSoftware.errorCatch(e);
		}
	},
	handleResponseLocked:function(response,msn_bloq,msn_good,msn_error,no_control){
		var msn='';
		if (response == '1') {
			msn=msn_good;
			DatosSoftware.dt_SW(no_control);
		}else
			msn=msn_error;
		msn_bloq.changeMsn(msn);
    	msn_bloq.modal('hide');

	},
	dt_SW:function(no_control){//cargar datos academicos
		try{
			var div_dt_software=document.getElementById('div_dt_software');
     		DatosSoftware.configureViewInit();
            $.post('ajax/dt_sw.php',{no_control:no_control})
            .done(function(data){
             	DatosSoftware.doneResponseDtSw(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown){
				DatosSoftware.configureViewFinal();
				ajax_error(jqXHR,textStatus,$('#div_dt_software'));
            });
        }catch(e){
            viewError(e,'div_dt_software',DatosSoftware.templateTitle());
            DatosSoftware.configureViewFinal();
        }
	},
	doneResponseDtSw:function(data){
		var datos=$.parseJSON(data); 
        var contend='';  
        if(datos.respuesta === '1')
            contend=DatosSoftware.viewItems(datos.sw);
        else
            contend=DatosSoftware.viweNoItems(datos.mensaje);
        div_dt_software.innerHTML=contend;
        DatosSoftware.configureViewFinal();
	}, 
	templateTitle:function(title){
		return '<h2>Software<img tabindex="0" id="agregar_sw" src="Imagenes/mask.png" class="symbol-add margin-both-sides-10"  title="Agregar Software" /></h2>';
	},
	templateItem:function(item){
		return '<Div class="display-flex justify-between margin-sides-10 software-div"><Div><b>'+item.nombre_sw+'</b></Div><Div><img tabindex="0" data-registro="'+item.id_consecutivo+'" data-description="'+item.nombre_sw+'" src="Imagenes/mask.png"  title="ELIMINAR" class="symbol-delete"/></Div></Div>';
	},	
	assembleItems:function(items){
		var result='';
		$.each(items,function(){
            result+=DatosSoftware.templateItem(this);
        });
        return result;
	},
	viewItems:function(items){
		var title=DatosSoftware.templateTitle();
		var items=DatosSoftware.assembleItems(items);
		return title + '<div>'+items+'</div>';
	},
	viweNoItems:function(msn){
		var title=DatosSoftware.templateTitle();
		return title + '<p>' +msn+ '</p>';
	},
	configureViewFinal:function(){
		$('#img_cargando_sw').hide();
        $('#div_dt_software').show();
	},
	configureViewInit:function(){
		$("#div_dt_software").hide();
        $("#div_dt_software").html('');
        $("#img_cargando_sw").show();
	},
	guardar_sw:function(no_control){//guardar nuevo idioma
	try{
        $("#img_enviar_sw").show();//img guardado
        $("#frm_sw").hide();//ocular formulario
        $.post('ajax/agregar_sw.php',{form:$('#frm_sw').serialize(),no_control:no_control})
        .done(function(data){
            DatosSoftware.handleResponse(data,no_control);
        })
        .fail(function(jqXHR, textStatus, errorThrown){
          	ajax_error_alert(jqXHR,textStatus);
        })
        .always(function(){
        	DatosSoftware.saveFinalView();
        });
        }catch(e){
            DatosSoftware.errorCatch(e);   
        }
	},
	handleResponse:function(data,no_control){
		datos=$.parseJSON(data);
        if(datos.respuesta=='1')//exito
            DatosSoftware.savedSuccessful(no_control)
        else if(datos.respuesta=='3')//eres muy listo?
            DatosSoftware.limitOfRecords();	
        else //error desde el servidor
            DatosSoftware.errorSaving(datos.mensaje);
	},
	savedSuccessful:function(no_control){
		DatosSoftware.dt_SW(no_control);
		alert('Guardado');
	},
	limitOfRecords:function(){
		alert("Maximo 15 registros");	
	},
	errorSaving:function(msn){
		alert(msn);
	},
	errorCatch:function(msn){
		alert(msn);
	},
	saveFinalView:function(){
		$('#img_enviar_sw').hide();
		show_SW();
		setTimeout('$("#frm_sw").show();',2000);
	}
}