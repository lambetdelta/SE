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
<title>Estadísticas de SSE</title>
<link href="HojasEstilo/estiloAdm.css" rel="stylesheet" type="text/css" /> 
<link href="HojasEstilo/bootstrap.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <header>
        <img src="Imagenes/banner_ittj.png" class="img-responsive" style="margin: auto"/>
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
                    <a href="administrador.php" title="Datos Personales" class="navbar-brand" style="font-size:22px">Egresados</a>
                </div>

                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a  href="estadisticas.php" title="Estadísticas de egresados e informes">Estadísticas</a></li>
                        <li><a class="active" href="configuracion.php" title="Contraseña, nombre usuario y más">Configuración</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a onclick="salir()" title="Cerrar sesión y salir">SALIR</a></li>
                    </ul>    
                </div>
            </nav>
        </div>
    </section>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="js/bootstrap.js"></script>
<script src="js/funciones_adm.js"></script>
<?php else : header('Location: error.php'); ?>
<?php endif; ?>

