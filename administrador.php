<?php
    include_once 'includes/db_connect.php';
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
    </head>
        <body>
        <header>
            <div class="row">
                <img src="Imagenes/banner_ittj.png" class="img-responsive" style="margin: auto"/>
            </div>
        </header> 
        <section>
            <div id="navegacion">
                 <nav role="navigation" class="navbar navbar-default nav-personal" style="margin-bottom:0px; border:none">
                    <div class="navbar-header">
                        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                            <span class="sr-only">Inicio</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="administrador.php" title="Datos Personales" class="navbar-brand active" style="font-size:28px">Egresados</a>
                    </div>

                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a  href="estadisticas.php" title="Estadísticas de egresados e informes">Estadísticas</a></li>
                            <li><a href="configuracion.php" title="Contraseña, nombre usuario y más">Configuración</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#navegacion" onclick="salir()" title="Cerrar sesión y salir">SALIR</a></li>
                        </ul>    
                    </div>
                </nav>
            </div>
        </section>
        <div id="contenedor-buscador" class="row">
            <div id="div-buscador" class="col-lg-8 col-lg-offset-2 col-sm-12">
                <div id="div-barra-busqueda"><input id="input-buscador" placeholder="BUSCAR" onkeypress="espacion_block(event)"></input><div id="div-img-encontrar"><img id="img-encontrar" src="Imagenes/adm/buscar_negro.png" title="BUSCAR"/></div></div>
            </div>
        </div>
        <div class="row">
            <div id="div-contenedor-resultados" class="col-lg-8 col-lg-offset-2 col-sx-12">
                <div id="div-resultados" ></div>
            </div>
        </div>    
            <div class="row">
                <div id="div-principal"class="col-xs-12">

                </div>              
        </div>
    </body>
    <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/funciones_adm.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){//animación
           $('#img-encontrar').hover(
                   function(){
                       $(this).attr('src','Imagenes/adm/buscar.png');}
                   ,function(){
                       $(this).attr('src','Imagenes/adm/buscar_negro.png');}); 
    
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
           
           $('#input-buscador').keyup(function(){//buscador
            var dato=$(this).val();
            if($(this).val().length>3)
                setTimeout('buscar($("#input-buscador").val());',500);
        });
        
        });
    </script>
    <?php else : header('Location: error.php'); ?>
    <?php endif; 

