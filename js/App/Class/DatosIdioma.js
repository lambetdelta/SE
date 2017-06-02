var DatosIdioma={
	no_control:null,
	init:function(argument) {
		$("#guardar_idioma").click(DatosIdioma.sendIdioma);
		$("#div_idioma").on('click keypress','img.symbol-delete',DatosIdioma.delete);
	},
	setNoControl:function(no_control){
		DatosIdioma.no_control=no_control;
	},
	delete:function(){
		var registro=this.dataset.registro;
		var description=this.dataset.description;
		// DatosAcademicos.confirmar(DatosAcademicos.no_control,registro);
		confirmarEliminacion('Deseas borrar este idioma:' + description + '?' ,DatosIdioma.deleteIdioma,DatosIdioma.no_control,registro)
	},
	deleteIdioma:function(no_control,registro){//borrar carrera
	try{
            var msn_bloqueado=alertBloqueado('BORRANDO...','danger');
            $.post('ajax/eliminar_idioma.php',{registro:registro,no_control:no_control})
            .done(function(data){
                DatosIdioma.handleResponseDelete(data,msn_bloqueado,no_control);
            }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            });
        }catch(e){
            DatosIdioma.errorCatch(e);
        }
	},	
	handleResponseDelete:function(data,msn_bloqueado,no_control){
		datos=$.parseJSON(data);
        var msn='';
        if(datos.respuesta=='1'){//exito
            msn='BORRADO EXITOSO';
            DatosIdioma.requestDatosIdioma(no_control);
        }
        else
            msn="Error"+datos.mensaje;
        msn_bloqueado.changeMsn(msn);
    	msn_bloqueado.modal('hide');
	},
	sendIdioma:function(){
		if($("#idiomas").val()!='1'){
			DatosIdioma.saveIdioma(DatosIdioma.no_control);
		}else
			alert('Datos Incompletos');
	},
	saveIdioma:function(no_control){//guardar nuevo idioma
		try{
            $("#img_enviar_idioma").show();//img guardado
            $("#frm_idioma").hide();//ocular formulario
            $.post('ajax/agregar_idioma.php',{form:$('#frm_idioma').serialize(),no_control:no_control})
            .done(function(data){
                DatosIdioma.handleResponse(data,no_control,'Datos Guardados',datos.mensaje);
            }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            }).
            always(function(){
            	$("#img_enviar_idioma").hide();//img guardado
            	$("#frm_idioma").show();//ocular formulario
            	show_idiomas();
            });//
        }catch(e){
            DatosIdioma.errorCatch(e);
        }
    },
    handleResponse:function(data,no_control,msn_successful,msn_error){
		datos=$.parseJSON(data);
        if(datos.respuesta == '1')//exito
            DatosIdioma.savedSuccessful(no_control,msn_successful)
        else if(datos.respuesta == '3')//eres muy listo?
            DatosIdioma.limitOfRecords();	
        else //error desde el servidor
            DatosIdioma.errorSaving(datos.mensaje);
	},
	savedSuccessful:function(no_control,msn_successful){
		DatosIdioma.requestDatosIdioma(no_control);
		alert(msn_successful);
	},
	errorSaving:function(msn){
		alertDanger(msn);
	},
	errorCatch:function(msn){
		alertDanger(msn);
	},
	limitOfRecords:function(){
		alert("Maximo 8 registros");	
	},
	requestDatosIdioma:function(no_control){//cargar datos academicos
		try{
            $("#img_cargando_idiomas").show();
            $("#div_idioma").hide();
            $.post('ajax/dt_idiomas.php',{no_control:no_control})
            .done(function(data){
         		DatosIdioma.doneResponseDatosIdioma(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown){
          		ajax_error(jqXHR,textStatus);
            })
            .always(function(){
            	$("#img_cargando_idiomas").hide();
            	$("#div_idioma").show();
            });
        }catch(e){
            DatosIdioma.errorCatch(e);  
        }
	},
	doneResponseDatosIdioma:function(data){
		var datos=$.parseJSON(data); 
        var contend='';  
        if(datos.respuesta === '1')
            contend=DatosIdioma.viewItems(datos.idioma);
        else
            contend=DatosIdioma.viweNoItems(datos.mensaje);
        document.getElementById('div_idioma').innerHTML=contend;
	}, 
	templateTitle:function(title){
		return  '<h2>Idiomas<img id="agregar_idioma" tabindex="0"  src="Imagenes/mask.png" class="symbol-add margin-both-sides-10"  title="Agregar Idioma" /></h2>';
	},
	templateTitleItems:function(){
		return '<Div class="display-flex justify-between margin-sides-10 idiomas-div">'+
		'<Div>Idioma</Div>'+
		'<Div>Habla</Div>'+
		'<Div>Escritura</Div>'+
		'<Div>Eliminar</Div></Div>';
	},
	templateItem:function(item){
		return '<Div class="display-flex justify-between margin-sides-10 idiomas-div > div">'+
		'<Div><b>'+item.idioma+'</b></Div>'+
		'<Div><b class="symbol-percentage">'+item.porcentaje_habla+'</b></Div>'+
		'<Div><b class="symbol-percentage">'+item.porcentaje_lec_escr+'</b></Div>'+
		'<Div><img tabindex="0" data-registro="'+item.id_consecutivo
		+'" data-description="'+item.idioma+'" src="Imagenes/mask.png"  title="ELIMINAR" '+
		' class="symbol-delete"/></Div></Div>';
	},	
	assembleItems:function(items){
		var result=DatosIdioma.templateTitleItems();;
		$.each(items,function(){
            result+=DatosIdioma.templateItem(this);
        });
        return result;
	},
	viewItems:function(items){
		var title=DatosIdioma.templateTitle();
		var items=DatosIdioma.assembleItems(items);
		return title + '<div>'+items+'</div>';
	},
	viweNoItems:function(msn){
		var title=DatosIdioma.templateTitle();
		return title + '<p>' +msn+ '</p>';
	},
}