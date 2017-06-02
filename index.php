<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
/* Cualquier duda repecto al código o en que diablos estaba pensando cuando lo hice :) enviar un correo 
 *  con el asunto SE a la siguiente direccion lambetdelta@hotmail.com con el  Ing. Osvaldo Uriel Garcia Gomez*/ 
sec_session_start();
if($mysqli->connect_errno){
    header('Location: error_bd.php');
}else{
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta charset="UTF-8">   
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title>Sistema de Seguimiento de Egresados</title>
<link href="HojasEstilo/estiloInicio.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="HojasEstilo/bootstrap.css">
</head>
    <body class="degradado" id="body"> 
<script type="text/javascript">
   navegador();     
</script>
	<header>
    	<figure>
        	<blockquote>
        	  <p>
        	      <img src="Imagenes/banner_ittj.png"   class="img-responsive" style="margin:auto" />
        	      <img src="Imagenes/titulo_se.png" class="img-responsive" style="margin:auto" alt="">
      	      </p>
      	  </blockquote>
    	</figure>
    </header>
    <section>
        <div class="row" >
            <div id="div-seleccion" class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12" style="margin-top: 5px">
                <div id="egresado" class="animacion" title="EGRESADO" tabindex="0">
                    <span id="span-egresado"class="titulo">Egresado</span>
                </div>
            </div>
        </div>
        <div id="div-row-info" class="row">
            <div id="div-col-info" class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12">
                <img src="Imagenes/index/Se.png" id="img-info-se" title="¿Quién es mi creador?" tabindex="0"/>
            </div>
            <div id="div-col-info-texto" class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12">
                <p >Este sistema fue desarrollado por Osvaldo Uriel Garcia Gomez y Alan Osberto Garcia 
                    Gomez del Instituto Tecnológico de Tlajomulco para cualquier duda ponerse en 
                    contacto al correo lambetdelta@hotmail.com con el asunto Sistema de seguimiento 
                    de egresados </p>
            </div>
        </div>
        <div class="row" >
            <div  id="contenedor" class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-12" >
                <div id="frm_egresado" style="display:none">
                    <a href="restablecer_pass.php" id="span-olvidaste-pass" class="span-password">¿Olvidaste tu contraseña?</a>
                    <form method="post" action="includes/process_login.php" name="login_form" class="egresado">
                        <h2>Sesión</h2>
                        <label>No: control</label><br>
                        <input type="text" maxlength="8" class="egresado" placeholder="Ingrese No: de Control" name="No_control" id="No_control"/><br />
                        <label>Contraseña</label><br>
                        <input type="password" maxlength="20" class="egresado" placeholder="Ingrese Contraseña"  name="password" id="password"/><br />
                        <input type="submit" class="egresado" value="Iniciar" onclick="formhash(this.form, this.form.password);" />
                    </form>
                </div>       
            </div>
        </div>
    </section>
</body>
    <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>
    <script type="text/JavaScript" src="js/funciones.js"></script>
    <script type="text/JavaScript" src="js/bootstrap.js"></script>
    <script type="text/JavaScript" src="js/respond.min.js"></script>
    <script>
$(document).ready(function(){
    $("#egresado").click(function(){//mostrar formularios
        toggleElements('div-row-info','frm_egresado');
    });
    $("#egresado").keypress(function(e){//mostrar formularios
        toggleElements('div-row-info','frm_egresado');
    });
    $("#img-info-se").click(function(){
        $('#div-col-info-texto').slideToggle();
    });
    $("#img-info-se").keypress(function(e){
        if(e.which===13)
            $('#div-col-info-texto').slideToggle();
    });
    $("#img-info-se").hover(function(){
        $(this).attr('src','Imagenes/index/se_enf.png');
    },function (){
        $(this).attr('src','Imagenes/index/SE.png');
    });
    $("#img-info-se").focusin(function(){
        $(this).attr('src','Imagenes/index/se_enf.png');
    });
    $("#img-info-se").focusout(function(){
        $(this).attr('src','Imagenes/index/Se.png');
    });
});

</script>
</html>
<?php }?>
