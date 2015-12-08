var no_registro=0;
var no_registro_b=0;
function salir(){
  window.location="includes/logout.php";  
}
function espacion_block(e){ //bloquear espacio
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==32) return false; 
}

function select_carrera(){
    $('#select-carrera').html('');
    $.post('ajax_adm/carreras.php').done(function(data){
        datos=$.parseJSON(data);
        if(datos.respuesta==='1'){
            $.each(datos.carrera,function(){
                $('#select-carrera').append('<option value="'+this.codigo_carrera+'">'+this.nombre+'</option>');
            });
        }else{
            $('#select-carrera').append('<option id="0">ERROR:'+datos.mensage+'</option>')
        }
    }).fail(function(jqXHR, textStatus, errorThrown){
        ajax_error_input(jqXHR, textStatus,$('#select-carrera'));
    });
}
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
          
//solicitudes ajax          

function buscar(dato,cantidad){
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
function ocultar_buscador(){
    $('#div-resultados').hide();
    $('#div-resultados').attr('z-index','0');
    $('#div-resultados').html('');
}

function buscar_todos(){
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
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas">VER MÁS</p>'; 
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
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas">VER MÁS</p>'; 
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

function buscar_avanzado(dato,cantidad){
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
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro_b=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas-avanzado">VER MÁS</p>'; 
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
                    $('#div-resultados-avanzado').append(div);
                    registro++;
                    no_registro_b=this.id_consecutivo;//ultimo registro recibido se necesita para seguir buscando
                });
                if(registro===20){
                    var div=$('<div/>');
                    p='<p class="p-ver-mas" id="ver-mas-avanzado">VER MÁS</p>'; 
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
    dt_empresa(no_control);
    dt_historial(no_control);
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
                var p='<h2>Idiomas<img src="Imagenes/adm/idioma.png" class="margen-izq"></h2>';
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
                 var p='<h2>Idiomas<img src="Imagenes/adm/idioma.png" class="margen-izq"></h2>';
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
                var p='<h2>Software<img src="Imagenes/adm/consola.png" class="margen-izq"></h2>';
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
                 var p='<h2>Software<img src="Imagenes/adm/consola.png" class="margen-izq"></h2>';
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
                var p='<h2>GRUPOS SOCIALES<img src="Imagenes/adm/torre.png" class="margen-izq"></h2>';
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
                 var p='<h2>GRUPOS SOCIALES<img src="Imagenes/adm/torre.png" class="margen-izq"></h2>';
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
                    p='<p>Nombre:'+this.nombre+'</p>'; 
                    div.append(p);
                    p='<p>Giro:'+this.giro+'</p>'; 
                    div.append(p);
                    p='<p>Web:'+this.web+'</p>'; 
                    div.append(p);
                    p='<p>Email:'+this.email+'</p>'; 
                    div.append(p);
                    p='<p>Puesto:'+this.puesto+'</p>'; 
                    div.append(p);
                    p='<p>Ingreso:'+this.año_ingreso+'</p>'; 
                    div.append(p);
                    div.addClass('div-datos-empresa-resultado');
                    div.attr('id','div-datos-empresa-'+this.codigo_empresa);
                    $('#div-datos-empresa').append(div);
                });
                $('#img-cargar-datos-empresa').hide();
                $('#div-datos-empresa').show();
             }else{
                 var p='<h2>EMPRESA´S<img src="Imagenes/adm/empresa.png" class="margen-izq"></h2>';
                 $('#div-datos-empresa').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
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

function ajax_error_input(jqXHR,textStatus,input){
        if (jqXHR.status === 0) {
            input.val('ERROR:SIN RESPUESTA DEL SERVIDOR');
        } else if (jqXHR.status == 404) {
            input.val('ERROR:PÁGINA NO ENCONTRADA [404]');

        } else if (jqXHR.status == 500) {
            input.val('ERROR:FALLA DEL SERVIDOR[505]');
            //Internal Server Error [500]
                
        } else if (textStatus === 'parsererror') {
            input.val('ERROR:DATOS RECIBIDOS CORRUPTOS');
//            Requested JSON parse failed

        } else if (textStatus === 'timeout') {
            input.val('ERROR:TIEMPO DE RESPUESTA EXPIRADO');
//           Time out error

        } else if (textStatus === 'abort') {

//            alert('Ajax request aborted.');

        } else {
            input.val('ERROR INESPERADO:'+ jqXHR.responseText);
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
                p='<div class="cancel"></div>';
                $('#div-datos-empresa-completa').append(p);
                $.each(datos.empresa,function(){
                    var div=$('<div/>');
                    p='<p>Nombre:'+this.nombre+'</p>'; 
                    div.append(p);
                    p='<p>Giro:'+this.giro+'</p>'; 
                    div.append(p);
                    p='<p>Web:'+this.web+'</p>'; 
                    div.append(p);
                    p='<p>Email:'+this.email+'</p>'; 
                    div.append(p);
                    p='<p>Puesto:'+this.puesto+'</p>'; 
                    div.append(p);
                    p='<p>Ingreso:'+this.año_ingreso+'</p>'; 
                    div.append(p);
                    p='<p>Superior inmediato:'+this.nombre_jefe+'</p>'; 
                    div.append(p);
                    p='<p>Telefono:'+this.telefono+'</p>'; 
                    div.append(p);
                    div.addClass('col-xs-6');
                    $('#div-datos-empresa-completa').append(div);
                    div=$('<div/>');
                    p='<p>Organismo:'+this.organismo+'</p>'; 
                    div.append(p);
                    p='<p>Razón Social:'+this.razon_social+'</p>'; 
                    div.append(p);
                    p='<p>Medio búsqueda:'+this.medio_busqueda+'</p>'; 
                    div.append(p);
                    p='<p>Tiempo de búsqueda:'+this.tiempo_busqueda+'</p>'; 
                    div.append(p);
                    p='<p>Domicilio</p>'; 
                    div.append(p);
                    p='<p>Calle:'+this.calle+' No:'+this.no_domicilio+'</p>'; 
                    div.append(p);
                    p='<p>Estado:'+this.estado+'</p>'; 
                    div.append(p);
                    p='<p>Municipio:'+this.municipio+'</p>'; 
                    div.append(p);
                    div.addClass('col-xs-6');
                    $('#div-datos-empresa-completa').append(div);
                });
                $('#img-cargar-datos-empresa-completa').hide();
                $('#div-datos-empresa-completa').show();
             }else{
                 var p='<h2>EMPRESA</h2>';
                 $('#div-datos-empresa-completa').append(p);
                 p='<div class="cancel"></div>';
                 $('#div-datos-empresa-completa').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
                 $('#div-datos-empresa-completa').append(p);
                 $('#img-cargar-datos-empresa-completa').hide();
                 $('#div-datos-empresa-completa').show();
                
             }   
            }).fail(function(jqXHR, textStatus, errorThrown){
              $('#img-cargar-datos-empresa-completa').hide();
              $('#div-datos-empresa-completa').show(); 
              p='<div class="cancel"></div>';
              $('#div-datos-empresa-completa').append(p);
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
                    p='<p>Nombre:'+this.nombre+'</p>'; 
                    div.append(p);
                    p='<p>Telefono:'+this.telefono+'</p>'; 
                    div.append(p);
                    p='<p>Web:'+this.web+'</p>'; 
                    div.append(p);
                    p='<p>Email:'+this.email+'</p>'; 
                    div.append(p);
                    $('#div-datos-historial').append(div);
                });
                $('#img-cargar-datos-historial').hide();
                $('#div-datos-historial').show();
             }else{
                 var p='<h2>Historial<img src="Imagenes/adm/historial.png" class="margen-izq"></h2>';
                 $('#div-datos-historial').append(p);
                 p='<p>Informe:'+datos.mensage+'</p>'; 
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