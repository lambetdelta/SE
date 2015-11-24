function salir(){
  window.location="includes/logout.php";  
}
function espacion_block(e){ //bloquear espacio
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==32) return false; 
}


function alerta(title,dialog,mensage){ 
var alert_=dialog;
$('#span-alerta').html(mensage);
   alert_.dialog({ 
   		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).show(); },
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

function buscar(dato,limit,cantidad){
    $.post('ajax_adm/buscar.php',{dato:dato,limit:limit,cantidad:cantidad})
            .done(function(data){
                $('#div-resultados').fadeIn();
                $('#div-resultados').html(data);
            }).fail(function(jqXHR, textStatus, errorThrown){
                $('#div-resultados').html('');
                $('#div-resultados').fadeIn();
                ajax_error(jqXHR,textStatus,$('#div-resultados'));
                });
}
function ocultar_buscador(){
    $('#div-resultados').hide();
    $('#div-resultados').attr('z-index','0');
    $('#div-resultados').html('');
}

function buscar_todos(){
    $('#div-pefil').hide();
    $('#div-resultados-avanzado-principal').show();
    $('#img-cargar-busqueda-avanzada').show();
    $('#div-resultados-avanzado').html('');
    $('#div-resultados-avanzado').hide();
    ocultar_buscador();
    $('#input-buscador').val('');
    $.post('ajax_adm/buscar_todos.php')
            .done(function(data){
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').fadeIn();
                $('#div-resultados-avanzado').html(data);
            }).fail(function(jqXHR, textStatus, errorThrown){
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').fadeIn();
                ajax_error(jqXHR,textStatus,$('#div-resultados-avanzado'));
                });
        }
function buscar_avanzado(dato,limit,cantidad){
    $('#div-resultados-avanzado-principal').show();
    $('#img-cargar-busqueda-avanzada').show();
    $('#div-resultados-avanzado').html('');
    $('#div-resultados-avanzado').hide();
    ocultar_buscador();
    $.post('ajax_adm/buscar.php',{dato:dato,limit:limit,cantidad:cantidad})
            .done(function(data){
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').fadeIn();
                $('#div-resultados-avanzado').html(data);
            }).fail(function(jqXHR, textStatus, errorThrown){
                $('#img-cargar-busqueda-avanzada').hide();
                $('#div-resultados-avanzado').fadeIn();
                ajax_error(jqXHR,textStatus,$('#div-resultados-avanzado'));
                });
                }
function cargar_datos_egresado(no_control){
    ocultar_buscador();
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
                     p='<h2>DATOS PERSONALES</h2>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-nombre" class="p-dt-egresado">Nombre:'+datos.egresado.nombre+' '+datos.egresado.apellido_p+' '+datos.egresado.apellido_m +'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-curp" class="p-dt-egresado">CURP:'+datos.egresado.curp+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-telefono" class="p-dt-egresado">Telefono:'+datos.egresado.telefono+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-email" class="p-dt-egresado">Email:'+datos.egresado.email+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-fecha_nac" class="p-dt-egresado">Fecha de nacimiento:'+datos.egresado.fecha_nacimiento+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-calle" class="p-dt-egresado">Calle:'+datos.egresado.calle+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-no-casa" class="p-dt-egresado">No. Casa:'+datos.egresado.numero_casa+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-estado" class="p-dt-egresado">Estado:'+datos.egresado.estado+'</p>';
                     $('#div-datos-personales').append(p);
                     p='<p id="p-municipio" class="p-dt-egresado">Municipio:'+datos.egresado.municipio+'</p>';
                     $('#div-datos-personales').append(p);                    
                     $('#img-cargar-datos-personales').hide();
                     $('#div-datos-personales').show();
                }else{
                    var p='<p id="p-estado" class="p-dt-egresado">ERROR:'+datos.mensage+'</p>';
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
                    p='<p>Carrera:'+this.carrera+'</p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Especialidad:'+this.especialidad+'</p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Fecha de inicio:'+this.fecha_inicio+'</p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Fecha de finalización:'+this.fecha_fin+'</p>'; 
                    $('#div-datos-academicos').append(p);
                    p='<p>Titulado:'+this.titulado+'</p>'; 
                    $('#div-datos-academicos').append(p);
                });
                $('#img-cargar-datos-academicos').hide();
                $('#div-datos-academicos').show();
             }else{
                 var p='<h2>DATOS ACADEMICOS</h2>';
                 $('#div-datos-academicos').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
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
                var p='<h2>Idiomas</h2>';
                $('#div-datos-idioma').append(p);
                var table = $('<table/>');
                table.addClass('tabla');
                table.addClass('table');
                table.addClass('table-hover');
                table.addClass('table table-condensed');
                table.append('<tr><th>Idioma</th><th>Habla</th><th>Lectura y escritura</th></tr>');
                $.each(datos.idioma,function(){
                    table.append( '<tr><td>' +this.idioma+'</td><td>' +this.porcentaje_habla+'</td><td>' +this.porcentaje_lec_escr+'</td></tr>' );
                });
                $('#div-datos-idioma').append(table);
                $('#img-cargar-datos-idioma').hide();
                $('#div-datos-idioma').show();
             }else{
                 var p='<h2>Idioma</h2>';
                 $('#div-datos-idioma').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
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
                var p='<h2>Software</h2>';
                $('#div-datos-sw').append(p);
                var table = $('<table/>');
                table.addClass('tabla');
                table.addClass('table');
                table.addClass('table-hover');
                table.addClass('table table-condensed');
                $.each(datos.sw,function(){
                    table.append( '<tr><td>' +this.nombre_sw+'</td></tr>' );
                });
                $('#div-datos-sw').append(table);
                $('#img-cargar-datos-sw').hide();
                $('#div-datos-sw').show();
             }else{
                 var p='<h2>Sotware</h2>';
                 $('#div-datos-sw').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
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
                $.each(datos.carrera,function(){
                    p='<div class="separador-posgrado"></div>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Posgrado:'+this.nombre+'</p>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Nivel:'+this.posgrado+'</p>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Escuela:'+this.escuela+'</p>'; 
                    $('#div-datos-posgrado').append(p);
                    p='<p>Titulado:'+this.titulado+'</p>'; 
                    $('#div-datos-posgrado').append(p);
                });
                $('#img-cargar-datos-posgrado').hide();
                $('#div-datos-posgrado').show();
             }else{
                 var p='<h2>DATOS POSGRADO</h2>';
                 $('#div-datos-posgrado').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
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
                var p='<h2>GRUPOS SOCIALES</h2>';
                $('#div-datos-social').append(p);
                $.each(datos.social,function(){
                    p='<div class="separador-social"></div>'; 
                    $('#div-datos-social').append(p);
                    p='<p>Nombre:'+this.nombre+'</p>'; 
                    $('#div-datos-social').append(p);
                    p='<p>Tipo:'+this.tipo+'</p>'; 
                    $('#div-datos-social').append(p);
                });
                $('#img-cargar-datos-social').hide();
                $('#div-datos-social').show();
             }else{
                 var p='<h2>GRUPO SOCIALES</h2>';
                 $('#div-datos-social').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
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

function ajax_error(jqXHR,textStatus,div){
        var div_=div;
        var p;
        if (jqXHR.status === 0) {
            div.append('<p>ERROR:SIN RESPUESTA DEL SERVIDOR</p>');
        } else if (jqXHR.status == 404) {
            div.append('<p>P</p>');
            alert('ERROR:PÁGINA NO ENCONTRADA [404]');

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
