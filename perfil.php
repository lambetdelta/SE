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
	/*clases generales*/
	$("#div_dt_posgrado").on('click',".eliminar",function(){//imagen eliminar  de idiomas
		var id=$(this).attr('id').toString();
		id=id.slice(19);
		confirmar_posgrado(no_control,id);
	});
	$("#div_dt_posgrado").on('keypress',".eliminar",function(e){//imagen eliminar  de idiomas
	    if(e.which===13){
                var id=$(this).attr('id').toString();
		id=id.slice(19);
		confirmar_posgrado(no_control,id);
            }
	});
	$("#div_dt_posgrado").on('click',"#agregar_posgrado",function(){//imagen eliminar  de idiomas
		show_posgrado();
                $('#select_posgrado').focus();
	});
        $("#div_dt_posgrado").on('keypress',"#agregar_posgrado",function(e){//imagen eliminar  de idiomas
	    if(e.which===13){
                show_posgrado();
                $('#select_posgrado').focus();
            }
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
                <div  id="contenedor_foto_e" class="col-lg-10 col-lg-push-1 col-md-12  col-sm-12 col-xs-12" style="text-align:center">
                    <h2>Perfil</h2>
                    <img id="foto_egresado" src="Imagenes/businessman_green.png" style=" max-width:100%; border:5px #999 solid" title="IMAGEN DE PERFIL" class="img-responsive"/>
                    <img id="cargando_foto" src="Imagenes/loading_min.gif"/>
                    <br />
                    
                    <button  id="addImage" class="guardar" style="width:40%; margin:auto">Cambiar</button>               
                </div>
            </div>
            <div class="row margin-sides-10">
                <div class="col-lg-10 col-lg-push-1 col-md-12  col-sm-12 col-xs-12">
                    <div id="contenedor_form_datos_personales">
                        <img src="Imagenes/loading45.svg" class="enviando loading" id="enviar"  style="display:none" />
                        <form id="frm_Datos_Personales" style="text-align:left; padding-left:10px" method="post">
                        <h2>
                            Formulario Datos Personales
                            <img id="cancelar" src="Imagenes/mask.png"  title="Cerrar" class="symbol-cancel" tabindex="0"/>
                        </h2>
                        <div class="display-flex data-personal ">
                            <input id="nombre" name="nombre" type="text"  placeholder="NOMBRE" class="text" maxlength="40"  title="NOMBRE"  required />

                            <input name="apellido_p" type="text"  placeholder="Apellido paterno" class="text" maxlength="40"  title="Apellido paterno"  required />

                            <input name="apellido_m" type="text"  placeholder="Apellido materno" class="text" maxlength="40"  title="Apellido materno"  required />

                            <select name="genero" class="domicilio" title="Género">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>

                            <input type="text" id="datepicker" name="fecha_nac"  readonly="readonly" placeholder="FECHA DE NACIMIENTO"  title="FECHA DE NACIMIENTO" required />

                            <input name="curp" type="text"  placeholder="CURP" maxlength="18" title="CURP" required />

                            <a href="http://consultas.curp.gob.mx/CurpSP/" target="_blank" title="CONSULTAR CURP">
                                <img src="Imagenes/ayuda.png" />
                            </a>

                            <input name="tel" type="tel"  placeholder="Teléfono" maxlength="15" title="Teléfono" required/>
                           
                            <input name="email" type="email" placeholder="Email" maxlength="30"  title="Email"  required />

                           <h2>DOMICILIO</h2><br>
                           <input  id="ciudad" name="ciudad" type="text" placeholder="Ciudad o localidad" maxlength="40"  title="Ciudad o localidad" required />

                           <input  id="colonia" name="colonia" type="text" placeholder="Colonia" maxlength="40"  title="Colonia" required />

                           <input  id="calle" name="calle" type="text" placeholder="Calle" maxlength="30"  title="Calle" required />

                           <input name="no_casa" placeholder="No:casa" maxlength="10" title="No:casa"  id="no_casa" required />

                           <input name="cp" placeholder="Código Postal" maxlength="5" title="Código Postal"  id="cp" required />

                       </div>
                       <div class="display-flex data-personal">
                            <select id="estados" class="domicilio" name="estado" title="Estado">
                                <option value="1">Cargando</option>
                            </select>
                            <div class="position-relative">
                                <select id="Municipios" class="domicilio" name="municipio" title="Municipio">
                                    <option value="1">Municipio</option>
                                </select>
                                <img id="img_cargando_estado" src="Imagenes/hourglass.svg" class="element-inside-input" />
                           </div>
                       </div>
                       <div class="align-right">
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
            <h2 class="text-center"> Datos Academicos</h2>
            <div class="row">
                <div class="col-lg-10 col-lg-push-1 col-md-12  col-sm-12 col-xs-12">
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
                    <div class="col-lg-10 col-lg-push-1 col-md-12  col-sm-12 col-xs-12" >
                        <div id="div_academia">
                            <div id="div_posgrado">
                                <img src="Imagenes/loading.svg" class="cargando" style="display:none" id="img_cargando_posgrado" />
                                <div id="div_frm_posgrado" style="text-align:center">
                                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_posgrado" style="top:70px" />	
                                    <form id="frm_posgrado">
                                        <h2>Formulario  Posgrado</h2><br />
                                        <img src="Imagenes/mask.png" id="img_cancelar_posgrado" title="Cerrar" class="symbol-cancel" tabindex="0"/>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <select id="select_posgrado" name="posgrado" class="basicos" style="width:90%">
                                                    <option value="0">Posgrado</option>
                                                    <option value="Maestría">Maestría</option>
                                                    <option value="Doctorado">Doctorado</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
                                                <select id="select_titulado_posgrado" name="titulado" class="basicos" style="width:90%">
                                                    <option value="0">Titulado</option>
                                                    <option value="SI">Si</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="text" name="nombre" required  style="width:80%" maxlength="110" class="frm_empresa" placeholder="Nombre del posgrado"/><br /><br />
                                        <input type="text" name="escuela" required style="width:80%" maxlength="80" class="frm_empresa" placeholder="Escuela"/><br /><br />
                                        <input type="submit" value="Guardar" class="guardar" /><img id="img_limpiar_frm_posgrado"  src="Imagenes/mask.png" title="Limpiar formulario" class="limpiar_form" data-target="frm_posgrado" style="width:40px; height:40px" tabindex="0"/>
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
                                        <h2 style="font-size:22px">Formulario Ingenieria</h2>
                                        <img src="Imagenes/mask.png" id="imgfrm_cancelar_academicos"  title="Cerrar" class="symbol-cancel" tabindex="0"/>
                                        <div class="row">
                                        	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <select id="carrera"  title="Carrera"class=" basicos" style="width:90%;height:35px;padding:2px;margin:10px" name="carrera" ><option value="1">Cargando</option></select>
                                             </div>
                                             <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">   
                                                <select id="especialidad"  title="Especialidad"class=" basicos" style="width:80%;height:35px;padding:2px;margin:10px" name="especialidad"><option value="1">Especialidad</option></select><img id="img_cargando" src="Imagenes/loading_.gif" style="width:30px; height:30px" />
                                             </div>  
                                        </div>
                                        <div class="row">
                                        	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <select id="select_titulado" name="titulado" class="basicos" style="width:80%; margin:10px">
                                                    <option value="0">Titulado</option>
                                                    <option value="SI">Si</option>
                                                    <option value="NO">No</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            	<input type="text" id="dp_academico_inicio" title="Inicio" readonly name="fecha_inicio" placeholder="Inicio" style="width:80%"  class="frm_acedemico_"required/>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            	<input type="text" id="dp_academico_fin"   title="Termino" readonly name="fecha_fin" placeholder="Termino"  required />
                                            </div>
                                        </div>
                                        <input   type="submit"   title="Guardar" value="GUARDAR" id="btn_guardar_academico" class="guardar"  />
                                        <img id="img_limpiar_frm_dt_academicos"  src="Imagenes/mask.png" title="Limpiar formulario" class="limpiar_form" data-target="frm_dt_academico" style="width:40px; height:40px;" tabindex="0" />
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
                <div class="col-lg-10 col-lg-push-1 col-md-12  col-sm-12 col-xs-12">   
                    <div style="min-height: 465px;">
                        <div  id="div-principal-idioma">
                            <img src="Imagenes/loading.svg"  class="cargando" id="img_cargando_idiomas"/>    
                            <div id="div_idioma">
                            </div>
                        </div>
                        <div id="div_frm_idioma">         
                            <img src="Imagenes/loading45.svg" class=" enviando" id="img_enviar_idioma" /> 
                            <form id="frm_idioma" class="text-center">
                                <h2 class="title-form">    
                                    Formulario de Idiomas
                                    <img src="Imagenes/mask.png" id="img_cancelar_idiomas"  title="CERRAR FORMULARIO" class="symbol-cancel" tabindex="0" />
                                </h2>   
                                <select name="idiomas" id="idiomas"  title="IDIOMAS" class="basicos">
                                    <option value="1">Cargando</option>
                                </select>
                                <br />
                                <div class="display-flex justify-around margin-sides-10 idioma-form-div">
                                    <label>Porcentaje habla</label>
                                    <input type="number" id="porcentaje_habla" class="input-numeric" title="HABLA"  name="porcentaje_habla" required max="100" min="1"/>
                                </div>
                                <div class="display-flex justify-around margin-sides-10 idioma-form-div">
                                    <label>Lectura y escritura</label>
                                    <input type="number" id="porcentaje_lec"  class="input-numeric" name="porcentaje_lec" title="ESCRITURA Y LECTURA" required max="100" min="1"/>
                                </div>
                                <div class="display-flex justify-around margin-sides-10 idioma-form-div">
                                    <input type="button" value="GUARDAR" id="guardar_idioma" title="GUARDAR" class="guardar" style=" width:40%" />
                                    <img id="img_limpiar_frm_Idioma"  src="Imagenes/mask.png" title="LIMPIAR FORMULARIO" class="limpiar_form" data-target="frm_idioma"  tabindex="0" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div>     
                        <div id="div_software">
                            <img src="Imagenes/loading.svg" id="img_cargando_sw" class="cargando" />
                            <div id="div_frm_software">
                                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_sw" /> 
                                <form id="frm_sw" style="text-align:center">
                                    <label style="text-align:center; font-size:22px; font-weight:bold">FORMULARIO DE SOFTWARE</label><br />
                                    <img src="Imagenes/mask.png" id="img_cancelar_sw" title="CERRAR FORMULARIO"  class="symbol-cancel" tabindex="0" />
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
        	<div id="dialogo_empresa" class="ventana" title="¿Estas Seguro?">  
			</div>
            <div id="borrar_empresa" class="ventana" title="¿Estas Seguro?">
            	<p>LA EMPRESA SE BORRARA DE MANERA PERMANETE Y PASARA A TU HISTORIAL LABORAL, DICHA ACCIÓN UNA VEZ TERMINADA ES IRREVERSIBLE</p>  
			</div>
            <div class="row">
       	 	<div id="div_empresa">
            <img src="Imagenes/loading.svg"  class="cargando" style="display:none" id="img_cargando_empresa"/>
                <div  id="div_frm_empresa">
                <img src="Imagenes/loading45.svg" class="enviando" id="img_enviar_empresa" style="top:22%; display:none" />
                <div class="row">
                    <form  id="frm_empresa" style="text-align:center">
                    	<h1 style="font-size:22px;text-align:center">FORMULARIO DE DATOS DE LA EMPRESA</h1>
                     	<img src="Imagenes/mask.png" id="img_cancelar_empresa" title="CERRAR FORMULARIO"  class="symbol-cancel" style="width:35px; height:35px" tabindex="0" /><br>
                    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <input id="input-nombre-empresa" class="frm_empresa" name="nombre" placeholder="NOMBRE DE LA EMPRESA" maxlength="30" title="NOMBRE DE LA EMPRESA"  required="required"/><br />
                        <input  class="frm_empresa" name="giro"  placeholder="GIRO O ACTIVIDAD PRINCIPAL" maxlength="40"  required="required" style="height:40px" title="GIRO Ó ACTIVIDAD PRINCIPAL"/><br />
                        <input type="text" placeholder="PUESTO QUE OCUPAS" name="puesto"  maxlength="30" class="frm_empresa"  title="PUESTO QUE OCUPAS"  required="required"/><br />
                        <input type="text" placeholder="AÑO DE INGRESO"  readonly name="año_ingreso" class="frm_empresa"  title="AÑO DE INGRESO" id="año_ingreso"  required="required"/><br />
                        <input type="text" placeholder="NOMBRE DE JEFE O SUPERIOR INMEDIATO" name="jefe" maxlength="40" class="frm_empresa"   title="NOMBRE DE JEFE O SUPERIOR INMEDIATO"  required/><br />
                        <label style=" font-size:22px;margin-top:10px">DATOS BÁSICOS</label><br />
                          <select  name="organismo"  id="organismo" class="frm_empresa_izd" style=" top:6%; color:#666" title="NATURALEZA DE LA EMPRESA">
                        	<option value="1" >ORGANISMO</option>
                        	<option value="PÚBLICO" >PÚBLICO</option>
                            <option value="PRIVADO">PRIVADO</option>
                            <option value="SOCIAL">SOCIAL</option>
                        </select><br />
                           <select  name="razon_social" id="razon_social" class="frm_empresa_izd" style="top:10%; color:#666" title="RAZÓN SOCIAL">
                        	<option value="1" >RAZÓN SOCIAL</option>
                        	<option value="PERSONA MORAL"  title="EMPRESA">PERSONA MORAL</option>
                            <option value="PERSONA FÍSICA"  title="UNA SOLA PERSONA">PERSONA FÍSICA</option>
                        </select><br />
                        <input type="tel" placeholder="TELÉFONO DE LA EMPRESA"  name="tel" required maxlength="14" title="TELÉFONO" class="frm_empresa" /><br />
                        <input type="email" placeholder="EMAIL DE LA EMPRESA" name="email"  maxlength="30"  class="frm_empresa" title="CORREO ELECTRÓNICO" required/><br />
                        <input type="text" placeholder="WEB DE LA EMPRESA" name="web" maxlength="30" class="frm_empresa"  title="WEB DE LA EMPRESA"/><br />
                        <label style=" font-size:22px;margin-top:10px">BÚSQUEDA</label><br />
                        <select name="medio_busqueda"   id="medio_busqueda"class="frm_empresa_izd" title="¿COMO ENCONTRASTE TU TRABAJO?" style="color:#666">
                        	<option value="1">MEDIO DE BÚSQUEDA</option>
                            <option value="BOLSA DE TRABAJO DEL PLANTEL">BOLSA DE TRABAJO DEL PLANTEL</option>
                            <option value="CONTACTOS PERSONALES">CONTACTOS PERSONALES</option>
                            <option value="RESIDENCIA PROFESIONAL">RESIDENCIA PROFESIONAL</option>
                            <option value="MEDIOS MASIVOS DE COMUNICACIÓN">MEDIOS MASIVOS DE COMUNICACIÓN</option>
                        </select>
                         <select name="tiempo_busqueda" id="tiempo_busqueda" class="frm_empresa_izd" title="¿CUANTO TIEMPO TARDASTES?" style="color:#666">
                         	<option value="1">TIEMPO DE BÚSQUEDA</option>
                         	<option value="SEIS MESES">SEIS MESES</option>
                            <option value="UN AÑO">UN AÑO</option>
                            <option value="DOS AÑOS">DOS AÑOS</option>
                            <option value="TRES AÑOS">TRES AÑOS</option>
                            <option value="MÁS 4 AÑOS">MÁS 4 AÑOS</option>
                        </select><br />
                     </div>
                     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <label  class="frm_empresa_" style="font-size:22px; top:18%; right:13%; color:#000;border:none">DOMICILIO</label>
                        <select  id="estado_empresa" name="estado" class="frm_empresa_" style=" width:50%;color:#666;" title="ESTADO">
                        	<option>ESTADO</option>
                        </select><br />
                        <select id="municipio_empresa" name="municipio" class="frm_empresa_" style="width:50%;color:#666;" title="MUNICIPIO">
                        	<option>MUNICIPIO</option>
                        </select><img id="img_muncipio_empresa" src="Imagenes/loading_.gif" style="width:30px; height:30px; right:2%; display:none; top:22%" class="frm_empresa_"/><br /><br />
                        <input name="calle" class="frm_empresa_"  placeholder="CALLE" title="CALLE" style=" top:26%; right:30%"  required="required"/><br />
                        <input name="no_domicilio" class="frm_empresa_"  placeholder="No:" title="No:" style=" top:26%; right:5%"  required="required"/><br />
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="requisito_div">
                           <h2 style="font-size:22px">REQUISITOS DE CONTRATACIÓN</h2><img  id="img_agregar_requisitos"src="Imagenes/más.png" class="frm_empresa_"  title="AGREGAR MÁS REQUISITOS" style=" margin-left:10px; width:30px; height:30px; border:none" tabindex="0"/><br>
                        <select  id="requisito" name="1requisito" class="frm_empresa_" style="color:#666;">
                            <option value="TITULO PROFESIONAL">TITULO PROFESIONAL</option>
                            <option value="EXAMEN DE SELECCIÓN">EXAMEN DE SELECCIÓN</option>
                            <option value="IDIOMA EXTRANJERO">IDIOMA EXTRANJERO</option>
                            <option value="HABILIDADES SOCIO-COMUNICATIVAS">HABILIDADES SOCIO-COMUNICATIVAS</option>
                            <option value="EXPERIENCIA LABORAL">EXPERIENCIA LABORAL</option>
                            <option value="NINGUNO">NINGUNO</option>
                        </select>
                    </div>
               			<input   type="submit"   title="GUARDAR" value="GUARDAR" id="btn_guardar_empresa" class="guardar" style="right:10%"  /><img id="img_limpiar_frm_dt_empresa"  src="Imagenes/mask.png" title="LIMPIAR FORMULARIO" data-target="frm_empresa" class="limpiar_form" style="width:40px; height:40px;right:5%" tabindex="0" />
                        </div>
                    </form><br /><br />
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
        </div>
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
                                        <input id="input-nombre-asociacion" type="text" name="nombre"   required="required" maxlength="30" class="frm_empresa"  placeholder="NOMBRE DE LA ASOCIACIÓN"/><br/>
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
                                        <input id="input-nombre-historial"type="text" name="nombre" title="NOMBRE DE LA EMPRESA" placeholder="NOMBRE DE LA EMPRESA" maxlength="30"  class="frm_empresa" required /><br />
		                    <input type="text" name="tel"  title="TELÉFONO DE LA EMPRESA" placeholder="TELEFONO DE LA EMPRESA" maxlength="18"  class="frm_empresa"  required/><br />
		                    <input type="text" name="web"  title="WEB DE LA EMPRESA" placeholder="WEB DE LA EMPRESA" maxlength="40"  class="frm_empresa" /><br />
		                    <input type="text" name="email"  title="EMAIL DE LA EMPRESA" placeholder="EMAIL DE LA EMPRESA" maxlength="30"  class="frm_empresa"required/><br />
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
<script type="text/javascript" src="js/App/Structure/StructureDatosEgresado.js"></script>
<script type="text/javascript" src="js/App/Class/Toggle.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        Animaciones.init();
        Toggle.init();
        var no_control=<?php echo $_SESSION['No_control'] ?>;//cargar variable
        EventosForm.init();
        EventosForm.setNoControl(no_control);
        LimpiarForm.init();
        DatosAcademicos.init();
        DatosAcademicos.setNoControl(no_control);
        DatosAcademicos.dt_academicos(no_control);
        DatosSoftware.init();
        DatosSoftware.setNoControl(no_control);
        DatosSoftware.dt_SW(no_control);
        DatosPersonales.init();
        DatosPersonales.setNoControl(no_control);
        DatosPersonales.requestDatosEgresado(no_control);
        DatosIdioma.init();
        DatosIdioma.setNoControl(no_control);
        DatosIdioma.requestDatosIdioma(no_control);
    });
</script>  
</html>    
        <?php else : header('Location: error.php'); ?>
         
<?php endif; }?>
