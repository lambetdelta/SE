<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php'; 
sec_session_start();
if($mysqli->connect_errno){
    header('Location: error_bd.php');
}else{
?>
<?php if (login_check($mysqli) == true) : ?>
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/AjaxUpload.2.0.min.js" type="text/javascript"></script>  
<script src="js/moment.js" type="text/javascript"></script>
<script src="js/funciones.js" type="text/javascript"></script>
<script src="js/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="js/jquery.jrumble.1.3.min.js" type="text/javascript"></script>
<script type="text/JavaScript" src="js/bootstrap.js"></script>
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/bootbox.min.js"></script> 
<script src="js/jquery.ba-bbq.js" type="text/javascript"></script>
<script type="text/javascript">
$("document").ready(function() { 
	var no_control=<?php echo $_SESSION['No_control'] ?>;//cargar variable
	inicio(no_control);
	dispositivo();
	var foto=<?php $foto=cargar_foto($mysqli,$_SESSION['No_control']);echo $foto?>;
	$('#foto_egresado').removeAttr('scr');
	$("#foto_egresado").attr('src',foto);
	var id_social;
	var tipo="-";
        var igualdad='0';
        var pass_valido='0';
	var id_historial;
	var tipo_empresa='-';
	var tipo_historial='-';
	var tipo_social='-';
	$("#no_control").val(no_control);
	$('#estados').change(function(){//cargar select municipios con ajax
		if($('#estados').val()!=='1')
                    cargar_municipios();
                else{
                   $('#Municipios').html('');
                   $('#Municipios').append('<option value="1">Municipio</option>'); 
               } 
		});	
	$('#carrera').change(function(){//cargar select especialidad con ajax
		cargar_especialidad();
		});		
        $('#img-ayuda-pass').click(function(){
            alert_('Recomedaciones',$('#div-ayuda-pass'),250);
        });
        $('#img-ayuda-pass').keypress(function(e){
            if(e.which===13){
                alert_('Recomedaciones',$('#div-ayuda-pass'),250);
            }
        });
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
        
        $('#frm_pass').submit(function(e){//!importante usar nueva clase
          e.preventDefault();
          if(igualdad==='1' && $('#pass_nuevo').length>0){
            nueva_contraseña(no_control); $('#span-pass-seguridad').html('');$('#pass_nuevo').removeClass();}
          else
              alert_('Datos Incompletos',$('#alert_academico'),250);    
          igualdad='0';
        });
	//funciones click	
	/*-----------personales--------*/
	/*--------empresa-----*/
	$("#div_dt_empresa").on('click',".agregar_carrera",function(){// click agregar empresa
            $('#div_dt_empresa_editar').hide();
            show_empresa();
            $("#frm_empresa").fadeIn(2000);
            document.getElementById('frm_empresa').dataset.registro=null;
            setTimeout("$('#input-nombre-empresa').focus();",1000);
        });
        $("#div_dt_empresa").on('keypress',".agregar_carrera",function(e){// click agregar empresa
            if(e.which===13){
                $('#div_dt_empresa_editar').hide();
                show_empresa();
                $("#frm_empresa").fadeIn(2000);
                document.getElementById('frm_empresa').dataset.registro=null;
                setTimeout("$('#input-nombre-empresa').focus();",1000);
            }
        });
	$("#div_dt_empresa").on('click',".editar_empresa",function(){//editar datos empresa
            var id=$(this).attr('id');
            id=id.slice(18);
            $("#div_dt_empresa_editar").show();
            show_empresa();
            $("#frm_empresa").fadeIn(2000);
            setTimeout("$('#input-nombre-empresa').focus();",1000);
            dt_empresa_editar(no_control,id);
            document.getElementById('frm_empresa').dataset.registro=id;
        });
        $("#div_dt_empresa").on('keypress',".editar_empresa",function(e){//editar datos empresa
            if(e.which===13){
                var id=$(this).attr('id');
                id=id.slice(18);
                $("#div_dt_empresa_editar").show();
                show_empresa();
                $("#frm_empresa").fadeIn(2000);
                setTimeout("$('#input-nombre-empresa').focus();",1000);
                dt_empresa_editar(no_control,id);
                document.getElementById('frm_empresa').dataset.registro=id;
            }
        });
	$("#div_dt_empresa").on('click',".elimnar_empresa",function(){//eliminar  empresa
            var id=$(this).attr('id');
            id=id.slice(18);
            confirmar_empresa(no_control,id);
        });
        $("#div_dt_empresa").on('keypress',".elimnar_empresa",function(e){//eliminar  empresa
            if(e.which===13){
                var id=$(this).attr('id');
                id=id.slice(18);
                confirmar_empresa(no_control,id);
            }
        });
	/*--------historial-----*/	
	$("#div_dt_historial_empresa").on('click',".editar_empresa",function(){//editar historial 
            $("#div_dt_historial_editar").show();
            id_historial=$(this).attr('id');
            id_historial=id_historial.slice(21);
            var div='div_historial_empresa'+id_historial ;
            document.getElementById("div_dt_historial_editar").innerHTML=document.getElementById(div).innerHTML;
            ocultar();
            document.getElementById('frm_historial').dataset.registro=id_historial;
            show_historial();
            $('#input-nombre-historial').focus();
        });
        $("#div_dt_historial_empresa").on('keypress',".editar_empresa",function(e){//editar historial 
            if(e.which===13){
                $("#div_dt_historial_editar").show();
                id_historial=$(this).attr('id');
                id_historial=id_historial.slice(21);
                var div='div_historial_empresa'+id_historial ;
                document.getElementById("div_dt_historial_editar").innerHTML=document.getElementById(div).innerHTML;
                ocultar();
                document.getElementById('frm_historial').dataset.registro=id_historial;
                show_historial();
                $('#input-nombre-historial').focus();
            }
        });
	$("#div_dt_historial_empresa").on('click',".elimnar_empresa",function(){//eliminar de historial 
            id_historial=$(this).attr('id');
            id_historial=id_historial.slice(21);
            confirmar_historial(no_control,id_historial);
        });
        $("#div_dt_historial_empresa").on('keypress',".elimnar_empresa",function(e){//eliminar de historial 
            if(e.which===13){
                id_historial=$(this).attr('id');
                id_historial=id_historial.slice(21);
                confirmar_historial(no_control,id_historial);
            }
        });
	$("#div_dt_historial_empresa").on('click',".agregar_carrera",function(){// click agregar historial empresa
            show_historial();
            document.getElementById('frm_historial').dataset.registro=null;
            $("#div_dt_historial_editar").hide();
            $('#input-nombre-historial').focus();
        });
        $("#div_dt_historial_empresa").on('keypress',".agregar_carrera",function(e){// click agregar historial empresa
            if(e.which===13){
                show_historial();
                document.getElementById('frm_historial').dataset.registro=null;
                $("#div_dt_historial_editar").hide();
                $('#input-nombre-historial').focus();
            }
        });
	$("#img_cerrar_frm_historial").click(function() {
            limpiaForm($("#frm_historial"));
            show_historial();
            setTimeout('mostrar();',500);    
        });
        $("#img_cerrar_frm_historial").keypress(function(e) {
            if(e.which===13){
                limpiaForm($("#frm_historial"));
                show_historial();
                setTimeout('mostrar();',500); 
            }
        });
	/*--------social-----*/
	$("#img_cerrar_frm_social").click(function(e) {
            limpiaForm($("#frm_social")); 
            show_social();  
        });
        $("#img_cerrar_frm_social").keypress(function(e) {
            if(e.which===13){
                limpiaForm($("#frm_social")); 
                show_social();
            }  
        });
	$("#div_dt_social").on('click',".agregar_carrera",function(){// click agregar social 
            show_social(); 
            document.getElementById('frm_social').dataset.registro=null;
            $('#input-nombre-asociacion').focus();
        });
        $("#div_dt_social").on('keypress',".agregar_carrera",function(e){// click agregar social 
            if(e.which===13){
                show_social(); 
                document.getElementById('frm_social').dataset.registro=null;
                $('#input-nombre-asociacion').focus();
            }	
        });
	$("#div_dt_social").on('click',".elimnar_empresa",function(){//eliminar de historial 
            id_social=$(this).attr('id');
            id_social=id_social.slice(19);
            confirmar_social(no_control,id_social);
        });
        $("#div_dt_social").on('keypress',".elimnar_empresa",function(e){//eliminar de historial 
            if(e.which===13){
                id_social=$(this).attr('id');
                id_social=id_social.slice(19);
                confirmar_social(no_control,id_social);
            }
        });
}/*fin de load*/);
</script>
<script type="text/javascript">
		$("document").ready(function() {
		
		//////////////////eventos del div empres
		$("#img_agregar_requisitos").click(function(){
			AgregarCampos();
			});
                $("#img_agregar_requisitos").keypress(function(e){
			if(e.which===13)
                            AgregarCampos();
			});
			
		$("#frm_empresa").on('click','.eliminar_requisito',function(){//eliminar select de requisitos
			var id=$(this).attr('id');
			id=id.substring(3,13);
			var img_clone=$(this).clone();
			eliminar_select(id,img_clone);
			$(this).remove();
			});
                $("#frm_empresa").on('keypress','.eliminar_requisito',function(e){//eliminar select de requisitos
			if(e.which===13){
                            var id=$(this).attr('id');
                            id=id.substring(3,13);
                            var img_clone=$(this).clone();
                            eliminar_select(id,img_clone);
                            $(this).remove();
                        }
			});
		//evento click
		$("#img_cancelar_empresa").click(function() {
                    $("#frm_empresa").fadeOut(2000);
                    limpiaForm($("#frm_empresa"));
                    show_empresa();    
		});
                $("#img_cancelar_empresa").keypress(function(e) {
                    if(e.which===13){
                        $("#frm_empresa").fadeOut(2000);
                        limpiaForm($("#frm_empresa"));
                        show_empresa();
                    }    
		});
		$("#estado_empresa").change(function(){//cargar municipios
			if($("#estado_empresa").val()!=='1')
                            cargar_municipios_empresa();
                        else{
                            $('#municipio_empresa').html('');
                            $('#municipio_empresa').append('<option value="1">Municipio</option>'); 
                        }
			});	
		//IMAGEN DE EGRESADO
		
		var button = $('#addImage'), interval;
		new AjaxUpload('#addImage', {
                    action: 'ajax/guardar_img_egresado.php',
                    onSubmit : function(file , ext){
                    //mas extensions rar|doc|zip|ppt|docx|pptx|txt|html|mp3|wma|xls|xlsx|pdf
                    if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){
                        // extensiones permitidas
                        alert_('Solo:jpg, png, jpeg',$("#alert_personales"),250);			
                        return false;
                    } else {
                        alert_Bloq('ESPERE POR FAVOR',$('#alert_personales'));
                        $('#foto_egresado').hide();
                        $("#cargando_foto").show();
                        button.hide();
                        this.disable();
                    }
                    },
                    onComplete: function(file,response){
                        button.text('Cambiar Imagen');
                        try{
                        respuesta = $.parseJSON(response);
                        if(respuesta.respuesta === 'done'){
                            $("#cargando_foto").hide();
                            $('#foto_egresado').show();
                            alert_('FOTO GUARDADA',$("#alert_personales"),250);
                            setTimeout('$("#alert_personales").dialog( "close" );',1000);
                            $('#foto_egresado').removeAttr('scr');
                            $('#foto_egresado').attr('src','fotos_egresados/'+ respuesta.fileName);
                            button.show();
                        }
                        else{
                            $("#cargando_foto").hide();
                            $('#foto_egresado').show();
                            $('#span-alert-personales').html(respuesta.mensaje);
                            alert_('ERROR',$("#alert_personales"),250);
                            setTimeout('$("#alert_personales").dialog( "close" );$("#span-alert-personales").html("");',2000);
                            button.show();

                        }	
                    this.enable();
                    }catch(e){
                        $("#cargando_foto").hide();
                        $('#foto_egresado').show();
                        $('#span-alert-personales').html(e);
                        alert_('ERROR',$("#alert_personales"),250);
                        setTimeout('$("#alert_personales").dialog( "close" );',2000);
                        setTimeout('$("#span-alert-personales").html("");',3000);
                        button.show();
                    }
                    }
		});
		$("#a_residencia").click(function(e) {
			$("#div_frm_residencia").slideToggle(1000);
		});
                
	});	
</script>
<script type="text/javascript">//mostrar calendario
datepicker_esp();
 $(function() {
    $( "#datepicker" ).datepicker({});
  });
 $(function() {
    $( "#dp_academico_inicio" ).datepicker({});
  }); 
  $(function() {
    $( "#dp_academico_fin" ).datepicker({});
  });
   $(function() {
    $( "#año_ingreso" ).datepicker({});
	
    $("#div_dt_historial_empresa").slimScroll({
    height: '99%',
	width: '100%',
	distance: '10px' 
    });
	
	 $("#div_dt_social").slimScroll({
    height: '99%',
	width: '100%',
	distance: '10px' 
    });
	
	$("#datos_academicos").slimScroll({
    height: '99%',
	width: '100%',
	distance: '10px' 
    });
	$("#div_dt_posgrado").slimScroll({
    height: '99%',
	width: '100%',
	distance: '10px' 
    });
        $("#img-ayuda-editar").hover(function(){
                $(this).attr('src','Imagenes/edita_amarillo.png');
        }, function(){
                $(this).attr('src','Imagenes/editar.png');
        });
        $("#img-ayuda-cancelar").hover(function(){
                $(this).attr('src','Imagenes/cancelar_rojo.png');
        }, function(){
                $(this).attr('src','Imagenes/cancelar.png');
        });
        $("#img-ayuda-agregar").hover(function(){
                $(this).attr('src','Imagenes/agregar_amarillo.png');
        }, function(){
                $(this).attr('src','Imagenes/agregar.png');
        });
  });
</script>

<script type="text/javascript">
$("document").ready(function() {
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
$("document").ready(function() {//evaluar passs
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
    $('#a-acc-menu').click(function(){//ocultar acceso rapido menú
        $('#div-accesorapido-menu').fadeOut();  
    }); 
    $('#a-acc-menu').keypress(function(e){//ocultar acceso rapido menú
        if(e.which===13)
            $('#div-accesorapido-menu').fadeOut(); 
    }); 
    $('#addImage').keypress(function(e){
        if(e.which===13)
        {
            $('input[name=userfile]').click();
        }
    });
    
});
</script>
<script type="text/javascript">
    var alto=$('#banner').height()+$('#tab').height();
    $(function () {//barra de acceso rapido a menu fixed
            var $win = $(window);           
            $win.scroll(function () {
               if ($win.scrollTop() <= alto){
                 $('#div-accesorapido-menu').hide(); 
             }
               else {
                 $('#div-accesorapido-menu').show();  
               }
             });
        $(window).resize(function(){//calcular altura en base a la distancia de la barra de menu y el incio de la pagina
            setTimeout("alto=$('#banner').height()+$('#tab').height();",300);
        });
     
});
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">   
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title>Sistema de Seguimiento de Egresados</title>
<meta property="og:title" content="Sistema de Seguimiento de Egresados ITTJ"/>
<meta property="og:site_name" content="Sistema de Seguimiento de Egresados"/>
<meta property="og:url" content=""/>
<meta property="og:description" content="Sistema para el control de los egresados del ITTJ"/>
<meta property="og:image" content="Sistema de Seguimiento de Egresados"/>
<meta property="twitter:site" content="Sistema de Seguimiento de Egresados ITTJ"/>
<meta property="twitter:url" content="www.Sistema de Seguimiento de Egresados"/>
<meta property="twitter:tile" content="Sistema para el control de los egresados del ITTJ"/>
<meta property="twitter:description" content="Sistema para el control de los egresados del ITTJ"/>
<meta property="twitter:image:src" content="Sistema de Seguimiento de Egresados"/>
<link href="HojasEstilo/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="HojasEstilo/bootbox.css" rel="stylesheet" type="text/css" />
<link href="HojasEstilo/estiloPerfil.css" rel="stylesheet" type="text/css" />
<link href="HojasEstilo/jquery-ui.min.css" rel="stylesheet" type="text/css" />
</head>
<body> 
    <div id="banner"class="Banner">
<div id="center_diag"></div>
<figure>
	<img src="Imagenes/banner.png"  class="img-responsive" style="margin:auto"/>
</figure>
</div>
<div class="div_social" id="div_botones_social_escritorio">
	<div id="div_redsocial">
            <ul>
                <li><a  class="social gmail" target="_blank" href="https://plus.google.com/share?url=http://www.ittlajomulco.edu.mx"></a></li>
                
                <li><a  class="social twitter" target="_blank" href="https://plus.google.com/share?url=http://www.ittlajomulco.edu.mx"></a></li>
		
                <li><a class="social linkedin" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=http://www.ittlajomulco.edu.mx"></a></li>
		
                <li><a class="social facebook" target="_blank" href="http://facebook.com/sharer.php?u=http://www.ittlajomulco.edu.mx"></a></li>
                
                <li><a class="social tumblr" target="_blank" href="http://www.tumblr.com/share/link?url=http://www.ittlajomulco.edu.mx"></a></li>
		          
           </ul>
        </div>
</div>
<div id="div-accesorapido-menu">
    <div id="div-menu">
        <a id="a-acc-menu" href="#tab"><img id="img-acc-menu" src="Imagenes/menu.png"  title="Menú" ></a></div>
    </div>
    </div>
    <div id="tab" class="tab">
    <nav role="navigation" class="navbar navbar-default tabs font" style="margin-bottom:0px; border:none">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Inicio</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#primero" title="Datos Personales" class="navbar-brand active" style="font-size:22px">MI PERFIL</a>
        </div>

        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="#segundo" title="Datos de la Empresa´s donde Laboras">EMPRESA</a></li>
                <li><a href="#tercero" title="Grupos de Egresados, Clubs, ect a los que Perteneces">SOCIAL</a></li>
                <li><a href="#cuarto" title="Tus Anteriores trabajos">HISTORIAL</a></li>
                <li><a href="#quinto" title="Tu universidad y mas...">ITTJ</a></li>
                <li><a href="#sexto" title="Contraseña, dudas, ect.">CONFIGURACIÓN</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a  href="#ayuda"  title="Consejos y más...">AYUDA</a></li>
                <li><a  href="#primero" onclick="salir()" title="Cerrar sesión y salir">SALIR</a></li>
            </ul>    
        </div>
    </nav>
</div>    
<div class="row">
    <div class="contenedor">
        <div id="primero">
            <div class="row">
                <div  id="contenedor_foto_e" class="col-lg-8 col-lg-push-2 col-md-12  col-sm-12 col-xs-12" style="text-align:center">
                    <h2>Perfil</h2>
                    <img id="foto_egresado" src="Imagenes/businessman_green.png" style=" max-width:100%; border:5px #999 solid" title="IMAGEN DE PERFIL" class="img-responsive"/>
                    <img id="cargando_foto" src="Imagenes/loading_min.gif"/>
                    <br />
                    
                    <button  id="addImage" class="guardar" style="width:40%; margin:auto">Cambiar</button>               
                </div>
            </div>
            <div class="row margin-sides-10">
                <div class="col-lg-8 col-lg-push-2 col-md-12  col-sm-12 col-xs-12">
                    <div id="contenedor_form_datos_personales">
                        <img src="Imagenes/loading45.svg" class="enviando loading" id="enviar"  style="display:none" />
                        <form id="frm_Datos_Personales" style="text-align:left;" method="post">
                          <h2>
                              Formulario Datos Personales
                              <img id="cancelar" src="Imagenes/mask.png"  title="Cerrar" class="symbol-cancel" tabindex="0"/>
                          </h2>
                          <div class="display-flex form-format ">
                              <div>
                                <label>Nombre</label><br>
                                <input id="nombre" name="nombre" type="text"   class="text" maxlength="40"  title="NOMBRE"  required />
                              </div>
                              <div>
                                <label>Apellido paterno</label><br>
                                <input name="apellido_p" type="text"  class="text" maxlength="40"  title="Apellido paterno"  required />
                              </div>
                              <div>
                                <label>Apellido materno</label><br>
                                <input name="apellido_m" type="text"   class="text" maxlength="40"  title="Apellido materno"  required />
                              </div>
                              <div>
                                <label>Género</label><br>
                                <select name="genero" class="domicilio" title="Género">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                              </div>
                              <div>
                                <label>Fecha de nacimiento</label><br>
                                <input type="text" id="datepicker" name="fecha_nac"  readonly="readonly"   title="FECHA DE NACIMIENTO" required />
                              </div>
                              <div>
                                <label>Curp</label><br>
                                <input name="curp" type="text"   maxlength="18" title="CURP" required />
                                <a href="http://consultas.curp.gob.mx/CurpSP/" target="_blank" title="CONSULTAR CURP" class="input-icon">
                                  <img src="Imagenes/mask-16.png" class="symbol-help"/>
                                </a>
                              </div>
                              <div>
                                <label>Teléfono</label><br>
                                  <input name="tel" type="tel"   maxlength="15" title="Teléfono" required/>
                              </div>
                              <div>
                                <label>Email</label><br>
                                  <input name="email" type="email"  maxlength="30"  title="Email" required />
                              </div>
                              <h2>DOMICILIO</h2><br>
                              <div>
                                <label>Ciudad</label><br>
                                <input  id="ciudad" name="ciudad" type="text"  maxlength="40"  title="Ciudad o localidad" required />
                              </div>
                              <div>
                                <label>Colonia</label>
                                <input  id="colonia" name="colonia" type="text"  maxlength="40"  title="Colonia" required />
                              </div>
                              <div>
                                <label>Calle</label><br>
                                <input  id="calle" name="calle" type="text"  maxlength="30"  title="Calle" required />
                              </div>
                              <div>
                                <label>No: casa</label><br>
                                <input name="no_casa"  maxlength="10" title="No:casa"  id="no_casa" required />
                              </div>
                          </div>
                          <div>
                            <div>
                                <label>Cp</label><br>
                                <input name="cp"  maxlength="5" title="Código Postal"  id="cp" required />
                            </div>
                          </div>
                          <div class="display-flex form-format">
                            <div>
                              <label>Estado</label>
                              <select id="estados"  name="estado" title="Estado">
                                <option value="1">Cargando</option>
                              </select>
                            </div>
                            <div class="position-relative margin-both-sides-10">
                              <label>Municipio</label>
                              <select id="Municipios"  name="municipio" title="Municipio">
                                  <option value="1">Municipio</option>
                              </select>
                              <img id="img_cargando_estado" src="Imagenes/hourglass.svg" class="element-inside-input" />
                            </div>
                          </div>
                          <div class="align-right container-save">
                             <input type="submit"  value="GUARDAR" id="btn_guardar" class="guardar" title="GUARDAR"/>
                          </div>
                        </form>
                    </div>
                    <div id="contenedor_Datos_Personales">
                         <img src="Imagenes/loading.svg"  class="cargando" id="cargando_frm"/>
                        <div id="contendedor_d1">
                        </div>
                    </div>
                </div>
            </div><!-- fin de datos personales -->
            <div class="row">
                <div class="col-lg-8 col-lg-push-2 col-md-12  col-sm-12 col-xs-12">
                  <div class="separator">
                    <div class="line"></div>
                    <div class="rombo"></div>
                  </div> 
                  <h2 class="text-center"> Datos Academicos</h2>
                	<div class="title-academic">
                        <div id="tab-ingenieria" class="img-title toggle" data-show="div_ingenieria" data-hide="div_posgrado">
                            <img  src="Imagenes/ingenieria.png" class="img-title-active"  tabindex="0"/>
                            <span>Ingenieria</span>
                        </div>
                        <div id="tab-posgrado" class="img-title toggle" data-hide="div_ingenieria" data-show="div_posgrado">
                            <img src="Imagenes/posgrado.png"  tabindex="0"/>
                            <span>Posgrado</span>
                        </div>
                    </div>
                </div>    
            </div><!-- fin de encabezado de datos academicos -->
        	<div class="row">    
                <div id="contenedor_datos_academicos">
                    <div class="col-lg-8 col-lg-push-2 col-md-12  col-sm-12 col-xs-12" >
                        <div id="div_academia">
                            <div id="div_posgrado">
                                <img src="Imagenes/loading.svg" class="cargando" id="img_cargando_posgrado" />
                                <div id="div_frm_posgrado">
                                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_posgrado" style="top:70px" />	
                                    <form id="frm_posgrado">
                                        <h2 class="title-form">
                                            Formulario  Posgrado
                                            <img src="Imagenes/mask.png" id="img_cancelar_posgrado" title="Cerrar" class="symbol-cancel" tabindex="0"/>
                                        </h2>
                                        <div class="display-flex form-format-2">
                                            <div>
                                              <label>Posgrado</label>
                                                <select id="select_posgrado" name="posgrado" >
                                                    <option value="Maestría">Maestría</option>
                                                    <option value="Doctorado">Doctorado</option>
                                                </select>
                                            </div>
                                            <div>    
                                              <label>Titulado</label>
                                              <select id="select_titulado_posgrado" name="titulado">
                                                  <option value="SI">Si</option>
                                                  <option value="NO">No</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="display-flex form-format-2">
                                          <div>
                                            <label>Nombre del posgrado</label><br>
                                            <input type="text" name="nombre" required  maxlength="110"  />
                                          </div>
                                          <div>
                                            <label>Institución</label>
                                            <input type="text" name="escuela" required maxlength="80"  />
                                          </div>
                                        </div>
                                        <div class="align-right container-save">
                                          <input id="save-posgrado" type="submit" value="Guardar" class="guardar" />
                                          <img id="img_limpiar_frm_posgrado"  src="Imagenes/mask.png" title="Limpiar formulario" class="limpiar_form" data-target="frm_posgrado"  tabindex="0"/>
                                        </div>
                                    </form>
                                </div>
                                <div id="div_dt_posgrado"></div>
                            </div>
                            <div id="div_ingenieria">
                            <img src="Imagenes/loading.svg" id="img_cargando_dt_academicos" class="cargando" />
                                <div id="frm_datos_academicos" style="width:100%">
                                    <br />    
                                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_academico" style="top:10%;display:none" />
                                    <form id="frm_dt_academico">
                                        <h2 class="title-form">
                                            Formulario Ingenieria
                                            <img src="Imagenes/mask.png" id="imgfrm_cancelar_academicos"  title="Cerrar" class="symbol-cancel" tabindex="0"/>
                                        </h2>
                                        <div class="display-flex form-format-2">
                                        	<div>
                                            <label>Carrerar</label>
                                            <select id="carrera"  title="Carrera" name="carrera" >
                                              <option value="1">Cargando</option>
                                            </select>
                                          </div>
                                          <div>   
                                            <label>Especialidad</label>
                                            <select id="especialidad"  title="Especialidad" name="especialidad">
                                              <option value="1">Especialidad</option>
                                            </select>
                                            <img id="img_cargando" src="Imagenes/hourglass.svg" />
                                          </div>  
                                        </div>
                                        <div class="display-flex form-format">
                                        	<div>
                                            <label>Titulado</label>
                                            <select id="select_titulado" name="titulado">
                                                <option value="SI">Si</option>
                                                <option value="NO">No</option>
                                            </select>
                                          </div>
                                          <div>
                                            <label>Fecha de inicio</label><br>
                                          	<input type="text" id="dp_academico_inicio" title="Inicio" readonly name="fecha_inicio"  required/>
                                          </div>
                                          <div>
                                            <label>Fecha de finalizacion</label><br>
                                          	<input type="text" id="dp_academico_fin"   title="Termino" readonly name="fecha_fin"   required />
                                          </div>
                                        </div>
                                        <div class="align-right container-save">
                                          <input   type="submit"   title="Guardar" value="GUARDAR" id="btn_guardar_academico" class="guardar"  />
                                          <img id="img_limpiar_frm_dt_academicos"  src="Imagenes/mask.png" title="Limpiar formulario" class="limpiar_form" data-target="frm_dt_academico" tabindex="0" />
                                        </div>
                                        <div>
                                            <h3  id="titlo_carrera"><b>Carrera y Especialidad Actual</b></h3>
                                            <div id="div_carrera_actualizar"></div>
                                        </div>
                                    </form>
                                </div>
                                 <div id="datos_academicos"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-push-2 col-md-12  col-sm-12 col-xs-12">
                    <div class="separator">
                      <div class="line"></div>
                      <div class="rombo"></div>
                    </div>   
                    <div style="min-height: 465px;">
                        <div  id="div-principal-idioma">
                            <img src="Imagenes/loading.svg"  class="cargando" id="img_cargando_idiomas"/>    
                            <div id="div_idioma">
                            </div>
                        </div>
                        <div id="div_frm_idioma">         
                            <img src="Imagenes/loading45.svg" class=" enviando" id="img_enviar_idioma" /> 
                            <form id="frm_idioma">
                                <h2 class="title-form">    
                                    Formulario de Idiomas
                                    <img src="Imagenes/mask.png" id="img_cancelar_idiomas"  title="CERRAR FORMULARIO" class="symbol-cancel" tabindex="0" />
                                </h2>  
                                <div class="form-format">
                                  <div>
                                    <label>Idioma</label><br>
                                    <select name="idiomas" id="idiomas"  title="Idiomas">
                                      <option value="1">Cargando</option>
                                    </select>
                                  </div>
                                  <div>
                                    <label>Porcentaje habla</label><br>
                                    <input type="text" id="porcentaje_habla" class="input-numeric" title="HABLA"  name="porcentaje_habla" required max="100" min="1"/>
                                  </div>
                                  <div>
                                      <label>Lectura y escritura</label><br>
                                      <input type="text" id="porcentaje_lec"  class="input-numeric" name="porcentaje_lec" title="ESCRITURA Y LECTURA" required max="100" min="1"/>
                                  </div>
                                </div> 
                                <div class="align-right container-save">
                                    <input type="button" value="GUARDAR" id="guardar_idioma" title="GUARDAR" class="guardar" />
                                    <img id="img_limpiar_frm_Idioma"  src="Imagenes/mask.png" title="LIMPIAR FORMULARIO" class="limpiar_form" data-target="frm_idioma"  tabindex="0" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div>
                      <div class="separator">
                        <div class="line"></div>
                        <div class="rombo"></div>
                      </div>      
                      <div id="div_software">
                          <img src="Imagenes/loading.svg" id="img_cargando_sw" class="cargando" />
                          <div id="div_frm_software">
                              <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_sw" />
                              <form id="frm_sw" style="text-align:center">
                                <h2 class="title-form">
                                    FORMULARIO DE SOFTWARE
                                    <img src="Imagenes/mask.png" id="img_cancelar_sw" title="Cerrar"  class="symbol-cancel" tabindex="0" />
                                </h2>
                                <p style="text-align:center">
                                    <select id="select-sw" name="sw" class="basicos" style="width:50%;height:35px;padding:2px;margin:10px" title="SOFTWARES">
                                        <option value="Microsoft office" title="Word, Excel, PowerPoint, Access, ect.">Microsoft office</option>
                                        <option value="SAP Business Suite" title="Software empresarial">SAP Business</option>
                                        <option value="Netbeans" title="IDE desarrollo libre para JAVA">Netbeans</option>
                                        <option value="Eclipse" title="IDE desarrollo libre para JAVA">Eclipse</option>
                                        <option value="Visual Studio" title="IDE desarrollado por Microsoft">Visual Studio</option>
                                        <option value="Diseño Gráfico" title="Illustrator, Photoshop o Indisign">Diseño Gráfico</option>
                                        <option value="RAD" title="IDE´s de desarrollo de sw rapido">RAD</option>
                                    </select>
                                </p>
                                <p style="text-align:center">
                                    <input   type="submit"  value="GUARDAR" id="btn_guardar_sw" class="guardar" title="GUARDAR" />
                                </p>
                              </form>
                          </div>
                          <div id="div_dt_software">
                          </div>
                      </div>
                    </div>
                </div><!-- col idioma y software -->
            </div><!-- row idioma y software -->
        </div><!-- fin de primero -->
	    <div id="segundo">
        <div class="row">
       	 	<div id="div_empresa" class="col-lg-8 col-lg-push-2 col-md-12  col-sm-12 col-xs-12">
            <img src="Imagenes/loading.svg"  class="cargando" id="img_cargando_empresa"/>
            <div  id="div_frm_empresa">
            <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_empresa"/>
            <div>
                <form  id="frm_empresa">
                	<h2 class="title-form">
                    FORMULARIO DE DATOS DE LA EMPRESA
                    <img src="Imagenes/mask.png" id="img_cancelar_empresa" title="CERRAR FORMULARIO"  class="symbol-cancel" tabindex="0" />
                  </h2>
                  <div class="form-format-2">
                    <div>
                      <label>Empresa</label><br>
                      <input id="input-nombre-empresa"  name="nombre" maxlength="30" title="Empresa"  class="width-95" required="required"/>
                    </div>
                  </div>
                  <div class="form-format-2">
                    <div>
                      <label>Puesto</label><br>
                      <input type="text"  name="puesto"  maxlength="30"   title="Puesto"  required="required"/>
                    </div>
                    <div>
                      <label>Giro</label><br>
                      <input  name="giro"   maxlength="40"  required="required"  title="Giro"/>
                    </div>
                    <div>
                      <label>Fecha de ingreso</label><br>
                      <input type="text"   readonly name="año_ingreso"   title="Fecha de ingreso" id="año_ingreso"  required="required"/>
                    </div>
                    <div>
                      <label>Superior inmediato</label><br>
                      <input type="text"  name="jefe" maxlength="40"    title="Superior inmediato"  required/>
                    </div>
                    <h2>DATOS BÁSICOS</h2>
                    <div>
                      <label>Teléfono</label><br>
                      <input type="tel"   name="tel" required maxlength="14" title="Teléfono"  />
                    </div>
                    <div>
                      <label>Email</label><br>
                      <input type="email"  name="email"  maxlength="30"   title="Email" required/>
                    </div>
                    <div>
                      <label>Tipo de organismo</label><br>
                      <select  name="organismo"  id="organismo" title="Naturaleza de la empresa">
                      <option value="Público" >Público</option>
                      <option value="Privado">Privado</option>
                      <option value="Social">Social</option>
                    </select>
                    </div>
                    <div>
                      <label>Razón social</label><br>
                      <select  name="razon_social" id="razon_social"  title="Razón social">
                        <option value="Persona moral"  title="EMPRESA">Persona moral</option>
                        <option value="Persona física"  title="UNA SOLA PERSONA">Persona física</option>
                      </select>
                    </div>
                    <div>
                      <label>Medio de búsqueda</label>
                      <select name="medio_busqueda"   id="medio_busqueda" title="Medio de búsqueda" >
                          <option value="1">Bolsa del plantel</option>
                          <option value="2">Contactos personales</option>
                          <option value="3">Residencia profecional</option>
                          <option value="4">Medios masivos de comunicación</option>
                      </select>
                    </div>
                    <div>
                      <label>Tiempo de búsqueda</label><br>
                      <select name="tiempo_busqueda" id="tiempo_busqueda" title="Tiempo de búsqueda">
                        <option value="1">Seis meses</option>
                          <option value="2">Un año</option>
                          <option value="3">Dos año</option>
                          <option value="4">Tres año</option>
                          <option value="5">Más 4 año</option>
                      </select>
                    </div>
                    <div>
                      <label>Web de la empresa</label><br>
                      <input type="text"  name="web" maxlength="30"   title="Web de la empresa" class="width-95"/>
                    </div>
                    <h2>DOMICILIO</h2>
                    <div>
                      <label>Calle</label><br>
                      <input name="calle"   title="Calle"  required="required"/>
                    </div>
                    <div>
                      <label>No:</label><br>
                      <input name="no_domicilio"    title="No:"   required="required"/>
                    </div>
                    <div>
                      <label>Estado</label><br>
                      <select  id="estado_empresa" name="estado" title="Estado">
                        <option>ESTADO</option>
                      </select>
                    </div>
                    <div class="position-relative">
                      <label>Municipio</label><br>
                      <select id="municipio_empresa" name="municipio" title="Municipio">
                        <option>Municipio</option>
                      </select>
                      <img id="img_muncipio_empresa" src="Imagenes/hourglass.svg" class="element-inside-input"/>
                    </div>
                  </div>
                  <div class="form-format-2">
                    <div id="requisito_div">
                       <h3>
                        Requisitos de contratación
                        <img  id="img_agregar_requisitos" src="Imagenes/mask.png"   title="Agregar requisito" class="symbol-add-extra cursor" tabindex="0"/>
                       </h3>
                      <select  id="requisito" name="1requisito" >
                          <option value="6">Titulo profecional</option>
                          <option value="2">Examen de selección</option>
                          <option value="3">Idioma extranjero</option>
                          <option value="4">Habilidades socio-comunicativas</option>
                          <option value="5">Experiencia laboral</option>
                          <option value="1">Ninguno</option>
                      </select>
                    </div>
                  </div>
                  <div class="container-save align-right">
                    <input   type="submit"   title="GUARDAR" value="GUARDAR" id="btn_guardar_empresa" class="guardar"   />
                    <img id="img_limpiar_frm_dt_empresa"  src="Imagenes/mask.png" title="LIMPIAR FORMULARIO" data-target="frm_empresa" class="limpiar_form"  tabindex="0" />
                  </div>
                </form>
                </div>
            <div class="row">    		
                <div id="div_dt_empresa_editar" class="row">
                </div>
            </div>            
            </div>
                <div id="div_dt_empresa">
                </div>
            </div>
        </div>
      </div><!-- fin de tercero -->
	    <div id="tercero">
        	<div id="dialogo_social"></div>
            <div id="div_borrar_social" style="display:none">
            	<p>ESTÁ ASOCIACIÓN SE BORRA DE MANERA PERMANTE EN EL SISTEMA,DICHA ACCIÓN ES IRREVERSIBLE UNA VEZ ACEPTADA</p>
            </div>
        	<img src="Imagenes/loading.svg" class="cargando" style="display:none" id="img_cargando_social" />
        	<div id="div_dt_social">
            </div>
            <div id="div_frm_social">
                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_social" style="top:10%;" />
	            <div class="row">
	            	<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		            	<form id="frm_social" style="text-align:center;">
		                    <h2 style="font-size:22px;">FORMULARIO PARA ASOCIACIONES SOCIALES</h2>
		                    <img id="img_cerrar_frm_social" class="symbol-cancel" src="Imagenes/mask.png" title="CERRAR FORMULARIO" tabindex="0" /><br>
                                        <input id="input-nombre-asociacion" type="text" name="nombre"   required="required" maxlength="30"   placeholder="NOMBRE DE LA ASOCIACIÓN"/><br/>
		                    <select name="tipo" id="select_social" class="basicos" style="width:70%" >
		                        <option value="1">TIPO</option>
		                        <option value="GRUPO ESTUDIANTIL">GRUPO ESTUDIANTIL</option>
		                        <option value="ASOCIACIÓN CIVIL">ASOCIACIÓN CIVIL</option>
		                    </select><br />
		                    <input type="submit" value="GUARDAR" name="GUARDAR" class="guardar"/><img id="img_limpiar_frm_social"  src="Imagenes/mask.png" title="LIMPIAR FORMULARIO" class="limpiar_form" data-target="frm_social" style="width:40px; height:40px;" tabindex="0" />
		            	</form>
		            </div>		
	            </div>
            </div>
        </div>
        <div id="cuarto">
        <div id="dialogo_historial"></div>
        	<div id="div_dt_historial_empresa">
            </div>
            <div id="div_borrar_historial" style="display:none">
            	<p>ESTÁ EMPRESA SE BORRA DE MANERA PERMANTE EN EL SISTEMA</p>
            </div>
            <img src="Imagenes/loading.svg" class="cargando" style="display:none" id="img_cargando_historial" />
            <div id="div_frm_historial">
                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_historial" style="top:15%; display:none" />
            	<div class="row">
            		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                <form id="frm_historial" style="text-align:center">
                                    <label style="font-size:22px;">FORMULARIO DE HISTORIAL EMPRESARIAL</label><br />
                                    <img id="img_cerrar_frm_historial" class="symbol-cancel" src="Imagenes/mask.png" title="CERRAR FORMULARIO" tabindex="0" /><br>
                                        <input id="input-nombre-historial"type="text" name="nombre" title="NOMBRE DE LA EMPRESA" placeholder="NOMBRE DE LA EMPRESA" maxlength="30"   required /><br />
		                    <input type="text" name="tel"  title="TELÉFONO DE LA EMPRESA" placeholder="TELEFONO DE LA EMPRESA" maxlength="18"    required/><br />
		                    <input type="text" name="web"  title="WEB DE LA EMPRESA" placeholder="WEB DE LA EMPRESA" maxlength="40"   /><br />
		                    <input type="text" name="email"  title="EMAIL DE LA EMPRESA" placeholder="EMAIL DE LA EMPRESA" maxlength="30"  required/><br />
		                    <input type="submit" name="GUARDAR" value="GUARDAR" class="guardar" placeholder="GUARDAR" title="GUARDAR"/><img id="img_limpiar_frm_historial"  src="Imagenes/mask.png" title="LIMPIAR FORMULARIO" class="limpiar_form" data-target="frm_historial" style="width:40px; height:40px;" tabindex="0" />
		                </form>
	                </div>
                </div>
                <br /><br /><br />
                <div id="div_dt_historial_editar"></div>
            </div>
        </div>
        <div id="quinto">
        	<div id="div_ittj" style="text-align:center">
        		<div class="row">
        			<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
	                <button class="guardar" id="a_residencia" >RESIDENCIA</button>
	                <div  id="div_frm_residencia" style="text-align:center;height:200px;position: relative">
                            <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_residencia" style="top:70px"/>
	                    <form id="frm_residencia" style="width:100%">
	                    <label style=" font-size:24px">EXPERIENCIA EN RESIDENCIA</label><br />
	                    <select id="residencia" class="basicos" name="residencia" style="width:70%" >
	                    	<option value="1">BUENA</option>
	                        <option value="2">REGULAR</option>
	                        <option value="3">MALA</option>
	                        <option value="4">PÉSIMA</option>
	                    </select><br />
	                    <br />
	                    <input type="submit"  value="GUARDAR" placeholder="GUARDAR" class="guardar" />
	                    </form>
	                    </div>
	                </div>
                </div>
                <div class="row">
	                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">	
	                <h2 style="text-align:center; font-size:24px">Domicilio</h2>
						<div class="maps">
		                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3738.5458748648207!2d-103.421196!3d20.44276100000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd31bc9f89150c788!2sInstituto+Tecnologico+de+Tlajomulco!5e0!3m2!1ses-419!2smx!4v1433197046100" width="800" height="600" frameborder="0" style="border:0"></iframe>
		                </div>
	                </div>
                </div>
                <br /><br />
                <div class="row">
                	<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                            <div id="div_contacto">
	                <?php 
					list($fechaCon,$direccion,$cargo,$domicilio,$tel,$email,$web)=datos();
				    ?>
	                	<h2 style="text-align:center">Contacto</h2>
	                    <?php 
					echo $domicilio.$tel;
				?><a href="mailto:ittj@ittlajomulco.edu.mx"><?php echo $email?></a>,<a href="http://www.ittlajomulco.edu.mx/"><?php echo $web?></a> 
					</div>
					</div>
                </div>
            </div>
        </div>
        <div id="sexto">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 col-sm-12" style="min-height: 200px">
                    <div id="alert_pass" class="ventana">
                        <p>Tu contraseña pasada no es la correcta verifica de nuevo</p>
                    </div>
                    <div id="div-ayuda-pass" class="ventana">
                        <ul>
                            <li>Procura usar letras <b>mayúsculas y minúsculas</b> combinadas.</li>
                            <li>Agregar <b>números</b> aumenta más la seguridad.</li>
                            <li>Por último no olvides <b>caracteres especiales</b> como $, ! # darán más seguridad a tu password.</li>
                        </ul>
                    </div>
                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_pass" style="top:60%;display: none" />    
                    <form id="frm_pass" style="margin-top:20px;">
                        <h2>Contraseña</h2>
                        <input id="viejo_pass" type="password" name="viejo_pass" maxlength="15" title="Contaseña actual" placeholder="CONTRASEÑA ACTUAL" class="input-pass" style="width:100%" required="ANTIGUA CONTRASEÑA NECESARIA"><br>                             
                        <div id="div-input-pass">                          
                            <input id="pass_nuevo" onKeyPress="return espacion_block(event)" type="password" name="nuevo_pass" maxlength="15" title="Nueva contraseña" placeholder="NUEVA CONTRASEÑA"   required="NUEVA CONTRASEÑA">
                                <img id="img-ayuda-pass"src="Imagenes/ayuda.png" style="float: left" tabindex="0"/><span id="span-pass-seguridad"></span>
                        </div>
                        <input id="pass_nuevo_reafirmar"  type="password" maxlength="15" name="nuevo_pass_reafirmar" title="Reafirmar contraseña" placeholder="REAFIRMAR CONTRASEÑA"class="input-pass" style="width:100%;display: none;" required="NUEVA CONTRASEÑA" ><br>
                        <span id="span_pass" class="span_pass-incorrecto">LAS CONTRASEÑAS NO COINCIDEN</span><span id="span-pass-correcto">LAS CONTRASEÑAS COINCIDEN</span><br>
                        <input type="submit" value="ACEPTAR" class="guardar" style="width: 50%">
                    </form>
                </div>
            </div>
            <div class="row">
                <div id="div-recomendaciones" class="col-lg-8 col-lg-offset-2 col-sx-12">
                    <h2>Recomendaciones</h2>
                    <ul>
                        <li>Es necesario que toda tu información este actualizada para ayudar mejor a las estadisticas.</li>
                        <li>No es necesario que llenes todos tus datos el mismo día.</li>
                        <li>Las maximas medidas de la imagen de perfil son 700 x 700.</li>
                        <li>El tamaño de la imagen de perfil no puede superar 1 MB.</li>
                        <li>Tu email es muy importante ya que en caso de que olvides tu 
                            contraseña se te enviara a tu correo un mensaje para  resetearlo por 
                            lo que se te recomienda sea uno de los primeros datos que agregues</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="ayuda">
            <div id="div-row-ayuda" class="row">
                <div id="div-col-ayuda" class="col-lg-10 col-lg-offset-1 col-sx-12">
                    <div id="div-ayuda" class="row">
                        <h2>Ayuda</h2>
                        <div class="media fondo">
                            <a class="pull-left">
                                <img id="img-ayuda-editar" src="Imagenes/editar.png " class="media-object img-giro" alt="imagen">
                            </a>
                            <div class="media-body">
                              <h2 class="media-heading">Editar</h2>
                              <p>Permite editar datos, normalmente mediante un formulario oculto</p>
                            </div>
                        </div>
                        <div class="media fondo">
                            <a class="pull-left">
                               <img id="img-ayuda-agregar" src="Imagenes/agregar.png" class="media-object img-giro" alt="imagen">
                            </a>
                            <div class="media-body">
                              <h2 class="media-heading">Agregar</h2>
                              <p>Permite agregar  nuevos datos, por ejemplo un nuevo idioma, normalmente mediante un formulario oculto</p>
                            </div>
                        </div>
                        <div class="media fondo">
                            <a class="pull-left">
                                <img id="img-ayuda-cancelar" src="Imagenes/mask.png" class="media-object symbol-cancel" alt="imagen">
                            </a>
                            <div class="media-body">
                                <h2 class="media-heading">Eliminar o cerrar</h2>
                                <p>Esta imagen elimina los datos que señala, por ejemplo borrar un idioma en caso de 
                                que se encuentre en un formulario lo oculta y limpia.</p> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
<div class="row">
    <div class="div_social" id="div_botones_social_mobil">
	<div id="div_redsocial_mobil" style="margin:0px auto 0px auto;width:270px">
            <a href="https://plus.google.com/share?url=http://www.ittlajomulco.edu.mx"><img src="Imagenes/social/gmail.png"  class="social"/></a>

            <a href="whatsapp://send?text=http://www.ittlajomulco.edu.mx" data-text="Sistema de Egresados" data-action="share/whatsapp/share" ><img src="Imagenes/social/whatsapp.png"  class="social"/></a>

            <a href="http://facebook.com/sharer.php?u=http://www.ittlajomulco.edu.mx"><img src="Imagenes/social/facebook.png"  class="social"/></a>

            <a   href="http://www.tumblr.com/share/link?url=http://www.ittlajomulco.edu.mx"><img src="Imagenes/social/tumblr.png"  class="social"/></a>

            <a href="http://twitter.com/share?url=http://www.ittlajomulco.edu.mx"><img src="Imagenes/social/twitter.png"  class="social"/></a>
        </div>
    </div>
</div>
</body> 
<script type="text/javascript" src="js/EventosForm.js"></script>
<script type="text/javascript" src="js/App/Class/Animaciones.js"></script>
<script type="text/javascript" src="js/App/Class/LimpiarForm.js"></script>
<script type="text/javascript" src="js/App/Class/datosAcademicos.js"></script>
<script type="text/javascript" src="js/App/Class/DatosSoftware.js"></script>
<script type="text/javascript" src="js/App/Class/DatosPersonales.js"></script>
<script type="text/javascript" src="js/App/Class/DatosIdioma.js"></script>
<script type="text/javascript" src="js/App/Class/DatosPosgrado.js"></script>
<script type="text/javascript" src="js/App/Structure/StructureDatosEgresado.js"></script>
<script type="text/javascript" src="js/App/Class/Toggle.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        Animaciones.init();
        Toggle.init();
        var no_control=<?php echo $_SESSION['No_control'] ?>;//cargar variable
        DatosAcademicos.setNoControl(no_control);
        DatosSoftware.setNoControl(no_control);
        DatosPersonales.setNoControl(no_control);
        DatosIdioma.setNoControl(no_control);
        DatosPosgrado.setNoControl(no_control);
        DatosPersonales.requestDatosEgresado(no_control);
        DatosAcademicos.dt_academicos(no_control);
        DatosIdioma.requestDatosIdioma(no_control);
        DatosPosgrado.requestDatosPosgrado(no_control);
        DatosSoftware.dt_SW(no_control);
        EventosForm.init();
        EventosForm.setNoControl(no_control);
        LimpiarForm.init();
        DatosAcademicos.init();
        DatosSoftware.init();
        DatosPersonales.init();
        DatosIdioma.init();
        DatosPosgrado.init();
    });
</script>  
</html>    
        <?php else : header('Location: error.php'); ?>
         
<?php endif; }?>
