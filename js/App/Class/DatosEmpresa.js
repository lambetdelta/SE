var DatosEmpresa={
	dataset_form:document.getElementById('frm_empresa').dataset,
	init:function(){
			$("#div_dt_empresa").on('click',"img.symbol-edit",DatosEmpresa.setUpEditDatosEmpresa);
			$("#div_dt_empresa").on('click',"#agregar_empresa",DatosEmpresa.setUpAddDatosEmpresa);
	},
	setNoControl:function(no_control){
		DatosEmpresa.no_control=no_control;
	},
	setUpEditDatosEmpresa:function(){
		DatosEmpresa.dataset_form.registro=this.dataset.registro;
	},
	setUpAddDatosEmpresa:function(){
		DatosEmpresa.dataset_form.registro=null;
	},
	requestDatosEmpresa:function(no_control){
		try{
            $("#div_dt_empresa").hide();
            $("#img_cargando_empresa").show();
            $.post('ajax/dt_empresa.php',{no_control:no_control})
            .done(function(data){
                 DatosEmpresa.doneResponseDatosEmpresa(data);  
            }).
        	fail(function(jqXHR, textStatus, errorThrown){
          		ajax_error(jqXHR,textStatus,$('#div_dt_empresa'));
            }).
            always(function(){
	        	$("#img_cargando_empresa").hide();
	          	$('#div_dt_empresa').show();
            }); 
        }catch(e){
            DatosEmpresa.errorCatch(e);
        }
	},
	doneResponseDatosEmpresa:function(data){
		var datos=$.parseJSON(data); 
        var contend='';  
        if(datos.respuesta === '1')
            contend=DatosEmpresa.viewItems(datos.empresa);
        else
            contend=DatosEmpresa.viweNoItems(datos.mensaje);
        document.getElementById('div_dt_empresa').innerHTML=contend;
	},
	templateTitle:function(){
		return  '<h2>Datos de Empresa<img id="agregar_empresa" tabindex="0"' +  
		'src="Imagenes/mask.png" class="symbol-add margin-both-sides-10"  title="Agregar Empresa" /></h2>';
	},
	templateItem:function(item){
		return '<Div class="div-posgrado form-format-1 position-relative">'+
		'<Div class="display-flex-justify-end"><img tabindex="0" data-registro="' + item.codigo_empresa +
		'"src="Imagenes/mask.png"  title="Editar" class="symbol-edit margin-both-sides-10"/>' +
		'<img tabindex="0" data-registro="' + item.codigo_empresa +
		'"data-description="' + item.nombre +'" src="Imagenes/mask.png" title="Eliminar" ' +
		'class="symbol-delete"/></Div>' +
		'<div class="form-format-2"><Div><label>Empresa:</label><b>' + item.nombre + '</b></Div>' +
		'<Div><label>Giro:</label><b>' +item.giro + '</b></Div>' +
		'<Div><label>Web:</label><b>' + item.web + '</b></Div>' +
		'<Div><label>Puesto:</label><b>' + item.puesto + '</b></Div>' +
		'<Div><label>Jefe:</label><b>' + item.nombre_jefe + '</b></Div>' +
		'<Div><label>Teléfono:</label><b>' + item.telefono + '</b></Div>' +
		'<Div><label>Ingreso:</label><b>' + item.año_ingreso + '</b></Div></div></Div>';
	},	
	assembleItems:function(items){
		var result='';
		$.each(items,function(){
            result+=DatosEmpresa.templateItem(this);
        });
        return result;
	},
	viewItems:function(items){
		var title=DatosEmpresa.templateTitle();
		var items=DatosEmpresa.assembleItems(items);
		return title + '<div>'+items+'</div>';
	},
	viweNoItems:function(msn){
		var title=DatosEmpresa.templateTitle();
		return title + '<p>' +msn+ '</p>';
	},
}