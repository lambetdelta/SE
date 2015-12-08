<?php
    include_once 'includes/conexion-bd-adm.php';
    include_once 'includes/functions.php';
    sec_session_start(); ?>
    <?php if(login_check_adm($mysqli)==TRUE): ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <title>Administrador de SSE</title>
    <link href="HojasEstilo/estiloAdm.css" rel="stylesheet" type="text/css" /> 
    <link href="HojasEstilo/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="HojasEstilo/adm_ui_jquey/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="HojasEstilo/adm_ui_jquey/jquery-ui.structure.css" rel="stylesheet" type="text/css" />
    <link href="HojasEstilo/adm_ui_jquey/jquery-ui.theme.css" rel="stylesheet" type="text/css" />
    </head>
        <body id="body">
        <header>
            <div class="row" id="div-img-banner">
                <img src="Imagenes/banner_ittj.png" class="img-responsive" style="margin: auto"/>
            </div>
        </header> 
        <section>
            <div class="tab">
            <div id="navegacion">
                 <nav role="navigation" class="navbar navbar-default nav-personal" style="margin-bottom:0px; border:none">
                    <div class="navbar-header">
                        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                            <span class="sr-only">Inicio</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#primero" title="Datos Personales" class="navbar-brand active" style="font-size:28px">Egresados</a>
                    </div>

                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a  href="#segundo" title="Estadísticas de egresados e informes">Estadísticas</a></li>
                            <li><a href="#tercero" title="Contraseña, nombre usuario y más">Configuración</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#navegacion" onclick="salir()" title="Cerrar sesión y salir">SALIR</a></li>
                        </ul>    
                    </div>
                </nav>
            </div>
            </div>    
        </section>
        <div id="div-contenedor-alert">
            <div id="alerta">
                <span id="span-alerta"></span>
            </div>
        </div>
            <div class="contenedor">
        <div id="primero">
        <div id="div-principal-buscador">
            <div id="contenedor-buscador" class="row">
                <div id="div-buscador" class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                    <div id="div-barra-busqueda"><input id="input-buscador" placeholder="BUSCAR" title="BUSCAR"></input><div id="div-img-encontrar"><img id="img-encontrar" src="Imagenes/adm/buscar_negro.png" title="BUSCAR"/></div></div>
                </div>
                <div id="div-buscar-todos" class="col-lg-1 col-md-2 col-xs-12">
                    <span id="span-buscar-todos" title="BUSCAR TODOS LOS EGRESADOS">Ver todos</span>
                </div>
            </div>
            <div class="row">
                <div id="div-contenedor-resultados" class="col-lg-8 col-lg-offset-2 col-sx-12">
                    <div id="div-resultados" ></div>
                </div>
            </div>
        </div>
        <div id="div-relleno" style="position: relative; display: none" class="row"></div>
            <div class="row">
                <div id="div-principal"class="col-xs-12">
                    <div id="div-resultados-avanzado-principal">
                        <img id="img-cargar-busqueda-avanzada"src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                        <div id="div-resultados-avanzado" class="col-lg-8 col-lg-offset-2 col-sx-12">
                            
                        </div>    
                    </div>
                    <div id="div-pefil">
                        <div id="row-datos-personales" class="row">
                            <div id="row-datos-foto" class="row">
                                <div id="div-principal-foto" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <img id="img-cargar-foto" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                                    <div id="div-foto">
                                        <img id="img-foto-egresado" ></img>
                                    </div>
                                </div>
                                <div id="div-principal-datos-personales" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <img id="img-cargar-datos-personales" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                                    <div id="div-datos-personales"></div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div id="div-principal-datos-idioma" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <img id="img-cargar-datos-idioma" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                                            <div id="div-datos-idioma" ></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="div-principal-datos-sw" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <img id="img-cargar-datos-sw" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                                            <div id="div-datos-sw"></div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div id="row-datos-academicos" class="row">
                                <div id="div-principal-datos-academicos" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div id="div-principal-img-seleccion">
                                        <div id="div-img-seleccion">
                                            <div id="div-img-ingenieria" class="div-img-seleccion-hover"><img id="img-ingenieria" src="Imagenes/adm/ingenieria.png" class="img-centrada"></img></div>
                                            <div id="div-img-posgrado"><img id="img-ingenieria" src="Imagenes/adm/posgrado.png" class="img-centrada"></img></div>
                                        </div>
                                    </div>
                                    <div id="div-principal-ingenieria">
                                        <img id="img-cargar-datos-academicos" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                                        <div id="div-datos-academicos" ></div>
                                    </div>
                                    <div id="div-principal-posgrado">
                                        <img id="img-cargar-datos-posgrado" src="Imagenes/espera.gif" ></img>
                                        <div id="div-datos-posgrado"></div>
                                    </div>
                                </div>
                                <div id="div-principal-social" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <img id="img-cargar-datos-social" src="Imagenes/espera.gif" ></img>
                                    <div id="div-datos-social"></div>    
                                </div>
                                
                            </div>
                        </div>  
                        <div id="div-row-datos-empresa">
                            <div id="div-datos-generales-empresa" >
                                <div id="div-principal-empresa" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <img id="img-cargar-datos-empresa" src="Imagenes/espera.gif" class="img-centrada-oculta" ></img>
                                    <div id="div-datos-empresa"></div>   
                                </div>
                                <div id="div-principal-historial" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <img id="img-cargar-datos-historial" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                                    <div id="div-datos-historial"></div>   
                                </div>
                            </div>
                            <div id="div-principal-empresa-completa" class="col-xs-10 col-xs-offset-1">
                                    <img id="img-cargar-datos-empresa-completa" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>
                                    <div id="div-datos-empresa-completa" class="row"></div>   
                            </div>
                        </div>
                    </div>
                </div>  
                </div>  
        </div>
                <div id="segundo" class="row">     
                    <div id="div-principal-estadisticas-fecha-carrera" class="row">
                        <div id="div-principal-formulario-estadisticas-fecha-carrera" class="row">
                            <div id="div-formulario-estadisticas-fecha-carrera" class="col-lg-8 col-lg-offset-2 col-sm-12">
                                <form id="form-estadisticas-fecha-carrera" action="estadisticas/fecha_carrera.php" target="_blank" method="post">
                                    <h2>Egresados</h2>
                                    <select id="input-fecha-egreso" name="fecha" type="text" value="Fecha de egreso"  class="boton"></br>
                                    <?php 
                                    $año=1970;
                                    while($año<date("Y")){
                                    echo '<option value="'.$año.'">'.$año.'</option>';
                                    $año++;
                                    }
                                    ?>
                                    </select>
                                    <select id="select-carrera" class="boton" name="carrera"></select>
                                    <input type="submit" class="boton" value="Solicitar"></input>
                                </form>
                            </div>
                        </div>
                        <div id="div-principal-datos-estadisticas-fecha-carrera" class="row">
                            <img id="img-cargar-datos-estadisticas-fecha-carrera" src="Imagenes/espera.gif" class="img-centrada-oculta"></img>    
                            <div id="div-datos-estadisticas-fecha-carrera"></div>
                        </div>
                    </div>
                    <div id="div-principal-estadisticas-egresados-empleados" class="row">
                        
                    </div>
                </div>
            </div>
            <div id="tercero">
                
            </div>
            </div>
    </body>
    <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/funciones_adm.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript">
    $("document").ready(function() {
	$(function (activar_pestanya) {
				var tabContainerssup = $('div.contenedor > div');
			    $('div.tab a').click(function () {
					$("a").removeClass("active");
					tabContainerssup.hide().filter(this.hash).show();
					$(this).addClass("active");
					return false;
			    }).filter(':first').click();
			});//fin activar pestaña		
	});
    </script>
    <script type="text/javascript">
        var alto_img=$('#div-img-banner').height();//alto de la img principal
        var $pos = alto_img+50;
        $('#div-principal-empresa-completa').css({'top':$pos+$('#div-principal-buscador').height()+'px'});//acomodar el top del  div  deacuerdo a el buscador , menu e imagen
        var min_height=$(window).height()-$pos;//alto de contenido principal n base a la pantalla donde se ve
        $('#div-relleno').height($('#div-principal-buscador').height());
        if($(window).height()>1900){//recalcular contenido principal si se ve un dispositivo mayor de 1900 px
            $(function(){
                min_height=$(window).height()-$pos;
                min_height=min_height+'px';
                $('#div-principal').css({'min-height':min_height});
            });
        }     
        $(function () {//barra de busqueda fixed
            var $win = $(window);           
            $win.scroll(function () {
               if ($win.scrollTop() <= $pos){
                 $('#div-relleno').hide();  
                 $('#div-principal-buscador').removeClass('div-scroll-activo');
                 $('#div-principal-empresa-completa').css({'top':$pos+$('#div-principal-buscador').height()+'px'});}
               else {
                 $('#div-relleno').show();  
                 $('#div-principal-buscador').addClass('div-scroll-activo');
                 $('#div-principal-empresa-completa').css({'top':$('#div-principal-buscador').height()+'px'});
               }
             });
        $(window).resize(function(){//calcular altura en base a la distancia de la barra de busqueda y el incio de la pagina
            alto_img=$('#div-img-banner').height();
            $pos = alto_img+50;
            setTimeout("$('#div-relleno').height($('#div-principal-buscador').height());$('#div-principal-empresa-completa').css({'top':$pos+$('#div-principal-buscador').height()+'px'});",300);
        });
       
});
    </script>
    <script type="text/javascript">
        $(document).ready(function(){//buscador eventos y animaciones
            $('*:not(div-resultados,.div-resultado,#div-buscador)').on('click',function(){
              ocultar_buscador();  
            });
           $('#input-buscador').keyup(function(){//buscador
                if($(this).val().length>2){
                    setTimeout('buscar($("#input-buscador").val(),10);',500);            
                    }
                else{
                    setTimeout('ocultar_buscador();',500);
                }
            });
        $('#div-img-encontrar').click(function(){
            if($("#input-buscador").val().length>2)
            {
                $('#div-pefil').hide();
                buscar_avanzado($("#input-buscador").val(),20);
            }else
                alerta('Alerta',$('#alerta'),'Es necesario una palabra de más de tres letras para una buena búsqueda');
        });
        
        $('#div-buscar-todos').click(function(){//buscar todos los registros
           buscar_todos(); 
        });
        
        $('#div-resultados-avanzado').on('click','.div-resultado',function (){
            var no_control=$(this).attr('id').slice(13);
            cargar_datos_egresado(no_control);          
        });
        $('#div-resultados-avanzado').on('click','#ver-mas',function (){
            buscar_todos_mas();         
        });
         $('#div-resultados-avanzado').on('click','#ver-mas-avanzado',function (){
            buscar_avanzado_mas($("#input-buscador").val(),20);         
        });
        $('#div-resultados').on('click','.div-resultado',function (){
            var no_control=$(this).attr('id').slice(13);
            cargar_datos_egresado(no_control);          
        });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#div-datos-empresa').on('click','.div-datos-empresa-resultado',function(){
                var codigo_empresa=$(this).attr('id').slice(18);
                todo_dt_empresa(codigo_empresa);
                
            });
            $('#div-principal-empresa-completa').on('click','.cancel',function(){
                $('#div-principal-empresa-completa').fadeOut();             
            });
            $('#div-img-ingenieria').click(function(){
            $('#div-img-ingenieria').addClass('div-img-seleccion-hover');
            $('#div-img-posgrado').removeClass('div-img-seleccion-hover');           
            $('#div-principal-posgrado').hide();    
            $('#div-datos-academicos').show();
            $('#div-principal-ingenieria').show();
           
        });//mostrar div de ingeniería
        $('#div-img-posgrado').click(function(){
            $('#div-img-posgrado').addClass('div-img-seleccion-hover');
            $('#div-img-ingenieria').removeClass('div-img-seleccion-hover');
            $('#div-datos-academicos').hide();
            $('#div-principal-ingenieria').hide();
            $('#div-principal-posgrado').show();
            
        });//mostrar div de posgrado
         $('#img-encontrar').hover(
                   function(){
                       $(this).attr('src','Imagenes/adm/buscar.png');}
                   ,function(){
                       $(this).attr('src','Imagenes/adm/buscar_negro.png');});
        });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        //objetos especiales 
        ;
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        //cargar dt 
        select_carrera();
    });
    </script>
    <?php else : echo 'Problemas con tu autenticacion inicia sesión de nuevo'; ?>
    <?php endif; 

