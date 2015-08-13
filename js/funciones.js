
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
	$('#contenedor_Datos_Personales').slideToggle(1000);//mostrar animar
	$('#contenedor_form_datos_personales').slideToggle(1000);
	};
function show_idiomas(){//animaciones de los contenedores de los datos basicos de los egresados
	$('#div_idioma').slideToggle(1000);//mostrar animar
	$('#div_frm_idioma').slideToggle(1000);
	$('#img_agregar_empresa').slideToggle(1000);
	};	
function navegador(){
	var navegador = navigator.userAgent;
 	 if (navigator.userAgent.indexOf('MSIE') !=-1) {
		 alert("!!!!!ESTAS USANDO INTERNET EXPLORER ESTE NAVEGADOR NO ES COMPATIBLE CON ESTA PAGINA PRUEBA OTRO NAVEGADOR");
  	} 
	}		
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
	
	$("#cargando_frm").show();
	$("#contendedor_d1").hide();
	jqXHR= $.post("contenidos/dt_egresado.php",{no_control:no_control})
	.fail(function(){
			alert_('Error en servidor',$("#alert_personales"),250);})
	.done(function(data){
            $("#cargando_frm").hide();
			$("#contendedor_d1").show();
			$("#contendedor_d1").html(data);
            }); 
	};		
function cargar_municipios(){	//cargar municpios con ajax
	 $("#estados option:selected").each(function () {
            elegido=$(this).val();
			$("#img_cargando_estado").show();
            jqXHR=$.post("contenidos/Municipios.php", { elegido: elegido })
	.fail(function(){
			$("#img_cargando_estado").hide();
			alert('Error con el servidor');})
	.done( function(data){
			$("#img_cargando_estado").hide();
            $("#Municipios").html(data);
            });            
        });
		};	
function cargar_municipios_empresa(){	//cargar municpios con ajax
	 $("#estado_empresa option:selected").each(function () {
            elegido=$(this).val();
			$("#img_muncipio_empresa").show();
            jqXHR=$.post("contenidos/Municipios.php", { elegido: elegido })
	.fail(function(){
			$("#img_muncipio_empresa").hide();
			alert('Error con el servidor');})
	.done( function(data){
			$("#img_muncipio_empresa").hide();
            $("#municipio_empresa").html(data);
            });            
        });
		};		
	
function cargar_especialidad(){	//cargar municpios con ajax
	 $("#carrera option:selected").each(function () {
            elegido=$(this).val();
			$("#img_cargando").show();
            jqXHR=$.post("ajax/especialidad.php", { elegido: elegido })
	.fail(function(){
			alert('Error con el servidor');})
	.done( function(data){
            	$("#especialidad").html(data);
				$("#img_cargando").hide();
            });            
        });
		};
function cargar_idiomas(){
	$("#idiomas").load("ajax/idiomas.php",function(response, status, xhr){
		if ( status == "error" ) {
    		alert_("ERROR EN SERVIDOR",$("#alert_academico"),250);
 								 }//fin if
		});
	};
function cargar_estados(){
	$("#estados").load("contenidos/Estados.php",function(response, status, xhr){
		if ( status == "error" ) {
    		alert_("ERROR SERVIDOR",$("#alert_personales"),250);
 								 }//fin if
		});
	$("#estado_empresa").load("contenidos/Estados.php",function(response, status, xhr){
		if ( status == "error" ) {
    		alert_("ERROR SERVIDOR",$("#alert_personales"),250);
 								 }//fin if
		});	
	};
function cargar_carrera(){
	$("#carrera").load("ajax/carrera.php",function(response, status, xhr){
		if ( status == "error" ) {
    		alert_("ERROR SERVIDOR",$("#alert_academico"),250);
 								 }//fin if
		});
	};								
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
	 showMonthAfterYear: false,
	 yearSuffix: ''
 };
	 $.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
	$("#fecha").datepicker();
});
	};	
function guardar_datos(no_control){//guardar datos básicos egresado
	$("#enviar").show();//ocultar y mostrar frm, gif de envio
	$("#cancelar").hide();
	$("#frm_Datos_Personales").hide();	
	jqXHR=$.post("ajax/guardar_datos.php",{form:$('#frm_Datos_Personales').serialize(),no_control:no_control})
	.fail(function(){
			show();
			setTimeout( "jQuery('#frm_Datos_Personales').show();$('#cancelar').show();",2000 );
			alert_('ERROR SERVIDOR',$("#alert_personales"),250);})
	.done(function(data){//evaluando respuesta del servidor
		$("#enviar").hide();
		if(data==1){
			limpiaForm($("#frm_Datos_Personales"));	//exito!!!
			alert_("DATOS GUARDADOS",$("#alert_personales"),250);
			show();
			datos_egresado(no_control);
			setTimeout( "jQuery('#frm_Datos_Personales').show();$('#cancelar').show();",2000 );
			}else{//error!!
				alert_("TRATÉ DESPUÉS",$("#alert_personales"),250);
				limpiaForm($("#frm_Datos_Personales"));	//exito!!!
				$("#frm_Datos_Personales").show();
			}
	});
	};	
	
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
	};
		
function dt_academicos(no_control){//cargar datos academicos
	$("#datos_academicos").hide();
	$("#img_cargando_dt_academicos").show();
	jqXHR=$.post('ajax/dt_academicos.php',{no_control:no_control}).
	fail(function(){
			$("#img_cargando_dt_academicos").hide();
			alert('Error con el servidor');
			$("#datos_academicos").show();
	})
	.done(function(data){
		$("#img_cargando_dt_academicos").hide();
		$("#datos_academicos").html(data);
		$("#datos_academicos").show();
		});
	};
			
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
	$("#img_enviar_academico").show();//img guardado
	$("#frm_dt_academico").hide();//ocular formulario
	$("#div_carrera_actualizar").hide();
	$("#titlo_carrera").hide();
	$(".eliminar").show();//ocultar img eliminar y eliminar
	$(".editar_academico").show();
	$.post('ajax/guardar_academico.php',{form:$('#frm_dt_academico').serialize(),no_control:no_control})
	.fail(function(){
			$("#img_enviar_academico").hide();
			$("#frm_dt_academico").show();
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_academico").hide();
			limpiaForm($("#frm_dt_academico"));
			alert_('CARRERA AGREGADA',$('#alert_academico'),250);
			show_dt_academicos();
			dt_academicos(no_control);
			setTimeout('$("#frm_dt_academico").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_academico").hide();
			limpiaForm($("#frm_dt_academico"));
			alert_('ERROR FORMULARIO',$('#alert_academico'),250);
			setTimeout('$("#frm_dt_academico").show();',2000);
			show_dt_academicos();
			}
		else if(data=='3'){//eres muy listo?
			$("#img_enviar_academico").hide();
			alert_("Max 4 carreras",$('#alert_academico'),250);
			limpiaForm($("#frm_dt_academico"));	
			setTimeout('$("#frm_dt_academico").show();',2000);	
			show_dt_academicos();
		}else{ //error desde el servidor
			$("#img_enviar_academico").hide();
			alert_('ERROR DESCONOCIDO',$('#alert_academico'),250);	
			setTimeout('$("#frm_dt_academico").show();',2000);
			show_dt_academicos();
		}
		});//fin de done
	}//fin de function principal;	
function confirmar(no_control,registro){ 
   $("#dialogo").dialog({ <!--  ------> muestra la ventana  -->
		width: 250,  <!-- -------------> ancho de la ventana -->
		height: 250,
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
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
	$("#img_enviar_academico").show();
	$("#frm_dt_academico").hide();
	$("#div_carrera_actualizar").hide();
	$("#titlo_carrera").hide();
	$.post('ajax/actualizar_academico.php',{form:$('#frm_dt_academico').serialize(),no_control:no_control,registro:registro})
	.fail(function(){
			$("#img_enviar_academico").hide();
			show_dt_academicos();
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);
			setTimeout('$("#frm_dt_academico").show();$("#div_carrera_actualizar").show();$("#titlo_carrera").show();',2000);
			})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_academico").hide();
			limpiaForm($("#frm_dt_academico"));
			alert_('DATOS ACTUALIZADOS',$('#alert_academico'),250);
			show_dt_academicos();
			dt_academicos(no_control);
			setTimeout('$("#frm_dt_academico").show();$("#div_carrera_actualizar").show();$("#titlo_carrera").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_academico").hide();
			limpiaForm($("#frm_dt_academico"));
			alert_('ERROR FORMULARIO',$('#alert_academico'),250);
			show_dt_academicos();
			setTimeout('$("#frm_dt_academico").show();$("#div_carrera_actualizar").show();$("#titlo_carrera").show();',2000);
			}
		else{ //error desde el servidor
			$("#img_enviar_academico").hide();
			alert_('ERROR DESCONOCIDO',$('#alert_academico'),250);
			show_dt_academicos();	
			setTimeout('$("#frm_dt_academico").show();$("#div_carrera_actualizar").show();$("#titlo_carrera").show();',2000);
		}
		});//fin de done
	};
	
function alert_(title,dialog,ancho){ 
var alert_=dialog;
   alert_.dialog({ <!--  ------> muestra la ventana  -->
   		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).show(); },
		width:ancho,  <!-- -------------> ancho de la ventana -->
		height: 250,
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
		title:title,
		position: { my: "center", at: "center", of: '#center_diag' }
		});
	  }		
	  	
function alert_Bloq(title,dialog){ 
var alert_=dialog;
   alert_.dialog({ <!--  ------> muestra la ventana  -->
  		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },//ocultar boton de cerrar ventana
		width:250,  <!-- -------------> ancho de la ventana -->
		height: 100,
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
		title:title,
		position: { my: "center", at: "center", of: '#center_diag' }
		});
	  }			
function borrar_carrera(no_control,registro){//borrar carrera
	alert_Bloq('BORRANDO...',$('#alert_academico'));
	$.post('ajax/eliminar_carrera.php',{registro:registro,no_control:no_control})
	.fail(function(){
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);})
	.done(function(data){
		if(data=='1'){//exito
			alert_('BORRADO EXITOSO',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			dt_academicos(no_control);
			}
		else if(data=='2'){//problemas con formulario
			alert_('ERROR FORMULARIO',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			}
		else{ //error desde el servidor
			alert_('ERROR DESCONOCIDO',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
		}
		});//fin de done
	};	
function dt_idioma(no_control){//cargar datos academicos
	$("#div_idioma_img").show();
	$("#img_cargando_idiomas").show();
	$("#div_idioma").hide();
	jqXHR=$.post('ajax/dt_idiomas.php',{no_control:no_control}).
	fail(function(){
			$("#div_idioma").show();
			alert('Error con el servidor');
			$("#div_idioma_img").hide();
	})
	.done(function(data){
		$("#div_idioma_img").hide();
		$("#div_idioma").html(data);
		$("#div_idioma").show();
		});
	};	
function borrar_idioma(no_control,registro){//borrar carrera
	alert_Bloq('BORRANDO...',$('#alert_academico'));
	$.post('ajax/eliminar_idioma.php',{registro:registro,no_control:no_control})
	.fail(function(){
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			})
	.done(function(data){
		if(data=='1'){//exito
			alert_('BORRADO EXITOSO',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			dt_idioma(no_control);
			}
		else if(data=='2'){//problemas con formulario
			alert_('ERROR FORMULARIO',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			}
		else{ //error desde el servidor
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
		}
		});//fin de done
	};	
	
function confirmar_idioma(no_control,registro){//preguntar borrado de idioma 
   $("#dialogo_idioma").dialog({ <!--  ------> muestra la ventana  -->
		width: 250,  <!-- -------------> ancho de la ventana -->
		height: 250,
		title:"BORRAR",
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
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
	$("#img_enviar_idioma").show();//img guardado
	$("#frm_idioma").hide();//ocular formulario
	$("#img_cancelar_idiomas").hide();
	$.post('ajax/agregar_idioma.php',{form:$('#frm_idioma').serialize(),no_control:no_control})
	.fail(function(){
			$("#img_enviar_idioma").hide();
			setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_idioma").hide();
			limpiaForm($("#frm_idioma"));
			alert_('IDIOMA AGREGADO',$('#alert_academico'),250);
			show_idiomas();
			dt_idioma(no_control);
			setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_idioma").hide();
			limpiaForm($("#frm_idioma"));
			show_idiomas();
			alert_('ERROR FORMULARIO',$('#alert_academico'),250);
			setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
			}
		else if(data=='3'){//eres muy listo?
			$("#img_enviar_idioma").hide();
			limpiaForm($("#frm_idioma"));
			show_idiomas();
			alert_("MAXIMO 7 IDIOMAS",$('#alert_academico'),250);	
			setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);	
		}else{ //error desde el servidor
			$("#img_enviar_academico").hide();
			show_idiomas();
			alert_('ERROR DESCONOCIDO',$('#alert_academico'),250);	
			setTimeout('$("#frm_idioma").show();$("#img_cancelar_idiomas").show();',2000);
			
		}
		});//fin de done
	}//fin de function principal; 
function dt_SW(no_control){//cargar datos academicos
	$("#div_dt_software").hide();
	$("#img_cargando_sw").show();
	jqXHR=$.post('ajax/dt_sw.php',{no_control:no_control}).
	fail(function(){
			$("#img_cargando_sw").hide();
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);
			$("#div_dt_software").show();
	})
	.done(function(data){
		$("#img_cargando_sw").hide();
		$("#div_dt_software").html(data);
		$("#div_dt_software").show();
		});
	};	
function guardar_sw(no_control){//guardar nuevo idioma
	$("#img_enviar_sw").show();//img guardado
	$("#frm_sw").hide();//ocular formulario
	$("#img_cancelar_sw").hide();
	$.post('ajax/agregar_sw.php',{form:$('#frm_sw').serialize(),no_control:no_control})
	.fail(function(){
			$("#img_enviar_sw").hide();
			show_SW();
			setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_sw").hide();
			limpiaForm($("#frm_sw"));
			alert_('SOFTWARE AGREGADO',$('#alert_academico'),250);
			show_SW();
			dt_SW(no_control);
			setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_sw").hide();
			show_SW();
			alert_('ERROR FORMULARIO',$('#alert_academico'),250);
			setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);
			}
		else if(data=='3'){//eres muy listo?
			$("#img_enviar_sw").hide();
			show_SW();
			alert_("MAXIMO 7 SOFTWARE",$('#alert_academico'),250);	
			setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);	
		}else{ //error desde el servidor
			$("#img_enviar_sw").hide();
			alert_('ERROR DESCONOCIDO',$('#alert_academico'),250);	
			setTimeout('$("#frm_sw").show();$("#img_cancelar_sw").show();',2000);
			
		}
		});//fin de done
	}//fin de function principal;	
function borrar_sw(no_control,registro){//borrar sw
	alert_Bloq('BORRANDO...',$('#alert_academico'));
	$.post('ajax/eliminar_sw.php',{registro:registro,no_control:no_control})
	.fail(function(){
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			})
	.done(function(data){
		if(data=='1'){//exito
			alert_('BORRADO EXITOSO',$('#alert_academico'),250);//msn de borrado
			setTimeout('$("#alert_academico").dialog( "close" );',1000);//cerrar el dlg
			dt_SW(no_control);//cargar nuevos datos
			}
		else if(data=='2'){//problemas con formulario
			alert_('ERROR EN ENVIO',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			}
		else{ //error desde el servidor
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
		}
		});//fin de done
};

function confirmar_sw(no_control,registro){//preguntar borrado de sw 
   $("#dialogo_sw").dialog({ <!--  ------> muestra la ventana  -->
		width: 250,  <!-- -------------> ancho de la ventana -->
		height: 250,
		title:"BORRAR ",
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
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
	 img_=' <img src="Imagenes/eliminar_verde.gif" class="eliminar_requisito "  style="color:#666;" id="img'+select_+'requisito"/>';
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
	$("#img_enviar_empresa").show();//img guardado
	$("#frm_empresa").hide();//ocular formulario
	$("#img_cancelar_empresa").hide();
	$.post('ajax/guardar_empresa.php',{form:$('#frm_empresa').serialize(),no_control:no_control,select_:select_})
	.fail(function(){
			$("#img_enviar_empresa").hide();
			alert_('ERROR SERVIDOR',$('#dialogo_empresa'),250);
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);
			})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			alert_('EMPRESA AGREGADA',$('#dialogo_empresa'),250);
			show_empresa();
			dt_empresa(no_control);
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			alert_('ERROR FORMULARIO',$('#dialogo_empresa'),250);
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);
			}
		else if(data=='3'){//eres muy listo?
			$("#img_enviar_empresa").hide();
			alert_("MAXIMO 4 EMPRESAS ",$('#dialogo_empresa'),250);	
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);	
		}else{ //error desde el servidor
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			alert_('ERROR DESCONOCIDO',$('#dialogo_empresa'),250);	
			setTimeout('$("#frm_empresa").show();$("#img_cancelar_empresa").show();',2000);
		}
		});//fin de done
	}//fin de function principal;		
	
function dt_empresa(no_control){//cargar datos academicos
	$("#div_dt_empresa").hide();
	$("#img_cargando_empresa").show();
	jqXHR=$.post('ajax/dt_empresa.php',{no_control:no_control}).
		fail(function(){
				$("#img_cargando_empresa").hide();
				alert('Error con el servidor');
				$("#div_dt_empresa").show();
		})
		.done(function(data){
			$("#img_cargando_empresa").hide();
			$("#div_dt_empresa").html(data);
			$("#div_dt_empresa").show();
		});
};

function dt_empresa_editar(no_control,empresa){//cargar datos academicos
	$("#div_dt_empresa_editar").hide();
	$.post('ajax/all_dt_empresa.php',{no_control:no_control,empresa:empresa}).
		fail(function(){
				alert('Error con el servidor');
		})
		.done(function(data){
			$("#div_dt_empresa_editar").fadeIn(2000);
			$("#div_dt_empresa_editar").html(data);
		});
};

function actualizar_empresa(no_control,registro){
	$("#img_enviar_empresa").show();
	$("#frm_empresa").hide();
	$("#div_dt_empresa_editar").hide();
	$.post('ajax/actualizar_empresa.php',{form:$('#frm_empresa').serialize(),no_control:no_control,registro:registro,select_:select_})
	.fail(function(){
			$("#img_enviar_empresa").hide();
			setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
			alert_('ERROR SERVIDOR',$('#dialogo_empresa'),250);})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			alert_('DATOS ACTUALIZADOS',$('#dialogo_empresa'),250);
			show_empresa();
			dt_empresa(no_control);
			setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			alert_('ERROR FORMULARIO',$('#dialogo_empresa'),250);
			setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
			}
		else{ //error desde el servidor
			$("#img_enviar_empresa").hide();
			limpiaForm($("#frm_empresa")); 
			alert_('Error desconocido',$('#dialogo_empresa'),250);	
			setTimeout('$("#frm_empresa").show();$("#div_dt_empresa_editar").show();',2000);
		}
		});//fin de done
	};

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
	alert_Bloq('BORRANDO...',$('#dialogo_empresa'));
	$.post('ajax/borrar_empresa.php',{registro:registro,no_control:no_control})
	.fail(function(){
			alert_('ERROR SERVIDOR',$('#dialogo_empresa'),250);
			setTimeout('$("#dialogo_empresa").dialog( "close" );',1000);})
	.done(function(data){
		if(data=='1'){//exito
			alert_('BORRADO EXITOSO',$('#dialogo_empresa',250));
			setTimeout('$("#dialogo_empresa").dialog( "close" );',1000);
			dt_empresa(no_control);
			dt_historial(no_control);
			}
		else if(data=='3'){//problemas con formulario
			alert_('ERROR FORMULARIO',$('#dialogo_empresa'),250);
			setTimeout('$("#dialogo_empresa").dialog( "close" );',1000);
			}
		else{ //error desde el servidor
			alert_('ERROR SERVIDOR',$('#dialogo_empresa'),250);
			setTimeout('$("#dialogo_empresa").dialog( "close" );',1000);
		}
		});//fin de done
}


function confirmar_empresa(no_control,registro){//preguntar borrado de empresa 
   $("#borrar_empresa").dialog({ <!--  ------> muestra la ventana  -->
		width: 250,  <!-- -------------> ancho de la ventana -->
		height: 250,
		title:"BORRAR ",
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
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
	$("#div_dt_historial_empresa").hide();
	$("#img_cargando_historial").show();
	jqXHR=$.post('ajax/dt_historial_empresa.php',{no_control:no_control}).
		fail(function(){
				$("#img_cargando_historial").hide();
				alert('Error con el servidor dt_historial');
				$("#div_dt_historial_empresa").show();
		})
		.done(function(data){
			$("#img_cargando_historial").hide();
			$("#div_dt_historial_empresa").html(data);
			$("#div_dt_historial_empresa").show();
		});
};
	
function mostrar(){
	$(".editar_empresa").show();
	$(".elimnar_empresa").show();
	}
function ocultar(){
	$(".editar_empresa").hide();
	$(".elimnar_empresa").hide();
	}		  
function actualizar_historial(no_control,registro){//actualizar historial
	$("#img_enviar_historial").show();
	$("#frm_historial").hide();
	$("#div_dt_historial_editar").hide();
	$("#img_cerrar_frm_historial").hide();
	$.post('ajax/actualizar_historial.php',{form:$('#frm_historial').serialize(),no_control:no_control,registro:registro})
	.fail(function(){
			$("#img_enviar_historial").hide();
			show_historial();
			setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();$("#img_cerrar_frm_historial").hide();',2000);//controlar animaciones
			alert_('ERROR SERVIDOR',$('#dialogo_historial'),250);})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_historial").hide();
			limpiaForm($("#frm_historial")); 
			alert_('DATOS ACTUALIZADOS',$('#dialogo_historial'),250);
			mostrar();
			show_historial();
			dt_historial(no_control);
			setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();$("#img_cerrar_frm_historial").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_historial").hide();
			limpiaForm($("#frm_historial")); 
			alert_('ERROR FORMULARIO',$('#dialogo_historial'),250);
			mostrar();
			show_historial();
			setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();$("#img_cerrar_frm_historial").show();',2000);
			}
		else{ //error desde el servidor
			$("#img_enviar_historial").hide();
			limpiaForm($("#frm_historial")); 
			alert_('Error desconocido',$('#dialogo_historial'),250);
			show_historial();	
			setTimeout('$("#frm_historial").show();$("#div_dt_historial_editar").show();$("#img_cerrar_frm_historial").show();',2000);
		}
		});//fin de done
	};	  
	
function borrar_historial(no_control,registro){//borrar empresa
	alert_Bloq('BORRANDO...',$('#dialogo_historial'));
	$.post('ajax/borrar_historial.php',{registro:registro,no_control:no_control})
	.fail(function(){
			alert_('FALLA DE SERVIDOR',$('#dialogo_historial'),250);
			setTimeout('$("#dialogo_historial").dialog( "close" );',1000);})
	.done(function(data){
		if(data=='1'){//exito
			alert_('BORRADO EXITOSO',$('#dialogo_historial'),250);
			setTimeout('$("#dialogo_historial").dialog( "close" );',1000);
			dt_historial(no_control);
			}
		else if(data=='3'){//problemas con formulario
			alert_('ERROR CON GUARDADO',$('#dialogo_historial'),250);
			setTimeout('$("#dialogo_historial").dialog( "close" );',1000);
			}
		else{ //error desde el servidor
			alert_('ERROR SERVIDOR',$('#dialogo_empresa'),250);
			setTimeout('$("#dialogo_historial").dialog( "close" );',1000);
		}
		});//fin de done
}	
function confirmar_historial(no_control,registro){//preguntar borrado de empresa 
   $("#div_borrar_historial").dialog({ <!--  ------> muestra la ventana  -->
		width: 250,  <!-- -------------> ancho de la ventana -->
		height: 250,
		title:"BORRAR",
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
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
	$("#img_enviar_historial").show();//img guardado
	$("#frm_historial").hide();//ocular formulario
	$("#img_cerrar_frm_historial").hide();
	$.post('ajax/guardar_historial.php',{form:$('#frm_historial').serialize(),no_control:no_control})
	.fail(function(){
			$("#img_enviar_historial").hide();
			show_historial();
			setTimeout('$("#frm_historial").show();$("#img_cerrar_frm_historial").show();',2000);
			alert_('ERROR SERVIDOR',$('#dialogo_empresa'),250);})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_historial").hide();
			limpiaForm($("#frm_historial")); 
			alert_('EMPRESA AGREGADA',$('#dialogo_empresa'),250);
			show_historial();
			dt_historial(no_control);
			setTimeout('$("#frm_historial").show();$("#img_cerrar_frm_historial").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_historial").hide();
			limpiaForm($("#frm_historial")); 
			alert_('ERROR FORMULARIO',$('#dialogo_empresa'),250);
			show_historial();
			setTimeout('$("#frm_historial").show();$("#img_cerrar_frm_historial").show();',2000);
			}
		else{ //error desde el servidor
			$("#img_enviar_historial").hide();
			limpiaForm($("#frm_historial")); 
			alert_('ERROR DESCONOCIDO',$('#dialogo_empresa'),250);
			show_historial();	
			setTimeout('$("#frm_historial").show();$("#img_cerrar_frm_historial").show();',2000);
		}
		});//fin de done
	}//fin de function principal;			  
	
function dt_social(no_control){//cargar datos social
	$("#div_dt_social").hide();
	$("#img_cargando_social").show();
	 xhr=$.post('ajax/dt_social.php',{no_control:no_control}).
		fail(function(){
				$("#img_cargando_social").hide();
				alert('Error con el servidor dt_social');
				$("#div_dt_social").show();
		})
		.done(function(data){
			$("#img_cargando_social").hide();
			$("#div_dt_social").html(data);
			$("#div_dt_social").show();
		});
};

function guardar_social(no_control){//guardar nueva mpresa
	$("#img_enviar_social").show();//img guardado
	$("#frm_social").hide();//ocular formulario
	$("#img_cerrar_frm_social").hide();
	$.post('ajax/guardar_social.php',{form:$('#frm_social').serialize(),no_control:no_control})
	.fail(function(){
			$("#img_enviar_social").hide();
			show_social();
			setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
			alert_('ERROR SERVIDOR',$('#dialogo_social'),250);})
	.done(function(data){
		if(data=='1'){//exito
			$("#img_enviar_social").hide();
			limpiaForm($("#frm_social")); 
			alert_('ASOCIACIÓN AGREGADA',$('#dialogo_social'),250);
			show_social();
			dt_social(no_control);
			setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
			}
		else if(data=='2'){//problemas con formulario
			$("#img_enviar_social").hide();
			limpiaForm($("#frm_social")); 
			alert_('ERROR FORMULARIO',$('#dialogo_social'),280);
			show_social();
			setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
			}
		else{ //error desde el servidor
			$("#img_enviar_social").hide();
			limpiaForm($("#frm_social")); 
			alert_('ERROR DESCONOCIDO',$('#dialogo_social'),280);
			show_social();	
			setTimeout('$("#frm_social").show();$("#img_cerrar_frm_social").show();',2000);
		}
		});//fin de done
	}//fin de function principal;
	
function borrar_social(no_control,registro){//borrar empresa
	alert_Bloq('BORRANDO...',$('#dialogo_social'));
	$.post('ajax/borrar_social.php',{registro:registro,no_control:no_control})
	.fail(function(){
			alert_('FALLA DE SERVIDOR',$('#dialogo_social'),280);
			setTimeout('$("#dialogo_social").dialog( "close" );',1000);})
	.done(function(data){
		if(data=='1'){//exito
			alert_('BORRADO EXITOSO',$('#dialogo_social'),280);
			setTimeout('$("#dialogo_social").dialog( "close" );',1000);
			dt_social(no_control);
			}
		else if(data=='3'){//problemas con formulario
			alert_('ERROR CON GUARDADO',$('#dialogo_social')),250;
			setTimeout('$("#dialogo_social").dialog( "close" );',1000);
			}
		else{ //error desde el servidor
			alert_('ERROR SERVIDOR',$('#dialogo_social'),250);
			setTimeout('$("#dialogo_social").dialog( "close" );',1000);
		}
		});//fin de done
}	

function confirmar_social(no_control,registro){//preguntar borrado de empresa 
   $("#div_borrar_social").dialog({ <!--  ------> muestra la ventana  -->
		width: 250,  <!-- -------------> ancho de la ventana -->
		height: 250,
		title:"BORRAR",
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
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
	$("#div_dt_posgrado").hide();
	$("#img_cargando_posgrado").show();
	jqXHR=$.post('ajax/dt_posgrado.php',{no_control:no_control}).
	fail(function(){
			$("#img_cargando_posgrado").hide();
			alert_('Error con el servidor',$('#alert_academico'),250);
			$("#div_dt_posgrado").show();
	})
	.done(function(data){
		$("#img_cargando_posgrado").hide();
		$("#div_dt_posgrado").html(data);
		$("#div_dt_posgrado").show();
		});
	};	  
	
function borrar_posgrado(no_control,registro){//borrar empresa
	alert_Bloq('BORRANDO...',$('#alert_academico'));
	$.post('ajax/borrar_posgrado.php',{registro:registro,no_control:no_control})
	.fail(function(){
			alert_('FALLA DE SERVIDOR',$('#alert_academico'),280);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);})
	.done(function(response){
		respuesta = $.parseJSON(response);
	 	if(respuesta.respuesta == 'done'){
			alert_('BORRADO EXITOSO',$('#alert_academico'),280);
			setTimeout('$("#alert_academico").dialog( "close" );',1000);
			dt_posgrado(no_control);
		}
		else{
			alert_(respuesta.mensaje,$("#alert_academico"),500);
		}
		});//fin de done
}		

function confirmar_posgrado(no_control,registro){//preguntar borrado de empresa 
   $("#div_borrar_posgrado").dialog({ <!--  ------> muestra la ventana  -->
		width: 250,  <!-- -------------> ancho de la ventana -->
		height: 250,
		title:"BORRAR",
		show: "scale", <!-- -----------> animación de la ventana al aparecer -->
		hide: "scale", <!-- -----------> animación al cerrar la ventana -->
		resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
		modal: "true", <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa
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
	$("#img_enviar_posgrado").show();//img guardado
	$("#frm_posgrado").hide();//ocular formulario
	$.post('ajax/guardar_posgrado.php',{form:$('#frm_posgrado').serialize(),no_control:no_control})
	.fail(function(){
			$("#img_enviar_posgrado").hide();
			setTimeout('$("#frm_posgrado").show();',2000);
			alert_('ERROR SERVIDOR',$('#alert_academico'),255);})
	.done(function(response){
		respuesta = $.parseJSON(response);
	 	if(respuesta.respuesta == 'done'){
			$("#img_enviar_posgrado").hide();
			limpiaForm($("#frm_posgrado")); 
			alert_('POSGRADO AGREGADO',$('#alert_academico'),250);
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
		});//fin de done
	}//fin de function principal; 	  
	
function guardar_residencia(no_control){//guardar nuevo idioma
	$("#img_enviar_residencia").show();//img guardado
	$("#frm_residencia").hide();//ocular formulario
	$.post('ajax/guardar_residencia.php',{form:$('#frm_residencia').serialize(),no_control:no_control})
	.fail(function(){
			$("#img_enviar_residencia").hide();
			setTimeout('$("#frm_residencia").show();',2000);
			alert_('ERROR SERVIDOR',$('#alert_academico'),250);})
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
			alert_(respuesta.mensaje,$("#alert_academico"),500);
			setTimeout('$("#frm_residencia").show();',1500);
		}
		});//fin de done
	}//fin de function principal; 	  	