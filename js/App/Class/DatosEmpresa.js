var DatosEmpresa={
	init:function(){
			
	},
	setNoControl:function(no_control){
		DatosPosgrado.no_control=no_control;
	},
	requestDatosPosgrado:function(no_control){
		try{
            $("#div_dt_empresa").hide();
            $("#img_cargando_empresa").show();
            $.post('ajax/dt_empresa.php',{no_control:no_control})
            .done(function(data){
                 DatosPosgrado.doneResponseDatosPosgrado(data);  
            }).
        	fail(function(jqXHR, textStatus, errorThrown){
          		ajax_error(jqXHR,textStatus,$('#div_dt_empresa'));
            }).
            always(function(){
	        	$("#img_cargando_empresa").hide();
	          	$('#div_dt_empresa').show();
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
        document.getElementById('div_dt_empresa').innerHTML=contend;
	},
	templateTitle:function(title){
		return  '<h2>Datos de la Empresa´s<img tabindex="0" id="agregar_empresa" src="Imagenes/mask.png" '+
		'class="symbol-add margin-both-sides-10" title="Agregar empresa"></h2>';
	},
	templateItem:function(item){
		return '<Div class="div-posgrado form-format-1 position-relative">'+
		'<Div class="display-flex-justify-end"><img tabindex="0" data-registro="'+item.codigo_empresa+
		'"src="Imagenes/mask.png"  title="Editar" '+
		'class="symbol-edit margin-both-sides-10"/><img tabindex="0" data-registro="'+item.codigo_empresa+
		'" data-description="'+item.nombre+'" src="Imagenes/mask.png"  title="Eliminar" '+
		' class="symbol-delete"/></Div>'+
		'<Div><label>Empresa:</label><b>'+item.nombre+'</b></Div>'+
		'<Div><label>Giro:</label><b>'+item.giro+'</b></Div>'+
		'<Div><label>Web:</label><b>'+item.web+'</b></Div>'+
		'<Div><label>Puesto:</label><b>'+item.puesto+'</b></Div>'+
		'<Div><label>Ingreso:</label><b>'+item.año_ingreso+'</b></Div></Div>';
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
}