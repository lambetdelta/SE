    <?php
    include '/includes/db_connect.php';
    include './includes/function_ext.php';
    $token = anti_xss_cad($_GET['token']);
    $no_control =anti_xss_cad($_GET['no_control']); 
    if(validar_token($mysqli, $no_control, $token)):?>

    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width; initial-scale=1.0">
            <title>Sistema de Seguimiento de Egresados</title>
            <link rel="stylesheet" href="HojasEstilo/bootstrap.css" type="text/css">
            <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
            <script src="js/bootstrap.js" type="text/javascript"></script>
            <script src="js/sha512.js" type="text/javascript"></script>
        </head>
        <body>
            <style>
                .guardar{
                    moz-box-shadow:inset 0px 1px 0px 0px #caefab;
                    -webkit-box-shadow:inset 0px 1px 0px 0px #caefab;
                    box-shadow:inset 0px 1px 0px 0px #caefab;
                    background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #77d42a), color-stop(1, #5cb811) );
                    background:-moz-linear-gradient( center top, #77d42a 5%, #5cb811 100% );
                    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77d42a', endColorstr='#5cb811');
                    background-color:#77d42a;
                    -webkit-border-top-left-radius:8px;
                    -moz-border-radius-topleft:8px;
                    border-top-left-radius:8px;
                    -webkit-border-top-right-radius:8px;
                    -moz-border-radius-topright:8px;
                    border-top-right-radius:8px;
                    -webkit-border-bottom-right-radius:8px;
                    -moz-border-radius-bottomright:8px;
                    border-bottom-right-radius:8px;
                    -webkit-border-bottom-left-radius:8px;
                    -moz-border-radius-bottomleft:8px;
                    border-bottom-left-radius:8px;
                    text-indent:0;
                    border:1px solid #268a16;
                    display:inline-block;
                    color:#000;
                    font-size:15px;
                    font-weight:bold;
                    font-style:normal;
                    height:35px;
                    line-height:35px;
                    width:50%;
                    text-decoration:none;
                    text-align:center;
                    text-shadow:1px 1px 0px #aade7c;
                    width: 80%;
            }
                .guardar:hover{
                    background: rgba(210,255,82,1);
                    background: -moz-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(210,255,82,1)), color-stop(100%, rgba(129,255,3,1)));
                    background: -webkit-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: -o-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: -ms-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: radial-gradient(ellipse at center, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d2ff52', endColorstr='#81ff03', GradientType=1 );

                    }
                .guardar:focus{
                    background: rgba(210,255,82,1);
                    background: -moz-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(210,255,82,1)), color-stop(100%, rgba(129,255,3,1)));
                    background: -webkit-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: -o-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: -ms-radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    background: radial-gradient(ellipse at center, rgba(210,255,82,1) 0%, rgba(129,255,3,1) 100%);
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d2ff52', endColorstr='#81ff03', GradientType=1 );

                    }
                #frm-contraseña{
                    border: #093 solid 2px;
                    border-radius:5px;
                    text-align: center;
                    padding: 10px;
                    width: 95%;
                    margin: auto;
                    text-align: center;
                                }
                #div-frm-contraeña{
                    min-height: 200px; 
                    position: relative;
                }
                #img-enviar-pass{
                    position: absolute;
                    top:0;
                    left:0;
                    right:0;
                    bottom:0;
                    margin: auto;
                    display: none;
                }
                .span_pass-incorrecto{
                color:#333333;
                background-color:#ff0033;
                border-radius:5px;
                display:none;
                font-size: 18px;
            }
                #span-pass-correcto{
                    color:#0C0;
                    background-color:#C3FF88;
                    border-radius:5px;
                    display:none;
                    font-size: 18px;
                }

                .muy-debil{
                    background-color:#ff0033;
                    border: 1px solid #ff0033;
                }
                .debil{
                    background-color:#ff9999;
                    border: 1px solid #ff9999;
                }
                .media{
                    background-color: #ffcc66;
                    border: 1px solid #ffcc66;
                }
                .alta{
                    background-color: #00cc33;
                    border: 1px solid #00cc33;
                }
                #div-ayuda-pass{
                    display: none;
                }
                .input-pass{
                    width: 100%;
                    height: 30px;
                    margin: 5px auto 5px auto;
                    border-radius:5px;
                    border: 1px solid #999;
                    background-color:#FFF;
                }
                .input-pass:hover{
                    background-color: #e7e1e1;
                }
                .input-pass:focus{
                    background-color: #e7e1e1;
                }
                #pass_nuevo{
                    width: 100%;
                    height: 30px;
                    margin: 5px auto 5px auto;
                    border-radius:5px;
                    border: 1px solid #999;
                }
                #div-input-pass{
                    text-align: right;
                }
                .span{
                    font-size: 18px;
                    color: #4CAF50;
                    transition: 1s;
                }
                .span:hover{
                    color: #003300;
                    font-size: 22px;
                    background-color:#4CAF50;
                    border-radius:5px;
                    text-decoration: none
                }
            </style>
            <div id="div-encabezado" class="row">
                <div class="col-xs-12">
                    <img src="Imagenes/banner_ittj.png" class="img-responsive" style="margin: auto">
                </div>                
            </div>
            <div class="row">
                <div id="div-frm-contraeña" class="col-lg-8 col-lg-offset-2 col-sm-12">
                     <img src="Imagenes/loading45.gif" id="img-enviar-pass"  />
                    <form id="frm-contraseña">
                        <h2>Contraseña</h2> 
                        <input type="text" placeholder="No: Control" title="No: Control" maxlength="8" class="input-pass" name="no_control" required="Tú número de control"><br>
                        <div id="div-input-pass">                          
                            <input id="pass_nuevo"  type="password" name="nuevo_pass" maxlength="15" title="Nueva contraseña" placeholder="NUEVA CONTRASEÑA"   required="NUEVA CONTRASEÑA">
                                <img tabindex="0" id="img-ayuda-pass"src="Imagenes/ayuda.png" style="float: left"/><span id="span-pass-seguridad"></span>
                        </div>
                        <input id="pass_nuevo_reafirmar"  type="password" maxlength="15" name="nuevo_pass_reafirmar" title="Reafirmar contraseña" placeholder="REAFIRMAR CONTRASEÑA"class="input-pass" style="width:100%;display: none;" required="NUEVA CONTRASEÑA" ><br>
                        <span id="span_pass" class="span_pass-incorrecto">LAS CONTRASEÑAS NO COINCIDEN</span><span id="span-pass-correcto">LAS CONTRASEÑAS COINCIDEN</span><br>
                            <input type="submit" value="ACEPTAR" class="guardar" style="width: 50%">
                    </form>
                     <span id="span-repuesta" class="span"></span> 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                    <div id="div-ayuda-pass">
                    <ul>
                        <li>Procura usar letras <b>mayúsculas y minúsculas</b> combinadas.</li>
                        <li>Agregar <b>números</b> aumenta más la seguridad.</li>
                        <li>Por último no olvides <b>caracteres especiales</b> como $, ! # darán más seguridad a tu password.</li>
                    </ul>
                </div>
                </div>
            </div>
        </body>
        <script type="text/javascript">
        $(document).ready(function(){
            $(function(){//validar igualdad de password nuevos
            $('#pass_nuevo_reafirmar').keyup(function(){               
                if($(this).val()===$('#pass_nuevo').val())
                {
                    $('#span_pass').hide();
                    $('#span-pass-correcto').show();
                    igualdad='1';
                }else
                {   
                    $('#span_pass').show();
                    $('#span-pass-correcto').hide();
                    igualdad='0';
                }    
                });      
            });
        $('#img-ayuda-pass').click(function(){
            $('#div-ayuda-pass').show();
        });
        $('#img-ayuda-pass').keypress(function(e){
            if(e.which===13){
                $('#div-ayuda-pass').show();
            }
        });
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
            
            $('#pass_nuevo').keyup(function(){
                evaluar_pass($(this));
                });
            $('#pass_nuevo').blur(function(){//evaluar longitud del pass nuevo
                if($('#pass_nuevo').val().length>0) 
                    $('#pass_nuevo_reafirmar').show();
                else{
                    $('#pass_nuevo_reafirmar').hide();
                    $('#pass_nuevo_reafirmar').val('');
                }
            });
            $('#pass_nuevo').focus(function(){//mostrar reafirmacion de pass
                $('#pass_nuevo_reafirmar').val('');
                $('#pass_nuevo_reafirmar').show();
                $('#span_pass').hide();
                $('#span-pass-correcto').hide();
            });
            $('#pass_nuevo').keypress(function(e){
                    tecla = (document.all) ? e.keyCode : e.which;
                    if (tecla===32) return false;    
            });
            $('#frm-contraseña').submit(function(e){//enviar formulario de pass
                e.preventDefault();
                if(igualdad==='1' && $('#pass_nuevo').length>0){
                    nueva_contraseña(); 
                    $('#span-pass-seguridad').html('');
                    $('#pass_nuevo').removeClass();}
                else
                    alert_('Datos Incompletos',$('#alert_academico'),250);    
                igualdad='0';
            });
            
            function nueva_contraseña(){
                try{
                    $("#frm-contraseña").hide();//ocultar campos
                    $("#img-enviar-pass").show();
                    var p = document.createElement("input"); 
                    p.name = "p";
                    p.type = "hidden";
                    p.value = hex_sha512($('#pass_nuevo_reafirmar').val());
                    $("#frm-contraseña").append(p); 
                    var x = document.createElement("input"); 
                    x.name = "x";
                    x.type = "hidden";
                    x.value = hex_sha512($('#pass_nuevo').val());
                    $("#frm-contraseña").append(x);
                    $('#pass_nuevo').val('no ver');
                    $('#pass_nuevo_reafirmar').val('no ver');
                    $.post('ajax/recuperar_contrasena.php',$('#frm-contraseña').serialize())
                        .fail(function(jqXHR, textStatus, errorThrown){
                            $("#img-enviar-pass").hide();
                            limpiaForm($('#frm-contraseña'));
                            $("#frm-contraseña").show();
                            ajax_error(jqXHR, textStatus,$('#span-repuesta'));
                        })
                        .done(function(data){
                        respuesta=$.parseJSON(data);
                            if(respuesta.respuesta==='hecho'){
                                $("#img-enviar-pass").hide();
                                $('#span-repuesta').html(respuesta.mensaje+' redireccionando...');
                                setTimeout('window.location="index.php";',5000);

                            }
                            else
                            {   $("#img-enviar-pass").hide();
                                $('#span-repuesta').html(respuesta.mensaje);
                                limpiaForm($('#frm-contraseña'));
                                $("#frm-contraseña").show();
                            }
                        });
                    p.remove(); 
                    x.remove();
                    $('#span_pass').hide();
                    $('#span-pass-correcto').hide();    
                }catch(e){
                     $("#img-enviar-pass").hide();
                    $('#span-repuesta').html(e);
                    limpiaForm($('#frm-contraseña'));
                    $("#frm-contraseña").show();    
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
			});//FIN EACH
}//FIN FUNCIÓN
        });
        </script>
        <script type="text/javascript">
            function ajax_error(jqXHR,textStatus,div){
            if (jqXHR.status === 0) {
                div.html('ERROR:SIN RESPUESTA DEL SERVIDOR');
            } else if (jqXHR.status === 404) {
                div.html('ERROR:PÁGINA NO ENCONTRADA [404]');

            } else if (jqXHR.status === 500) {
                div.html('ERROR:FALLA DEL SERVIDOR[505]');
                //Internal Server Error [500]

            } else if (textStatus === 'parsererror') {
                div.html('ERROR:DATOS RECIBIDOS CORRUPTOS');
    //            Requested JSON parse failed

            } else if (textStatus === 'timeout') {
                div.html('ERROR:TIEMPO DE RESPUESTA EXPIRADO');
    //           Time out error

            } else if (textStatus === 'abort') {

    //            alert('Ajax request aborted.');

            } else {
                div.html('ERROR INESPERADO:'+ jqXHR.responseText+'');
           }
    }
        </script>
    </html>

    <?php else: ?>
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width; initial-scale=1.0">
            <title>Sistema de Seguimiento de Egresados</title>
            <link rel="stylesheet" href="HojasEstilo/bootstrap.css" type="text/css">
            <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
            <script src="js/bootstrap.js" type="text/javascript"></script>
            <script src="js/sha512.js" type="text/javascript"></script>
        </head>
        <body>
            <div id="div-encabezado" class="row">
                <div class="col-xs-12">
                    <img src="Imagenes/banner_ittj.png" class="img-responsive" style="margin: auto">
                </div>                
            </div>
            <div class="row">
                <div id="div-contenido">
                    <span class="span">EL enlace que tratas de usar ya expiró solicita uno nuevo en el siguiente enlace </span><a href="restablecer_pass.php">NUEVA CONTRASEÑA</a>
                </div>
            </div>
        </body>
    </html>
    <?php endif;