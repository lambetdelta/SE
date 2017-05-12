/*Casi todos los contenidos por ajax siguen la siguiente secuencia:
 * -ocultar div donde se uetarn datos-
 * -mostrar imagen de carga-
 * -validar respuesta-
 * -cargar respuesta mediante html generado con javascript */
/*Para borrar datos es casi la misma secuencia pero con la diferencia de que primero se lanza un evento de 
 * pregunta antes de borrar.
 /* Cualquier duda repecto al código o en que diablos estaba pensando cuando lo hice :) enviar un correo 
 *  con el asunto SE a la siguiente direccion lambetdelta@hotmail.com con el  Ing. Osvaldo Uriel Garcia Gomez*/ 

var no_registro=0;
var no_registro_b=0;
function salir(){
  window.location="includes/logout.php";  
}
function espacion_block(e){ //bloquear espacio
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==32) return false; 
}
//select de carrera carga con ajax
function select_carrera(){
    $('#select-carrera').html('');
    $('#select-carrera').append('<option value="0">Espere...</option>');
    $('#select-borrar-carrera').html('');
    $('#select-borrar-carrera').append('<option value="0">Espere...</option>');
    $('#select-borrar-carrera-especialidad').html('');
    $('#select-borrar-carrera-especialidad').append('<option value="0">Espere...</option>');
    $('#select-nueva-carrera-especialidad').html('');
    $('#select-nueva-carrera-especialidad').append('<option value="0">Espere...</option>');
    $.post('ajax_adm/carreras.php').done(function(data){
        datos=$.parseJSON(data);
        $('#select-carrera').html('');
        $('#select-borrar-carrera').html('');
        $('#select-borrar-carrera-especialidad').html('');
        $('#select-nueva-carrera-especialidad').html('');
        if(datos.respuesta==='1'){
            $.each(datos.carrera,function(){
                $('#select-carrera').append('<option value="'+this.codigo_carrera+'">'+this.nombre+'</option>');
                $('#select-borrar-carrera').append('<option value="'+this.codigo_carrera+'">'+this.nombre+'</option>');
                $('#select-borrar-carrera-especialidad').append('<option value="'+this.codigo_carrera+'">'+this.nombre+'</option>');
                $('#select-nueva-carrera-especialidad').append('<option value="'+this.codigo_carrera+'">'+this.nombre+'</option>');
            });
            setTimeout('select_especialidad_inicio()',1000);
        }else{
            $('#select-carrera').append('<option id="0">ERROR:'+datos.mensage+'</option>');
            $('#select-borrar-carrera').append('<option id="0">ERROR:'+datos.mensage+'</option>');
            $('#select-borrar-carrera-especialidad').append('<option id="0">ERROR:'+datos.mensage+'</option>');
            $('#select-nueva-carrera-especialidad').append('<option id="0">ERROR:'+datos.mensage+'</option>');
        }
    }).fail(function(jqXHR, textStatus, errorThrown){
        $('#select-carrera').html('');
        ajax_error_input(jqXHR, textStatus,$('#select-carrera'));
        $('#select-borrar-carrera').html('');
        ajax_error_input(jqXHR, textStatus,$('#select-borrar-carrera'));
        $('#select-borrar-carrera-especialidad').html('');
        ajax_error_input(jqXHR, textStatus,$('#select-borrar-carrera-especialidad'));
        $('#select-nueva-carrera-especialidad').html('');
        ajax_error_input(jqXHR, textStatus,$('#select-nueva-carrera-especialidad'));
    });
}

function select_especialidad(){	//cargar municpios con ajax
    try{
    $("#select-borrar-carrera-especialidad option:selected").each(function () {
        $("#select-borrar-especialidad").html('');
        $('#select-borrar-especialidad').append('<option value="1">Espere...</option>');
        elegido=$(this).val();
        $.post("ajax/especialidad.php", { elegido: elegido })
            .fail(function(jqXHR, textStatus, errorThrown){
                $("#select-borrar-especialidad").html('');
                $('#select-borrar-especialidad').append('<option value="1">Error</option>');
                ajax_error_alert(jqXHR, textStatus);
            })
       .done( function(data){
           datos=$.parseJSON(data);
           $("#select-borrar-especialidad").html('');
           if(datos.respuesta==='1'){
                $.each(datos.especialidad,function(){
                    $('#select-borrar-especialidad').append('<option value="'+this.codigo_especialidad+'">'+this.nombre+'</option>');
              }); 
           }else{
               $('#select-borrar-especialidad').append('<option value="1">Error'+datos.mensaje+'</option>');
           }
       });            
   });    
    }catch(e){
        $("#select-borrar-especialidad").html('');
        $('#select-borrar-especialidad').append('<option value="1">ERROR</option>');
    }
}

function select_especialidad_inicio(){	//cargar municpios con ajax
    try{
        $("#select-borrar-especialidad").html('');
        $('#select-borrar-especialidad').append('<option value="1">Espere...</option>');
        elegido=$('#select-borrar-carrera-especialidad').val();
        $.post("ajax/especialidad.php", { elegido: elegido })
            .fail(function(jqXHR, textStatus, errorThrown){
                $("#select-borrar-especialidad").html('');
                $('#select-borrar-especialidad').append('<option value="1">Error</option>');
                ajax_error_alert(jqXHR, textStatus);
            })
       .done( function(data){
           datos=$.parseJSON(data);
           $("#select-borrar-especialidad").html('');
           if(datos.respuesta==='1'){
                $.each(datos.especialidad,function(){
                    $('#select-borrar-especialidad').append('<option value="'+this.codigo_especialidad+'">'+this.nombre+'</option>');
              }); 
           }else{
               $('#select-borrar-especialidad').append('<option value="1">Error'+datos.mensaje+'</option>');
           }
       });    
    }catch(e){
        $("#select-borrar-especialidad").html('');
        $('#select-borrar-especialidad').append('<option value="1">ERROR</option>');
    }
}
//select de estados carga con ajax
function select_estados(){
    $('#select-estado').html('');
    $('#select-estado-municipio-agregar').html('');
    $('#select-estado-municipio-borrar').html('');
    $('#select-estado').append('<option value="0">Estado</option>');
    $('#select-estado-municipio-agregar').append('<option value="0">Estado</option>');
    $('#select-estado-municipio-borrar').append('<option value="0">Estado</option>');
    $.post('contenidos/Estados.php').done(function(data){
        datos=$.parseJSON(data);
        if(datos.respuesta==='1'){
            $.each(datos.estados,function(){
                $('#select-estado').append('<option value="'+this.codigo_estado+'">'+this.nombre+'</option>');
                $('#select-estado-municipio-agregar').append('<option value="'+this.codigo_estado+'">'+this.nombre+'</option>');
                $('#select-estado-municipio-borrar').append('<option value="'+this.codigo_estado+'">'+this.nombre+'</option>');
            });
            setTimeout('select_municipio()');
        }else{
            $('#select-estado').append('<option id="0">ERROR:'+datos.mensage+'</option>');
            $('#select-estado-municipio-agregar').append('<option id="0">ERROR:'+datos.mensaje+'</option>');
            $('#select-estado-municipio-borrar').append('<option id="0">ERROR:'+datos.mensaje+'</option>');
        }
    }).fail(function(jqXHR, textStatus, errorThrown){
        ajax_error_input(jqXHR, textStatus,$('#select-estado'));
        ajax_error_input(jqXHR, textStatus,$('#select-estado-municipio-agregar'));
        ajax_error_input(jqXHR, textStatus,$('#select-estado-municipio-borrar'));
    });
}
function select_idiomas(){
	try{
            $('#select-idioma-borrar').html('');
            $('#select-idioma-borrar').append('<option value="0">Espere...</option>'); 
            $.post('ajax/idiomas.php')
                .done(function(data){
                    $('#select-idioma-borrar').html('');
                    datos=$.parseJSON(data);
                    if(datos.respuesta==='1'){
                        $.each(datos.idioma,function(){
                            $('#select-idioma-borrar').append('<option value="'+this.codigo_idioma+'">'+this.nombre+'</option>');
                        });
                    }else{
                        $('#select-idioma-borrar').append('<option value="0">Error:'+datos.mensaje+'</option>'); 
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown){
                    $('#select-idioma-borrar').html('');
                    ajax_error_input(jqXHR, textStatus,$('#select-idioma-borrar')); 
                });
        }catch(e){
            $('#select-idioma-borrar').html('');
        $("#select-idioma-borrar").append('<option value="1">ERROR</option>');    
        }
	}
function select_municipio(){
    $('#select-municipio').html('');
    $('#select-municipio').append('<option value="0">Espere</option>');
    $.post('contenidos/Municipios.php',{elegido:$('#select-estado-municipio-borrar').val()})
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    $('#select-municipio').html('');
                    $('#select-municipio').append('<option value="0">Municipio</option>');
                    $.each(datos.municipio,function(){
                        $('#select-municipio').append('<option value="'+this.codigo_municipio+'">'+this.nombre+'</option>');
                    });
                }else
                  $('#select-municipio').append('<option value="0">Error:'+datos.mensaje+'</option>');  
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                ajax_error_input(jqXHR, textStatus,$('#select-municipio'));
            });
}
function select_administrador(){
    $('#select-administrador').html('');
    $('#select-administrador-editar').html('');
    $.post('ajax_adm/administrador.php').done(function(data){
        datos=$.parseJSON(data);
        if(datos.respuesta==='1'){
            $.each(datos.carrera,function(){
                $('#select-administrador').append('<option value="'+this.no_administrador+'">'+this.nombre+'</option>');
                $('#select-administrador-editar').append('<option value="'+this.no_administrador+'">'+this.nombre+'</option>');
            });
        }else{
            $('#select-administrador').append('<option value="0">ERROR:'+datos.mensaje+'</option>');
            $('#select-administrador-editar').append('<option value="'+this.no_administrador+'">'+this.nombre+'</option>');
        }
    }).fail(function(jqXHR, textStatus, errorThrown){
        ajax_error_input(jqXHR, textStatus,$('#select-administrador'));
        ajax_error_input(jqXHR, textStatus,$('#select-administrador-editar'));
    });
}


//dialog de jquery personnalizado
function alerta(title,dialog,mensage){ 
var alert_=dialog;
$('#span-alerta').html(mensage);
   alert_.dialog({ 
   		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).show(); },
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		title:title,
		position: { my: "center", at: "center", of: '#div-contenedor-alert' }
		});
	  }
function alert_Bloq(title,dialog,mensaje){ 
$('#span-alerta').html(mensaje);
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
		position: { my: "center", at: "center", of: '#div-contenedor-alert' }
		});
	  }
          
//solicitudes ajax          
//buscar con ajax, json y mysql buscador principal
function buscar(dato,cantidad){
    $('#div-row-eliminar-egresado').hide();
    $.post('ajax_adm/buscar.php',{dato:dato,no_registro:0,cantidad:cantidad})
            .done(function(data){
             datos=$.parseJSON(data); 
             $('#div-resultados').html(' ');
             var p='';
             if(datos.respuesta==='1'){
                $.each(datos.egresado,function(){
                    var div=$('<div/>');
                    p='<span class="span-no_control">'+this.no_control+'</span>'; 
                    div.append(p);
                    var div_min=$('<div/>');
                    p='<img src="fotos_egresados/'+this.imagen+'" class="img-egresado">'+this.nombre+' '+this.apellido_p+' '+this.apellido_m;
                    div_min.append(p);
                    div_min.addClass('div-miniatura');
                    div.append(div_min);
                    div.addClass('div-resultado');
                    div.attr('id','div-resultado'+this.no_control);
                    div.attr('tabindex',0);
                    $('#div-resultados').append(div);
                    $('#div-resultados').show();
                });
             }else{
                 p='<p>Informe:'+datos.mensage+'</p>'; 
                 $('#div-resultados').append(p);
                 $('#div-resultados').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
                $('#div-resultados').html('');
                $('#div-resultados').show();
                ajax_error(jqXHR,textStatus,$('#div-resultados'));
                });
}
//ocultar buscador principal
function ocultar_buscador(){
    $('#div-resultados').hide();
    $('#div-resultados').attr('z-index','0');
    $('#div-resultados').html('');
    
}
//buscar todos los egresados solo los primeros 10
function buscar_todos(){
    $('#div-row-eliminar-egresado').hide();
    no_registro=0;
    $('#div-pefil').hide();
    $('#div-resultados-avanzado-principal').show();
    $('#img-cargar-busqueda-avanzada').show();
    $('#div-resultados-avanzado').html('');
    $('#div-resultados-avanzado').hide();
    ocultar_buscador();
    $('#input-buscador').val('');
    $.post('ajax_adm/buscar_todos.php',{no_registro:0})
            .done(function(data){
            datos=$.parseJSON(data); 
            $('#div-resultados-avanzado').html(' ');
            var p='';
            var registro=0;
            if(datos.respuesta==='1'){
                $.each(datos.egresado,function(){
                    var div=$('<div/>');
                    p='<span class="span-no_control">'+this.no_control+'</span>'; 
                    div.append(p);
                    var div_min=$('<div/>');
                    p='<img src="fotos_egresados/'+this.imagen+'" class="img-egresado">'+this.nombre+' '+this.apellido_p+' '+this.apellido_m;
                    div_min.append(p);
                    div_min.addClass('div-miniatura');
                    div.append(div_min);
                    div.addClass('div-resultado');
                    div.attr('id','div-resultado'+this.no_control);
                    div.attr('tabindex',0);
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas" tabindex="0">VER MÁS</p>'; 
                    div.append(p);
                    div.attr('id','div-img-cargar-datos-mas');
                    $('#div-resultados-avanzado').append(div);
                }
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').fadeIn();
             }else{
                 no_registro=0;
                 $('#img-cargar-busqueda-avanzada').hide();
                 p='<p>Informe:'+datos.mensage+'</p>'; 
                 $('#div-resultados-avanzado').append(p);
                 $('#div-resultados-avanzado').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
                no_registro=0;
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').html('');
                $('#div-resultados-avanzado').show();
                ajax_error(jqXHR,textStatus,$('#div-resultados'));
                });
}
//buscar todos los egresados de 10 en 10
function buscar_todos_mas(){ 
    $('#div-img-cargar-datos-mas').html(' ');
    var p='<img id="img-cargar-datos-mas" src="Imagenes/espera.gif" class="img-centrada"></img>';
    $('#div-img-cargar-datos-mas').append(p);
    $.post('ajax_adm/buscar_todos.php',{no_registro:no_registro_b})
            .done(function(data){
            datos=$.parseJSON(data); 
            var p='';
            var registro=0;
            if(datos.respuesta==='1'){
                $('#ver-mas').remove();
                $('#div-img-cargar-datos-mas').remove();
                $.each(datos.egresado,function(){
                    var div=$('<div/>');
                    p='<span class="span-no_control">'+this.no_control+'</span>'; 
                    div.append(p);
                    var div_min=$('<div/>');
                    p='<img src="fotos_egresados/'+this.imagen+'" class="img-egresado">'+this.nombre+' '+this.apellido_p+' '+this.apellido_m;
                    div_min.append(p);
                    div_min.addClass('div-miniatura');
                    div.append(div_min);
                    div.addClass('div-resultado');
                    div.attr('id','div-resultado'+this.no_control);
                    div.attr('tabindex',0);
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas" tabindex="0">VER MÁS</p>'; 
                    div.append(p);
                    div.attr('id','div-img-cargar-datos-mas');
                    $('#div-resultados-avanzado').append(div);
                }
             }else{
                 no_registro=0;
                 $('#div-img-cargar-datos-mas').remove();
                 p='<p>Informe:'+datos.mensage+'</p>'; 
                 $('#div-resultados-avanzado').append(p);
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
                no_registro=0;
                $('#div-img-cargar-datos-mas').remove();
                ajax_error(jqXHR,textStatus,$('#div-resultados'));
                });
}
//buscar egresados mediante filtro los primeros 10
function buscar_avanzado(dato,cantidad){
    $('#div-row-eliminar-egresado').hide();
    $('#div-resultados-avanzado-principal').show();
    $('#img-cargar-busqueda-avanzada').show();
    $('#div-resultados-avanzado').html('');
    $('#div-resultados-avanzado').hide();
    ocultar_buscador();
    $.post('ajax_adm/buscar.php',{dato:dato,no_registro:0,cantidad:cantidad})
            .done(function(data){
            datos=$.parseJSON(data); 
            $('#div-resultados-avanzado').html(' ');
            var p='';
            var registro=0;
            if(datos.respuesta==='1'){
                $.each(datos.egresado,function(){
                    var div=$('<div/>');
                    p='<span class="span-no_control">'+this.no_control+'</span>'; 
                    div.append(p);
                    var div_min=$('<div/>');
                    p='<img src="fotos_egresados/'+this.imagen+'" class="img-egresado">'+this.nombre+' '+this.apellido_p+' '+this.apellido_m;
                    div_min.append(p);
                    div_min.addClass('div-miniatura');
                    div.append(div_min);
                    div.addClass('div-resultado');
                    div.attr('id','div-resultado'+this.no_control);
                    div.attr('tabindex',0);
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro_b=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas" tabindex="0">VER MÁS</p>'; 
                    div.append(p);
                    div.attr('id','div-img-cargar-datos-mas');
                    $('#div-resultados-avanzado').append(div);
                }
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').fadeIn();
             }else{
                 no_registro_b=0;
                 $('#img-cargar-busqueda-avanzada').hide();
                 p='<p>Informe:'+datos.mensage+'</p>'; 
                 $('#div-resultados-avanzado').append(p);
                 $('#div-resultados-avanzado').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
                no_registro_b=0;
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').html('');
                $('#div-resultados-avanzado').show();
                ajax_error(jqXHR,textStatus,$('#div-resultados'));
                });
}
//buscar egresados mediante filtro de 10 en 10
function buscar_avanzado_mas(dato,cantidad){  
    $('#div-img-cargar-datos-mas').html(' ');
    var p='<img id="img-cargar-datos-mas" src="Imagenes/espera.gif" class="img-centrada"></img>';
    $('#div-img-cargar-datos-mas').append(p);
    $.post('ajax_adm/buscar.php',{dato:dato,no_registro:no_registro_b,cantidad:cantidad})
            .done(function(data){
            datos=$.parseJSON(data); 
            var p='';
            var registro=0;
            if(datos.respuesta==='1'){
                $('#ver-mas').remove();
                $('#div-img-cargar-datos-mas').remove();
                $.each(datos.egresado,function(){
                    var div=$('<div/>');
                    p='<span class="span-no_control">'+this.no_control+'</span>'; 
                    div.append(p);
                    var div_min=$('<div/>');
                    p='<img src="fotos_egresados/'+this.imagen+'" class="img-egresado">'+this.nombre+' '+this.apellido_p+' '+this.apellido_m;
                    div_min.append(p);
                    div_min.addClass('div-miniatura');
                    div.append(div_min);
                    div.addClass('div-resultado');
                    div.attr('id','div-resultado'+this.no_control);
                    div.attr('tabindex',0);
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro_b=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas" tabindex="0">VER MÁS</p>'; 
                    div.append(p);
                    div.attr('id','div-img-cargar-datos-mas');
                    $('#div-resultados-avanzado').append(div);
                }
             }else{
                 no_registro_b=0;
                 $('#div-img-cargar-datos-mas').remove();
                 p='<p>Informe:'+datos.mensage+'</p>'; 
                 $('#div-resultados-avanzado').append(p);
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
                no_registro_b=0;
                $('#div-img-cargar-datos-mas').remove();
                ajax_error(jqXHR,textStatus,$('#div-resultados'));
                });
}
//cargar todos los datos de un egresado
function cargar_datos_egresado(no_control){
    ocultar_buscador();
    no_control_=no_control;
    $('#div-resultados-avanzado-principal').hide();
    $('#div-resultados-avanzado').hide();
    $('#div-pefil').show();
    cargar_foto(no_control);
    dt_personales(no_control);
    dt_academicos(no_control);
    dt_idioma(no_control);
    dt_sw(no_control);
    dt_posgrado(no_control);
    dt_social(no_control);
    dt_empresa(no_control);
    dt_historial(no_control);
    $('#div-row-eliminar-egresado').show();
}
function cargar_foto(no_control){
    $('#div-foto').hide();
    $('#img-cargar-foto').show();
    $.post('ajax_adm/cargar_foto.php',{no_control:no_control}).
            done(function(data){
                datos=$.parseJSON(data);
                if(datos.resultado==='1'){
                    $('#img-cargar-foto').hide();
                    $('#div-foto').show();
                    $('#img-foto-egresado').removeAttr('src');
                    $('#img-foto-egresado').attr('src',datos.imagen);
                }else{
                    $('#img-cargar-foto').hide();
                    $('#div-foto').show();
                    alerta('ERROR',$('#alerta'),datos.mensaje);
                    $('#img-foto-egresado').removeAttr('src');
                    $('#img-foto-egresado').attr('src','fotos_egresados/businessman.png');    
                }
            }).fail(function(jqXHR, textStatus, errorThrown){
                $('#img-cargar-foto').hide();
                $('#div-foto').show();
                $('#img-foto-egresado').removeAttr('src');
                $('#img-foto-egresado').attr('src','fotos_egresados/businessman.png'); 
              });
}
function dt_personales(no_control){
    $('#div-datos-personales').hide();
    $('#div-datos-personales').html('');
    $('#img-cargar-datos-personales').show();
    $.post('ajax_adm/dt_egresado.php',{no_control:no_control}).
            done(function(data){
                 var p='';
                datos=$.parseJSON(data);
                if(datos.resultado==='1'){
                     p='<h2>DATOS PERSONALES<img src="Imagenes/adm/personal.png" class="margen-izq"></h2>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-nombre" class="p-dt-egresado">Nombre:<b>'+datos.egresado.nombre+' '+datos.egresado.apellido_p+' '+datos.egresado.apellido_m +'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-curp" class="p-dt-egresado">CURP:<b>'+datos.egresado.curp+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-curp" class="p-dt-egresado">Género:<b>'+datos.egresado.genero+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-telefono" class="p-dt-egresado">Telefono:<b>'+datos.egresado.telefono+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-email" class="p-dt-egresado">Email:<b>'+datos.egresado.email+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-fecha_nac" class="p-dt-egresado">Fecha de nacimiento:<b>'+datos.egresado.fecha_nacimiento+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-calle" class="p-dt-egresado">Calle:<b>'+datos.egresado.calle+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-no-casa" class="p-dt-egresado">No. Casa:<b>'+datos.egresado.numero_casa+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-no-casa" class="p-dt-egresado">C.P:<b>'+datos.egresado.cp+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-estado" class="p-dt-egresado">Estado:<b>'+datos.egresado.estado+'</b></p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-municipio" class="p-dt-egresado">Municipio:<b>'+datos.egresado.municipio+'</b></p>';
                     $('#div-datos-personales').append(p);                    
                     $('#img-cargar-datos-personales').hide();
                     $('#div-datos-personales').show();
                }else{
                    var p='<p id="p-estado" class="p-dt-egresado">ERROR:<b>'+datos.mensage+'</b></p>';
                    $('#div-datos-personales').append(p);
                    $('#img-cargar-datos-personales').hide();
                    $('#div-datos-personales').show();
                }
                }).fail(function(jqXHR, textStatus, errorThrown){
                     $('#img-cargar-datos-personales').hide();
                    $('#div-datos-personales').show();
                    ajax_error(jqXHR,textStatus,$('#div-datos-personales'));
                  });
            
}

function dt_academicos(no_control){
    $('#div-datos-academicos').hide();
     $('#div-datos-academicos').html('');
    $('#img-cargar-datos-academicos').show();
    $.post('ajax_adm/dt_academicos.php',{no_control:no_control})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>DATOS ACADEMICOS</h2>';
                $('#div-datos-academicos').append(p);
                $.each(datos.carrera,function(){
                    p='<div class="separador"></div>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Carrera:<b>'+this.carrera+'</b></p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Especialidad:<b>'+this.especialidad+'</b></p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Fecha de inicio:<b>'+this.fecha_inicio+'</b></p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Fecha de finalización:<b>'+this.fecha_fin+'</b></p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Titulado:<b>'+this.titulado+'</b></p>'; 
                    $('#div-datos-academicos').append(p);
                });
                $('#img-cargar-datos-academicos').hide();
                $('#div-datos-academicos').show();
             }else{
                 var p='<h2>DATOS ACADEMICOS</h2>';
                 $('#div-datos-academicos').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</b></p>'; 
                 $('#div-datos-academicos').append(p);
                 $('#img-cargar-datos-academicos').hide();
                 $('#div-datos-academicos').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-academicos').hide();
              $('#div-datos-academicos').show(); 
              ajax_error(jqXHR,textStatus,$('#div-datos-academicos'));
            });
}


function dt_idioma(no_control){
    $('#div-datos-idioma').hide();
     $('#div-datos-idioma').html('');
    $('#img-cargar-datos-idioma').show();
    $.post('ajax_adm/dt_idioma.php',{no_control:no_control})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>Idiomas<img src="Imagenes/adm/idioma.png" class="margen-izq"></h2>';
                $('#div-datos-idioma').append(p);
                var table = $('<table/>');
                table.addClass('tabla');
                table.addClass('table');
                table.addClass('table-hover');
                table.addClass('table table-condensed');
                table.append('<tr><th>Idioma</th><th>Habla</th><th>Lectura y escritura</th></tr>');
                $.each(datos.idioma,function(){
                    table.append( '<tr><td><b>' +this.idioma+'</b></td><td><b>' +this.porcentaje_habla+'</b></td><td><b>' +this.porcentaje_lec_escr+'</b></td></tr>' );
                });
                $('#div-datos-idioma').append(table);
                $('#img-cargar-datos-idioma').hide();
                $('#div-datos-idioma').show();
             }else{
                 var p='<h2>Idiomas<img src="Imagenes/adm/idioma.png" class="margen-izq"></h2>';
                 $('#div-datos-idioma').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</b></p>'; 
                 $('#div-datos-idioma').append(p);
                 $('#img-cargar-datos-idioma').hide();
                 $('#div-datos-idioma').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-idioma').hide();
              $('#div-datos-idioma').show(); 
              ajax_error(jqXHR,textStatus,$('#div-datos-idioma'));
            });
}

function dt_sw(no_control){
    $('#div-datos-sw').hide();
     $('#div-datos-sw').html('');
    $('#img-cargar-datos-sw').show();
    $.post('ajax_adm/dt_sw.php',{no_control:no_control})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>Software<img src="Imagenes/adm/consola.png" class="margen-izq"></h2>';
                $('#div-datos-sw').append(p);
                var table = $('<table/>');
                table.addClass('tabla');
                table.addClass('table');
                table.addClass('table-hover');
                table.addClass('table table-condensed');
                $.each(datos.sw,function(){
                    table.append( '<tr><td><b>' +this.nombre_sw+'</b></td></tr>' );
                });
                $('#div-datos-sw').append(table);
                $('#img-cargar-datos-sw').hide();
                $('#div-datos-sw').show();
             }else{
                 var p='<h2>Software<img src="Imagenes/adm/consola.png" class="margen-izq"></h2>';
                 $('#div-datos-sw').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</b></p>'; 
                 $('#div-datos-sw').append(p);
                 $('#img-cargar-datos-sw').hide();
                 $('#div-datos-sw').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-sw').hide();
              $('#div-datos-sw').show(); 
              ajax_error(jqXHR,textStatus,$('#div-datos-sw'));
            });
}

function dt_posgrado(no_control){
    $('#div-datos-posgrado').hide();
     $('#div-datos-posgrado').html('');
    $('#img-cargar-datos-posgrado').show();
    $.post('ajax_adm/dt_posgrado.php',{no_control:no_control})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>DATOS POSGRADO</h2>';
                $('#div-datos-posgrado').append(p);
                $.each(datos.posgrado,function(){
                    p='<div class="separador-posgrado"></div>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Posgrado:<b>'+this.nombre+'</b></p>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Nivel:<b>'+this.posgrado+'</b></p>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Escuela:<b>'+this.escuela+'</b></p>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Titulado:<b>'+this.titulado+'</b></p>'; 
                    $('#div-datos-posgrado').append(p);
                });
                $('#img-cargar-datos-posgrado').hide();
                $('#div-datos-posgrado').show();
             }else{
                 var p='<h2>DATOS POSGRADO</h2>';
                 $('#div-datos-posgrado').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</b></p>'; 
                 $('#div-datos-posgrado').append(p);
                 $('#img-cargar-datos-posgrado').hide();
                 $('#div-datos-posgrado').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-posgrado').hide();
              $('#div-datos-posgrado').show(); 
              ajax_error(jqXHR,textStatus,$('#div-datos-posgrado'));
            });
}

function dt_social(no_control){
    $('#div-datos-social').hide();
     $('#div-datos-social').html('');
    $('#img-cargar-datos-social').show();
    $.post('ajax_adm/dt_social.php',{no_control:no_control})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>GRUPOS SOCIALES<img src="Imagenes/adm/torre.png" class="margen-izq"></h2>';
                $('#div-datos-social').append(p);
                $.each(datos.social,function(){
                    p='<div class="separador-social"></div>'; 
                    $('#div-datos-social').append(p);
                    p='<p>Nombre:<b>'+this.nombre+'</b></p>'; 
                    $('#div-datos-social').append(p);
                    p='<p>Tipo:<b>'+this.tipo+'</b></p>'; 
                    $('#div-datos-social').append(p);
                });
                $('#img-cargar-datos-social').hide();
                $('#div-datos-social').show();
             }else{
                 var p='<h2>GRUPOS SOCIALES<img src="Imagenes/adm/torre.png" class="margen-izq"></h2>';
                 $('#div-datos-social').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</b></p>'; 
                 $('#div-datos-social').append(p);
                 $('#img-cargar-datos-social').hide();
                 $('#div-datos-social').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-social').hide();
              $('#div-datos-social').show(); 
              ajax_error(jqXHR,textStatus,$('#div-datos-social'));
            });
}

function dt_empresa(no_control){
    $('#div-datos-empresa').hide();
    $('#div-datos-empresa').html('');
    $('#img-cargar-datos-empresa').show();
    $.post('ajax_adm/dt_empresa.php',{no_control:no_control})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>EMPRESA´S<img src="Imagenes/adm/empresa.png" class="margen-izq"></h2>';            
                $('#div-datos-empresa').append(p);
                $.each(datos.empresa,function(){
                    var div=$('<div/>');
                    p='<div class="separador-empresa"></div>'; 
                    div.append(p);
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
                    div.addClass('div-datos-empresa-resultado');
                    div.attr('id','div-datos-empresa-'+this.codigo_empresa);
                    div.attr('tabindex',0);
                    $('#div-datos-empresa').append(div);
                });
                $('#img-cargar-datos-empresa').hide();
                $('#div-datos-empresa').show();
             }else{
                 var p='<h2>EMPRESA´S<img src="Imagenes/adm/empresa.png" class="margen-izq"></h2>';
                 $('#div-datos-empresa').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</b></p>'; 
                 $('#div-datos-empresa').append(p);
                 $('#img-cargar-datos-empresa').hide();
                 $('#div-datos-empresa').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-empresa').hide();
              $('#div-datos-empresa').show(); 
              ajax_error(jqXHR,textStatus,$('#div-datos-empresa'));
            });
}
//errores de servidor se emite una alerta dentro del div donde se cargan los datos
function ajax_error(jqXHR,textStatus,div){
        if (jqXHR.status === 0) {
            div.append('<p><b>ERROR:SIN RESPUESTA DEL SERVIDOR</b></p>');
        } else if (jqXHR.status == 404) {
            div.append('<p><b>ERROR:PÁGINA NO ENCONTRADA [404]</b></p>');

        } else if (jqXHR.status == 500) {
            div.append('<p><b>ERROR:FALLA DEL SERVIDOR[505]</b></p>');
            //Internal Server Error [500]
                
        } else if (textStatus === 'parsererror') {
            div.append('<p><b>ERROR:DATOS RECIBIDOS CORRUPTOS</b></p>');
//            Requested JSON parse failed

        } else if (textStatus === 'timeout') {
            div.append('<p><b>ERROR:TIEMPO DE RESPUESTA EXPIRADO</b></p>');
//           Time out error

        } else if (textStatus === 'abort') {

//            alert('Ajax request aborted.');

        } else {
            div.append('<p>ERROR INESPERADO:<b>'+ jqXHR.responseText+'</b></p>');
       }
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

//errores de servidor se emite una alerta con dialog
function ajax_error_alert(jqXHR,textStatus){
        if (jqXHR.status === 0) {
            alerta('Error',$('#alerta'),'ERROR:SIN RESPUESTA DEL SERVIDOR');
            setTimeout("$('#alerta').dialog('close');",2000);
        } else if (jqXHR.status === 404) {
            alerta('Error',$('#alerta'),'ERROR:PÁGINA NO ENCONTRADA [404]');
            setTimeout("$('#alerta').dialog('close');",2000);
        } else if (jqXHR.status === 500) {
            alerta('Error',$('#alerta'),'ERROR:FALLA DEL SERVIDOR[505]');
            setTimeout("$('#alerta').dialog('close');",2000);
            //Internal Server Error [500]
                
        } else if (textStatus === 'parsererror') {
            alerta('Error',$('#alerta'),'ERROR:DATOS RECIBIDOS CORRUPTOS');
            setTimeout("$('#alerta').dialog('close');",2000);
//            Requested JSON parse failed

        } else if (textStatus === 'timeout') {
            alerta('Error',$('#alerta'),'ERROR:TIEMPO DE RESPUESTA EXPIRADO');
            setTimeout("$('#alerta').dialog('close');",2000);
//           Time out error

        } else if (textStatus === 'abort') {

//            alert('Ajax request aborted.');

        } else {
            alerta('Error',$('#alerta'),'ERROR INESPERADO:'+ jqXHR.responseText);
            setTimeout("$('#alerta').dialog('close');",2000);
       }
}
function todo_dt_empresa(codigo_empresa){
    $('#div-principal-empresa-completa').fadeIn();
    $('#div-datos-empresa-completa').html('');
    $('#img-cargar-datos-empresa-completa').show();
    $.post('ajax_adm/dt_empresa_completa.php',{codigo_empresa:codigo_empresa})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>EMPRESA</h2>';            
                $('#div-datos-empresa-completa').append(p);
                p='<div id="div-cancel" class="cancel" tabindex="0"></div>';
                $('#div-datos-empresa-completa').append(p);
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
                    div.addClass('col-xs-6');
                    $('#div-datos-empresa-completa').append(div);
                    div=$('<div/>');
                    p='<p>Organismo:<b>'+this.organismo+'</b></p>'; 
                    div.append(p);
                    p='<p>Razón Social:<b>'+this.razon_social+'</b></p>'; 
                    div.append(p);
                    p='<p>Medio búsqueda:<b>'+this.medio_busqueda+'</b></p>'; 
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
                    div.addClass('col-xs-6');
                    $('#div-datos-empresa-completa').append(div);
                });
                $('#img-cargar-datos-empresa-completa').hide();
                $('#div-datos-empresa-completa').show();
                $('#div-cancel').focus();
             }else{
                 var p='<h2>EMPRESA</h2>';
                 $('#div-datos-empresa-completa').append(p);
                 p='<div id="div-cancel" class="cancel" tabindex="0"></div>';
                 $('#div-datos-empresa-completa').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</b></p>'; 
                 $('#div-datos-empresa-completa').append(p);
                 $('#img-cargar-datos-empresa-completa').hide();
                 $('#div-datos-empresa-completa').show();
                 $('#div-cancel').focus();
                
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-empresa-completa').hide();
              $('#div-datos-empresa-completa').show(); 
              p='<div id="div-cancel" class="cancel" tabindex="0"></div>';
              $('#div-datos-empresa-completa').append(p);
              $('#div-cancel').focus();
              ajax_error(jqXHR,textStatus,$('#div-datos-empresa-completa'));
            });
}

function dt_historial(no_control){
    $('#div-datos-historial').hide();
    $('#div-datos-historial').html('');
    $('#img-cargar-datos-historial').show();
    $.post('ajax_adm/dt_historial.php',{no_control:no_control})
            .done(function(data){
             datos=$.parseJSON(data);   
             if(datos.respuesta==='1'){
                var p='<h2>Historial<img src="Imagenes/adm/historial.png" class="margen-izq"></h2>';            
                $('#div-datos-historial').append(p);
                $.each(datos.empresa,function(){
                    var div=$('<div/>');
                    p='<div class="separador-historial"></div>'; 
                    div.append(p);
                    p='<p>Nombre:<b>'+this.nombre+'</b></p>'; 
                    div.append(p);
                    p='<p>Telefono:<b>'+this.telefono+'</b></p>'; 
                    div.append(p);
                    p='<p>Web:<b>'+this.web+'</b></p>'; 
                    div.append(p);
                    p='<p>Email:<b>'+this.email+'</b></p>'; 
                    div.append(p);
                    $('#div-datos-historial').append(div);
                });
                $('#img-cargar-datos-historial').hide();
                $('#div-datos-historial').show();
             }else{
                 var p='<h2>Historial<img src="Imagenes/adm/historial.png" class="margen-izq"></h2>';
                 $('#div-datos-historial').append(p);
                 p='<p>Informe:<b>'+datos.mensage+'</p></b>'; 
                 $('#div-datos-historial').append(p);
                 $('#img-cargar-datos-historial').hide();
                 $('#div-datos-historial').show();
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-historial').hide();
              $('#div-datos-historial').show(); 
              ajax_error(jqXHR,textStatus,$('#div-datos-historial'));
            });
}


function nuevos_egresados(cantidad){
    try{
       $('#form-agregar-egresado').hide();
        $('#img-agregar-egresado').show();
        $.post('ajax_adm/nuevos_egresados.php',{form:$('#form-agregar-egresado').serialize(),cantidad:cantidad})
                .done(function(data){
                    datos=$.parseJSON(data);
                    if(datos.respuesta==='1'){
                        alerta('Éxito',$('#alerta'),'Datos Guardados con éxito');
                        $('#img-agregar-egresado').hide();
                        $('#form-agregar-egresado').show();
                        limpiaForm($('#form-agregar-egresado'));
                    }else if(datos.respuesta==='2'){
                        alerta('Error',$('#alerta'),'Informe:'+datos.mensaje+' '+datos.egresados);
                        $('#img-agregar-egresado').hide();
                        $('#form-agregar-egresado').show();
                    }else{
                        alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                        $('#img-agregar-egresado').hide();
                        $('#form-agregar-egresado').show();
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown){
                    $('#img-agregar-egresado').hide();
                    $('#form-agregar-egresado').show();
                    ajax_error_alert(jqXHR, textStatus);
                }); 
    }catch(e){
        alerta('Error Script',$('#alerta'),'Informe:'+e);
        $('#img-agregar-egresado').hide();
        $('#form-agregar-egresado').show();
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
            case'number':
               this.value=''; 
            break;
        default:
        this.value = '';
        }});
                }
function borrar_egresado(no_control){     
    try{
    alert_Bloq('BORRANDO...',$('#alerta'),'Espere...');
    $.post('ajax_adm/borrar_egresado.php',{no_control:no_control})
    .done(function(data){
        datos=$.parseJSON(data);
            if(datos.respuesta=='1'){//exito
                alerta('Completado',$('#alerta'),'La operación se completo de manera correcta');
                setTimeout('$("#alerta").dialog( "close" );',1000);
                $('#div-row-eliminar-egresado').hide();
                $('#div-pefil').hide();
            }
            else{ //error desde el servidor
                alerta("Error",$("#alerta"),'Informe:'+datos.mensaje+'');
                setTimeout("$('#alerta').dialog('close');",2000);
            }
            }).
    fail(function(jqXHR, textStatus, errorThrown){
        ajax_error_alert(jqXHR,textStatus);
    });//fin de done    
    }catch(e){
        alerta("Error script",$("#alerta"),e);
        setTimeout("$('#alerta').dialog('close');",2000);    
    }
}
    
function confirmar_borrar_egresado(no_control){ 
   $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#div-contenedor-alert' },
		buttons: {
			ACEPTAR: function() {
				// ir al sitio oficial jquery.com
				 borrar_egresado(no_control);
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				// Ir al sitio oficial jqueryui.com
				$(this).dialog( "close" );
		}
		}
		});
	  }
          
function nuevo_administrador(){
    try{
    $('#frm-agregar-administrador').hide();
    $('#img-agregar-administrador').show();
    var input=$('<input/>');
    input.attr('id','input-pass');
    input.attr('name','pass');
    input.attr('visibility','hidden');
    var pass=hex_sha512($('#input-administrador-password').val());
    input.val(pass);
    $('#input-administrador-password').val('***');
    $('#pass_nuevo_reafirmar').val('');
    $('#frm-agregar-administrador').append(input);
    $.post('ajax_adm/nuevo_adm.php',{form:$('#frm-agregar-administrador').serialize()})
        .done(function(data){
            datos=$.parseJSON(data);
            if(datos.respuesta==='1'){
                alerta('Éxito',$('#alerta'),'Datos Guardados con éxito');
                select_administrador();
                $('#img-agregar-administrador').hide();
                $('#input-pass').remove();
                $('#input-administrador-password').val('');
                ocultar_pass();
                limpiaForm($('#frm-agregar-administrado'));
            }else{
                alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                $('#img-agregar-administrador').hide();
                $('#input-pass').remove();
                ocultar_pass();
                $('#input-administrador-password').val('');
                limpiaForm($('#frm-agregar-administrado'));
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown){
            $('#img-agregar-administrador').hide();
            $('#input-pass').remove();
            ocultar_pass();
            $('#input-administrador-password').val('');
            limpiaForm($('#frm-agregar-administrado'));
            ajax_error_alert(jqXHR, textStatus);
        }); 
    }catch(e){
        alerta('Error Script',$('#alerta'),'Informe:'+e);
        $('#input-pass').remove();
        $('#img-agregar-administrador').hide();
        $('#input-administrador-password').val('');
        limpiaForm($('#frm-agregar-administrado'));
        ocultar_pass();
    }
}

function evaluar_pass(input,span,img){//evaluar password
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
                        span.html('');
                        img.hide();
                        input.removeClass(); 
                    }
                    if(total===1){ 
                        input.removeClass(); 
                        input.addClass('muy-debil');
                        span.html('Muy Débil');
                        img.show();
                    }
                    if(total===2){ 
                        input.removeClass(); 
                        input.addClass('debil');
                        span.html('Débil');
                        img.show();
                    }
                    if(total===3) {
                        input.removeClass();
                        input.addClass('media');
                        span.html('Media');
                        img.show();
                    }
                    if(total===4){ 
                        input.removeClass(); 
                        input.addClass('alta');
                        span.html('Alta');
                        img.show();
                    }
                }
                
function borrar_adm(no_adm){
    try{
    alert_Bloq('BORRANDO...',$('#alerta'),'Espere');
    $.post('ajax_adm/borrar_.php',{no_adm:no_adm})
    .done(function(data){
        datos=$.parseJSON(data);
            if(datos.respuesta=='1'){//exito
                select_administrador();
                alerta('Completado',$('#alerta'),'La operación se completo de manera correcta');
                setTimeout('$("#alerta").dialog( "close" );',1000);
            }
            else{ //error desde el servidor
                alerta("Error",$("#alerta"),'Informe:'+datos.mensaje+'');
                setTimeout("$('#alerta').dialog('close');",1500);
            }
            }).
    fail(function(jqXHR, textStatus, errorThrown){
        ajax_error_alert(jqXHR,textStatus);
    });//fin de done    
    }catch(e){
        alerta("Error script",$("#alerta"),e);
        setTimeout("$('#alerta').dialog('close');",2000);    
    }
}

function confirmar_borrar_adm(no_adm){
     $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#div-contenedor-alert' },
		buttons: {
			ACEPTAR: function() {
				
				 borrar_adm(no_adm);
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				
				$(this).dialog( "close" );
		}
		}
		});
	  }
function editar_administrador(){
    try{
    $('#frm-editar-administrador').hide();
    $('#img-editar-administrador').show();
    var input=$('<input/>');
    input.attr('id','input-pass-editar');
    input.attr('name','pass');
    input.attr('visibility','hidden');
    var pass=hex_sha512($('#input-administrador-password-editar').val());
    input.val(pass);
    $('#input-administrador-password-editar').val('***');
    $('#pass_nuevo_reafirmar-editar').val('');
    $('#frm-editar-administrador').append(input);
    $.post('ajax_adm/editar_adm.php',{form:$('#frm-editar-administrador').serialize()})
        .done(function(data){
            datos=$.parseJSON(data);
            if(datos.respuesta==='1'){
                alerta('Éxito',$('#alerta'),'Datos Guardados con éxito');
                select_administrador();
                $('#img-editar-administrador').hide();
                ocultar_pass_editar();
                $('#input-pass-editar').remove();
                $('#input-administrador-password-editar').val('');
                limpiaForm($('#frm-editar-administrado'));
            }else{
                alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                $('#input-pass-editar').remove();
                ocultar_pass_editar();
                $('#input-administrador-password-editar').val('');
                limpiaForm($('#frm-editar-administrado'));
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown){
            $('#img-editar-administrador').hide();
            $('#input-pass-editar').remove();
            ocultar_pass_editar();
            $('#input-administrador-password-editar').val('');
            limpiaForm($('#frm-editar-administrado'));
            ajax_error_alert(jqXHR, textStatus);
        }); 
    }catch(e){
        alerta('Error Script',$('#alerta'),'Informe:'+e);
        $('#input-pass-editar').remove();
        $('#img-editar-administrador').hide();
        $('#input-administrador-password-editar').val('');
        limpiaForm($('#frm-editar-administrado'));
        ocultar_pass_editar();
        
    }
}

function ocultar_pass_editar(){
    $('#frm-editar-administrador').show();
    $('#span-pass-seguridad-editar').hide();
    $('#img-ayuda-pass-editar').hide();
    $('#span-pass-correcto-editar').hide();
    $('#pass_nuevo_reafirmar-editar').hide();
    $('#input-administrador-password-editar').removeClass();
}
function ocultar_pass(){
    $('#frm-agregar-administrador').show();
    $('#span-pass-seguridad').hide();
    $('#img-ayuda-pass').hide();
    $('#span-pass-correcto').hide();
    $('#pass_nuevo_reafirmar').hide();
    $('#input-administrador-password').removeClass();
}

function dt_escuela(){
    $('#div-datos-escuela').hide();
    $('#div-datos-escuela').html('');
    $('#img-cargar-datos-escuela').show();
    $.post('ajax_adm/dt_escuela.php').
            done(function(data){
                 var p='';
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                     p='<h2>Datos de la Institución<img id="img-editar-datos-escuela" src="Imagenes/adm/editar_r.png" tabindex="0" class="img-giro"></h2>';
                     $('#div-datos-escuela').append(p);
                     p='<p id="p-nombre" >Director:<b>'+datos.escuela.director+'</b></p>';
                     $('#div-datos-escuela').append(p);
                     p='<p id="p-curp" class="p-dt-egresado">Fecha conmemorativa:<b>'+datos.escuela.fecha+'</b></p>';
                     $('#div-datos-escuela').append(p);
                     p='<p id="p-curp" class="p-dt-egresado">Cargo:<b>'+datos.escuela.cargo+'</b></p>';
                     $('#div-datos-escuela').append(p);
                     p='<p id="p-telefono" class="p-dt-egresado">Teléfono:<b>'+datos.escuela.tel+'</b></p>';
                     $('#div-datos-escuela').append(p);
                     p='<p id="p-telefono" class="p-dt-egresado">Dirección:<b>'+datos.escuela.direccion+'</b></p>';
                     $('#div-datos-escuela').append(p);
                     p='<p id="p-email" class="p-dt-egresado">Web:<b>'+datos.escuela.web+'</b></p>';
                     $('#div-datos-escuela').append(p);
                     p='<p id="p-fecha_nac" class="p-dt-egresado">Email:<b>'+datos.escuela.email+'</b></p>';
                     $('#div-datos-escuela').append(p);
                     p='<img id=""img-banner-principal class="img-responsive"></img>'
                     $('#img-cargar-datos-escuela').hide();
                     $('#div-datos-escuela').show();
                }else{
                    var p='<p id="p-estado" class="p-dt-egresado">ERROR:'+datos.mensage+'</p>';
                    $('#div-datos-escuela').append(p);
                    $('#img-cargar-datos-escuela').hide();
                    $('#div-datos-escuela').show();
                }
                }).fail(function(jqXHR, textStatus, errorThrown){
                     $('#img-cargar-datos-escuela').hide();
                    $('#div-datos-escuela').show();
                    ajax_error(jqXHR,textStatus,$('#div-datos-escuela'));
                  });
            
}

function guardar_escuela(){
    try{
        $('#img-datos-escuela').show();
        $('#frm-datos-escuela').hide();
        $.post('ajax_adm/guardar_escuela.php',{form:$('#frm-datos-escuela').serialize()}).
                done(function(data){
                    datos=$.parseJSON(data);
                    if(datos.respuesta==='1'){
                        alerta('Exito',$('#alerta'),'Datos guardados');
                         $('#img-datos-escuela').hide();
                         limpiaForm($('#frm-datos-escuela'));
                        $('#frm-datos-escuela').show();
                        $('#div-principal-frm-datos-escuela').hide();
                        $('#div-principal-datos-escuela').show(); 
                        dt_escuela();
                    }else{
                        alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                        $('#img-datos-escuela').hide();
                        limpiaForm($('#frm-datos-escuela'));
                        $('#frm-datos-escuela').show(); 
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown){
                    $('#img-datos-escuela').hide();
                    limpiaForm($('#frm-datos-escuela'));
                   $('#frm-datos-escuela').show(); 
                    ajax_error_alert(jqXHR, textStatus);
                });
        }catch(e){
            $('#img-datos-escuela').hide();
            limpiaForm($('#frm-datos-escuela'));
           $('#frm-datos-escuela').show(); 
           alerta('Error javascript',$('#alerta'),'Informe:'+e);
        }
}

function guardar_img(){
    var data=new FormData(document.getElementById("frm-img-institucion"));
    $('#img-banner-institucion').attr('src','Imagenes/espera.gif');
    $('#img-banner-sistema').attr('src','Imagenes/espera.gif');
    $('#img-firma').attr('src','Imagenes/espera.gif');
    $('#img-banner-institucion').addClass('loading');
    $('#img-banner-sistema').addClass('loading');
    $('#img-firma').addClass('loading');
    $('#img-banner-institucion-principal').attr('src','Imagenes/espera.gif');
    $.ajax({url:'ajax_adm/guardar_img.php',
        type:'POST',
        data:data,
        contentType: false,
        processData: false
    }).done(function(data){
        datos=$.parseJSON(data);
        if(datos.respuesta==='1'){
            alerta('Exito',$('#alerta'),'Operación completada');
            $('#img-banner-institucion-principal').attr('src','Imagenes/banner_ittj.png?'+ "?nocache=" + (new Date()).getTime());
            $('#img-banner-institucion').attr('src','Imagenes/banner_ittj.png'+ "?nocache=" + (new Date()).getTime());
            $('#img-banner-sistema').attr('src','Imagenes/banner.png'+ "?nocache=" + (new Date()).getTime());
            $('#img-firma').attr('src','Imagenes/firmaDirector.png'+ "?nocache=" + (new Date()).getTime());    
        }else{
            alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
            $('#img-banner-institucion-principal').attr('src','Imagenes/banner_ittj.png?'+ "?nocache=" + (new Date()).getTime());
            $('#img-banner-institucion').attr('src','Imagenes/banner_ittj.png'+ "?nocache=" + (new Date()).getTime());
            $('#img-banner-sistema').attr('src','Imagenes/banner.png'+ "?nocache=" + (new Date()).getTime());
            $('#img-firma').attr('src','Imagenes/firmaDirector.png'+ "?nocache=" + (new Date()).getTime());
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown){
            $('#img-banner-institucion-principal').attr('src','Imagenes/banner_ittj.png?'+ "?nocache=" + (new Date()).getTime());
            $('#img-banner-institucion').attr('src','Imagenes/banner_ittj.png'+ "?nocache=" + (new Date()).getTime());
            $('#img-banner-sistema').attr('src','Imagenes/banner.png'+ "?nocache=" + (new Date()).getTime());
            $('#img-firma').attr('src','Imagenes/firmaDirector.png'+ "?nocache=" + (new Date()).getTime());
        ajax_error_alert(jqXHR, textStatus);
    });
    $('#img-banner-institucion').removeClass('loading');
    $('#img-banner-sistema').removeClass('loading');
    $('#img-firma').removeClass('loading');
}

function nuevo_estado(){
    $('#frm-enviar-estado').hide();
    $('#img-enviar-estados').show();
    $.post('ajax_adm/nuevo_estado.php',{form:$('#frm-enviar-estado').serialize()})
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-enviar-estados').hide();
                    limpiaForm($('#frm-enviar-estado'));
                    $('#frm-enviar-estado').show();
                    select_estados();
                }else
                {
                  alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-enviar-estados').hide();
                    $('#frm-enviar-estado').hide();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-enviar-estados').hide();
                $('#frm-enviar-estado').show(); 
                ajax_error_alert(jqXHR, textStatus);
            });
}

function borrar_estado(){
   $('#frm-borrar-estado').hide();
   $('#img-borrar-estados').show();
   $.post('ajax_adm/borrar_estado.php',{form:$('#frm-borrar-estado').serialize()})
           .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-borrar-estados').hide();
                    limpiaForm($('#frm-borrar-estado'));
                    $('#frm-borrar-estado').show();
                    $('#select-municipio').html('');
                    $('#select-municipio').append('<option value="0">Municipio</option>');
                    select_estados();
                }else
                {
                    alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-borrar-estados').hide();
                    $('#frm-borrar-estado').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-borrar-estados').hide();
                $('#frm-borrar-estado').show(); 
                ajax_error_alert(jqXHR, textStatus);
            });
}

function confirmar_borrar_estado(){
     $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#div-contenedor-alert' },
		buttons: {
			ACEPTAR: function() {
				
				 borrar_estado();
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				
				$(this).dialog( "close" );
		}
		}
		});
	  }
function nuevo_municipio(){
   $('#frm-enviar-municipio').hide();
    $('#img-enviar-municipio').show();
    $.post('ajax_adm/nuevo_municipio.php',{form:$('#frm-enviar-municipio').serialize()})
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-enviar-municipio').hide();
                    limpiaForm($('#frm-enviar-municipio'));
                    $('#frm-enviar-municipio').show();
                    select_estados();
                }else
                {
                  alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-enviar-municipio').hide();
                    $('#frm-enviar-municipio').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-enviar-municipio').hide();
                $('#frm-enviar-municipio').show(); 
                ajax_error_alert(jqXHR, textStatus);
            }); 
}

function borrar_municipio(){
   $('#frm-borrar-municipio').hide();
   $('#img-borrar-municipio').show();
   $.post('ajax_adm/borrar_municipio.php',{form:$('#frm-borrar-municipio').serialize()})
           .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-borrar-municipio').hide();
                    limpiaForm($('#frm-borrar-municipio'));
                    $('#frm-borrar-municipio').show();
                    $('#select-estado-municipio-borrar option[value="0"]').attr("selected", "selected");
                    $('#select-municipio').html('');
                    $('#select-municipio').append('<option value="0">Municipio</option>');
                }else
                {
                    alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-borrar-municipio').hide();
                    $('#frm-borrar-municipio').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-borrar-municipio').hide();
                $('#frm-borrar-municipio').show(); 
                ajax_error_alert(jqXHR, textStatus);
            });
}
function confirmar_borrar_municipio(){
     $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#div-contenedor-alert' },
		buttons: {
			ACEPTAR: function() {
				
				 borrar_municipio();
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				
				$(this).dialog( "close" );
		}
		}
		});
	  }
function nuevo_idioma(){
   $('#frm-enviar-idioma').hide();
    $('#img-enviar-idioma').show();
    $.post('ajax_adm/nuevo_idioma.php',{form:$('#frm-enviar-idioma').serialize()})
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-enviar-idioma').hide();
                    limpiaForm($('#frm-enviar-idioma'));
                    $('#frm-enviar-idioma').show();
                    select_idiomas();
                }else
                {
                  alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-enviar-idioma').hide();
                    $('#frm-enviar-idioma').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-enviar-idioma').hide();
                $('#frm-enviar-idioma').show(); 
                ajax_error_alert(jqXHR, textStatus);
            }); 
}

function borrar_idioma(){
   $('#frm-borrar-idioma').hide();
   $('#img-borrar-idioma').show();
   $.post('ajax_adm/borrar_idioma.php',{form:$('#frm-borrar-idioma').serialize()})
           .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-borrar-idioma').hide();
                    limpiaForm($('#frm-borrar-idioma'));
                    $('#frm-borrar-idioma').show();
                    $('#select-idioma-borrar').html('');
                    select_idiomas();
                }else
                {
                    alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-borrar-idioma').hide();
                    $('#frm-borrar-idioma').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-borrar-idioma').hide();
                $('#frm-borrar-idioma').show(); 
                ajax_error_alert(jqXHR, textStatus);
            });
}

function confirmar_borrar_idioma(){
     $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#div-contenedor-alert' },
		buttons: {
			ACEPTAR: function() {
				
				 borrar_idioma();
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				
				$(this).dialog( "close" );
		}
		}
		});
	  }
          
function nueva_carrera(){
   $('#frm-enviar-carrera').hide();
    $('#img-enviar-carrera').show();
    $.post('ajax_adm/nueva_carrera.php',{form:$('#frm-enviar-carrera').serialize()})
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-enviar-carrera').hide();
                    limpiaForm($('#frm-enviar-carrera'));
                    $('#frm-enviar-carrera').show();
                    select_carrera();
                }else
                {
                  alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-enviar-carrera').hide();
                    $('#frm-enviar-carrera').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-enviar-carrera').hide();
                $('#frm-enviar-carrera').show(); 
                ajax_error_alert(jqXHR, textStatus);
            }); 
}

function borrar_carrera(){
   $('#frm-borrar-carrera').hide();
   $('#img-borrar-carrera').show();
   $.post('ajax_adm/borrar_carrera.php',{form:$('#frm-borrar-carrera').serialize()})
           .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-borrar-carrera').hide();
                    limpiaForm($('#frm-borrar-carrera'));
                    $('#frm-borrar-carrera').show();
                    select_carrera();
                }else
                {
                    alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-borrar-carrera').hide();
                    $('#frm-borrar-carrera').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-borrar-carrera').hide();
                $('#frm-borrar-carrera').show(); 
                ajax_error_alert(jqXHR, textStatus);
            });
}

function confirmar_borrar_carrera(){
     $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#div-contenedor-alert' },
		buttons: {
			ACEPTAR: function() {
				
				 borrar_carrera();
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				
				$(this).dialog( "close" );
		}
		}
		});
	  }
          
          
function nueva_especialidad(){
   $('#frm-enviar-especialidad').hide();
    $('#img-enviar-especialidad').show();
    $.post('ajax_adm/nueva_especialidad.php',{form:$('#frm-enviar-especialidad').serialize()})
            .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-enviar-especialidad').hide();
                    limpiaForm($('#frm-enviar-especialidad'));
                    $('#frm-enviar-especialidad').show();
                    select_carrera();
                }else
                {
                  alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-enviar-especialidad').hide();
                    $('#frm-enviar-especialidad').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-enviar-especialidad').hide();
                $('#frm-enviar-especialidad').show(); 
                ajax_error_alert(jqXHR, textStatus);
            }); 
}

function borrar_especialidad(){
   $('#frm-borrar-especialidad').hide();
   $('#img-borrar-especialidad').show();
   $.post('ajax_adm/borrar_especialidad.php',{form:$('#frm-borrar-especialidad').serialize()})
           .done(function(data){
                datos=$.parseJSON(data);
                if(datos.respuesta==='1'){
                    alerta('Completado',$('#alerta'),'Operación completada correctamente');
                    $('#img-borrar-especialidad').hide();
                    limpiaForm($('#frm-borrar-especialidad'));
                    $('#frm-borrar-especialidad').show();
                    select_carrera();
                }else
                {
                    alerta('Error',$('#alerta'),'Informe:'+datos.mensaje);
                    $('#img-borrar-especialidad').hide();
                    $('#frm-borrar-especialidad').show();  
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                $('#img-borrar-especialidad').hide();
                $('#frm-borrar-especialidad').show(); 
                ajax_error_alert(jqXHR, textStatus);
            });
}

function confirmar_borrar_especialidad(){
     $("#dialogo").dialog({ 
		width: 250,  
		height: 250,
		show: "scale", 
		hide: "scale", 
		resizable: "false", 
		modal: "true", 
		position: { my: "center", at: "center", of: '#div-contenedor-alert' },
		buttons: {
			ACEPTAR: function() {
				
				 borrar_especialidad();
				 $(this).dialog("close");
		},
			CANCELAR: function() {
				
				$(this).dialog( "close" );
		}
		}
		});
	  }