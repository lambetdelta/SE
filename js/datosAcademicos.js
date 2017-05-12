var DatosAcademicos={
	no_control:null,
	init:function(){
		$("#datos_academicos").on('click',"img.eliminar",DatosAcademicos.Eliminar);
		$("#datos_academicos").on('click keypress','img.editar_academico',DatosAcademicos.configurarDatosAcademicosEdicion);
		$("#datos_academicos").on('click keypress','#agregar_carrera',DatosAcademicos.configurarDatosAcademicosNuevo);
		$("#frm_dt_academico").submit(EventosForm.sendDatosAcademicos);
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
	        	msn_bloqueado.modal('hide');
	            if(datos.respuesta=='1'){//exito
	                alert('BORRADO EXITOSO');
	                DatosAcademicos.dt_academicos(no_control);
	            }
	            else{ //error desde el servidor
	                alert("Error"+datos.mensaje);
	            }
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
        var p=$('<h2>Datos Academicos</h2>');            
        frag.appendChild(p[0]);
	  	$.post('ajax/dt_academicos.php',{no_control:no_control}).
	  	done(function(data){
            datos=$.parseJSON(data);   
            if(datos.respuesta==='1'){
                frag=DatosAcademicos.vistaDatosAcademicos(frag,datos.carrera);
             }else{
                frag=DatosAcademicos.vistaSinDatos(frag,datos.mensaje);
             }   
         	$('#datos_academicos').append(frag);
            DatosAcademicos.configurarVistaFinal();
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
	vistaDatosAcademicos:function(frag,datos){
		p=$('<img id="agregar_carrera" tabindex="0" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar carrera" /> ');          
        frag.appendChild(p[0]);
        $.each(datos,function(){
            var div=$('<div class="div_carrera" data-registro="'+this.no_registro+'"/>');
            div.append(DatosAcademicos.plantillaDatoAcademico(this));
            frag.appendChild(div[0]);
        });
        return frag;
	},
	vistaSinDatos:function(frag,msn){
		p=$('<img tabindex="0" id="agregar_carrera" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar carrera" /> '); 
        frag.appendChild(p[0]);
        p=$('<p>Informe:'+msn+'</p>'); 
        frag.appendChild(p[0]);
        return frag;
	},
	vistaError:function(frag,e){
		var p=$('<img tabindex="0" id="agregar_carrera" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar carrera" />');          
        frag.appendChild(p[0]);
        p=$('<p>Informe:'+e+'</p>'); 
        frag.appendChild(p[0]);
        return frag;
	},
	plantillaDatoAcademico:function(json){
		return template='<img data-titulado="'+json.titulado+'" data-inicio="'+json.fecha_inicio+'" data-fin="'+json.fecha_fin+'" data-codigo_especilidad="'+json.codigo_especialidad+'" data-codigo_carrera="'+json.codigo_carrera+'" data-carrera="'+json.carrera+'" data-registro="'+json.no_registro+'" src="Imagenes/editar.png"  title="EDITAR" class="editar_academico" tabindex="0"/><img tabindex="0" data-registro="'+json.no_registro+'" data-carrera="'+json.carrera+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar" /><p>Carrera:<b>'+json.carrera+'</b></p><p>Especialidad:<b>'+json.especialidad+'</b></p><p>Fecha de inicio:<b>'+json.fecha_inicio+'</b></p><p>Fecha de finalización:<b>'+json.fecha_fin+'</b></p><p>Titulado:<b>'+json.titulado+'</b></p>'; 
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
				if(this.dataset.registro != 'null'){
					actualizar_carrera(EventosForm.no_control,registro);	
				}else
					guardar_dt_academicos(EventosForm.no_control);	
				}
			else
				alert('Datos Incompletos');
	 	}else
		 	alert('Datos Incompletos');
	},
}