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
	$("#div_dt_software").on('click',".eliminar_sw",function(){//imagen eliminar  de datos sw
            // var id=$(this).attr('id').slice(16);
            confirmar_sw(no_control,id);
	});
        $("#div_dt_software").on('keypress',".eliminar_sw",function(e){//imagen eliminar  de datos sw
            if(e.which===13){
                var id=$(this).attr('id').slice(16);
                confirmar_sw(no_control,id);
            }
	});
	/*clases generales*/
	$(".limpiar").mouseenter(function() {
      $(this).attr('src','Imagenes/limpiar_verde.png');  
    });
	$(".limpiar").mouseleave(function() {
      $(this).attr('src','Imagenes/limpiar.png');  
    });
        $(".limpiar").focusin(function() {
      $(this).attr('src','Imagenes/limpiar_verde.png');  
    });
	$(".limpiar").focusout(function() {
      $(this).attr('src','Imagenes/limpiar.png');  
    });
	
	$(".limpiar").click(function() {
        limpiaForm($(this).parent());
    });
	$(".agregar_carrera").mouseenter(function(e) {
    	$(this).attr('src','Imagenes/agregar_amarillo.png');    
    });
	$(".agregar_carrera").mouseenter(function(e) {
    	$(this).attr('src','Imagenes/agregar.png');    
    });
        $(".agregar_carrera").focusin(function(e) {
    	$(this).attr('src','Imagenes/agregar_amarillo.png');    
    });
	$(".agregar_carrera").focusout(function(e) {
    	$(this).attr('src','Imagenes/agregar.png');    
    });
	$("#div_idioma").on('click',".eliminar_idioma",function(){//imagen eliminar  de idiomas
		var id=$(this).attr('id').slice(20);
               confirmar_idioma(no_control,id);
	});
        $("#div_idioma").on('keypress',".eliminar_idioma",function(e){//imagen eliminar  de idiomas
	    if(e.which===13){
                var id=$(this).attr('id').slice(20);
               confirmar_idioma(no_control,id);
            }
	});
	$("#div_idioma").on('click',"#agregar_idioma",function(){//imagen agregar idioma a
		show_idiomas_();
                $('#idiomas').focus();
	});
        $("#div_idioma").on('keypress',"#agregar_idioma",function(e){//imagen agregar idioma a
	    if(e.which===13){
                show_idiomas_();
                $('#idiomas').focus();
            }
	});
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
	$("#img_limpiar_frm_dt_personales").click(function() {
            limpiaForm($("#frm_Datos_Personales"));
        });
        $("#img_limpiar_frm_dt_personales").keypress(function(e) {
            if(e.which===13)
                limpiaForm($("#frm_Datos_Personales"));
        });
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
	$("#img_limpiar_frm_historial").click(function(e) {
            limpiaForm($("#frm_historial"));    
        });
        $("#img_limpiar_frm_historial").keypress(function(e) {
            if(e.which===13)
                limpiaForm($("#frm_historial")); 
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
	$("#img_limpiar_frm_social").click(function(e) {
            limpiaForm($("#frm_social"));   
        });
        $("#img_limpiar_frm_social").keypress(function(e) {
            if(e.which===13)
                limpiaForm($("#frm_social"));   
        });
}/*fin de load*/);
</script>
<script type="text/javascript">
		$("document").ready(function() {
			/*animaciones y colores*/
			
			$("#img_ayuda").hover(function(){
				$(this).attr('src','Imagenes/ayuda_grande_white.png');
			},function(){
				$(this).attr('src','Imagenes/ayuda_grande.png');	
			});
			$(".cancelar").hover(function(){
				$(this).attr('src','Imagenes/cancelar_rojo.png');
			},function(){
				$(this).attr('src','Imagenes/cancelar.png');	
					});
                        $('.cancelar').focusin(function(){
                           $(this).attr('src','Imagenes/cancelar_rojo.png'); 
                        });
                        $('.cancelar').focusout(function(){
                           $(this).attr('src','Imagenes/cancelar.png'); 
                        });
			/*-------------empresa-----------*/
			$("#div_dt_social").on('mouseenter',".elimnar_empresa",function(){//cambiar imagen de eliminar de empresa 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
                        });
			$("#div_dt_social").on('mouseleave',".elimnar_empresa",function(){//devolver imagen de eliminar empresa
                            $(this).attr('src','Imagenes/cancelar.png');
                        });
                        $("#div_dt_social").on('focusin',".elimnar_empresa",function(){//cambiar imagen de eliminar de empresa 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
                        });
			$("#div_dt_social").on('focusout',".elimnar_empresa",function(){//devolver imagen de eliminar empresa
                            $(this).attr('src','Imagenes/cancelar.png');
                        });
			
			$("#img_agregar_requisitos").mouseenter(function(){//efecto a imagen agregar requisito
                            $(this).attr('src','Imagenes/más_verde.png');
			});	
			$("#img_agregar_requisitos").mouseleave(function(){
                            $(this).attr('src','Imagenes/más.png');
			});	
			$("#img_agregar_requisitos").focusin(function(){//efecto a imagen agregar requisito
                            $(this).attr('src','Imagenes/más_verde.png');
			});	
			$("#img_agregar_requisitos").focusout(function(){
                            $(this).attr('src','Imagenes/más.png');
			});
			$("#img_cancelar_empresa").mouseenter(function(){//efecto a imagen cancelar frm empresa
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#img_cancelar_empresa").mouseleave(function(){//cerrar frm empresa
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#img_cancelar_empresa").focusin(function(){//efecto a imagen cancelar frm empresa
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#img_cancelar_empresa").focusout(function(){//cerrar frm empresa
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			$("#frm_empresa").on('mouseenter',".eliminar_requisito",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/eliminar.gif');
			});
			$("#frm_empresa").on('mouseleave',".eliminar_requisito",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/eliminar_verde.gif');
			});
                        $("#frm_empresa").on('focusin',".eliminar_requisito",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/eliminar.gif');
			});
			$("#frm_empresa").on('focusout',".eliminar_requisito",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/eliminar_verde.gif');
			});
			$("#div_dt_empresa").on('mouseenter',".editar_empresa",function(){//cambiar imagen de agregar de empresa 
                            $(this).attr('src','Imagenes/edita_amarillo.png');
			});
			$("#div_dt_empresa").on('mouseleave',".editar_empresa",function(){//devolver imagen de agregar empresa
                            $(this).attr('src','Imagenes/editar.png');
			});
                        $("#div_dt_empresa").on('focusin',".editar_empresa",function(){//cambiar imagen de agregar de empresa 
                            $(this).attr('src','Imagenes/edita_amarillo.png');
			});
			$("#div_dt_empresa").on('focusout',".editar_empresa",function(){//devolver imagen de agregar empresa
                            $(this).attr('src','Imagenes/editar.png');
			});
			$("#div_dt_empresa").on('mouseenter',".elimnar_empresa",function(){//cambiar imagen de eliminar de empresa 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});
			$("#div_dt_empresa").on('mouseleave',".elimnar_empresa",function(){//devolver imagen de eliminar empresa
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#div_dt_empresa").on('focusin',".elimnar_empresa",function(){//cambiar imagen de eliminar de empresa 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});
			$("#div_dt_empresa").on('focusout',".elimnar_empresa",function(){//devolver imagen de eliminar empresa
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			$("#div_dt_empresa").on('mouseenter',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_empresa").on('mouseleave',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
			});
                        $("#div_dt_empresa").on('focusin',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_empresa").on('focusout',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
			});
			/*--------social----------*/	
			$("#div_dt_social").on('mouseenter',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_social").on('mouseleave',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
			});
                        $("#div_dt_social").on('focusin',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_social").on('focusout',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
			});
			/*--------personales--------*/
			$("#img_limpiar_frm_dt_personales").mouseenter(function() {//cambiar imagen limpiar frm dt oersonales
                            $(this).attr('src','Imagenes/limpiar_verde.png');    
                        });
			$("#img_limpiar_frm_dt_personales").mouseleave(function() {//cambiar imagen limpiar frm dt oersonales
                            $(this).attr('src','Imagenes/limpiar.png');    
			});
                        $("#img_limpiar_frm_dt_personales").focusin(function() {//cambiar imagen limpiar frm dt oersonales
				$(this).attr('src','Imagenes/limpiar_verde.png');    
                        });
			$("#img_limpiar_frm_dt_personales").focusout(function() {//cambiar imagen limpiar frm dt oersonales
				$(this).attr('src','Imagenes/limpiar.png');    
			});
			$("#contenedor_form_datos_personales").on('mouseenter',".cancelar",function(){//cambiar imagen cerrar frm datos personales
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#contenedor_form_datos_personales").on('mouseleave',".cancelar",function(){//devolver imagen cerrar frm datos personales
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			$("#contendedor_d1").on('mouseenter',"#img_editar",function(){//cambiar imagen de editar de datos personales 
				$(this).attr('src','Imagenes/edita_amarillo.png');
			});
			$("#contendedor_d1").on('mouseleave',"#img_editar",function(){//devolver imagen de editar de datos personales
				$(this).attr('src','Imagenes/editar.png');
			});
                        $("#contendedor_d1").on('focusin',"#img_editar",function(){//cambiar imagen de editar de datos personales 
				$(this).attr('src','Imagenes/edita_amarillo.png');
			});
			$("#contendedor_d1").on('focusout',"#img_editar",function(){//devolver imagen de editar de datos personales
				$(this).attr('src','Imagenes/editar.png');
			});
                        /*-----------posgrado-----------*/
                        $("#div_dt_posgrado").on('mouseenter',".eliminar",function(){//cambiar imagen de eliminar de datos academicos 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#div_dt_posgrado").on('mouseleave',".eliminar",function(){//devolver imagen original de eliminar de datos academicos
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#div_dt_posgrado").on('focusin',".eliminar",function(){//cambiar imagen de eliminar de datos academicos 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#div_dt_posgrado").on('focusout',".eliminar",function(){//devolver imagen original de eliminar de datos academicos
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#div_dt_posgrado").on('mouseenter',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_posgrado").on('mouseleave',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
			});
                        $("#div_dt_posgrado").on('focusin',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_posgrado").on('focusout',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
			});
			/*-----------academico-----------*/
			$("#datos_academicos").on('mouseenter',".eliminar",function(){//cambiar imagen de eliminar de datos academicos 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#datos_academicos").on('mouseleave',".eliminar",function(){//devolver imagen original de eliminar de datos academicos
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#datos_academicos").on('focusin',".eliminar",function(){//cambiar imagen de eliminar de datos academicos 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#datos_academicos").on('focusout',".eliminar",function(){//devolver imagen original de eliminar de datos academicos
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			$("#datos_academicos").on('mouseleave',".editar_academico",function(){//devolver imagen de editar de datos academicos
                            $(this).attr('src','Imagenes/editar.png');
			});
			$("#datos_academicos").on('mouseenter',".editar_academico",function(){//cambiar imagen de editar de datos academicos 
                            $(this).attr('src','Imagenes/edita_amarillo.png');
			});
                        $("#datos_academicos").on('focusin',".editar_academico",function(){//devolver imagen de editar de datos academicos
                            $(this).attr('src','Imagenes/edita_amarillo.png');
			});
			$("#datos_academicos").on('focusout',".editar_academico",function(){//cambiar imagen de editar de datos academicos 
                            $(this).attr('src','Imagenes/editar.png');
			});
			$("#datos_academicos").on('mouseenter',".agregar_carrera",function(){//cambiar imagen de agregar de datos academicos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#datos_academicos").on('mouseleave',".agregar_carrera",function(){//devolver imagen de agregar de datos academicos
                            $(this).attr('src','Imagenes/agregar.png');
			});
                        $("#datos_academicos").on('focusin',".agregar_carrera",function(){//cambiar imagen de agregar de datos academicos 
				$(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#datos_academicos").on('focusout',".agregar_carrera",function(){//devolver imagen de agregar de datos academicos
				$(this).attr('src','Imagenes/agregar.png');
			});
			$("#imgfrm_cancelar_academicos").mouseenter(function(){//efecto a imagen cancelar frm dt academicos
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});
			$("#imgfrm_cancelar_academicos").mouseleave(function(){
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#imgfrm_cancelar_academicos").focusin(function(){//efecto a imagen cancelar frm dt academicos
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});
			$("#imgfrm_cancelar_academicos").focusout(function(){
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			/*---------idioma------------*/
			$("#div_idioma").on('mouseenter',".eliminar_idioma",function(){//cambiar imagen de eliminar de idioma 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#div_idioma").on('mouseleave',".eliminar_idioma",function(){//devolver imagen original de eliminar idioma
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#div_idioma").on('focusin',".eliminar_idioma",function(){//cambiar imagen de eliminar de idioma 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#div_idioma").on('focusout',".eliminar_idioma",function(){//devolver imagen original de eliminar idioma
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			$("#div_idioma").on('mouseenter',"#agregar_idioma",function(){//cambiar imagen de agregar idioma
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_idioma").on('mouseleave',"#agregar_idioma",function(){//devolver imagen de agregar idioma
                            $(this).attr('src','Imagenes/agregar.png');
			});
                        $("#div_idioma").on('focusin',"#agregar_idioma",function(){//cambiar imagen de agregar idioma
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_idioma").on('focusout',"#agregar_idioma",function(){//devolver imagen de agregar idioma
                            $(this).attr('src','Imagenes/agregar.png');
			});
			$("#img_cancelar_idiomas").mouseenter(function(){//efecto a imagen cancelar frm dt idiomas
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#img_cancelar_idiomas").mouseleave(function(){
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#img_cancelar_idiomas").focusin(function(){//efecto a imagen cancelar frm dt idiomas
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#img_cancelar_idiomas").focusout(function(){
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			/*--------sw-------*/
			$("#div_dt_software").on('mouseenter',".eliminar_sw",function(){//imagen eliminar  de datos sw
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});
			$("#div_dt_software").on('mouseleave',".eliminar_sw",function(){//imagen eliminar  de datos sw
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#div_dt_software").on('focusin',".eliminar_sw",function(){//imagen eliminar  de datos sw
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});
			$("#div_dt_software").on('focusout',".eliminar_sw",function(){//imagen eliminar  de datos sw
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			$("#div_frm_software").on('mouseenter',".cancelar",function(){//cambiar imagen cerrar original de frm sw 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#div_frm_software").on('mouseleave',".cancelar",function(){//devolver imagen cerrar original de frm sw 
                            $(this).attr('src','Imagenes/cancelar.png');
			});
                        $("#div_frm_software").on('focusin',".cancelar",function(){//cambiar imagen cerrar original de frm sw 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			});	
			$("#div_frm_software").on('focusout',".cancelar",function(){//devolver imagen cerrar original de frm sw 
                            $(this).attr('src','Imagenes/cancelar.png');
			});
			$("#div_dt_software").on('mouseenter',".agregar_carrera",function(){//cambiar imagen de agregar de datos sw 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_software").on('mouseleave',".agregar_carrera",function(){//devolver imagen de agregar de datos sw
                            $(this).attr('src','Imagenes/agregar.png');
			});
                        $("#div_dt_software").on('focusin',".agregar_carrera",function(){//cambiar imagen de agregar de datos sw 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
			});
			$("#div_dt_software").on('focusout',".agregar_carrera",function(){//devolver imagen de agregar de datos sw
                            $(this).attr('src','Imagenes/agregar.png');
			});
			/*--------historial-----*/	
			$("#div_dt_historial_empresa").on('mouseenter',".editar_empresa",function(){//cambiar imagen de agregar de historia empresa 
                            $(this).attr('src','Imagenes/edita_amarillo.png');
                        });
			$("#div_dt_historial_empresa").on('mouseenter',".elimnar_empresa",function(){//cambiar imagen de eliminar dehistorial  empresa 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
                        });
                        $("#div_dt_historial_empresa").on('focusin',".elimnar_empresa",function(){//cambiar imagen de eliminar dehistorial  empresa 
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
                        });
                        $("#div_dt_historial_empresa").on('focusin',".editar_empresa",function(){//cambiar imagen de agregar de historia empresa 
                            $(this).attr('src','Imagenes/edita_amarillo.png');
                        });
			$("#div_dt_historial_empresa").on('focusout',".elimnar_empresa",function(){//cambiar imagen de eliminar dehistorial  empresa 
                            $(this).attr('src','Imagenes/cancelar.png');
                        });
			$("#div_dt_historial_empresa").on('mouseleave',".elimnar_empresa",function(){//devolver imagen de eliminar historial empresa
                            $(this).attr('src','Imagenes/cancelar.png');
                        });		
			$("#div_dt_historial_empresa").on('mouseleave',".editar_empresa",function(){//devolver imagen de agregar historia empresa
                            $(this).attr('src','Imagenes/editar.png');
                        });		
			$("#div_dt_historial_empresa").on('focusout',".editar_empresa",function(){//devolver imagen de agregar historia empresa
                            $(this).attr('src','Imagenes/editar.png');
                        });
			$("#div_dt_historial_empresa").on('mouseenter',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
                        });
			$("#div_dt_historial_empresa").on('mouseleave',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
                        });
                        $("#div_dt_historial_empresa").on('focusin',".agregar_carrera",function(){//cambiar imagen de agregar de requisitos 
                            $(this).attr('src','Imagenes/agregar_amarillo.png');
                        });
			$("#div_dt_historial_empresa").on('focusout',".agregar_carrera",function(){//devolver imagen de agregar requisitos
                            $(this).attr('src','Imagenes/agregar.png');
                        });
			/*----------------social---------*/
			$("#img_cerrar_frm_historial").hover(function(){
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
			},function(){
                            $(this).attr('src','Imagenes/cancelar.png');	
			});
                        $("#img_cerrar_frm_historial").focusin(function(){
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
                        });
                        $("#img_cerrar_frm_historial").focusout(function(){
                            $(this).attr('src','Imagenes/cancelar.png');
                        });
			$("#img_cerrar_frm_social").hover(function(){
				$(this).attr('src','Imagenes/cancelar_rojo.png');
			},function(){
				$(this).attr('src','Imagenes/cancelar.png');	
			});
                        $("#img_cerrar_frm_social").focusin(function(){
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
                        });
                        $("#img_cerrar_frm_social").focusout(function(){
                            $(this).attr('src','Imagenes/cancelar_rojo.png');
                        });
		
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
		$("#img_limpiar_frm_dt_empresa").click(function(e) {
			limpiaForm($("#frm_empresa"));    
		});
                $("#img_limpiar_frm_dt_empresa").keypress(function(e) {
		    if(e.which===13)
                        limpiaForm($("#frm_empresa"));
		});
		$("#img_limpiar_frm_dt_academicos").click(function(e) {//limpiar frm dt personles
		   limpiaForm($("#frm_datos_academicos")); 
		});
		$("#img_limpiar_frm_dt_academicos").keypress(function(e) {//limpiar frm dt personles
		   if(e.which===13)
                       limpiaForm($("#frm_datos_academicos"));
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
	$('#img_posgrado').jrumble({
		x: 10,
		y: 10,
		rotation: 4
	}); 
	$('#img_ingenieria').jrumble({
		x: 10,
		y: 10,
		rotation: 4
	});
	
        
	$("#img_posgrado,#img_ingenieria").hover(function(){
			$(this).trigger('startRumble');
		}, function(){
			$(this).trigger('stopRumble');
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
	$("#img_posgrado,#img_ingenieria").focusin(function(){
           $(this).trigger('startRumble'); 
        });
        $("#img_posgrado,#img_ingenieria").focusout(function(){
           $(this).trigger('stopRumble'); 
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
        <div id="alert_academico" class="ventana">
            <p id="p-alert-academico"></p>   
        </div>
        <div id="alert_personales" class="ventana">
                        <span id="span-alert-personales"></span>
                    </div>
        <div id="primero">
         <div id="dialogo" class="ventana" title="¿Estas Seguro?">  
        	<p>LA CARRERA SE BORRARA DEL SISTEMA DE MANERA PERMANENTE,¿ESTAS SEGURO?</p>
        </div>
        <div class="row">
        	<h1 style="font-size:24px">DATOS PERSONALES</h1>
        	<div  id="contenedor_foto_e" class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="text-align:center">
               		<img id="foto_egresado" src="Imagenes/businessman_green.png" style=" max-width:100%; border:5px #999 solid" title="IMAGEN DE PERFIL" class="img-responsive img-rounded"/>
                    <img id="cargando_foto" src="Imagenes/loading_min.gif"/>
                    <br />
                    
                        <button  id="addImage" class="guardar" style="width:40%; margin:auto">Cambiar</button>               
            </div>
            <div class="col-lg-6 col-lg-push-1 col-md-8  col-sm-12 col-xs-12">
                <div id="contenedor_form_datos_personales">
                    <img src="Imagenes/loading45.gif" class="enviando loading" id="enviar"  style="display:none" />
                    <img id="cancelar" src="Imagenes/cancelar.png"  title="CERRAR FORMULARIO" class="cancelar" tabindex="0"/>
                    <form id="frm_Datos_Personales" style="text-align:left; padding-left:10px" method="post">
                    <h2>Datos Personales</h2>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
                        	<div class="form-group">
                        		<input id="nombre" name="nombre" type="text"  placeholder="NOMBRE" class="text" maxlength="40"  title="NOMBRE"  required />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
                        	<div class="form-group">
                        		<input name="apellido_p" type="text"  placeholder="APELLIDO PATERNO" class="text" maxlength="40"  title="APELLIDO PATERNO"  required />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
                        	<div class="form-group">
                       			<input name="apellido_m" type="text"  placeholder="APELLIDO MATERNO" class="text" maxlength="40"  title="APELLIDO MATERNO"  required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" >
                        <div class="form-group">
                            <input name="curp" type="text"  placeholder="CURP" maxlength="18" class="text_2" title="CURP" required />
                            <a href="http://consultas.curp.gob.mx/CurpSP/" target="_blank" title="CONSULTAR CURP"><img src="Imagenes/ayuda.png" /></a>
                            <select name="genero" class="domicilio" title="Género">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                            <input type="text" id="datepicker" name="fecha_nac"  readonly="readonly" class="text_2" placeholder="FECHA DE NACIMIENTO"  title="FECHA DE NACIMIENTO" required />
                          
                            <input name="tel" type="tel"  placeholder="TELÉFONO" maxlength="15" class="text_2" title="TELÉFONO" required/>
                           
                            <input name="email" type="email" placeholder="EMAIL" maxlength="30" class="text_2"  title="EMAIL"  required />
                           <p style="text-align:center; font-size:22px">DOMICILIO</p>
                           <input  id="ciudad" name="ciudad" type="text" placeholder="CIUDAD O LOCALIDAD" maxlength="40" class="text_2"  title="CIUDAD O LOCALIDAD" required />
                           <input  id="colonia" name="colonia" type="text" placeholder="COLONIA" maxlength="40" class="text_2"  title="COLONIA" required />
                           <input  id="calle" name="calle" type="text" placeholder="CALLE" maxlength="30" class="text_2"  title="CALLE" required />
                           <input name="no_casa" placeholder="No:CASA" maxlength="10" class="text_2" title="No:CASA"  id="no_casa" required />
                           <input name="cp" placeholder="Código Postal" maxlength="5" class="text_2" title="Código Postal"  id="cp" required />
                       </div>
                   </div>
                   </div>
                   <div class="row">
                   		<div class="col-lg-4 col-md-4 col-xs-12 col-xs-12">
                       		<select id="estados" class="domicilio" name="estado" title="ESTADOS"><option value="1">Cargando</option></select>
                       </div>
                       <div class="col-lg-4 col-md-4 col-xs-12 col-xs-12">
                       <img id="img_cargando_estado" src="Imagenes/loading_min.gif" style="width:30px; height:30px; display:none; position:absolute; right:0px" />
                       		<select id="Municipios" class="domicilio" name="municipio" title="MUNICIPIO" style="width:80%;"><option value="1">MUNICIPIO</option></select></div>
                       <div class="col-lg-4 col-md-4 col-xs-12 col-xs-12">
                           <img id="img_limpiar_frm_dt_personales"  src="Imagenes/limpiar.png" title="LIMPIAR FORMULARIO" tabindex="0"/>
                           <input   type="submit"  value="GUARDAR" id="btn_guardar" class="guardar" title="GUARDAR"  style="position:absolute; bottom:5px; right:1%;"/>
                       </div>
                   </div>
                    </form>
            </div>
        	<div id="contenedor_Datos_Personales">
                    
            	 <img src="Imagenes/loading.gif"  class="cargando" id="cargando_frm"/>
        		<div id="contendedor_d1">
                        </div>
        	</div>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12"  style="padding:0px">
            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:0px">
                    <img  id="img_ingenieria" src="Imagenes/ingenieria_activo.png" style="width:auto; height:120px;border:1px solid #999" class="img-responsive cursor"  tabindex="0"/>
                </div> 
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:0px">   
                    <img id="img_posgrado"  src="Imagenes/posgrado.png"  style="width:auto; height:120px;" class="img-responsive cursor" tabindex="0"/>
                </div>
        </div>    
        </div>
        	<div class="row">    
            
                <div id="contenedor_datos_academicos">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" >
                    <div id="div_academia">
                        <div id="div_posgrado">
                            <div id="div_borrar_posgrado" style="display:none">
                                <p>Su posgrado se borrará de manera permanente, dicha acción una vez terminada es irreversible </p>
                            </div>
                            <img src="Imagenes/loading.gif" class="cargando" style="display:none" id="img_cargando_posgrado" />
                            <div id="div_frm_posgrado" style="text-align:center">
                            <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_posgrado" style="display:none; top:70px" />	
                                <form id="frm_posgrado">
                                    <label style="font-size:22px">Formulario de posgrado</label><br />
                                    <img src="Imagenes/cancelar.png" id="img_cancelar_posgrado" title="CERRAR FORMULARIO" class="cancelar" tabindex="0"/>
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
                                                <option value="0">TITULADO</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="text" name="nombre" required  style="width:80%" maxlength="110" class="frm_empresa" placeholder="NOMBRE DE POSGRADO"/><br /><br />
                                    <input type="text" name="escuela" required style="width:80%" maxlength="80" class="frm_empresa" placeholder="ESCUELA"/><br /><br />
                                    <input type="submit" value="GUARDAR" class="guardar" /><img id="img_limpiar_frm_posgrado"  src="Imagenes/limpiar.png" title="LIMPIAR FORMULARIO" class="limpiar"  style="width:40px; height:40px" tabindex="0"/>
                                </form>
                            </div>
                            <div id="div_dt_posgrado"></div>
                        </div>
                        <div id="div_ingenieria">
                        <img src="Imagenes/loading.gif" id="img_cargando_dt_academicos" class="cargando" />
                            <div id="frm_datos_academicos" style="width:100%">
                                <br />    
                            <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_academico" style="top:10%;display:none" />
                                <form id="frm_dt_academico">
                                    <h2 style="font-size:22px">FORMULARIO DE DATOS ACADEMICOS</h2>
                                    <img src="Imagenes/cancelar.png" id="imgfrm_cancelar_academicos"  title="CANCELAR Y CERRAR FORMULARIO" tabindex="0"/>
                                    <div class="row">
                                    	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <select id="carrera"  title="CARRERA"class=" basicos" style="width:90%;height:35px;padding:2px;margin:10px" name="carrera" ><option value="1">Cargando</option></select>
                                         </div>
                                         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">   
                                            <select id="especialidad"  title="ESPECIALIDAD"class=" basicos" style="width:80%;height:35px;padding:2px;margin:10px" name="especialidad"><option value="1">ESPECIALIDAD</option></select><img id="img_cargando" src="Imagenes/loading_.gif" style="width:30px; height:30px" />
                                         </div>  
                                    </div>
                                    <div class="row">
                                    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <select id="select_titulado" name="titulado" class="basicos" style="width:80%; margin:10px">
                                                <option value="0">TITULADO</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        	<input type="text" id="dp_academico_inicio" title="INICIO" readonly name="fecha_inicio" placeholder="INICIO" style="width:80%"  class="frm_acedemico_"required/>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        	<input type="text" id="dp_academico_fin"   title="FINALIZACIÓN" readonly name="fecha_fin" placeholder="FINALIZACIÓN"  style="width:80%"class="frm_acedemico_" required />
                                        </div>
                                    </div>
                                    <input   type="submit"   title="GUARDAR" value="GUARDAR" id="btn_guardar_academico" class="guardar"  />
                                    <img id="img_limpiar_frm_dt_academicos"  src="Imagenes/limpiar.png" title="LIMPIAR FORMULARIO" class="limpiar" style="width:40px; height:40px;" tabindex="0" />
                                </form>
                                <br />
                                <p  id="titlo_carrera" style="font-size:20px; color:#090">CARRRERA Y ESPECIALIDAD A EDITAR</p>
                                <div id="div_carrera_actualizar"></div>
                                <br />
                            </div>
                             <div id="datos_academicos"></div>
                        </div>
                    </div>
                    </div>
                    
                 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">   
                    <div id="dt_academicos_idiomas_sw">
                    <div id="dialogo_idioma" class="ventana" title="¿Estas Seguro?">  
                        <p>EL IDIOMA SE BORRARA DEL SISTEMA DE MANERA PERMANENTE,¿ESTAS SEGURO?</p>
                    </div>
                        <div class="row">
                            <div class="col-lg-12" id="div-principal-idioma">
                                <img src="Imagenes/loading.gif"  class="cargando" id="img_cargando_idiomas"/>    
                                <div id="div_idioma">
                                </div>
                            </div>
                            <div id="div_frm_idioma">         
                                <img src="Imagenes/loading45.gif" class=" enviando" id="img_enviar_idioma" /> 
                                <form id="frm_idioma" style="text-align:center; ">
                                    <label style="text-align:center; font-size:22px; font-weight:bold">Formulario de Idiomas</label><br />
                                     <img src="Imagenes/cancelar.png" id="img_cancelar_idiomas"  title="CERRAR FORMULARIO" tabindex="0" /><br />	
                                    <select name="idiomas" id="idiomas"  title="IDIOMAS" class="basicos" style="width:60%; height:30px; text-align:center; margin-bottom:10px">
                                        <option value="1">CARGANDO</option>
                                    </select>
                                    <br />
                                    <p class="frm_idiomas">Porcentaje habla
                                        <input type="number" id="porcentaje_habla" class="frm_idiomas_" title="HABLA"  name="porcentaje_habla" required max="100" min="1" style="width:20%"/>
                                    </p>
                                    <p class="frm_idiomas" >Lectura y escritura
                                        <input type="number" id="porcentaje_lec"  class="frm_idiomas_" name="porcentaje_lec" title="ESCRITURA Y LECTURA" required max="100" min="1" style="width:20%"/>
                                    </p>
                                    <p style="text-align:center">
                                        <input type="submit" value="GUARDAR" id="guardar_idoma" title="GUARDAR" class="guardar" style=" width:40%" />
                                        <img id="img_limpiar_frm_Idioma"  src="Imagenes/limpiar.png" title="LIMPIAR FORMULARIO" class="limpiar limpiar_form" data-target="frm_idioma"  style="width:40px; height:40px" tabindex="0" />
                                    </p>
                                </form>
                            </div>
                        </div>
                   <div class="row">     
                    <div id="div_software" class="col-xs-12">
                     <div id="dialogo_sw" class="ventana" title="¿Estas Seguro?">  
                        <p>EL SOFTWARE SE BORRARA DEL SISTEMA DE MANERA PERMANENTE,¿ESTAS SEGURO?</p>
                    </div>
                     <img src="Imagenes/loading.gif" id="img_cargando_sw" class="cargando" />
                        <div id="div_frm_software">
                            <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_sw" /> 
                            <form id="frm_sw" style="text-align:center">
                                <label style="text-align:center; font-size:22px; font-weight:bold">FORMULARIO DE SOFTWARE</label><br />
                                <img src="Imagenes/cancelar.png" id="img_cancelar_sw" title="CERRAR FORMULARIO"  class="cancelar" tabindex="0" />
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
                    </div>
                    
                    </div>
                </div>
            </div>
        </div>
	    <div id="segundo">
        	<div id="dialogo_empresa" class="ventana" title="¿Estas Seguro?">  
			</div>
            <div id="borrar_empresa" class="ventana" title="¿Estas Seguro?">
            	<p>LA EMPRESA SE BORRARA DE MANERA PERMANETE Y PASARA A TU HISTORIAL LABORAL, DICHA ACCIÓN UNA VEZ TERMINADA ES IRREVERSIBLE</p>  
			</div>
            <div class="row">
       	 	<div id="div_empresa">
            <img src="Imagenes/loading.gif"  class="cargando" style="display:none" id="img_cargando_empresa"/>
                <div  id="div_frm_empresa">
                <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_empresa" style="top:22%; display:none" />
                <div class="row">
                    <form  id="frm_empresa" style="text-align:center">
                    	<h1 style="font-size:22px;text-align:center">FORMULARIO DE DATOS DE LA EMPRESA</h1>
                     	<img src="Imagenes/cancelar.png" id="img_cancelar_empresa" title="CERRAR FORMULARIO"  class="cancelar" style="width:35px; height:35px" tabindex="0" /><br>
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
               			<input   type="submit"   title="GUARDAR" value="GUARDAR" id="btn_guardar_empresa" class="guardar" style="right:10%"  /><img id="img_limpiar_frm_dt_empresa"  src="Imagenes/limpiar.png" title="LIMPIAR FORMULARIO" class="limpiar" style="width:40px; height:40px;right:5%" tabindex="0" />
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
        	<img src="Imagenes/loading.gif" class="cargando" style="display:none" id="img_cargando_social" />
        	<div id="div_dt_social">
            </div>
            <div id="div_frm_social">
                <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_social" style="top:10%;" />
	            <div class="row">
	            	<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		            	<form id="frm_social" style="text-align:center;">
		                    <h2 style="font-size:22px;">FORMULARIO PARA ASOCIACIONES SOCIALES</h2>
		                    <img id="img_cerrar_frm_social" class="cancelar" src="Imagenes/cancelar.png" title="CERRAR FORMULARIO" tabindex="0" /><br>
                                        <input id="input-nombre-asociacion" type="text" name="nombre"   required="required" maxlength="30" class="frm_empresa"  placeholder="NOMBRE DE LA ASOCIACIÓN"/><br/>
		                    <select name="tipo" id="select_social" class="basicos" style="width:70%" >
		                        <option value="1">TIPO</option>
		                        <option value="GRUPO ESTUDIANTIL">GRUPO ESTUDIANTIL</option>
		                        <option value="ASOCIACIÓN CIVIL">ASOCIACIÓN CIVIL</option>
		                    </select><br />
		                    <input type="submit" value="GUARDAR" name="GUARDAR" class="guardar"/><img id="img_limpiar_frm_social"  src="Imagenes/limpiar.png" title="LIMPIAR FORMULARIO" class="limpiar" style="width:40px; height:40px;" tabindex="0" />
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
            <img src="Imagenes/loading.gif" class="cargando" style="display:none" id="img_cargando_historial" />
            <div id="div_frm_historial">
                <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_historial" style="top:15%; display:none" />
            	<div class="row">
            		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
		                <form id="frm_historial" style="text-align:center">
                                    <label style="font-size:22px;">FORMULARIO DE HISTORIAL EMPRESARIAL</label><br />
                                    <img id="img_cerrar_frm_historial" class="cancelar" src="Imagenes/cancelar.png" title="CERRAR FORMULARIO" tabindex="0" /><br>
                                        <input id="input-nombre-historial"type="text" name="nombre" title="NOMBRE DE LA EMPRESA" placeholder="NOMBRE DE LA EMPRESA" maxlength="30"  class="frm_empresa" required /><br />
		                    <input type="text" name="tel"  title="TELÉFONO DE LA EMPRESA" placeholder="TELEFONO DE LA EMPRESA" maxlength="18"  class="frm_empresa"  required/><br />
		                    <input type="text" name="web"  title="WEB DE LA EMPRESA" placeholder="WEB DE LA EMPRESA" maxlength="40"  class="frm_empresa" /><br />
		                    <input type="text" name="email"  title="EMAIL DE LA EMPRESA" placeholder="EMAIL DE LA EMPRESA" maxlength="30"  class="frm_empresa"required/><br />
		                    <input type="submit" name="GUARDAR" value="GUARDAR" class="guardar" placeholder="GUARDAR" title="GUARDAR"/><img id="img_limpiar_frm_historial"  src="Imagenes/limpiar.png" title="LIMPIAR FORMULARIO" class="limpiar" style="width:40px; height:40px;" tabindex="0" />
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
                            <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_residencia" style="top:70px"/>
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
                <img src="Imagenes/loading45.gif" class="enviando" id="img_enviar_pass" style="top:60%;display: none" />    
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
                                <img id="img-ayuda-cancelar" src="Imagenes/cancelar.png" class="media-object img-giro" alt="imagen">
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
<script type="text/javascript" src="js/Animaciones.js"></script>
<script type="text/javascript" src="js/LimpiarForm.js"></script>
<script type="text/javascript" src="js/DatosAcademicos.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var no_control=<?php echo $_SESSION['No_control'] ?>;//cargar variable
        EventosForm.init();
        EventosForm.setNoControl(no_control);
        Animaciones.init();
        LimpiarForm.init();
        DatosAcademicos.init();
        DatosAcademicos.setNoControl(no_control);
        DatosAcademicos.dt_academicos(no_control);
    });
</script>  
</html>    
        <?php else : header('Location: error.php'); ?>
         
<?php endif; }?>
