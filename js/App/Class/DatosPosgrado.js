var DatosPosgrado = {
	no_control:null,
	init:function(){
		$("#frm_posgrado").submit(DatosPosgrado.savePosgrado);
		$('#div_dt_posgrado').on('click','.symbol-delete',DatosPosgrado.delete);
	},
	setNoControl:function(no_control){
		DatosPosgrado.no_control=no_control;
	},
	requestDatosPosgrado:function(no_control){
		try{
            $("#div_dt_posgrado").hide();
            $("#img_cargando_posgrado").show();
            $.post('ajax/dt_posgrado.php',{no_control:no_control})
            .done(function(data){
                 DatosPosgrado.doneResponseDatosPosgrado(data);  
            }).
        	fail(function(jqXHR, textStatus, errorThrown){
          		ajax_error(jqXHR,textStatus,$('#div_dt_posgrado'));
            }).
            always(function(){
	        	$("#img_cargando_posgrado").hide();
	          	$('#div_dt_posgrado').show();
            }); 
        }catch(e){
            DatosPosgrado.errorCatch(e);
        }
	},
	doneResponseDatosPosgrado:function(data){
		var datos=$.parseJSON(data); 
        var contend='';  
        if(datos.respuesta === '1')
            contend=DatosPosgrado.viewItems(datos.posgrado);
        else
            contend=DatosPosgrado.viweNoItems(datos.mensaje);
        document.getElementById('div_dt_posgrado').innerHTML=contend;
	}, 
	templateTitle:function(title){
		return  '<h2>Posgrado<img tabindex="0" id="agregar_posgrado" src="Imagenes/mask.png" '+
		'class="symbol-add margin-both-sides-10" title="Agregar posgrado"></h2>';
	},
	templateItem:function(item){
		return '<Div class="div-posgrado form-format-1 position-relative">'+
		'<Div class="display-flex-justify-end"><img tabindex="0" data-registro="'+item.id_posgrado+
		'" data-description="'+item.nombre+'" src="Imagenes/mask.png"  title="ELIMINAR" '+
		' class="symbol-delete"/></Div>'+
		'<Div><label>Posgrado:</label><b>'+item.posgrado+'</b></Div>'+
		'<Div><label>Escuela:</label><b>'+item.escuela+'</b></Div>'+
		'<Div><label>Titulado:</label><b>'+item.titulado+'</b></Div>'+
		'<Div><label>Tipo:</label><b>'+item.nombre+'</b></Div></Div>';
	},	
	assembleItems:function(items){
		var result='';
		$.each(items,function(){
            result+=DatosPosgrado.templateItem(this);
        });
        return result;
	},
	viewItems:function(items){
		var title=DatosPosgrado.templateTitle();
		var items=DatosPosgrado.assembleItems(items);
		return title + '<div>'+items+'</div>';
	},
	viweNoItems:function(msn){
		var title=DatosPosgrado.templateTitle();
		return title + '<p>' +msn+ '</p>';
	},
	savedSuccessful:function(no_control,msn_successful){
		DatosPosgrado.requestDatosPosgrado(no_control);
		alert(msn_successful);
	},
	errorSaving:function(msn){
		alertDanger(msn);
	},
	errorCatch:function(msn){
		alertDanger(msn);
	},
	delete:function(){
		var registro=this.dataset.registro;
		var description=this.dataset.description;
		confirmarEliminacion('Deseas borrar este posgrado:' + description + '?',DatosPosgrado.deletePosgrado,DatosPosgrado.no_control,registro)
	},
	deletePosgrado:function(no_control,registro){
	try{
            var msn_bloqueado=alertBloqueado('BORRANDO...','danger');
            $.post('ajax/borrar_posgrado.php',{registro:registro,no_control:no_control})
            .done(function(data){
                DatosPosgrado.handleResponseDelete(data,msn_bloqueado,no_control);
            }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            });
        }catch(e){
            DatosPosgrado.errorCatch(e);
        }
	},	
	handleResponseDelete:function(data,msn_bloqueado,no_control){
		datos=$.parseJSON(data);
        var msn='';
        if(datos.respuesta=='done'){
            msn='BORRADO EXITOSO';
            DatosPosgrado.requestDatosPosgrado(no_control);
        }
        else
            msn="Error"+datos.mensaje;
        msn_bloqueado.changeMsn(msn);
    	msn_bloqueado.modal('hide');
	},
	savePosgrado:function(e){
		try{
			e.preventDefault();
            $("#img_enviar_posgrado").show();
            $("#frm_posgrado").hide();
            $.post('ajax/guardar_posgrado.php',{form:$('#frm_posgrado').serialize(),no_control:DatosPosgrado.no_control})
            .done(function(data){
                DatosPosgrado.handleResponse(data,DatosPosgrado.no_control,'Datos Guardados',datos.mensaje);
            }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            }).
            always(function(){
            	$("#img_enviar_posgrado").hide();
            	$("#frm_posgrado").show();
            	show_posgrado();
            });//
        }catch(e){
            DatosPosgrado.errorCatch(e);
        }
    },
    handleResponse:function(data,no_control,msn_successful,msn_error){
		datos=$.parseJSON(data);
        if(datos.respuesta == 'done')
            DatosPosgrado.savedSuccessful(no_control,msn_successful)
        else if(datos.respuesta == '3')
            DatosPosgrado.limitOfRecords();	
        else 
            DatosPosgrado.errorSaving(datos.mensaje);
	}
}