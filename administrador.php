<?php
    /* Cualquier duda repecto al código o en que diablos estaba pensando cuando lo hice :) enviar un correo 
 *  con el asunto SE a la siguiente direccion lambetdelta@hotmail.com con el  Ing. Osvaldo Uriel Garcia Gomez*/ 
    include_once 'includes/conexion-bd-adm.php';
    include_once 'includes/functions.php';
    sec_session_start();
    if($mysqli->connect_errno){
    header('Location: error_bd.php');
}else{
    ?>
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
                <img id="img-banner-institucion-principal" src="Imagenes/banner_ittj.png" class="img-responsive" style="margin: auto"/>
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
            <div id="div-recomendaciones">
                    <h2>Ayuda</h2>
                    <ul>
                        <li>Procura usar letras <b>mayúsculas y minúsculas</b> combinadas.</li>
                        <li>Agregar <b>números</b> aumenta más la seguridad.</li>
                        <li>Por último no olvides <b>caracteres especiales</b> como $, ! # darán más seguridad a tu password.</li>
                    </ul>
            </div>
            <div id="dialogo" title="¿Estás seguro?">
            <p>Esta acción es irreversible una vez hecha, ¿estás seguro?</p>
            </div>
        </div>
        <div class="contenedor">
            <div id="primero">
            <div id="div-principal-buscador">
                <div id="contenedor-buscador" class="row">
                    <div id="div-agregar-egresado" class="col-lg-1 col-lg-offset-1  col-md-1 col-md-offset-1 col-sm-12" tabindex="0">
                        <span id="span-agregar-egresado">Agregar</span>
                    </div>
                    <div id="div-buscador" class="col-lg-8  col-md-8  col-sm-12">
                        <div id="div-barra-busqueda"><input id="input-buscador" placeholder="BUSCAR" title="BUSCAR"></input><div id="div-img-encontrar" class="div-img-encontrar" tabindex="0"><img id="img-encontrar" src="Imagenes/adm/buscar_negro.png" title="BUSCAR"/></div></div>
                    </div>
                    <div id="div-buscar-todos" class="div-buscar-todos col-lg-1 col-md-2 col-xs-12" tabindex="0">
                        <span id="span-buscar-todos" title="BUSCAR TODOS LOS EGRESADOS">Ver todos</span>
                    </div>
                </div>
                <div class="row" >
                    <div id="div-contenedor-resultados" class="col-lg-8 col-lg-offset-2 col-sx-12">
                        <div id="div-resultados" ></div>
                    </div>
                </div>
                <div id="div-row-eliminar-egresado" class="row">
                    <div id="div-eliminar-egresado" class="col-lg-3 col-lg-offset-1 col-sx-12" tabindex="0">
                        <span id="span-eliminar-egresado">Borrar egresado</span>
                    </div>
                </div>
            </div>
            <div id="div-relleno" style="position: relative; display: none" class="row"></div>
                <div class="row">
                    <div id="div-principal"class="col-xs-12">
                        <div id="div-principal-agregar-egresado" class="row">
                            <img id="img-agregar-egresado" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <div id="div-formulario-agregar-egresado" class="col-md-12 col-sx-12">
                                <form id="form-agregar-egresado">
                                    <h2>Nuevo Egresado</h2>
                                    <div id="div-cerrar-agregar-egresado" class="cancel" tabindex="0"></div>
                                    <div id="div-no-control"><input id="input-no-control1" name="no_control1" type="number" placeholder="No: control"  class="boton" maxlength="8" minlength="8" required/>
                                    <img tabindex="0" id="img-mas-egresado1" class="img-mininmizar"src="Imagenes/adm/mas.png" title="Agregar" alt="Agregar más"/>
                                    </div>
                                    <input value="GUARDAR" type="submit" class="boton" />
                                </form>
                            </div>   
                        </div>
                        <div id="div-resultados-avanzado-principal">
                            <img id="img-cargar-busqueda-avanzada"src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                            <div id="div-resultados-avanzado" class="col-lg-8 col-lg-offset-2 col-sx-12">
                            </div>    
                        </div>
                        <div id="div-pefil">
                            <div id="row-datos-personales" class="row">
                                <div id="row-datos-foto" class="row">
                                    <div id="div-principal-foto"  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <img id="img-cargar-foto" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                                        <div id="div-foto">
                                            <img id="img-foto-egresado" ></img>
                                        </div>
                                    </div>
                                    <div id="div-principal-datos-personales" class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
                                        <img id="img-cargar-datos-personales" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                                        <div id="div-datos-personales" ></div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div id="div-principal-datos-idioma" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                                <img id="img-cargar-datos-idioma" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                                                <div id="div-datos-idioma" ></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="div-principal-datos-sw" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                                <img id="img-cargar-datos-sw" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                                                <div id="div-datos-sw"></div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="row-datos-academicos" class="row">
                                    <div id="div-principal-datos-academicos" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div id="div-principal-img-seleccion">
                                            <div id="div-img-seleccion">
                                                <div id="div-img-ingenieria" class="div-img-seleccion-hover" tabindex="0"><img id="img-ingenieria" src="Imagenes/adm/ingenieria.png" class="img-centrada"></img></div>
                                                <div id="div-img-posgrado" tabindex="0"><img id="img-ingenieria" src="Imagenes/adm/posgrado.png" class="img-centrada"></img></div>
                                            </div>
                                        </div>
                                        <div id="div-principal-ingenieria">
                                            <img id="img-cargar-datos-academicos" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                                            <div id="div-datos-academicos" ></div>
                                        </div>
                                        <div id="div-principal-posgrado">
                                            <img id="img-cargar-datos-posgrado" src="Imagenes/espera.gif" ></img>
                                            <div id="div-datos-posgrado" ></div>
                                        </div>
                                    </div>
                                    <div id="div-principal-social" class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                                        <img id="img-cargar-datos-social" src="Imagenes/espera.gif" ></img>
                                        <div id="div-datos-social" ></div>    
                                    </div>

                                </div>
                            </div>  
                            <div id="div-row-datos-empresa">
                                <div id="div-datos-generales-empresa" >
                                    <div id="div-principal-empresa" class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                                        <img id="img-cargar-datos-empresa" src="Imagenes/espera.gif" class="img-centrada-oculta loading" ></img>
                                        <div id="div-datos-empresa" ></div>   
                                    </div>
                                    <div id="div-principal-historial" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <img id="img-cargar-datos-historial" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                                        <div id="div-datos-historial" ></div>   
                                    </div>
                                </div>
                                <div id="div-principal-empresa-completa" class="col-xs-10 col-xs-offset-1">
                                        <img id="img-cargar-datos-empresa-completa" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                                        <div id="div-datos-empresa-completa" class="row"></div>   
                                </div>
                            </div>
                        </div>
                    </div>  
                    </div>  
            </div>
                    <div id="segundo" class="row">
                        <div id="div-row-img-estadisticas" class="row">
                        <div id="div-img-estadisticas" class="col-xs-12">
                            <img src="Imagenes/adm/estadisticas.png" class="img-centrada"/>
                        </div>
                    </div>
                        <div id="div-principal-estadisticas-fecha-carrera" class="row">
                            <div id="div-principal-formulario-estadisticas-fecha-carrera" class="row">
                                <div id="div-formulario-estadisticas-fecha-carrera" class="col-lg-8 col-lg-offset-2 col-sm-12">
                                    <form id="form-estadisticas-fecha-carrera" action="estadisticas/fecha_carrera.php" target="_blank" method="post">
                                        <h2>Egresados</h2>
                                        <label>Año de egreso</label><br>
                                        <select id="input-fecha-egreso" name="fecha" type="text" value="Fecha de egreso"  class="boton"></br>
                                        <?php 
                                        $año=1970;
                                        $añoAc=date("Y");
                                        while($año<=$añoAc){
                                        echo '<option value="'.$año.'">'.$año.'</option>';
                                        $año++;
                                        }
                                        ?>
                                        </select>
                                        <select id="select-carrera" class="boton" name="carrera"></select><br>
                                        <input id="input-clave-estudios" class="boton" name="clave" placeholder="Clave de estudios" />
                                        <input type="submit" class="boton" value="Solicitar"></input>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="div-principal-estadisticas-egresados-empleados" class="row" style="display: none">
                            <div id="div-formulario-estadisticas-empleados-carrera" class="col-lg-8 col-lg-offset-2 col-sm-12">
                                    <form id="form-estadisticas-empleados-carrera" action="estadisticas/fecha_carrera.php" target="_blank" method="post">
                                        <h2>Empleados</h2>
                                        <select id="input-fecha-egreso-empleados" name="fecha-egreso" type="text" value="Fecha de egreso"  class="boton"></br>
                                        <?php 
                                        $año=1970;
                                        $añoAc=date("Y");
                                        while($año<=$añoAc){
                                        echo '<option value="'.$año.'">'.$año.'</option>';
                                        $año++;
                                        }
                                        ?>
                                        </select>
                                        <select id="select-carrera-empleado" class="boton" name="carrera-empleado"></select><br>
                                            <select id="select-sector" class="boton" name="sector">
                                                <option value="PÚBLICO">PÚBLICO</option>
                                                <option value="PRIVADO">PRIVADO</option>
                                                <option value="SOCIAL">SOCIAL</option>
                                            </select>
                                        <input type="submit" class="boton" value="Solicitar"></input>
                                    </form>
                            </div>    
                        </div>
                    </div>
                <div id="tercero">
                    <div id="div-img-adm" class="row">
                        <div id="div-img-adm" class="col-xs-12">
                            <img src="Imagenes/adm/adm.png" class="img-centrada"/>
                        </div>
                    </div>
                    <div id="div-row-principal-frm-agregar-administradores" class="row margen-top">
                        <div id="div-col-frm-agregar-administradores" class="col-lg-6  col-sx-12">
                            <img id="img-agregar-administrador" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-agregar-administrador" class="formularios" method="post">
                                <h2>Nuevo Administrador</h2>
                                <input name="nombre"type="text" class="input" placeholder="Administrador" title="Administrador" maxlength="40" required></input>
                                <div id="div-contraseña" style="position: relative">
                                    <input id="input-administrador-password"type="password"  placeholder="Contraseña" title="Contraseña" maxlength="15" required/><br/><img tabindex="0" id="img-ayuda-pass"src="Imagenes/ayuda.png"/>
                                    <span id="span-pass-seguridad"></span>
                                </div>
                                <div>
                                    <input id="pass_nuevo_reafirmar"  type="password" maxlength="15" name="nuevo_pass_reafirmar" title="Reafirmar contraseña" placeholder="REAFIRMAR CONTRASEÑA"class="input" style="display: none;" required="NUEVA CONTRASEÑA" />
                                <br><span id="span_pass" class="span_pass-incorrecto">LAS CONTRASEÑAS NO COINCIDEN</span><span id="span-pass-correcto">LAS CONTRASEÑAS COINCIDEN</span>
                                </div>
                                <input type="submit" value="Guardar" class="guardar" />
                            </form>
                        </div>
                        <div id="div-col-frm-borrar-administradores" class="col-lg-6  col-sx-12">
                            <form id="frm-borrar-administrador" class="formularios" method="post">
                                <h2>Borrar Administrador</h2>
                                <select id="select-administrador" class="input" ></select>
                                <input type="submit" value="Borrar" class="guardar" />
                            </form>
                        </div>
                    </div>
                    <div id="div-row-principal-frm-administradores" class="row margen-top">
                        <div id="div-col-frm-editar-administradores" class="col-lg-6 col-lg-offset-3 col-sx-12">
                            <img id="img-editar-administrador" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-editar-administrador" class="formularios" method="post">
                                <h2>Editar Administrador</h2>
                                <select id="select-administrador-editar" class="input" name="no_adm"></select>
                                <input name="nombre"type="text" class="input" placeholder="Nuevo nombre" title="Administrador" maxlength="40" required></input>
                                <div id="div-contraseña-editar" style="position: relative">
                                    <input id="input-administrador-password-editar"type="password"  placeholder="Contraseña" title="Contraseña" maxlength="15" required/><br/><img tabindex="0" id="img-ayuda-pass-editar"src="Imagenes/ayuda.png"/>
                                    <span id="span-pass-seguridad-editar"></span>
                                </div>
                                <div>
                                    <input id="pass_nuevo_reafirmar-editar"  type="password" maxlength="15" name="nuevo_pass_reafirmar" title="Reafirmar contraseña" placeholder="REAFIRMAR CONTRASEÑA"class="input" style="display: none;" required="NUEVA CONTRASEÑA" />
                                <br><span id="span_pass-editar" class="span_pass-incorrecto">LAS CONTRASEÑAS NO COINCIDEN</span><span id="span-pass-correcto-editar">LAS CONTRASEÑAS COINCIDEN</span>
                                </div>
                                <input type="submit" value="Guardar" class="guardar" />
                            </form>
                        </div>    
                    </div>
                    <div id="div-img-datos-escuela" class="row">
                        <div id="div-principal-img-datos-escuela" class="col-xs-12">
                            <img src="Imagenes/adm/institucion.png" class="img-centrada"/>
                        </div>
                    </div>
                    <div id="div-row-principal-datos-escuela" class="row margen-top">
                        <div id="div-principal-datos-escuela" class="col-lg-8 col-lg-offset-2 col-xs-12 div-contenedor">
                            <img id="img-cargar-datos-escuela" src="Imagenes/espera.gif" class="img-centrada-oculta loading"></img>
                            <div id="div-datos-escuela"></div>
                        </div>
                        <div id="div-principal-frm-datos-escuela" class="col-lg-8 col-lg-offset-2 col-xs-12 div-contenedor">
                            <img id="img-datos-escuela" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-datos-escuela" class="formularios">
                                <img src="Imagenes/adm/cancel.png" id="img-cerrar-frm-datos-escuela" tabindex="0" class="img-centrar"/>
                                <h2>Datos de la insitución</h2>
                                <input name="director" placeholder="Director" type="text" class="input" title="Director" maxlength="60" required/>
                                <input name="fecha" placeholder="Fecha conmemorativa" type="text" class="input" title="Fecha conmemorativa" maxlength="60" required/>
                                <input name="cargo" placeholder="Cargo" type="text" class="input" title="Cargo" maxlength="40" required/>
                                <input name="tel" placeholder="Teléfono" type="tel" class="input" title="Teléfono" maxlength="40" required/>
                                <input name="domicilio" placeholder="Dirección" type="text" class="input" title="Dirección" maxlength="80" required/>
                                <input name="web" placeholder="Web" type="text" class="input" title="Web" maxlength="60" required/>
                                <input name="email" placeholder="Email" type="email" class="input" title="Email" maxlength="60" required/>
                                <input type="submit" value="Guardar" title="Guardar" class="guardar"/>
                            </form>
                        </div>
                    </div>
                    <div id="div-row-principal-img-escuela" class="row div-contenedor margen-top">
                        <img id="img-guardar-escuela" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                        <form id="frm-img-institucion" class="formularios" enctype="multipart/form-data" method="post">
                            <h2>Imágenes del sistema </h2>
                            <div id="div-row-img-escuela-banner-institucion" class="row">
                                <div id="div-principal-img-banner-institucion" class="col-xs-12">
                                    <h3>Imagen de la institucion<img id="img-info-institucion" src="Imagenes/adm/info_r.png" title="Información" class="img-info" tabindex="0"  /></h3>
                                    <img id="img-banner-institucion" src="Imagenes/banner_ittj.png" class="img-responsive img-centrar"/>
                                    <input name="banner_institucion" type="file" value="Cambiar" class="input" title="Cambiar" required/>
                                </div>
                            </div>
                            <div id="div-row-img-escuela-banner-sistema" class="row">
                                <div id="div-principal-img-banner-sistema" class="col-xs-12">
                                    <h3>Imagen del sistema<img id="img-info-sistema" src="Imagenes/adm/info_r.png" title="Información" class="img-info" tabindex="0"/></h3>
                                    <img id="img-banner-sistema" src="Imagenes/banner.png" class="img-responsive img-centrar"/>
                                    <input name="banner" type="file" value="Cambiar" class="input" title="Cambiar" required/>
                                </div>
                            </div>
                            <div id="div-row-img-escuela-firma" class="row">
                                <div id="div-principal-img-firma" class="col-xs-12">
                                    <h3>Imagen de la firma del director<img id="img-info-director" src="Imagenes/adm/info_r.png" title="Información" class="img-info" tabindex="0"/></h3>
                                    <img id="img-firma" src="Imagenes/firmaDirector.png" class="img-responsive img-centrar"/>
                                    <input name="director" type="file" value="Cambiar" class="input" title="Cambiar" required/>
                                </div>
                            </div>
                            <input type="submit" value="Guardar" title="Guardar" class="guardar"/>
                        </form>
                    </div>
                    <div id="div-row-img-carrera" class="row margen-top">
                        <div id="div-col-img-carrera" class="col-xs-12">
                            <img src="Imagenes/adm/carrera.png" class="img-centrada"/>
                        </div>
                    </div>
                    <div id="div-row-carrera" class="row margen-top">
                        <div id="div-col-enviar-carrera" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-enviar-carrera" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-enviar-carrera" class="formularios">
                                <h2>Nueva carrera</h2>
                                <input name="codigo" class="input" placeholder="Código de carrera" title="Código de carrera" alt="Código de carrera" type="text" maxlength="7" required/>
                                <input name="carrera" class="input" placeholder="Carrera" title="Carrera" alt="Carrera" type="text" maxlength="50" required/>
                                <input type="submit" class="guardar" value="Guardar" title="Guardar"/>
                            </form>
                        </div>
                        <div id="div-col-borrar-carrera" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-borrar-carrera" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-borrar-carrera" class="formularios">
                                <h2>Borrar carrera</h2>
                                <select id="select-borrar-carrera" class="input" name="codigo" title="Carrera"></select>
                                <input type="submit" class="guardar" value="Borrar" title="Guardar"/>
                            </form>
                        </div>
                    </div>
                    <div id="div-row-especialidad" class="row margen-top">
                        <div id="div-col-enviar-especialidad" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-enviar-especialidad" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-enviar-especialidad" class="formularios">
                                <h2>Nueva especialidad</h2>
                                <select id="select-nueva-carrera-especialidad" class="input" name="carrera" title="Carrera"></select>
                                <input name="codigo" class="input" placeholder="Código de especialidad" title="Código de especialidad" alt="Código de especialidad" type="text" maxlength="7" required/>
                                <input name="especialidad" class="input" placeholder="Especialidad" title="especialidad" alt="especialidad" type="text" maxlength="50" required/>
                                <input type="submit" class="guardar" value="Guardar" title="Guardar"/>
                            </form>
                        </div>
                        <div id="div-col-borrar-especialidad" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-borrar-especialidad" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-borrar-especialidad" class="formularios">
                                <h2>Borrar especialidad</h2>
                                <select id="select-borrar-carrera-especialidad" class="input" name="carrera" title="Carrera"></select>
                                <select id="select-borrar-especialidad" class="input" name="codigo" title="especialidad"></select>
                                <input type="submit" class="guardar" value="Borrar" title="Guardar"/>
                            </form>
                        </div>
                    </div>
                    <div id="div-row-img-mexico" class="row margen-top">
                        <div id="div-col-img-mexico" class="col-xs-12">
                            <img src="Imagenes/adm/mexico.png" class="img-centrada"/>
                        </div>
                    </div>
                    <div id="div-row-estados" class="row margen-top">
                        <div id="div-col-enviar-estado" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-enviar-estados" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-enviar-estado" class="formularios">
                                <h2>Nuevo estado</h2>
                                <input name="estado" class="input" placeholder="Estado" title="Estado" alt="Estado" type="text" maxlength="60" required/>
                                <input type="submit" class="guardar" value="Guardar" title="Guardar"/>
                            </form>
                        </div>
                        <div id="div-col-borrar-estado" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-borrar-estados" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-borrar-estado" class="formularios">
                                <h2>Borrar estado</h2>
                                <select id="select-estado" class="input" name="codigo" title="Estados"></select>
                                <input type="submit" class="guardar" value="Borrar" title="Borrar"/>
                            </form>
                        </div>
                    </div>
                    <div id="div-row-img-jalisco" class="row margen-top">
                        <div id="div-col-img-jalisco" class="col-xs-12" style="position: relative">
                            <img src="Imagenes/adm/jalisco.png" class="img-centrada"/>
                        </div>
                    </div>
                    <div id="div-row-municipios" class="row margen-top">
                        <div id="div-col-enviar-municipio" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-enviar-municipio" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-enviar-municipio" class="formularios">
                                <h2>Nuevo municipio</h2>
                                <select id="select-estado-municipio-agregar" class="input" title="Estados" name="estado"></select>
                                <input name="municipio" class="input" placeholder="Municipio" title="Municipio" alt="Estado" type="text" maxlength="60" required/>
                                <input type="submit" class="guardar" value="Guardar" title="Guardar"/>
                            </form>
                        </div>
                        <div id="div-col-borrar-municipio" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-borrar-municipio" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-borrar-municipio" class="formularios">
                                <h2>Borrar municipio</h2>
                                <select id="select-estado-municipio-borrar" name="estado" class="input" title="Estados"></select>
                                <select id="select-municipio" class="input" title="Municipio" name="codigo">
                                    <option value="0">Municipio</option>
                                </select>
                                <input type="submit" class="guardar" value="Borrar" title="Borrar"/>
                            </form>
                        </div>
                    </div>
                   <div id="div-row-img-idioma" class="row margen-top">
                        <div id="div-col-img-idioma" class="col-xs-12" style="position: relative">
                            <img src="Imagenes/adm/idiomas.png" class="img-centrada"/>
                        </div>
                    </div>
                    <div id="div-row-idioma" class="row margen-top">
                        <div id="div-col-enviar-idioma" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-enviar-idioma" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-enviar-idioma" class="formularios">
                                <h2>Nuevo idioma</h2>
                                <input name="codigo" class="input" placeholder="Código del idioma" title="Código del idioma" alt="Código del idioma" maxlength="6" type="text" required/>
                                <input name="idioma" class="input" placeholder="idioma" title="idioma" alt="idioma" type="text" maxlength="60" required/>
                                <input type="submit" class="guardar" value="Guardar" title="Guardar"/>
                            </form>
                        </div>
                        <div id="div-col-borrar-idioma" class="col-lg-6 col-sx-12 div-contenedor">
                            <img id="img-borrar-idioma" src="Imagenes/loading45.gif" class="img-centrada-oculta loading"></img>
                            <form id="frm-borrar-idioma" class="formularios">
                                <h2>Borrar idioma</h2>
                                <select id="select-idioma-borrar" name="codigo" class="input" title="idioma"></select>
                                
                                <input type="submit" class="guardar" value="Borrar" title="Borrar"/>
                            </form>
                        </div>
                    </div> 
                </div> 
            </div>
            </div>
    </body>
    <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
    <script src="js/sha512.js" type="text/javascript"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/funciones_adm.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.slimscroll.min.js"></script>
    <script src="js/jquery.ba-bbq.js" type="text/javascript"></script>
    <script type="text/javascript">
    $("document").ready(function() {
        dt_escuela();
        $(function(){
            var tabContainers = $('div.contenedor > div');
            // creamos un nuevo evento y lo incluimos al browser
            $(window).bind('hashchange', function () {
               // nuestra variable no la sacamos del <a> sino de la URL y dejamos el primero seleccionado
               var hash = window.location.hash || '#primero';
               // el resto es prácticamente lo mismo
               tabContainers.hide();
               $(hash).show();
               $('div.tab a').removeClass('active');
               $('a[href='+hash+']').addClass('active');
            });
            // ejecutamos este nuevo evento 'hashchange' mediante un trigger
            $(window).trigger('hashchange');
            });
	});
    </script>
    <script type="text/javascript">
        var alto_img=$('#div-img-banner').height();//alto de la img principal
        var $pos = alto_img+50;
        var no_control_;
        /*para el menu fixed es necesario conocer la altura del menu dependiendo del tipo de pantalla
         ya que cuando el usuario se desplaza hacia abajo se crea un relleno para evitar que todo el contenido
        se mueva una vez que el buscador adquiere la propiedad fixed por ello se calcula el alto de la banner principal*/
        $('#div-principal-empresa-completa').css({'top':$pos+$('#div-principal-buscador').height()+'px'});
        var min_height=$(window).height()-$pos;//alto de contenido principal en base a la pantalla donde se ve
        //alto del relleno usado en la barra búsqueda fixed
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
                 $('#div-principal-empresa-completa').css({'top':$pos+$('#div-principal-buscador').height()+'px'});
             }
               else {
                 $('#div-relleno').show();  
                 $('#div-principal-buscador').addClass('div-scroll-activo');
                 $('#div-principal-empresa-completa').css({'top':$('#div-principal-buscador').height()+'px'});
               }
             });
        $(window).resize(function(){//calcular altura en base a la distancia de la barra de busqueda y el inicio de la pagina
            alto_img=$('#div-img-banner').height();
            $pos = alto_img+50;
            setTimeout("$('#div-relleno').height($('#div-principal-buscador').height());\n\
            $('#div-principal-empresa-completa').css({'top':$pos+$('#div-principal-buscador').height()+'px'});",300);
        });
       
});
    </script>
    <script type="text/javascript">
        var egresados=1;
        $(document).ready(function(){//buscador principal ocultar al click
            $('#input-buscador').on('focusout',function(){
              setTimeout('ocultar_buscador();',200);
              var div=$('#div-pefil');
              if(div.is(':visible')){
                  $('#div-row-eliminar-egresado').show();
              }
            });
            //buscador
           $('#input-buscador').keyup(function(e){
                if($(this).val().length>2 && e.which!==13){
                    setTimeout('buscar($("#input-buscador").val(),10);',500);            
                    }
                else{
                    setTimeout('ocultar_buscador();',500);
                }
            });
        //mostrar div de egresados
        $('#div-agregar-egresado').on('click',function(){
            $('#div-principal-agregar-egresado').show();
            $('#input-no-control1').focus();
        });
        $('#div-cerrar-agregar-egresado').on('click',function(){
            $('#div-principal-agregar-egresado').hide();
        });
        $('#div-cerrar-agregar-egresado').on('keypress',function(e){
          if(e.which===13)  
            $('#div-principal-agregar-egresado').hide();
        });
        $('#div-agregar-egresado').on('keypress',function(e){
            if(e.which===13){
                $('#div-principal-agregar-egresado').show();
                $('#input-no-control1').focus();
            }
            
        });
        function agregar_input(){
            var input=$('#input-no-control1').clone();
            var img_menos=$('<img/>');
            var img_mas=$('<img/>');
            if(egresados<10){
                if(egresados===1)
                    $('#img-mas-egresado1').remove();
                if(egresados>1){
                  $('#img-mas-egresado'+egresados).remove();
                  $('#img-borrar-egresado'+egresados).remove();
                }
                egresados++;
                input.attr('id','input-no-control'+egresados);
                input.attr('name','no_control'+egresados);
                $('#div-no-control').append(input);
                img_mas.attr('tabindex',0);
                img_mas.attr('id','img-mas-egresado'+egresados);
                img_mas.attr('src','Imagenes/adm/mas.png');
                img_mas.addClass('img-mininmizar');
                $('#div-no-control').append(img_mas);
                img_menos.attr('tabindex',0);
                img_menos.attr('id','img-borrar-egresado'+egresados);
                img_menos.attr('src','Imagenes/adm/menos_b.png');
                img_menos.addClass('img-minimizar-borrar');
                $('#div-no-control').append(img_menos);
                
            }else
                alerta('Aviso',$('#alerta'),'Solo 10 alumnos por cada registro');
        }
        //agregar input egresado
        $('#div-no-control').on('click','.img-mininmizar',function(){
           agregar_input(); 
        });
        $('#div-no-control').on('keypress','.img-mininmizar',function(e){
           if(e.which===13)
            agregar_input(); 
        });
        //borrar input de egresado
        function borrar_input(){
            if(egresados>1){
            var img_mas=$('#img-mas-egresado'+egresados).clone();
            var img_menos=$('#img-borrar-egresado'+egresados).clone();
            var input=$('#input-no-control1').clone();
            var img_menos_=document.getElementById('img-borrar-egresado'+egresados);
            img_menos_.remove();
            var img_mas_=document.getElementById('img-mas-egresado'+egresados);
            img_mas_.remove();
            var input_=document.getElementById('input-no-control'+egresados);
            input_.remove();
            egresados--;
            if(egresados===1){
                img_mas.attr('id','img-mas-egresado'+egresados);
                img_mas.attr('name','no-control'+egresados);
                $('#div-no-control').append(img_mas);
                img_mas_borrar=img_mas; 
            }else{
                img_mas.attr('id','img-mas-egresado'+egresados);
                img_mas.attr('name','no_control'+egresados);
                img_mas.attr('tabindex',0);
                $('#div-no-control').append(img_mas);
                img_menos.attr('id','img-borrar-egresado'+egresados);
                img_menos.attr('title','Eliminar');
                img_menos.attr('tabindex',0);
                img_menos.attr('src','Imagenes/adm/menos_b.png');
                img_menos.addClass('img-minimizar-borrar');
                $('#div-no-control').append(img_menos);
            }
            }
        }
        $('#div-no-control').on('click','.img-minimizar-borrar',function(){
          borrar_input();  
        });
        $('#div-no-control').on('keypress','.img-minimizar-borrar',function(e){
          if(e.which===13)
            borrar_input();  
        });
        // estados
        $('#frm-enviar-estado').submit(function(e){
            e.preventDefault();
            nuevo_estado();
        });
        // carrera
        $('#frm-enviar-carrera').submit(function(e){
            e.preventDefault();
            nueva_carrera();
        });
        $('#frm-borrar-carrera').submit(function(e){
            e.preventDefault();
            confirmar_borrar_carrera();
        });
        // especialidad
        $('#frm-enviar-especialidad').submit(function(e){
            e.preventDefault();
            nueva_especialidad();
        });
        $('#frm-borrar-especialidad').submit(function(e){
            e.preventDefault();
            if($('#select-borrar-especialidad').val()!=='0'){
                confirmar_borrar_especialidad(); 
            }else
                alerta('Verifique',$('#alerta'),'Escoja una especialidad');
        });
        //idioma
        $('#frm-enviar-idioma').submit(function(e){
            e.preventDefault();
            nuevo_idioma();
        });
        $('#frm-borrar-idioma').submit(function(e){
            e.preventDefault();
            confirmar_borrar_idioma();
        });
        $('#frm-borrar-estado').submit(function(e){
            e.preventDefault();
            if($('#select-estado').val()!=='0'){
                confirmar_borrar_estado(); 
            }else
                alerta('Verifique',$('#alerta'),'Escoja un estado');
        });
        //municipios
        $('#frm-enviar-municipio').submit(function(e){
            e.preventDefault();
            if($('#select-estado-municipio-agregar').val()!=='0'){
                nuevo_municipio();
            }else
                alerta('Verifique',$('#alerta'),'Escoja un estado');
        });
        $('#frm-borrar-municipio').submit(function(e){
            e.preventDefault();
            if($('#select-estado-municipio-borrar').val()!=='0'){
                if($('#select-municipio').val()!=='0')
                    confirmar_borrar_municipio();
                else
                    alerta('Verifique',$('#alerta'),'Escoja un municipio');
            }else
                alerta('Verifique',$('#alerta'),'Escoja un estado');
        });
        //borrar administrador
        $('#frm-borrar-administrador').submit(function(e){
            e.preventDefault();
            if($('#select-administrador').val()!=="0")
                confirmar_borrar_adm($('#select-administrador').val());
            else
                alerta('Error',$('#alerta'),'Valor de administrador incorrecto');
        });
        //guardar datos escuela
        $('#frm-datos-escuela').submit(function(e){
            e.preventDefault();
            guardar_escuela();
        });
        //guardar img sistema
       $('#frm-img-institucion').submit(function(e){
           e.preventDefault();
           guardar_img();
       });
        //editar administrador
        $('#frm-editar-administrador').submit(function(e){
            e.preventDefault();
            if(igualdad_editar===1)
                    if($('#select-administrador').val()!=="0")
                        editar_administrador();
                else
                    alerta('Error',$('#alerta'),'Valor de administrador incorrecto');
            else
                alerta('Incompleto',$('#alerta'),'Las contraseñas no coinciden');
        });
        //enviar nuevos egresados
        $('#form-agregar-egresado').submit(function(e){
          e.preventDefault();
          nuevos_egresados(egresados);
        });
        //nuevos administradores
        $('#frm-agregar-administrador').submit(function(e){
            e.preventDefault();
            if(igualdad===1)
                nuevo_administrador();
            else
                alerta('Incompleto',$('#alerta'),'Las contraseñas no coinciden');
        });
        $('#input-administrador-password').focus(function(){
           $('#pass_nuevo_reafirmar').val('');
            $('#span_pass').hide();
            $('#span-pass-correcto').hide();
        });
        var igualdad=0;
        $(function(){//validar igualdad de password nuevos
            $('#pass_nuevo_reafirmar').keyup(function(){               
                if($(this).val()===$('#input-administrador-password').val())
                {
                    $('#span_pass').hide();
                    $('#span-pass-correcto').show();
                    igualdad=1;
                }else
                {   
                    $('#span_pass').show();
                    $('#span-pass-correcto').hide();
                    igualdad=0;
                }    
                });      
            });
        var igualdad_editar=0;
        $(function(){//validar igualdad de password nuevos editar adm
            $('#pass_nuevo_reafirmar-editar').keyup(function(){               
                if($(this).val()===$('#input-administrador-password-editar').val())
                {
                    $('#span_pass-editar').hide();
                    $('#span-pass-correcto-editar').show();
                    igualdad_editar=1;
                }else
                {   
                    $('#span_pass-editar').show();
                    $('#span-pass-correcto-editar').hide();
                    igualdad_editar=0;
                }    
                });      
            });
            //mostrar input reafirmación de password
        $('#div-agregar-egresado').keypress(function(e){
            if(e.which===13){
                $('#div-principal-agregar-egresado').show();
                $('#input-no-control1').focus();
            }
        });
        //buscar todos los registros
        $('#div-buscar-todos').click(function(){
           buscar_todos(); 
        });
        //efectos de hover con el focus
        $('#div-buscar-todos').focus(function(){
            $('#div-buscar-todos').addClass('div-buscar-todos-hover');
        });
        $('#div-buscar-todos').focusout(function(){
            $('#div-buscar-todos').removeClass('div-buscar-todos-hover');
        });
        $('#div-buscar-todos').keypress(function(e){
            if(e.which===13){
             buscar_todos();    
            }
        });
        //buscador secundario
        $('#div-resultados').on('click','.div-resultado',function (){
            var no_control=$(this).attr('id').slice(13);
            cargar_datos_egresado(no_control);          
        });
        $('#div-resultados').on('keypress','.div-resultado',function (e){
            if(e.which===13){
                var no_control=$(this).attr('id').slice(13);
                cargar_datos_egresado(no_control); 
            }
        });
        $('#div-resultados-avanzado').on('click','.div-resultado',function (){
            var no_control=$(this).attr('id').slice(13);
            cargar_datos_egresado(no_control);          
        });
        $('#div-resultados-avanzado').on('keypress','.div-resultado',function (e){
            if(e.which===13){
                var no_control=$(this).attr('id').slice(13);
                cargar_datos_egresado(no_control);
            }
        });
        //ver más resultados todos
        $('#div-resultados-avanzado').on('click','#ver-mas',function (){
            buscar_todos_mas();         
        });
        $('#div-resultados-avanzado').on('keypress','#ver-mas',function (e){
            if(e.which===13)
                buscar_todos_mas();         
        });
        //ver más resultados filtro
         $('#div-resultados-avanzado').on('click','#ver-mas-avanzado',function (){
            buscar_avanzado_mas($("#input-buscador").val(),20);         
        });
        $('#div-resultados-avanzado').on('keypress','#ver-mas-avanzado',function (e){
            if(e.which===13)
                buscar_avanzado_mas($("#input-buscador").val(),20);         
        });
        //buscador principal
        $('#div-img-encontrar').click(function(){
            if($("#input-buscador").val().length>2)
            {
                $('#div-pefil').hide();
                buscar_avanzado($("#input-buscador").val(),20);
            }else
                alerta('Alerta',$('#alerta'),'Es necesario una palabra de más de tres letras para una buena búsqueda');
        });
        $('#div-img-encontrar').keypress(function(e){
            if(e.which===13){
                if($("#input-buscador").val().length>2)
            {
                $('#div-pefil').hide();
                buscar_avanzado($("#input-buscador").val(),20);
            }else
                alerta('Alerta',$('#alerta'),'Es necesario una palabra de más de tres letras para una buena búsqueda');
            }
        });
        $('#div-img-encontrar').focus(function(){
            $('#div-img-encontrar').addClass('div-img-encontrar-hover');
            $('#img-encontrar').attr('src','Imagenes/adm/buscar.png');
        });
        $('#div-img-encontrar').focusout(function(){
            $('#div-img-encontrar').removeClass('div-img-encontrar-hover');
            $('#img-encontrar').attr('src','Imagenes/adm/buscar_negro.png');
        });
        $('#input-buscador').on('keypress',function (e){
            if(e.which===13){
                if($("#input-buscador").val().length>2)
            {
                $('#div-pefil').hide();
                ocultar_buscador();
                buscar_avanzado($("#input-buscador").val(),20);
            }else
                alerta('Alerta',$('#alerta'),'Es necesario una palabra de más de tres letras para una buena búsqueda');
            }        
        });
        //alertas
        $('#form-estadisticas-fecha-carrera').submit(function(){
           alerta('Espere',$('#alerta'),'Espere el proceso puede tardar alrdedor de dos minutos de pendiendo los registros encontrados') ;
        });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            //solicitar todo los dt de la empresa
            $('#div-datos-empresa').on('click','.div-datos-empresa-resultado',function(){
                var codigo_empresa=$(this).attr('id').slice(18);
                todo_dt_empresa(codigo_empresa);
            });
            $('#div-datos-empresa').on('keypress','.div-datos-empresa-resultado',function(e){
                if(e.which===13){    
                    var codigo_empresa=$(this).attr('id').slice(18);
                    todo_dt_empresa(codigo_empresa);
                }
            });
            //borrar_egresado
            $('#div-eliminar-egresado').on('click',function(){
                confirmar_borrar_egresado(no_control_);
            });
            $('#div-eliminar-egresado').on('keypress',function(e){
                if(e.which===13)
                    confirmar_borrar_egresado(no_control_);
            });
            //cerrar div de datos completos de empresa
            $('#div-principal-empresa-completa').on('click','.cancel',function(){
                $('#div-principal-empresa-completa').fadeOut();             
            });
            $('#div-principal-empresa-completa').on('keypress','.cancel',function(e){
                if(e.which===13)
                    $('#div-principal-empresa-completa').fadeOut();             
            });
            //ocultar buscador en el uso tab
            $('#div-principal-foto').focus(function(){
                ocultar_buscador();
            });
            //mostrar div de ingeniería
            $('#div-img-ingenieria').click(function(){
                $('#div-img-ingenieria').addClass('div-img-seleccion-hover');
                $('#div-img-posgrado').removeClass('div-img-seleccion-hover');           
                $('#div-principal-posgrado').hide();    
                $('#div-datos-academicos').show();
                $('#div-principal-ingenieria').show();

            });
            $('#div-img-ingenieria').keypress(function(e){
                if(e.which===13){
                    $('#div-img-ingenieria').addClass('div-img-seleccion-hover');
                    $('#div-img-posgrado').removeClass('div-img-seleccion-hover');           
                    $('#div-principal-posgrado').hide();    
                    $('#div-datos-academicos').show();
                    $('#div-principal-ingenieria').show();
                }

            });
            //mostrar div de posgrado
            $('#div-img-posgrado').click(function(){
                $('#div-img-posgrado').addClass('div-img-seleccion-hover');
                $('#div-img-ingenieria').removeClass('div-img-seleccion-hover');
                $('#div-datos-academicos').hide();
                $('#div-principal-ingenieria').hide();
                $('#div-principal-posgrado').show();

            });
            $('#div-img-posgrado').keypress(function(e){
                if(e.which===13){
                    $('#div-img-posgrado').addClass('div-img-seleccion-hover');
                    $('#div-img-ingenieria').removeClass('div-img-seleccion-hover');
                    $('#div-datos-academicos').hide();
                    $('#div-principal-ingenieria').hide();
                    $('#div-principal-posgrado').show();
                }
            });//mostrar div de posgrado
             $('#img-encontrar').hover(
                       function(){
                           $(this).attr('src','Imagenes/adm/buscar.png');}
                       ,function(){
                           $(this).attr('src','Imagenes/adm/buscar_negro.png');});
                });
            //evaluar seguridad password
            $('#input-administrador-password').keyup(function(){
                evaluar_pass($(this),$("#span-pass-seguridad"),$('#img-ayuda-pass'));
                if($('#input-administrador-password').val().length>0) 
                    $('#pass_nuevo_reafirmar').show();
                else{
                    $('#pass_nuevo_reafirmar').hide();
                    $('#pass_nuevo_reafirmar').val('');
                }
                });
            $('#input-administrador-password-editar').keyup(function(){
                evaluar_pass($(this),$("#span-pass-seguridad-editar"),$('#img-ayuda-pass-editar'));
                if($('#input-administrador-password-editar').val().length>0) 
                    $('#pass_nuevo_reafirmar-editar').show();
                else{
                    $('#pass_nuevo_reafirmar-editar').hide();
                    $('#pass_nuevo_reafirmar-editar').val('');
                }
                });
            //animacion de div agregar
            $('#div-agregar-egresado').hover(function(){
                $('#span-agregar-egresado').fadeIn();
            },function(){
                $('#span-agregar-egresado').fadeOut();
            });
            $('#div-agregar-egresado').focusin(function(){
               $('#span-agregar-egresado').fadeIn(); 
            });
            $('#div-agregar-egresado').focusout(function(){
              $('#span-agregar-egresado').fadeOut(); 
            });
            //animación de div eliminar egresado
            $('#div-eliminar-egresado').hover(function(){
                $('#span-eliminar-egresado').fadeIn();
            },function(){
                $('#span-eliminar-egresado').fadeOut();
            });
            $('#div-eliminar-egresado').focusin(function(){
               $('#span-eliminar-egresado').fadeIn(); 
            });
            $('#div-eliminar-egresado').focusout(function(){
              $('#span-eliminar-egresado').fadeOut(); 
            });
            //mostrar div de frm escuela
            $('#div-datos-escuela').on('click','#img-editar-datos-escuela',function(){
                $('#div-principal-datos-escuela').hide();
                $('#div-principal-frm-datos-escuela').show();
            });
            $('#div-datos-escuela').on('keypress','#img-editar-datos-escuela',function(e){
                if(e.which===13){
                    $('#div-principal-datos-escuela').hide();
                    $('#div-principal-frm-datos-escuela').show();
                }
            });
            //mostrar div de frm escuela
            $('#img-cerrar-frm-datos-escuela').click(function(){
                $('#div-principal-frm-datos-escuela').hide();
                $('#div-principal-datos-escuela').show();
            });
            $('#img-cerrar-frm-datos-escuela').keypress(function(e){
                if(e.which===13){
                    $('#div-principal-frm-datos-escuela').hide();
                    $('#div-principal-datos-escuela').show();    
                }
            });
            //animar objetos
            $('#input-administrador-password').focusin(function(){
                $(this).addClass('muy-debil');
            });
            $('#input-administrador-password').hover(function(){
               $(this).addClass('input-hover'); 
            },function(){
               $(this).removeClass('input-hover');  
            });
             $('#input-administrador-password-editar').focusin(function(){
                $(this).addClass('muy-debil');
            });
            $('#input-administrador-password-editar').hover(function(){
               $(this).addClass('input-hover'); 
            },function(){
               $(this).removeClass('input-hover');  
            });
            $('#div-datos-escuela').on('mouseenter','#img-editar-datos-escuela',function(){
                $(this).attr('src','Imagenes/adm/editar_n.png');
            });
            $('#div-datos-escuela').on('mouseleave','#img-editar-datos-escuela',function(){
                $(this).attr('src','Imagenes/adm/editar_r.png');
            });
            $('#div-datos-escuela').on('focusin','#img-editar-datos-escuela',function(){
                $(this).attr('src','Imagenes/adm/editar_n.png');
            });
            $('#div-datos-escuela').on('focusout','#img-editar-datos-escuela',function(){
                $(this).attr('src','Imagenes/adm/editar_r.png');
            });
            $('#img-cerrar-frm-datos-escuela').hover(function(){
                $(this).attr('src','Imagenes/adm/cancel_a.png');
            },function(){
               $(this).attr('src','Imagenes/adm/cancel.png'); 
            });
            $('#img-cerrar-frm-datos-escuela').focusin(function(){
                $(this).attr('src','Imagenes/adm/cancel_a.png');
            });
            $('#img-cerrar-frm-datos-escuela').focusout(function(){
                $(this).attr('src','Imagenes/adm/cancel.png');
            });
            $('#img-ayuda-pass').click(function(){
                alerta('Recomendaciones',$('#div-recomendaciones'),'');
            });
            $('#img-ayuda-pass-editar').click(function(){
                alerta('Recomendaciones',$('#div-recomendaciones'),'');
            });
            $('.img-info').hover(function(){
                $(this).attr('src','Imagenes/adm/info_a.png');
            },function(){
               $(this).attr('src','Imagenes/adm/info_r.png'); 
            });
            $('.img-info').focusin(function(){
                $(this).attr('src','Imagenes/adm/info_a.png');
            });
            $('.img-info').focusout(function(){
                $(this).attr('src','Imagenes/adm/info_r.png');
            });
            
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        //alertas he info 
        $('#img-info-sistema').click(function(){
            alerta('Información',$('#alerta'),'Las medidas recomendadas son 1350 px de ancho y 150px de alto, de utilizarse otras quizás el sistema rechace las imagenes, para más información consulte la guía de usuario');
        });
        $('#img-info-institucion').click(function(){
            alerta('Información',$('#alerta'),'Las medidas recomendadas son 1000 px de ancho y 120px de alto, de utilizarse otras quizás el sistema rechace las imagenes, para más información consulte la guía de usuario');
        });
        $('#img-info-director').click(function(){
            alerta('Información',$('#alerta'),'Las medidas recomendadas son 256 px de ancho y 90px de alto, de utilizarse otras quizás el sistema rechace las imagenes, para más información consulte la guía de usuario');
        });
        $('#img-info-sistema').keypress(function(e){
           if(e.which===13)
               alerta('Información',$('#alerta'),'Las medidas recomendadas son 1350 px de ancho y 150px de alto, de utilizarse otras quizás el sistema rechace las imagenes, para más información consulte la guía de usuario');
        });
        $('#img-info-institucion').keypress(function(e){
           if(e.which===13)
               alerta('Información',$('#alerta'),'Las medidas recomendadas son 1000 px de ancho y 120px de alto, de utilizarse otras quizás el sistema rechace las imagenes, para más información consulte la guía de usuario');
        });
        $('#img-info-director').keypress(function(e){
           if(e.which===13)
               alerta('Información',$('#alerta'),'Las medidas recomendadas son 256 px de ancho y 90px de alto, de utilizarse otras quizás el sistema rechace las imagenes, para más información consulte la guía de usuario');
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        //cargar dt 
        select_carrera();
        select_administrador();
        select_estados();
        select_idiomas();
        $('#select-estado-municipio-borrar').change(function(){
            select_municipio();
        });
        $('#select-borrar-carrera-especialidad').change(function(){
            select_especialidad();
        });
        setTimeout('select_especialidad_inicio()',2000);
    });
    </script>
    <?php else : echo 'Problemas con tu autenticacion inicia sesión de nuevo'; ?>
<?php endif; } 

