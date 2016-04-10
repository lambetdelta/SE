    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
    <meta charset="UTF-8">   
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <title>Sistema de Seguimiento de Egresados</title>
    <link href="HojasEstilo/estiloRestablecer.css" rel="stylesheet" type="text/css" />
    <link href="HojasEstilo/bootstrap.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <img src="Imagenes/banner_ittj.png" class="img-responsive" style="margin:auto"/>
        </header>
        <div class="row">
            <div id="div-contenedor-frm-email" class='col-lg-6 col-lg-offset-3 col-xs-12' style="min-height: 230px;position: relative">
                <img id="img-enviar-email" src="Imagenes/loading45.gif" class="enviar"/>
                <form id="frm-email">
                    <h2>Solicitud de reseteo de contraseña</h2>
                    <input id="input-no-control" name="no_control"type="number" class="frm-email" title="No: de control"  placeholder='No: de Control' maxlength="8"required></input>
                    <input id="input-email" name="email" type="email" title="Email" class="frm-email" placeholder='Email' maxlength="30" required></input>
                    <input  type="submit"class="guardar" value="Enviar"></input>
                </form>
            </div>
        </div>
        <div class="row">
            <div class='col-lg-6 col-lg-offset-3 col-xs-12'>
                <p id="span-repuesta-email">UNO</p>
            </div>
        </div>
    </body>
        <script>
        $('document').ready(function(){
            $('#frm-email').submit(function(e){
                try{
                   e.preventDefault();
                $('#frm-email').hide();
                $('#span-repuesta-email').removeClass();
                $('#img-enviar-email').show();
                $.post('ajax/validar_email.php',($('#frm-email').serialize()))
                        .fail(function(jqXHR, textStatus, errorThrown){
                            $('#img-enviar-email').hide();
                            limpiaForm($('#frm-email'));
                            $('#frm-email').show();
                            $('#span-repuesta-email').addClass('span-respuesta-email-incorrecto');
                            $('#span-repuesta-email').show();
                            setTimeout('$("#span-repuesta-email").fadeOut();',10000); 
                            ajax_error(jqXHR, textStatus,$('#span-repuesta-email'));
                        })
                        .done(function(datos){
                            respuesta=$.parseJSON(datos);
                            if(respuesta.respuesta==='hecho')
                            {
                                $('#img-enviar-email').hide();
                                limpiaForm($('#frm-email'));
                                $('#frm-email').show();
                                $('#span-repuesta-email').html(respuesta.mensaje);
                                $('#span-repuesta-email').addClass('span-respuesta-email-correcto');
                                $('#span-repuesta-email').show();
                                setTimeout('$("#span-repuesta-email").fadeOut();',10000);
                            }
                            else
                            {
                                $('#img-enviar-email').hide();
                                limpiaForm($('#frm-email'));
                                $('#frm-email').show();
                                $('#span-repuesta-email').html(respuesta.mensaje);
                                $('#span-repuesta-email').addClass('span-respuesta-email-incorrecto');
                                $('#span-repuesta-email').show();
                                setTimeout('$("#span-repuesta-email").fadeOut();',10000);
                            }
                        }); 
                }catch(e){
                    $('#img-enviar-email').hide();
                    limpiaForm($('#frm-email'));
                    $('#frm-email').show();
                    $('#span-repuesta-email').html(e);
                    $('#span-repuesta-email').addClass('span-respuesta-email-incorrecto');
                    $('#span-repuesta-email').show();
                    setTimeout('$("#span-repuesta-email").fadeOut();',10000);    
                }
            });
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