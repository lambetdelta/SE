
function show_dt_academicos(){//animaciones de los contenedores de los datos basicos de los egresados
	$('#datos_academicos').slideToggle(1000);//mostrar animar
	$('#frm_datos_academicos').slideToggle(1000);
	};
	
function show_historial(){
	$("#div_dt_historial_empresa").slideToggle(1000);
	$("#div_frm_historial").slideToggle(1000);
	};		
function show_social(){
	$("#div_dt_social").slideToggle(1000);
	$("#div_frm_social").slideToggle(1000);
	};		
function show_posgrado(){
	$("#div_frm_posgrado").slideToggle(1000);
	$("#div_dt_posgrado").slideToggle(1000);
	}	
function show_SW(){
	$("#div_frm_software").slideToggle(1000);
	$("#div_dt_software").slideToggle(1000);
	};	
function show(){//animaciones de los contenedores de los datos basicos de los egresados
	$('#contenedor_Datos_Personales').hide();//mostrar animar
	$('#contenedor_form_datos_personales').show();
	};
function show_1(){//animaciones de los contenedores de los datos basicos de los egresados
	$('#contenedor_form_datos_personales').hide();
        $('#contenedor_Datos_Personales').show();//mostrar animar
	};
function show_idiomas(){//animaciones de los contenedores de los datos basicos de los egresados
	$('#div_frm_idioma').hide();
        $('#div-principal-idioma').show();//mostrar animar
	};
function show_idiomas_(){//animaciones de los contenedores de los datos basicos de los egresados
    $('#div-principal-idioma').hide();//mostrar animar
    $('#div_frm_idioma').show();
    };
function inicio(no_control){//animaciones de los contenedores de los datos basicos de los egresados
	$('#contenedor_form_datos_personales').hide();	
	$("#cargando_frm").hide();
	$("#frm_datos_academicos").hide();
	$("#img_cargando").hide();
	$("#img_cargando_dt_academicos").hide();
	$("#img_enviar_academico").hide();
	cargar_idiomas();
	cargar_carrera();
	cargar_estados();
	dt_academicos(no_control);//solicitar datos academicos
	datos_egresado(no_control);//solicitar datos egresado funcion mediate ajax
	dt_idioma(no_control);
	dt_SW(no_control);//dt de sw
	dt_empresa(no_control);
	dt_historial(no_control);
	dt_social(no_control);
	dt_posgrado(no_control);
		};		
function validar_texto(e) 
{
	tecla = (document.all) ? e.keyCode : e.which;
	
	//Tecla de retroceso para borrar, siempre la permite
	if (tecla==8) return true; 
	 
	// Patron de entrada, en este caso solo acepta letras
	patron =/[A-ZÁÉÍÓÚa-zñáéíóú ]/;  
	
	tecla_final = String.fromCharCode(tecla);
	return patron.test(tecla_final); 
};
function espacion_block(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==32) return false; 
}
function salir(){
    window.location="includes/logout.php";
    
}
function dispositivo(){
	var device = navigator.userAgent;
if (device.match(/Iphone/i)|| device.match(/Ipod/i)|| device.match(/Android/i)|| device.match(/J2ME/i)|| device.match(/BlackBerry/i)|| device.match(/iPhone|iPad|iPod/i)|| device.match(/Opera Mini/i)|| device.match(/IEMobile/i)|| device.match(/Mobile/i)|| device.match(/Windows Phone/i)|| device.match(/windows mobile/i)|| device.match(/windows ce/i)|| device.match(/webOS/i)|| device.match(/palm/i)|| device.match(/bada/i)|| device.match(/series60/i)|| device.match(/nokia/i)|| device.match(/symbian/i)|| device.match(/HTC/i))
 { 
 	$("#div_botones_social_escritorio").hide();
	$("#div_botones_social_mobil").show();
}else{
	$("#div_botones_social_escritorio").show();
	$("#div_botones_social_mobil").hide();
	
}

}
	
function datos_egresado(no_control){//recuperar datos básicos egresado	
	
    try{
        $('#alert_academico').html('');
        $("#cargando_frm").show();
        $('#contendedor_d1').html('');
	$("#contendedor_d1").hide();
	$.post("contenidos/dt_egresado.php",{no_control:no_control})
	.done(function(data){
                 var p='';
                datos=$.parseJSON(data);
                if(datos.resultado==='1'){
                    
                    p='<h2>DATOS PERSONALES</h2>';
                    $('#contendedor_d1').append(p);
                    p='<img src="Imagenes/editar.png" class="img-responsive editar" id="img_editar" title="EDITAR PERFIL" tabindex="0">';
                    $('#contendedor_d1').append(p); 
                    p='<p id="p-nombre" class="p-dt-egresado">Nombre:<b>'+datos.egresado.nombre+' '+datos.egresado.apellido_p+' '+datos.egresado.apellido_m +'</b></p>';
                     $('#contendedor_d1').append(p);
                     p='<p id="p-curp" class="p-dt-egresado">CURP:<b>'+datos.egresado.curp+'</b></p>';
                     $('#contendedor_d1').append(p);
                     p='<p id="p-curp" class="p-dt-egresado">Género:<b>'+datos.egresado.genero+'</b></p>';
                     $('#contendedor_d1').append(p);
                     p='<p id="p-telefono" class="p-dt-egresado">Telefono:<b>'+datos.egresado.telefono+'<b></p>';
                      $('#contendedor_d1').append(p);
                     p='<p id="p-email" class="p-dt-egresado">Email:<b>'+datos.egresado.email+'</b></p>';
                      $('#contendedor_d1').append(p);
                     p='<p id="p-fecha_nac" class="p-dt-egresado">Fecha de nacimiento:<b>'+datos.egresado.fecha_nacimiento+'</b></p>';
                      $('#contendedor_d1').append(p);
                      p='<p id="p-cuidad" class="p-dt-egresado">Ciudad o localidad:<b>'+datos.egresado.ciudad+'</b></p>';
                     $('#contendedor_d1').append(p);
                      p='<p id="p-colonia" class="p-dt-egresado">Colonia:<b>'+datos.egresado.colonia+'</b></p>';
                     $('#contendedor_d1').append(p);
                     p='<p id="p-calle" class="p-dt-egresado">Calle:<b>'+datos.egresado.calle+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-no-casa" class="p-dt-egresado">No. Casa:<b>'+datos.egresado.numero_casa+'</b></p>';
                      $('#contendedor_d1').append(p);
                     p='<p id="p-no-casa" class="p-dt-egresado">C.P:<b>'+datos.egresado.cp+'</b></p>';
                      $('#contendedor_d1').append(p);
                     p='<p id="p-estado" class="p-dt-egresado">Estado:<b>'+datos.egresado.estado+'</b></p>';
                      $('#contendedor_d1').append(p);
                     p='<p id="p-municipio" class="p-dt-egresado">Municipio:<b>'+datos.egresado.municipio+'</b></p>';
                      $('#contendedor_d1').append(p);  
                      $("#cargando_frm").hide();
                      $('#contendedor_d1').show();
                }else{
                    var p='<p id="p-estado" class="p-dt-egresado">ERROR:'+datos.mensaje+'</p>';
                     $('#contendedor_d1').append(p);
                     $("#cargando_frm").hide();
                     $('#contendedor_d1').show();
                }
                }).fail(function(jqXHR, textStatus, errorThrown){
                     $('#contendedor_d1').show();
                     $("#cargando_frm").hide();
                    ajax_error(jqXHR,textStatus,$('#contendedor_d1'));
                  }); 
    }catch (e){
        var p='<p id="p-estado" class="p-dt-egresado">ERROR:'+e+'</p>';
        $('#contendedor_d1').append(p);
        $("#cargando_frm").hide();
        $('#contendedor_d1').show();
    }
	}		
function cargar_municipios(){	//cargar municpios con ajax 
    try{
    $("#estados option:selected").each(function () {
        elegido=$(this).val();
        $("#img_cargando_estado").show();
        $('#Municipios').html('');
        $('#Municipios').append('<option value="1">Espere...</option>');
        $.post("contenidos/Municipios.php", { elegido: elegido })
            .fail(function(jqXHR, textStatus, errorThrown){
                $("#img_cargando_estado").hide();
                $('#Municipios').append('<option value="1">ERROR</option>'); 
                ajax_error_alert(jqXHR, textStatus, errorThrown);
                })
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    $("#img_cargando_estado").hide();
                    $('#Municipios').html('');
                    $.each(datos.municipio,function(){
                        $('#Municipios').append('<option value="'+this.codigo_municipio+'">'+this.nombre+'</option>');
                    });
                }else{
                    $("#img_cargando_estado").hide();
                    $('#Municipios').html('');
                    $('#Municipios').append('<option value="1">Error:'+datos.mensaje+'</option>'); 
                } 
            });            
    });    
    }catch(e){
        $("#img_cargando_estado").hide();
        $('#Municipios').append('<option value="1">ERROR</option>');
        alert_('Error Javascript',$("#alert_academico"),250);
    }
		}	
function cargar_municipios_empresa(){	//cargar municpios con ajax
    try{
     $("#estado_empresa option:selected").each(function () {
        elegido=$(this).val();
        $("#img_muncipio_empresa").show();
        $('#municipio_empresa').html('');
        $('#municipio_empresa').append('<option value="1">Espere...</option>');
        $.post("contenidos/Municipios.php", { elegido: elegido })
            .fail(function(jqXHR, textStatus, errorThrown){
                $("#img_muncipio_empresa").hide();
                $('#municipio_empresa').html('');
                $('#municipio_empresa').append('<option value="1">ERROR</option>'); 
                 ajax_error_alert(jqXHR, textStatus);
            })
            .done(function(data){
                datos=$.parseJSON(data);
                $('#municipio_empresa').html('');
                if(datos.respuesta==='1'){
                    $("#img_muncipio_empresa").hide();
                    $.each(datos.municipio,function(){
                        $('#municipio_empresa').append('<option value="'+this.codigo_municipio+'">'+this.nombre+'</option>');
                    });
                }else{
                    $("#img_muncipio_empresa").hide();
                    $('#municipio_empresa').append('<option value="1">Error:'+datos.mensaje+'</option>');
                }  
            });            
    });    
    }catch(e){
    $("#img_muncipio_empresa").hide();
    $('#municipio_empresa').append('<option value="1">ERROR</option>');
    }
		}		
	
function cargar_especialidad(){	//cargar municpios con ajax
    try{
    $("#carrera option:selected").each(function () {
        $("#especialidad").html('');
        $('#especialidad').append('<option value="1">Espere...</option>');
        elegido=$(this).val();
        $("#img_cargando").show();
        $.post("ajax/especialidad.php", { elegido: elegido })
            .fail(function(jqXHR, textStatus, errorThrown){
                $("#especialidad").html('');
                $("#img_cargando").hide();
                $('#especialidad').append('<option value="1">Error</option>');
                ajax_error_alert(jqXHR, textStatus);
            })
       .done( function(data){
           $("#img_cargando").hide();
           datos=$.parseJSON(data);
           $("#especialidad").html('');
           if(datos.respuesta=='1'){
                $("#img_cargando").hide();
                $.each(datos.especialidad,function(){
                    $('#especialidad').append('<option value="'+this.codigo_especialidad+'">'+this.nombre+'</option>');
              }); 
           }else{
               $("#img_cargando").hide();
               $('#especialidad').append('<option value="1">Error'+datos.mensaje+'</option>');
           }
       });            
   });    
    }catch(e){
        $("#especialidad").html('');
        $("#img_cargando").hide();
        $('#especialidad').append('<option value="1">ERROR</option>');
    }
}
function cargar_idiomas(){
	try{
            $('#idiomas').html('');
            $.post('ajax/idiomas.php')
                .done(function(data){
                    datos=$.parseJSON(data);
                    if(datos.respuesta==='1'){
                        $.each(datos.idioma,function(){
                            $('#idiomas').append('<option value="'+this.codigo_idioma+'">'+this.nombre+'</option>');
                        });
                    }else{
                        $('#idiomas').append('<option value="0">Error:'+datos.mensaje+'</option>'); 
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown){
                    ajax_error_input(jqXHR, textStatus,$('#idiomas')); 
                });
        }catch(e){
        $("#idiomas").append('<option value="1">ERROR</option>');    
        }
	}
function cargar_estados(){	
    try{
      $('#estados').html('');
      $('#estado_empresa').html('');
        $.post('contenidos/Estados.php').done(function(data){
        datos=$.parseJSON(data);
        if(datos.respuesta==='1'){
            $('#estados').append('<option value="1">Estado</option>');
            $('#estado_empresa').append('<option value="1">Estado</option>');
            $.each(datos.estados,function(){
                $('#estados').append('<option value="'+this.codigo_estado+'">'+this.nombre+'</option>');
                $('#estado_empresa').append('<option value="'+this.codigo_estado+'">'+this.nombre+'</option>');
            });
        }else{
            $('#estados').append('<option id="0">ERROR:'+datos.mensage+'</option>');
            $('#estado_empresa').append('<option id="0">ERROR:'+datos.mensage+'</option>');
        }
        }).fail(function(jqXHR, textStatus, errorThrown){
            ajax_error_input(jqXHR, textStatus,$('#select-estado'));
        });    
    }catch(e){
        $("#estados").append('<option value="1">ERROR</option>'); 
        $("#estado_empresa").append('<option value="1">ERROR</option>'); 
    }	
}
function cargar_carrera(){
        $('#carrera').html('');
	$.post('ajax/carrera.php').
            done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    $('#carrera').append('<option value="1">Carrera</option>');
                    $.each(datos.carrera,function(){
                        $('#carrera').append('<option value="'+this.codigo_carrera+'">'+this.nombre+'</option>');
                    });
                }else{
                   $('#carrera').append('<option value="0">Error:'+datos.mensaje+'</option>'); 
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown){
               ajax_error_input(jqXHR, textStatus,$('#carrera')); 
            });
	}
//errores por parte del servidor, se muestran dentro de el input 
function ajax_error_input(jqXHR,textStatus,input){
        if (jqXHR.status === 0) {
            input.append('<option value="0">ERROR:SIN RESPUESTA DEL SERVIDOR</option>');
        } else if (jqXHR.status == 404) {
            input.val('ERROR:PÁGINA NO ENCONTRADA [404]</option>');

        } else if (jqXHR.status == 500) {
            input.append('<option value="0">ERROR:FALLA DEL SERVIDOR[505]</option>');
            //Internal Server Error [500]
                
        } else if (textStatus === 'parsererror') {
            input.append('<option value="0">ERROR:DATOS RECIBIDOS CORRUPTOS</option>');
//            Requested JSON parse failed

        } else if (textStatus === 'timeout') {
            input.append('<option value="0">ERROR:TIEMPO DE RESPUESTA EXPIRADO</option>');
//           Time out error

        } else if (textStatus === 'abort') {

//            alert('Ajax request aborted.');

        } else {
            input.append('<option value="0">ERROR INESPERADO:'+ jqXHR.responseText+'</option>');
       }
}        
function ajax_error(jqXHR,textStatus,div){
        if (jqXHR.status === 0) {
            div.append('<p>ERROR:SIN RESPUESTA DEL SERVIDOR</p>');
        } else if (jqXHR.status == 404) {
            div.append('<p>ERROR:PÁGINA NO ENCONTRADA [404]</p>');

        } else if (jqXHR.status == 500) {
            div.append('<p>ERROR:FALLA DEL SERVIDOR[505]</p>');
            //Internal Server Error [500]
                
        } else if (textStatus === 'parsererror') {
            div.append('<p>ERROR:DATOS RECIBIDOS CORRUPTOS</p>');
//            Requested JSON parse failed

        } else if (textStatus === 'timeout') {
            div.append('<p>ERROR:TIEMPO DE RESPUESTA EXPIRADO</p>');
//           Time out error

        } else if (textStatus === 'abort') {

//            alert('Ajax request aborted.');

        } else {
            div.append('<p>ERROR INESPERADO:'+ jqXHR.responseText+'</p>');
       }
}

function ajax_error_alert(jqXHR,textStatus){
        if (jqXHR.status === 0) {
            $('#alert_personales').append('<p>ERROR:SIN RESPUESTA DEL SERVIDOR</p>');
            alert_Bloq('Error',$('#alert_personales'));
            setTimeout('$("#alert_personales").dialog( "close" );$("#alert_personales").html("");',2000);
        } else if (jqXHR.status == 404) {
            $('#alert_personales').append('<p>ERROR:PÁGINA NO ENCONTRADA [404]</p>');
            alert_Bloq('Error',$('#alert_personales'));
            setTimeout('$("#alert_personales").dialog( "close" );$("#alert_personales").html("");',2000);

        } else if (jqXHR.status == 500) {
            $('#alert_personales').append('<p>ERROR:FALLA DEL SERVIDOR[505]</p>');
            alert_Bloq('Error',$('#alert_personales'));
            setTimeout('$("#alert_personales").dialog( "close" );$("#alert_personales").html("");',2000);
            //Internal Server Error [500]
                
        } else if (textStatus === 'parsererror') {
            $('#alert_personales').append('<p>ERROR:DATOS RECIBIDOS CORRUPTOS</p>');
            alert_Bloq('Error',$('#alert_personales'));
            setTimeout('$("#alert_personales").dialog( "close" );$("#alert_personales").html("");',2000);
//            Requested JSON parse failed

        } else if (textStatus === 'timeout') {
            $('#alert_personales').append('<p>ERROR:TIEMPO DE RESPUESTA EXPIRADO</p>');
            alert_Bloq('Error',$('#alert_personales'));
            setTimeout('$("#alert_personales").dialog( "close" );$("#alert_personales").html("");',2000);
//           Time out error

        } else if (textStatus === 'abort') {

//            alert('Ajax request aborted.');

        } else {
            $('#alert_personales').append('<p>ERROR INESPERADO:'+ jqXHR.responseText+'</p>');
            alert_Bloq('Error',$('#alert_personales'));
            setTimeout('$("#alert_personales").dialog( "close" );$("#alert_personales").html("");',2000);
       }
} 
function datepicker_esp(){//calendario español
	 $.datepicker.regional['es'] = {
	 changeYear: true,
	 numberOfMonths: 1,
	 changeMonth: true,
	 closeText: 'Cerrar',
	 prevText: '<Ant',
	 nextText: 'Sig>',
	 currentText: 'Hoy',
	 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	 weekHeader: 'Sm',
	 dateFormat: 'yy-mm-dd',
	 firstDay: 1,
	 isRTL: false,
         yearRange: "-99:+0",
         maxDate: "+0m +0d",
	 showMonthAfterYear: false,
	 yearSuffix: ''
 };
	 $.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
	$("#fecha").datepicker();
});
	};
        
function guardar_datos(no_control){//guardar datos básicos egresado
    try{
    $('#alert_academico').html('');
        $("#enviar").show();//ocultar y mostrar frm, gif de envio
	$("#cancelar").hide();
	$("#frm_Datos_Personales").hide();	
	$.post("ajax/guardar_datos.php",{form:$('#frm_Datos_Personales').serialize(),no_control:no_control})
	.done(function(data){//evaluando respuesta del servidor
		$("#enviar").hide();
                datos=$.parseJSON(data);
		if(datos.respuesta=='1'){
			limpiaForm($("#frm_Datos_Personales"));	//exito!!!
			alert_("DATOS GUARDADOS",$("#alert_personales"),250);
			show_1();
			datos_egresado(no_control);
			setTimeout( "jQuery('#frm_Datos_Personales').show();$('#cancelar').show();",2000 );
                }else{//error!!
                        $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);
                        limpiaForm($("#frm_Datos_Personales"));	
                        $("#frm_Datos_Personales").show();
                }
	}).fail(function(jqXHR, textStatus, errorThrown){
           limpiaForm($("#frm_Datos_Personales"));	
           $("#frm_Datos_Personales").show();
           ajax_error_alert(jqXHR,textStatus);
        });    
    }catch(e){
        $("#alert_personales").append('<p>Informe:'+e+'</p>');
        alert_("Error",$("#alert_personales"),250);
        limpiaForm($("#frm_Datos_Personales"));	
        $("#frm_Datos_Personales").show();    
    }
    }	
	
function validar_Est_Mun(){//verificar estados y municipios 
	if($("#Estados").selectedIndex==1){
		$("#Estados").focus();	
		alert_("Datos Incompletos",$("#alert_personales"),250);
		return false;}
	else{
		if($("#Municipios").val()=="1"){
			$("#Municipios").focus();	
			alert_("Datos Incompletos",$("#alert_personales"),250);
			return false
		}else
			return true;
		}	
	}
		
function dt_academicos(no_control){//cargar datos academicos
	try{
        $('#alert_academico').html('');
        $("#datos_academicos").hide();
        $("#datos_academicos").html('');
	$("#img_cargando_dt_academicos").show();
	$.post('ajax/dt_academicos.php',{no_control:no_control}).
	done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>Datos Academicos</h2>';            
                $('#datos_academicos').append(p);
                p='<img id="agregar_carrera" tabindex="0" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar carrera" /> ';          
                $('#datos_academicos').append(p);
                $.each(datos.carrera,function(){
                    var div=$('<div/>');
                    p='<img id="img-dt-academicos'+this.no_registro+'" src="Imagenes/editar.png"  title="EDITAR" class="editar_academico" tabindex="0"/>';
                    div.append(p);
                    p='<img tabindex="0" id="'+this.no_registro+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar"/>';
                    div.append(p);
                    p='<p>Carrera:<b>'+this.carrera+'</b></p>';
                    div.append(p);
                    p='<p>Especialidad:<b>'+this.especialidad+'</b></p>';
                    div.append(p);
                    p='<p>Fecha de inicio:<b>'+this.fecha_inicio+'</b></p>';
                    div.append(p);
                     p='<p>Fecha de finalización:<b>'+this.fecha_fin+'</b></p>'; 
                    div.append(p);
                    p='<p>Titulado:<b>'+this.titulado+'</b></p>'; 
                    div.append(p);
                    div.addClass('div_carrera');
                    div.attr('id','div-dt-academicos'+this.no_registro);
                    $('#datos_academicos').append(div);
                    $('#datos_academicos').show();
                });
                $("#img_cargando_dt_academicos").hide();
                $('#datos_academicos').show();
             }else{
                var p='<h2>Datos Academicos</h2>';
                $('#datos_academicos').append(p);
                p='<img tabindex="0" id="agregar_carrera" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar carrera" /> ';          
                $('#datos_academicos').append(p);
                p='<p>Informe:'+datos.mensaje+'</p>'; 
                $('#datos_academicos').append(p);
                $('#img_cargando_dt_academicos').hide();
                $('#datos_academicos').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $("#img_cargando_dt_academicos").hide();
              $('#datos_academicos').show(); 
              ajax_error(jqXHR,textStatus,$('#datos_academicos'));
            });    
        }catch(e){
            var p='<h2>Datos Academicos</h2>';
            $('#datos_academicos').append(p);
            p='<img tabindex="0" id="agregar_carrera" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar carrera" /> ';          
            $('#datos_academicos').append(p);
            p='<p>Informe:'+e+'</p>'; 
            $('#datos_academicos').append(p);
            $('#img_cargando_dt_academicos').hide();
            $('#datos_academicos').show();
        }
	}
			
function validar_fechas(inicio,fin){ //verificar fechas dobles si son validas
if (moment(inicio).isValid()) {
	if(moment(fin).isValid())
		return true;
	else
	return false;
} else {
  return false;
  
}
	};	
function guardar_dt_academicos(no_control){//guarda nueva carrera
        try{
            $('#alert_academico').html('');
        $("#img_enviar_academico").show();//img guardado
	$("#frm_dt_academico").hide();//ocular formulario
	$("#div_carrera_actualizar").hide();
	$("#titlo_carrera").hide();
	$(".eliminar").show();//ocultar img eliminar y eliminar
	$(".editar_academico").show();
	$.post('ajax/guardar_academico.php',{form:$('#frm_dt_academico').serialize(),no_control:no_control})
	.done(function(data){
            datos=$.parseJSON(data);
		if(datos.respuesta=='1'){//exito
			$("#img_enviar_academico").hide();
			limpiaForm($("#frm_dt_academico"));
			alert_('CARRERA AGREGADA',$('#alert_academico'),250);
			show_dt_academicos();
			dt_academicos(no_control);
			setTimeout('$("#frm_dt_academico").show();',2000);
			}
		else if(datos.respuesta=='3'){//eres muy listo?
			$("#img_enviar_academico").hide();
			alert_("Max 4 carreras",$('#alert_academico'),250);
			limpiaForm($("#frm_dt_academico"));	
			setTimeout('$("#frm_dt_academico").show();',2000);	
			show_dt_academicos();
			}
		else {
			$("#img_enviar_academico").hide();
			$("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);
			limpiaForm($("#frm_dt_academico"));	
			setTimeout('$("#frm_dt_academico").show();',2000);	
			show_dt_academicos();
		}
		})
            .fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_academico").hide();
                limpiaForm($("#frm_dt_academico"));	
                setTimeout('$("#frm_dt_academico").show();',2000);
                show_dt_academicos();
                ajax_error_alert(jqXHR, textStatus);
            });
        }catch(e){
            $("#img_enviar_academico").hide();
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            limpiaForm($("#frm_dt_academico"));	
            setTimeout('$("#frm_dt_academico").show();',2000);	
            show_dt_academicos();
        }
	}//fin de function principal;	
function confirmar(no_control,registro){ 
   $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#center_diag' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 borrar_carrera(no_control,registro);
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }	
function val_carrera(){
	if($("#carrera").val()!="1"){
		if($("#especialidad").val()!="1")
			return true;
		else
			return false;
	}else
	return false;
	};
				  
function actualizar_carrera(no_control,registro){
    try{
        $('#alert_academico').html('');
        $("#img_enviar_academico").show();
	$("#frm_dt_academico").hide();
	$("#div_carrera_actualizar").hide();
	$("#titlo_carrera").hide();
	$.post('ajax/actualizar_academico.php',{form:$('#frm_dt_academico').serialize(),no_control:no_control,registro:registro})
	.done(function(data){//evaluando respuesta del servidor
            datos=$.parseJSON(data);
            if(datos.respuesta=='1'){
                $("#img_enviar_academico").hide();
                limpiaForm($("#frm_dt_academico"));	//exito!!!
                alert_("DATOS GUARDADOS",$("#alert_personales"),250);
                show_dt_academicos();
                dt_academicos(no_control);
                setTimeout( "jQuery('#frm_dt_academico').show();",2000 );
            }else{//error!!
                $("#img_enviar_academico").hide();
                $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                alert_("Error",$("#alert_personales"),250);
                limpiaForm($("#frm_dt_academico"));	
                $("#frm_dt_academico").show();
                $("#div_carrera_actualizar").show();
                $("#titlo_carrera").show();
                }
	}).fail(function(jqXHR, textStatus, errorThrown){
            $("#img_enviar_academico").hide();
            limpiaForm($("#frm_dt_academico"));	
            $("#frm_dt_academico").show();
            $("#div_carrera_actualizar").show();
            $("#titlo_carrera").show();
            ajax_error_alert(jqXHR,textStatus);
        });
    }catch(e){
        $("#img_enviar_academico").hide();
        $("#alert_personales").append('<p>Informe:'+e+'</p>');
        alert_("Error",$("#alert_personales"),250);
        limpiaForm($("#frm_dt_academico"));	
        $("#frm_dt_academico").show();
        $("#div_carrera_actualizar").show();
        $("#titlo_carrera").show();    
    }
}
	
function alert_(title,dialog,ancho){    
var alert_=dialog;
   alert_.dialog({ 
   		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).show(); },
		width:ancho,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		title:title,
		position: { my: "center", at: "center", of: '#center_diag' },
                close:function(){$('#alert_personales').html('');}
		});
	  }		
	  	
function alert_Bloq(title,dialog){ 
var alert_=dialog;
   alert_.dialog({ 
  		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },//ocultar boton de cerrar ventana
		width:250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		title:title,
		position: { my: "center", at: "center", of: '#center_diag' }
		});
	  }			
function borrar_carrera(no_control,registro){//borrar carrera
    try{
    alert_Bloq('BORRANDO...',$('#alert_personales'));
    $.post('ajax/eliminar_carrera.php',{registro:registro,no_control:no_control})
    .done(function(data){
        datos=$.parseJSON(data);
            if(datos.respuesta=='1'){//exito
                alert_('BORRADO EXITOSO',$('#alert_personales'),250);
                setTimeout('$("#alert_personales").dialog( "close" );',1000);
                dt_academicos(no_control);
            }
            else{ //error desde el servidor
                $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                alert_("Error",$("#alert_personales"),250);
                setTimeout("$('#alert_personales').dialog('close');",2000);
            }
            }).
    fail(function(jqXHR, textStatus, errorThrown){
        ajax_error_alert(jqXHR,textStatus);
    });//fin de done    
    }catch(e){
        $("#alert_personales").append('<p>Informe:'+e+'</p>');
        alert_("Error",$("#alert_personales"),250);
        setTimeout("$('#alert_personales').dialog('close');",2000);    
    }
	}	
function dt_idioma(no_control){//cargar datos academicos
	try{
            $("#img_cargando_idiomas").show();
            $("#div_idioma").html('');
            $("#div_idioma").hide();
            $.post('ajax/dt_idiomas.php',{no_control:no_control})
                .done(function(data){
                 datos=$.parseJSON(data);   
                 if(datos.respuesta==='1'){
                    var p='<h2>Idiomas<img tabindex="0" id="agregar_idioma" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar Idioma" /> </h2>';
                    $('#div_idioma').append(p);
                    var table = $('<table/>');
                    table.addClass('tabla');
                    table.addClass('table');
                    table.addClass('table-hover');
                    table.addClass('table table-condensed');
                    table.append('<tr><th>Idioma</th><th>Habla</th><th>Lectura y escritura</th></tr>');
                    $.each(datos.idioma,function(){
                        table.append( '<tr><td><b>' +this.idioma+'</b></td><td><b>' +this.porcentaje_habla+'</b></td><td><b>' +this.porcentaje_lec_escr+'</b></td><td><img tabindex="0" id="img-eliminar-idioma-'+this.id_consecutivo+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar_idioma"/></td></tr>' );
                    });
                    $('#div_idioma').append(table);
                    $('#img_cargando_idiomas').hide();
                    $('#div_idioma').show();
                 }else{
                     var p='<h2>Idiomas<img tabindex="0" id="agregar_idioma" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar Idioma" /></h2>';
                     $('#div_idioma').append(p);
                     p='<p>Informe:'+datos.mensaje+'</p>'; 
                     $('#div_idioma').append(p);
                     $('#img_cargando_idiomas').hide();
                     $('#div_idioma').show();
                 }   
                }).fail(function(jqXHR, textStatus, errorThrown){
                  $('#img_cargando_idiomas').hide();
                  $('#div_idioma').show(); 
                  ajax_error(jqXHR,textStatus,$('#div_idioma'));
                });
        }catch(e){
            var p='<h2>Idiomas<img tabindex="0" id="agregar_idioma" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar Idioma" /></h2>';
            $('#div_idioma').append(p);
            p='<p>Informe:'+e+'</p>'; 
            $('#div_idioma').append(p);
            $('#img_cargando_idiomas').hide();
            $('#div_idioma').show();   
        }
	}	
function borrar_idioma(no_control,registro){//borrar carrera
	try{
            alert_Bloq('BORRANDO...',$('#alert_personales'));
            $.post('ajax/eliminar_idioma.php',{registro:registro,no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            alert_('BORRADO EXITOSO',$('#alert_personales'),250);
                            setTimeout('$("#alert_personales").dialog( "close" );',1000);
                            dt_idioma(no_control);
                            }
                    else {//problemas con formulario
                            $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                            alert_("Error",$("#alert_personales"),250);
                            setTimeout("$('#alert_personales').dialog('close');",2000);
                            }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            });
        }catch(e){
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            setTimeout("$('#alert_personales').dialog('close');",2000);
        }
	}	
	
function confirmar_idioma(no_control,registro){//preguntar borrado de idioma 
   $("#dialogo_idioma").dialog({ 
		width: 250,  
		height: 250,
		title:"BORRAR",
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#center_diag' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 borrar_idioma(no_control,registro);
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }		
	  
function guardar_idioma(no_control){//guardar nuevo idioma
	try{
            $("#img_enviar_idioma").show();//img guardado
            $("#frm_idioma").hide();//ocular formulario
            $("#img_cancelar_idiomas").hide();
            $.post('ajax/agregar_idioma.php',{form:$('#frm_idioma').serialize(),no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta=='1'){//exito
                        $("#img_enviar_idioma").hide();
                        limpiaForm($("#frm_idioma"));
                        alert_('IDIOMA AGREGADO',$('#alert_academico'),250);
                        show_idiomas();
                        dt_idioma(no_control);
                        setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
                        }
                else if(datos.respuesta=='3'){//
                        $("#img_enviar_idioma").hide();
                        limpiaForm($("#frm_idioma"));
                        show_idiomas();
                        alert_("MAXIMO 5 IDIOMAS",$('#alert_academico'),250);	
                        setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
                        }
                else {//
                        $("#img_enviar_idioma").hide();
                        limpiaForm($("#frm_idioma"));
                        show_idiomas();
                        $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);	
                        setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);	
                }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_idioma").hide();
                limpiaForm($("#frm_idioma"));
                show_idiomas();
                setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
                ajax_error_alert(jqXHR,textStatus);
            });//
        }catch(e){
            $("#img_enviar_idioma").hide();
            limpiaForm($("#frm_idioma"));
            show_idiomas();
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);	
            setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
        }
    }//fin de function principal; 
function dt_SW(no_control){//cargar datos academicos
	try{
            $("#div_dt_software").hide();
            $("#div_dt_software").html('');
            $("#img_cargando_sw").show();
            $.post('ajax/dt_sw.php',{no_control:no_control})
            .done(function(data){
                 datos=$.parseJSON(data);   
                 if(datos.respuesta==='1'){
                    var p='<h2>Paqueteria de software<img tabindex="0" id="agregar_sw" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar Idioma" /> </h2>';
                    $('#div_dt_software').append(p);
                    var table = $('<table/>');
                    table.addClass('tabla');
                    table.addClass('table');
                    table.addClass('table-hover');
                    table.addClass('table table-condensed');
                    table.append('<tr><th>Software</th></tr>');
                    $.each(datos.sw,function(){
                        table.append( '<tr><td><b>' +this.nombre_sw+'</b></td><td><img tabindex="0" id="img-eliminar-sw-'+this.id_consecutivo+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar_sw"/></td></tr>' );
                    });
                    $('#div_dt_software').append(table);
                    $('#img_cargando_sw').hide();
                    $('#div_dt_software').show();
                 }else{
                     var p='<h2>Software<img tabindex="0" id="agregar_sw" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar Idioma" /></h2>';
                     $('#div_dt_software').append(p);
                     p='<p>Informe:'+datos.mensaje+'</p>'; 
                     $('#div_dt_software').append(p);
                     $('#img_cargando_sw').hide();
                     $('#div_dt_software').show();
                 }   
                }).fail(function(jqXHR, textStatus, errorThrown){
                  $('#img_cargando_sw').hide();
                  $('#div_dt_software').show(); 
                  ajax_error(jqXHR,textStatus,$('#div_dt_software'));
                });
        }catch(e){
            var p='<h2>Software<img tabindex="0" id="agregar_sw" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar Idioma" /></h2>';
            $('#div_dt_software').append(p);
            p='<p>Informe:'+e+'</p>'; 
            $('#div_dt_software').append(p);
            $('#img_cargando_sw').hide();
            $('#div_dt_software').show();
        }
	}	
function guardar_sw(no_control){//guardar nuevo idioma
	try{
            $("#img_enviar_sw").show();//img guardado
            $("#frm_sw").hide();//ocular formulario
            $("#img_cancelar_sw").hide();
            $.post('ajax/agregar_sw.php',{form:$('#frm_sw').serialize(),no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                        $("#img_enviar_sw").hide();
                        limpiaForm($("#frm_sw"));
                        alert_('AGREGADO',$('#alert_academico'),250);
                        show_SW();
                        dt_SW(no_control);
                        setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);
                            }
                    else if(datos.respuesta=='3'){//eres muy listo?
                        $("#img_enviar_sw").hide();
                        show_SW();
                        alert_("MÁXIMO 7 ",$('#alert_academico'),250);	
                        setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);	
                    }else{ //error desde el servidor
                        $("#img_enviar_sw").hide();
                        $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);
                        show_SW();
                        setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);

                    }
                    }).fail(function(jqXHR, textStatus, errorThrown){
                  $('#img_enviar_sw').hide();
                  show_SW();
                  setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);
                  ajax_error_alert(jqXHR,textStatus);
                });//fin de done
        }catch(e){
            $("#img_enviar_sw").hide();
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            show_SW();
            setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);    
        }
	}//fin de function principal;	
function borrar_sw(no_control,registro){//borrar sw
	try{
            alert_Bloq('BORRANDO...',$('#alert_personales'));
            $.post('ajax/eliminar_sw.php',{registro:registro,no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            alert_('BORRADO EXITOSO',$('#alert_personales'),250);//msn de borrado
                            setTimeout('$("#alert_personales").dialog( "close" );',1000);//cerrar el dlg
                            dt_SW(no_control);//cargar nuevos datos
                            }
                    else{ //error desde el servidor
                            $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                            alert_("Error",$("#alert_personales"),250);
                            setTimeout("$('#alert_personales').dialog('close');",2000);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            });
        }catch(e){
           $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            setTimeout("$('#alert_personales').dialog('close');",2000); 
        }
}

function confirmar_sw(no_control,registro){//preguntar borrado de sw 
   $("#dialogo_sw").dialog({
		width: 250,  
		height: 250,
		title:"BORRAR ",
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#center_diag' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 borrar_sw(no_control,registro);
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }
	  
	  /////////////////////funciones del div empresa
 function show_empresa(){//mostrar contendores empresa
	$("#div_frm_empresa").slideToggle(1000);
	$("#div_dt_empresa").slideToggle(1000);
	};
	

var select_=1;//agregar select	
var stilo;
function AgregarCampos(){//agregar campos requisitos
	select_=select_+1;	
	if (select_<7){	
	var img_;
	 img_=' <img tabindex="0" src="Imagenes/eliminar_verde.gif" class="eliminar_requisito "  style="color:#666;" id="img'+select_+'requisito"/>';
	var campo=$("#requisito").clone();		
	campo.attr('name',select_+'requisito');	
	campo.attr('id',select_+'requisito');	
	if(select_>2){//imagenes borrar
		var eliminar=document.getElementById("img"+(select_-1)+"requisito");
		eliminar.remove();
		}	
		$("#requisito_div").append(campo);
		$("#requisito_div").append(img_);
	}
	else{
		alert_('6 REQUISITOS MAX',$("#dialogo_empresa"),250);
		select_=select_-1;
		}
}
	
function eliminar_select(id,clone){//borrar select de requisitos contratacion
	var eliminar=document.getElementById(id);//img de borrar
	eliminar.remove();
		if(select_>2){
		img_nueva=clone;//asignar clon de img	
		img_nueva.attr('src','Imagenes/eliminar_verde.gif');
		estilo='color:#666;';
		img_nueva.attr('id','img'+(select_-1)+'requisito');
		img_nueva.attr('style',estilo);
		$("#requisito_div").append(img_nueva);
		}
				
	select_=select_-1;
	}	
function guardar_empresa(no_control){//guardar nueva mpresa
    try{
        $("#img_enviar_empresa").show();//img guardado
	$("#frm_empresa").hide();//ocular formulario
	$("#img_cancelar_empresa").hide();
	$.post('ajax/guardar_empresa.php',{form:$('#frm_empresa').serialize(),no_control:no_control,select_:select_})
	.done(function(data){
            datos=$.parseJSON(data);
		if(datos.respuesta=='1'){//exito
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			alert_('EMPRESA AGREGADA',$('#dialogo_empresa'),250);
			show_empresa();
			dt_empresa(no_control);
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);
			}
		else if(datos.respuesta=='3'){//eres muy listo?
			$("#img_enviar_empresa").hide();
			alert_("MAXIMO 4 ",$('#dialogo_empresa'),250);	
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);	
		}else{ //error desde el servidor
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			$("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);	
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);
		}
		}).
        fail(function(jqXHR, textStatus, errorThrown){
            $("#img_enviar_empresa").hide();
            limpiaForm($("#frm_empresa"));
            show_empresa();
            setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
            ajax_error_alert(jqXHR,textStatus);
        });
    }catch(e){
        $("#img_enviar_empresa").hide();
        limpiaForm($("#frm_empresa")); 
        $("#alert_personales").append('<p>Informe:'+e+'</p>');
        alert_("Error",$("#alert_personales"),250);	
        setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);
    }
}//fin de function principal;		
	
function dt_empresa(no_control){//cargar datos academicos
	try{
           $("#div_dt_empresa").hide();
            $("#div_dt_empresa").html('');
            $("#img_cargando_empresa").show();
            $.post('ajax/dt_empresa.php',{no_control:no_control})
                .done(function(data){
                datos=$.parseJSON(data);   
                if(datos.respuesta==='1'){
                    var p='<h2>Datos de la Empresa´s</h2>';            
                    $('#div_dt_empresa').append(p);
                    p='<img tabindex="0" id="agregar_empresa" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/>';          
                    $('#div_dt_empresa').append(p);
                    $.each(datos.empresa,function(){
                        var div=$('<div/>');
                        p='<p><img tabindex="0" id="img_editar_empresa'+this.codigo_empresa+'" src="Imagenes/editar.png"  title="EDITAR" class="editar_empresa"/><img tabindex="0" id="img_editar_empresa'+this.codigo_empresa+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="elimnar_empresa"/></p>';
                        div.append(p);
                        p='<p><img  id="img_empresa'+this.codigo_empresa+'" src="Imagenes/empresa.png" class="img_empresa visible-lg visible-md"/>';
                        div.append(p);
                        p='EMPRESA:<b>'+this.nombre+'</b></br>';
                        div.append(p);
                        p='GIRO:<b>'+this.giro+'</b></br>';
                        div.append(p);
                        p='WEB:<b>'+this.web+'</b></br>';
                        div.append(p);
                         p='PUESTO:<b>'+this.puesto+'</b></br>'; 
                        div.append(p);
                        p='INGRESO:<b>'+this.año_ingreso+'</b></p>'; 
                        div.append(p);
                        div.addClass('div_dt_empresa_Ajax');
                        div.attr('id','div_empresa'+this.codigo_empresa);
                        $('#div_dt_empresa').append(div);
                        $('#div_dt_empresa').show();
                    });
                    $("#img_cargando_empresa").hide();
                    $('#div_dt_empresa').show();
                 }else{
                    var p='<h2>Datos de la Empresa´s</h2>';
                    $('#div_dt_empresa').append(p);
                    p='<img tabindex="0" id="agregar_empresa" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/>';            
                    $('#div_dt_empresa').append(p);
                    p='<p>Informe:'+datos.mensaje+'</p>'; 
                    $('#div_dt_empresa').append(p);
                    $('#img_cargando_empresa').hide();
                    $('#div_dt_empresa').show();
                 }   
                }).fail(function(jqXHR, textStatus, errorThrown){
                    $("#img_cargando_empresa").hide();
                    $('#div_dt_empresa').show(); 
                    ajax_error(jqXHR,textStatus,$('#div_dt_empresa'));
                }); 
        }catch(e){
            var p='<h2>Datos de la Empresa´s</h2>';
            $('#div_dt_empresa').append(p);
            p='<img tabindex="0" id="agregar_empresa" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/>';            
            $('#div_dt_empresa').append(p);
            p='<p>Informe:'+e+'</p>'; 
            $('#div_dt_empresa').append(p);
            $('#img_cargando_empresa').hide();
            $('#div_dt_empresa').show();
        }
    }

function dt_empresa_editar(no_control,codigo_empresa){//cargar datos academicos
	try{
           $('#div_dt_empresa_editar').html('');
            $("#div_dt_empresa_editar").hide();
            $.post('ajax/all_dt_empresa.php',{codigo_empresa:codigo_empresa}).done(function(data){
                 datos=$.parseJSON(data);   
                 if(datos.respuesta==='1'){
                    var p='<h2>EMPRESA</h2>';            
                    $('#div_dt_empresa_editar').append(p);
                    $.each(datos.empresa,function(){
                        var div=$('<div/>');
                        p='<p>Nombre:<b>'+this.nombre+'</b></p>'; 
                        div.append(p);
                        p='<p>Giro:<b>'+this.giro+'</b></p>'; 
                        div.append(p);
                        p='<p>Web:<b>'+this.web+'</b></p>'; 
                        div.append(p);
                        p='<p>Email:<b>'+this.email+'</b></p>'; 
                        div.append(p);
                        p='<p>Puesto:<b>'+this.puesto+'</b></p>'; 
                        div.append(p);
                        p='<p>Ingreso:<b>'+this.año_ingreso+'</b></p>'; 
                        div.append(p);
                        p='<p>Superior inmediato:<b>'+this.nombre_jefe+'</b></p>'; 
                        div.append(p);
                        p='<p>Telefono:<b>'+this.telefono+'</b></p>'; 
                        div.append(p);
                        div.addClass('col-sm-6');
                        div.addClass('col-xs-12');
                        $('#div_dt_empresa_editar').append(div);
                        div=$('<div/>');
                        p='<p>Organismo:<b>'+this.organismo+'</b></p>'; 
                        div.append(p);
                        p='<p>Razón Social:<b>'+this.razon_social+'</b></p>'; 
                        div.append(p);
                        p='<p>Medio búsqueda:'+this.medio_busqueda+'</b></p>'; 
                        div.append(p);
                        p='<p>Tiempo de búsqueda:<b>'+this.tiempo_busqueda+'</b></p>'; 
                        div.append(p);
                        p='<p>Domicilio</p>'; 
                        div.append(p);
                        p='<p>Calle:<b>'+this.calle+' No:'+this.no_domicilio+'</b></p>'; 
                        div.append(p);
                        p='<p>Estado:<b>'+this.estado+'</b></p>'; 
                        div.append(p);
                        p='<p>Municipio:<b>'+this.municipio+'</b></p>'; 
                        div.append(p);
                        div.addClass('col-sm-6');
                        div.addClass('col-xs-12');
                        $('#div_dt_empresa_editar').append(div);
                    });
                    $('#div_dt_empresa_editar').show();
                 }else{
                     var p='<h2>EMPRESA</h2>';
                     $('#div_dt_empresa_editar').append(p);
                     p='<div class="cancel"></div>';
                     $('#div_dt_empresa_editar').append(p);
                     p='<p>Informe:'+datos.mensaje+'</p>'; 
                     $('#div_dt_empresa_editar').append(p);
                     $('#div_dt_empresa_editar').show();

                 }   
                }).fail(function(jqXHR, textStatus, errorThrown){
                  $('#div_dt_empresa_editar').show(); 
                  ajax_error(jqXHR,textStatus,$('#div_dt_empresa_editar'));
                }); 
        }catch(e){
            var p='<h2>EMPRESA</h2>';
            $('#div_dt_empresa_editar').append(p);
            p='<div class="cancel"></div>';
            $('#div_dt_empresa_editar').append(p);
            p='<p>Informe:'+e+'</p>'; 
            $('#div_dt_empresa_editar').append(p);
            $('#div_dt_empresa_editar').show();
        }
}

function actualizar_empresa(no_control,registro){
	try{
            $("#img_enviar_empresa").show();
            $("#frm_empresa").hide();
            $("#div_dt_empresa_editar").hide();
            $.post('ajax/actualizar_empresa.php',{form:$('#frm_empresa').serialize(),no_control:no_control,registro:registro,select_:select_})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            $("#img_enviar_empresa").hide();
                            limpiaForm($("#frm_empresa")); 
                            alert_('ACTUALIZADO',$('#dialogo_empresa'),250);
                            show_empresa();
                            dt_empresa(no_control);
                            setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
                            }
                    else{ //error desde el servidor
                            $("#img_enviar_empresa").hide();
                            limpiaForm($("#frm_empresa")); 
                            $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                            alert_("Error",$("#alert_personales"),250);	
                            setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);

                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_empresa").hide();
                limpiaForm($("#frm_empresa"));
                show_empresa();
                setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
                ajax_error_alert(jqXHR,textStatus);
            });//fin de done 
        }catch(e){
            $("#img_enviar_empresa").hide();
            limpiaForm($("#frm_empresa")); 
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);	
            setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
        }
	}

function evaluar_frm_empresa(){//evaluar select de frm empresa
	if($("#organismo").val()!='1'){
		if($("#razon_social").val()!='1'){
			if($("#medio_busqueda").val()!='1'){
				if($("#tiempo_busqueda").val()!='1'){
					if($("#estado_empresa").val()!='1')
						return true;
					else{
						alert_('Datos Incompletos ',$('#dialogo_empresa'),250);
						$("#tiempo_busqueda").focus();
						return false;
						}
				}else{
					alert_('Datos Incompletos',$('#dialogo_empresa'),250);
					$("#tiempo_busqueda").focus();
					return false;
				}	
			}else{
				$("#medio_busqueda").focus();
				alert_('Datos Incompletos ',$('#dialogo_empresa',250));
				return false;	
			}	
		}else{
			alert_('Datos Incompletos ',$('#dialogo_empresa'),250);
			$("#razon_social").focus();
			return false;		
		}
		
	}else{
		alert_('Datos Incompletos ',$('#dialogo_empresa'),250);
		$("#organismo").focus();
	}
	}	
	
function limpiaForm(miForm) {
// recorremos todos los campos que tiene el formulario
	$(':input', miForm).each(function() {
		var type = this.type;
		var tag = this.tagName.toLowerCase();
			switch (type) {
			case "checkbox":
				this.checked = false;
			break;
			case "radio":
				this.checked = false;
			break;
			case "submit":
				this.value='GUARDAR';
			break;
			default:
			this.value = '';
			}
			switch (tag) {
				case "textarea":
				this.value = '';
			break;
			case "select":
				if(this.name =='estado' ){
					this.selectedIndex =0;
				}else if(this.name =='municipio'){
					$(this).empty();
					var option = document.createElement("option");
					var x = document.getElementById($(this).attr('id'));
					option.text = "MUNICIPIO";
					option.value='1';
					x.add(option);	
					}
				else if(this.name =='especialidad'){
					$(this).empty();
					var option = document.createElement("option");
					var x = document.getElementById($(this).attr('id'));
					option.text = "ESPECIALIDAD";
					option.value='1';
					x.add(option);	
					}
				else {
					this.selectedIndex =0;	
					}			
			break;
			default:			
			}
			});//FIN EACH
}//FIN FUNCIÓN

function borrar_empresa(no_control,registro){//borrar empresa       
        try{
            alert_Bloq('BORRANDO...',$('#alert_personales'));
            $.post('ajax/borrar_empresa.php',{registro:registro,no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            alert_('BORRADO EXITOSO',$('#alert_personales'),250);//msn de borrado
                            setTimeout('$("#alert_personales").dialog( "close" );',1000);//cerrar el dlg
                            dt_empresa(no_control);
                            $('#div_frm_historial').hide();
                            $('#div_dt_historial_empresa').show();
                            dt_historial(no_control);
                            }

                    else{ //error desde el servidor
                        $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);
                        setTimeout("$('#alert_personales').dialog('close');",2000);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            }); 
        }catch(e){
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            setTimeout("$('#alert_personales').dialog('close');",2000);
        }
	}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       


function confirmar_empresa(no_control,registro){//preguntar borrado de empresa 
   $("#borrar_empresa").dialog({ 
		width: 250,  
		height: 250,
		title:"BORRAR ",
		show: "scale", 
		hide: "scale",
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#center_diag' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 $("#borrar_empresa").dialog("close");
				 borrar_empresa(no_control,registro);
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }
	  
function dt_historial(no_control){//cargar datos historial
	try{
            $("#div_dt_historial_empresa").hide();
            $("#div_dt_historial_empresa").html('');
            $("#img_cargando_historial").show();
            $.post('ajax/dt_historial_empresa.php',{no_control:no_control})
                .done(function(data){
                datos=$.parseJSON(data);   
                if(datos.respuesta==='1'){
                    var p='<h2>Historial laboral</h2>';            
                    $('#div_dt_historial_empresa').append(p);
                    p='<img tabindex="0" id="agregar_historial" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/></p>';          
                    $('#div_dt_historial_empresa').append(p);
                    $.each(datos.empresa,function(){
                        var div=$('<div/>');
                        p='<p><img tabindex="0" id="img_historial_empresa'+this.id_consecutivo+'" src="Imagenes/editar.png"  title="EDITAR" class="editar_empresa"/><img tabindex="0" id="img_historial_empresa'+this.id_consecutivo+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="elimnar_empresa"/></p>';
                        div.append(p);
                        p='<p><img  id="img_empresa_historial'+this.id_consecutivo+'" src="Imagenes/empresa.png" class="img_empresa visible-lg visible-md"/>';
                        div.append(p);
                        p='EMPRESA:<b>'+this.nombre+'</b></br>';
                        div.append(p);
                        p='TELÉFONO:<b>'+this.telefono+'</b></br>';
                        div.append(p);
                        p='WEB:<b>'+this.web+'</b></br>';
                        div.append(p);
                         p='EMAIL:<b>'+this.email+'</b></br>'; 
                        div.append(p);
                        div.addClass('div_dt_empresa_Ajax');
                        div.attr('id','div_historial_empresa'+this.id_consecutivo);
                        $('#div_dt_historial_empresa').append(div);
                    });
                    $("#img_cargando_historial").hide();
                    $('#div_dt_historial_empresa').show();
                 }else{
                    var p='<h2>Historial laboral</h2>';
                    $('#div_dt_historial_empresa').append(p);
                    p='<img tabindex="0" id="agregar_historial" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/></p>';          
                    $('#div_dt_historial_empresa').append(p);
                    p='<p>Informe:'+datos.mensaje+'</p>'; 
                    $('#div_dt_historial_empresa').append(p);
                    $('#img_cargando_historial').hide();
                    $('#div_dt_historial_empresa').show();
                 }   
                }).fail(function(jqXHR, textStatus, errorThrown){
                    $("#img_cargando_historial").hide();
                    $('#div_dt_historial_empresa').show(); 
                    ajax_error(jqXHR,textStatus,$('#div_dt_historial_empresa'));
                }); 
        }catch(e){
            var p='<h2>Historial laboral</h2>';
            $('#div_dt_historial_empresa').append(p);
            p='<img tabindex="0" id="agregar_historial" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS EMPRESAS" class="agregar_carrera"/></p>';          
            $('#div_dt_historial_empresa').append(p);
            p='<p>Informe:'+e+'</p>'; 
            $('#div_dt_historial_empresa').append(p);
            $('#img_cargando_historial').hide();
            $('#div_dt_historial_empresa').show();
        }
	}
	
function mostrar(){
	$(".editar_empresa").show();
	$(".elimnar_empresa").show();
	}
function ocultar(){
	$(".editar_empresa").hide();
	$(".elimnar_empresa").hide();
	}		  
function actualizar_historial(no_control,registro){//actualizar historial
	try{
            $("#img_enviar_historial").show();
            $("#frm_historial").hide();
            $("#div_dt_historial_editar").hide();
            $("#img_cerrar_frm_historial").hide();
            $.post('ajax/actualizar_historial.php',{form:$('#frm_historial').serialize(),no_control:no_control,registro:registro})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                        $("#img_enviar_historial").hide();
                        limpiaForm($("#frm_historial")); 
                        alert_('ACTUALIZADO',$('#dialogo_historial'),250);
                        mostrar();
                        show_historial();
                        dt_historial(no_control);
                        setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();$("#img_cerrar_frm_historial").show();',2000);
                        }
                    else{ //error desde el servidor
                        $("#img_enviar_historial").hide();
                        limpiaForm($("#frm_historial")); 
                        $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);
                        show_historial();	
                        setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();$("#img_cerrar_frm_historial").show();',2000);
                        }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_historial").hide();
                limpiaForm($("#frm_historial"));
                show_historial();
                setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();',2000);
                ajax_error_alert(jqXHR,textStatus);
            });//fin de done 
        }catch(e){
            $("#img_enviar_historial").hide();
            limpiaForm($("#frm_historial")); 
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            show_historial();	
            setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();$("#img_cerrar_frm_historial").show();',2000);
        }
	}	  
	
function borrar_historial(no_control,registro){//borrar empresa
	try{
           alert_Bloq('BORRANDO...',$('#alert_personales'));
            $.post('ajax/borrar_historial.php',{registro:registro,no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            alert_('BORRADO EXITOSO',$('#alert_personales'),250);
                            setTimeout('$("#alert_personales").dialog( "close" );',1000);
                            dt_historial(no_control);
                            }
                    else{ //error desde el servidor
                        $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);
                        setTimeout("$('#alert_personales').dialog('close');",2000);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            }); 
        }catch(e){
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            setTimeout("$('#alert_personales').dialog('close');",2000);
        }
	}      
function confirmar_historial(no_control,registro){//preguntar borrado de empresa 
   $("#div_borrar_historial").dialog({ 
		width: 250,  
		height: 250,
		title:"BORRAR",
		show: "scale", 
		hide: "scale", 
		resizable: "false",
		modal: "true", 
		position: { my: "center", at: "center", of: '#center_diag' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 $("#div_borrar_historial").dialog("close");
				 borrar_historial(no_control,registro);
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }
function guardar_historial(no_control){//guardar nueva mpresa
	try{
            $("#img_enviar_historial").show();//img guardado
            $("#frm_historial").hide();//ocular formulario
            $("#img_cerrar_frm_historial").hide();
            $.post('ajax/guardar_historial.php',{form:$('#frm_historial').serialize(),no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            $("#img_enviar_historial").hide();
                            limpiaForm($("#frm_historial")); 
                            alert_('EMPRESA AGREGADA',$('#dialogo_empresa'),250);
                            show_historial();
                            dt_historial(no_control);
                            setTimeout('$("#frm_historial").show();$("#img_cerrar_frm_historial").show();',2000);
                            }
                    else{ //error desde el servidor
                            $("#img_enviar_historial").hide();
                            limpiaForm($("#frm_historial")); 
                            $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                            alert_("Error",$("#alert_personales"),250);
                            show_historial();	
                            setTimeout('$("#frm_historial").show();$("#img_cerrar_frm_historial").show();',2000);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_historial").hide();
                limpiaForm($("#frm_historial"));
                show_historial();
                setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();',2000);
                ajax_error_alert(jqXHR,textStatus);
            });//fin de done 
        }catch(e){
            $("#img_enviar_historial").hide();
            limpiaForm($("#frm_historial")); 
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            show_historial();	
            setTimeout('$("#frm_historial").show();$("#img_cerrar_frm_historial").show();',2000);
        }
	}		  
	
function dt_social(no_control){//cargar datos social
	try{
            $("#div_dt_social").hide();
            $("#div_dt_social").html('');
            $("#img_cargando_social").show();
            $.post('ajax/dt_social.php',{no_control:no_control}).done(function(data){
                datos=$.parseJSON(data);   
                if(datos.respuesta==='1'){
                    var p='<h2>Asociaciones Sociales</h2>';            
                    $('#div_dt_social').append(p);
                    p='<img tabindex="0" id="agregar_social" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS ACTIVIDADES SOCIALES" class="agregar_carrera"/>';          
                    $('#div_dt_social').append(p);
                    $.each(datos.social,function(){
                        var div=$('<div/>');
                        p='<p><img tabindex="0" id="img_eliminar_social'+this.id_consecutivo+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="elimnar_empresa" style="margin-left:30%"/></p>';
                        div.append(p);
                        p='<p>NOMBRE:<b>'+this.nombre+'</b></p>';
                        div.append(p);
                        p='<p>Tipo:<b>'+this.tipo+'</b></p>'; 
                        div.append(p);
                        div.addClass('div_dt_social');
                        div.attr('id','div_social'+this.id_consecutivo);
                        $('#div_dt_social').append(div);
                    });
                    $("#img_cargando_social").hide();
                    $('#div_dt_social').show();
                 }else{
                    var p='<h2>Asociaciones Sociales</h2>';
                    $('#div_dt_social').append(p);
                    p='<img tabindex="0" id="agregar_social" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS ACTIVIDADES SOCIALES" class="agregar_carrera"/>';            
                    $('#div_dt_social').append(p);
                    p='<p>Informe:'+datos.mensaje+'</p>'; 
                    $('#div_dt_social').append(p);
                    $('#img_cargando_social').hide();
                    $('#div_dt_social').show();
                 }   
                }).fail(function(jqXHR, textStatus, errorThrown){
                    $("#img_cargando_social").hide();
                    $('#div_dt_social').show(); 
                    ajax_error(jqXHR,textStatus,$('#div_dt_social'));
                });    
        }catch(e){
            var p='<h2>Asociaciones Sociales</h2>';
            $('#div_dt_social').append(p);
            p='<img tabindex="0" id="agregar_social" style="width:40px;height:40px;left:35%;" src="Imagenes/agregar.png"  title="AGREGAR MÁS ACTIVIDADES SOCIALES" class="agregar_carrera"/>';            
            $('#div_dt_social').append(p);
            p='<p>Informe:'+e+'</p>'; 
            $('#div_dt_social').append(p);
            $('#img_cargando_social').hide();
            $('#div_dt_social').show();
        }
	}

function guardar_social(no_control){//guardar nueva mpresa
	try{
            $("#img_enviar_social").show();//img guardado
            $("#frm_social").hide();//ocular formulario
            $("#img_cerrar_frm_social").hide();
            $.post('ajax/guardar_social.php',{form:$('#frm_social').serialize(),no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            $("#img_enviar_social").hide();
                            limpiaForm($("#frm_social")); 
                            alert_('EXITO',$('#dialogo_social'),250);
                            show_social();
                            dt_social(no_control);
                            setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
                            }
                    else{ //error desde el servidor
                            $("#img_enviar_social").hide();
                            limpiaForm($("#frm_social")); 
                            $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                            alert_("Error",$("#alert_personales"),250);
                            show_social();	
                            setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_social").hide();
                limpiaForm($("#frm_social")); 
                show_social();
                setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
                ajax_error_alert(jqXHR,textStatus);
            });//fin de done    
        }catch(e){
            $("#img_enviar_social").hide();
            limpiaForm($("#frm_social")); 
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            show_social();	
            setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
                 
        }
	}
	
function borrar_social(no_control,registro){//borrar empresa
	try{
            alert_Bloq('BORRANDO...',$('#alert_personales'));
            $.post('ajax/borrar_social.php',{registro:registro,no_control:no_control})
            .done(function(data){
                datos=$.parseJSON(data);
                    if(datos.respuesta=='1'){//exito
                            alert_('BORRADO EXITOSO',$('#alert_personales'),280);
                            setTimeout('$("#alert_personales").dialog( "close" );',1000);
                            dt_social(no_control);
                            }
                    else{ //error desde el servidor
                        $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                        alert_("Error",$("#alert_personales"),250);
                        setTimeout("$('#alert_personales').dialog('close');",2000);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            });    
        }catch(e){
            $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
            alert_("Error",$("#alert_personales"),250);
            setTimeout("$('#alert_personales').dialog('close');",2000);    
        }
	} 

function confirmar_social(no_control,registro){//preguntar borrado de empresa 
   $("#div_borrar_social").dialog({ 
		width: 250,  
		height: 250,
		title:"BORRAR",
		show: "scale",
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#center_diag' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 $("#div_borrar_social").dialog("close");
				 borrar_social(no_control,registro);
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }  
	  
function dt_posgrado(no_control){//cargar datos academicos
	try{
            $("#div_dt_posgrado").hide();
            $("#div_dt_posgrado").html('');
            $("#img_cargando_posgrado").show();
            $.post('ajax/dt_posgrado.php',{no_control:no_control})
            .done(function(data){
                 datos=$.parseJSON(data);   
                 if(datos.respuesta==='1'){
                    var p='<h2>Posgrado</h2>';            
                    $('#div_dt_posgrado').append(p);
                    p='<img tabindex="0" id="agregar_posgrado" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar pogrado" /> ';          
                    $('#div_dt_posgrado').append(p);
                    $.each(datos.posgrado,function(){
                        var div=$('<div/>');
                        p='<img tabindex="0" id="img_posgrado_borrar'+this.id_posgrado+'" src="Imagenes/cancelar.png"  title="ELIMINAR" class="eliminar"/>';
                        div.append(p);
                        p='<p>Posgrado:<b>'+this.nombre+'</b></p>';
                        div.append(p);
                        p='<p>Escuela:<b>'+this.escuela+'</b></p>';
                        div.append(p);
                        p='<p>titulado:<b>'+this.titulado+'</b></p>';
                        div.append(p);
                         p='<p>Tipo:<b>'+this.posgrado+'</b></p>'; 
                        div.append(p);
                        div.addClass('div_carrera');
                        div.attr('id','div_posgrado'+this.id_posgrado);
                        $('#div_dt_posgrado').append(div);
                    });
                    $("#img_cargando_posgrado").hide();
                    $('#div_dt_posgrado').show();
                 }else{
                        var p='<h2>Posgrado</h2>';
                        $('#div_dt_posgrado').append(p);
                        p='<img tabindex="0" id="agregar_posgrado" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar posgrado" /> ';          
                        $('#div_dt_posgrado').append(p);
                        p='<p>Informe:'+datos.mensaje+'</p>'; 
                        $('#div_dt_posgrado').append(p);
                        $('#img_cargando_posgrado').hide();
                        $('#div_dt_posgrado').show();
                 }   
                }).fail(function(jqXHR, textStatus, errorThrown){
                  $("#img_cargando_posgrado").hide();
                  $('#div_dt_posgrado').show(); 
                  ajax_error(jqXHR,textStatus,$('#div_dt_posgrado'));
                }); 
        }catch(e){
            var p='<h2>Posgrado</h2>';
            p='<p>Informe:'+e+'</p>'; 
            $('#div_dt_posgrado').append(p);
            p='<img tabindex="0" id="agregar_posgrado" src="Imagenes/agregar.png" class="agregar_carrera"  title="Agregar posgrado" /> ';       
            $('#div_dt_posgrado').append(p);
            $('#img_cargando_posgrado').hide();
            $('#div_dt_posgrado').show();
        }
	}	  
	
function borrar_posgrado(no_control,registro){//borrar empresa
	try{
            alert_Bloq('BORRANDO...',$('#alert_personales'));
            $.post('ajax/borrar_posgrado.php',{registro:registro,no_control:no_control})
            .done(function(response){
                    respuesta = $.parseJSON(response);
                    if(respuesta.respuesta == 'done'){
                            alert_('BORRADO EXITOSO',$('#alert_personales'),280);
                            setTimeout('$("#alert_personales").dialog( "close" );',1000);
                            dt_posgrado(no_control);
                    }
                    else{
                            $("#alert_personales").append('<p>Informe:'+datos.mensaje+'</p>');
                            alert_("Error",$("#alert_personales"),250);
                            setTimeout("$('#alert_personales').dialog('close');",2000);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_alert(jqXHR,textStatus);
            });//fin de done 
        }catch(e){
            $("#alert_personales").append('<p>Informe:'+e+'</p>');
            alert_("Error",$("#alert_personales"),250);
            setTimeout("$('#alert_personales').dialog('close');",2000);
        }
}		

function confirmar_posgrado(no_control,registro){//preguntar borrado de empresa 
   $("#div_borrar_posgrado").dialog({ 
		width: 250,  
		height: 250,
		title:"BORRAR",
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#center_diag' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 $("#div_borrar_posgrado").dialog("close");
				 borrar_posgrado(no_control,registro);
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }
	  
function guardar_posgrado(no_control){//guardar nuevo idioma
	try{
            $("#img_enviar_posgrado").show();//img guardado
            $("#frm_posgrado").hide();//ocular formulario
            $.post('ajax/guardar_posgrado.php',{form:$('#frm_posgrado').serialize(),no_control:no_control})
            .done(function(response){
                    respuesta = $.parseJSON(response);
                    if(respuesta.respuesta == 'done'){
                            $("#img_enviar_posgrado").hide();
                            limpiaForm($("#frm_posgrado")); 
                            alert_('POSGRADO AGREGADO',$('#alert_academico'),300);
                            show_posgrado();
                            dt_posgrado(no_control);
                            setTimeout('$("#frm_posgrado").show();',1500);
                    }
                    else{
                            $("#img_enviar_posgrado").hide();
                            limpiaForm($("#frm_posgrado")); 
                            alert_(respuesta.mensaje,$("#alert_academico"),500);
                            show_posgrado();
                            setTimeout('$("#frm_posgrado").show();',1500);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_posgrado").hide();
                limpiaForm($("#frm_posgrado")); 
                show_posgrado();
                setTimeout('$("#frm_posgrado").show();',1500);
                ajax_error_alert(jqXHR,textStatus);
            });//fin de done    
        }catch(e){
            $("#img_enviar_posgrado").hide();
            limpiaForm($("#frm_posgrado")); 
            alert_(respuesta.mensaje,$("#alert_academico"),500);
            show_posgrado();
            setTimeout('$("#frm_posgrado").show();',1500);
        }
	}//fin de function principal; 	  
	
function guardar_residencia(no_control){//guardar nuevo idioma
	try{
           $("#img_enviar_residencia").show();//img guardado
            $("#frm_residencia").hide();//ocular formulario
            $.post('ajax/guardar_residencia.php',{form:$('#frm_residencia').serialize(),no_control:no_control})
            .done(function(response){
                    respuesta = $.parseJSON(response);
                    if(respuesta.respuesta == 'done'){
                            $("#img_enviar_residencia").hide();
                            $("#div_frm_residencia").fadeOut(500);
                            limpiaForm($("#frm_residencia")); 
                            alert_('ÉXITO',$('#alert_academico'),250);
                            setTimeout('$("#frm_residencia").show();',1500);

                    }
                    else{
                            $("#img_enviar_residencia").hide();
                            limpiaForm($("#frm_residencia")); 
                            $("#div_frm_residencia").fadeOut(500);
                            alert_(respuesta.mensaje,$("#alert_academico"),250);
                            setTimeout('$("#frm_residencia").show();',1500);
                    }
                    }).
            fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_residencia").hide();
                $("#div_frm_residencia").fadeOut(500);
                ajax_error_alert(jqXHR,textStatus);
            }); 
        }catch(e){
            $("#img_enviar_residencia").hide();
            limpiaForm($("#frm_residencia")); 
            $("#div_frm_residencia").fadeOut(500);
            alert_(e,$("#alert_academico"),250);
            setTimeout('$("#frm_residencia").show();',1500);
        }
	}//fin de function principal;
function nueva_contraseña(no_control){
    try{
        $("#frm_pass").hide();//ocultar campos
        $("#img_enviar_pass").show();
        var p = document.createElement("input"); 
        p.name = "p";
        p.type = "hidden";
        p.value = hex_sha512($('#viejo_pass').val());
        $("#frm_pass").append(p); 
        $('#viejo_pass').val('no ver');
        var x = document.createElement("input"); 
        x.name = "x";
        x.type = "hidden";
        x.value = hex_sha512($('#pass_nuevo').val());
        $("#frm_pass").append(x);
        $('#pass_nuevo').val('no ver');
        $('#pass_nuevo_reafirmar').val('no ver');
        $.post('ajax/nueva_contrasena.php',{form:$("#frm_pass").serialize(),no_control:no_control})
            .fail(function(jqXHR, textStatus, errorThrown){
                $("#img_enviar_pass").hide();
                ajax_error_alert(jqXHR,textStatus); 
                limpiaForm($('#frm_pass'));
                $("#frm_pass").show();
            })
            .done(function(data){
            respuesta=$.parseJSON(data);
                if(respuesta.respuesta==='hecho'){
                    $("#img_enviar_pass").hide();
                    alert_('ÉXITO',$('#alert_academico'),250);
                    limpiaForm($('#frm_pass'));
                    $("#frm_pass").show();
                }
                else
                {   $("#img_enviar_pass").hide();
                    alert_(respuesta.mensaje,$('#alert_pass'),250);
                    limpiaForm($('#frm_pass'));
                    $("#frm_pass").show();
                }
            });
        p.remove(); 
        x.remove();
        $('#span_pass').hide();
        $('#span-pass-correcto').hide();    
    }catch(e){
        $("#img_enviar_pass").hide();
        alert_(e,$('#alert_pass'),250);
        limpiaForm($('#frm_pass'));
        $("#frm_pass").show();
    }
}

function evaluar_pass(input){//evaluar password
    var input=input;
    var caracteres = 0;
    var may = 0;
    var min = 0;
    var numero = 0;
    var especiales = 0;
    var total=0;
    var mayusculas= new RegExp('[A-Z]');
    var minusculas= new RegExp('[a-z]');
    var numeros = new RegExp('[0-9]');
    var esp_caracteres = new RegExp('([!,%,&,@,#,$,^,*,?,_,~])');
    
    if (input.val().length > 8) { caracteres = 1; } else { caracteres = 0; };
    if (input.val().match(mayusculas)) { may = 1;} else { may = 0; };
    if (input.val().match(esp_caracteres)) { especiales = 1;} else { especiales = 0; };
    if (input.val().match(minusculas)) { min = 1;}  else { min = 0; };
    if (input.val().match(numeros)) { numero = 1;}  else { numero = 0; };
    
    total=caracteres+may+min+numero+especiales;
    
    if(total===0){ 
        $('#pass_nuevo').removeClass();
        $('#span-pass-seguridad').html('');
    }
    if(total===1){ 
        $('#pass_nuevo').removeClass(); 
        $('#pass_nuevo').addClass('muy-debil');
        $('#span-pass-seguridad').html('Muy Débil');
    }
    if(total===2){ 
        $('#pass_nuevo').removeClass(); 
        $('#pass_nuevo').addClass('debil');
        $('#span-pass-seguridad').html('Débil');
    }
    if(total===3) {
        $('#pass_nuevo').removeClass();
        $('#pass_nuevo').addClass('media');
        $('#span-pass-seguridad').html('Media');
    }
    if(total===4){ 
        $('#pass_nuevo').removeClass(); 
        $('#pass_nuevo').addClass('alta');
        $('#span-pass-seguridad').html('Alta');
    }
}