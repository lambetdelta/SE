<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bienvenido</title>
<link href="HojasEstilo/estiloBienvenido.css" rel="stylesheet" type="text/css" />
</head>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
$("document").ready(function() {
	$( "#Estados" ).load( "contenidos/Estados.php" );
	$("#Estados").change(function()
	 	{
		var id_estado=$("#Estados").val();
		$.get("contenidos/Municipios.php",{param_id_estado:id_estado})
		.done(function(data)
			{
			$("#Municipio").html(data);
			}/*fin de done*/)
		}/*fin de change*/ );
		
}/*fin de load*/);
</script>
     <?php if (login_check($mysqli) == true) : ?>
     <body>
 	<header>
    	<figure>
        	<img src="Imagenes/banner_ittj.png" class="centrar"/>
         </figure>
    </header>
     	<section> 
          <div class="frase">
          	<?php 
				list($fechaCon,$direccion,$cargo,$domicilio,$email,$web)=datos();
				echo $fechaCon;
			?>
          </div>
          <div class="fecha">
			  <?php $fecha=fecha();
              echo $fecha; ?>
          </div>
          <article class="Escolar" style="color:#333">
              <div class="Mensagge">
              <h1>ESTIMADO EGRESADO</h1>
               <br/>
             
               <p>Los servicios educativos de este Instituto  Tecnológico debe estar en mejora continua para asegurar la        pertinencia de los conocimientos adquiridos y mejorar sistemáticamente, para colaborar en la formación integral de nuestros alumnos.</p>
               <br />
               <p>Para esto es indispensable tomarte en cuenta como factor de cambios y reformas, por lo que por este medio solicitamos tu valiosa participación y cooperación en esta investigación del Seguimiento de Egresados, que nos permitira obtener información valiosa para analizar la problematica del mercado laboral y sus características, así como las competencias laborales de nuestros egresados.</p>
               <br />
               <p>Los datos proporcionados  serán tratados con absoluta confidencialidad y con fines, meramente estadísticos.</p>
               <br />
              
               <p>Con nuestro agradecimiento por tu cooperación, recibe un cordial saludo.</p>
               <br />
               <br />
               <p>ATENTAMENTE</p>
               <i>Educando Para La Sociedad Actual Y Los Retos Del Futuro</i>
               <figure style="margin-left:0%">
               		<img src="Imagenes/firmaDirector.JPG" />
               </figure>
               	<?php 
				echo $direccion;
			    ?>
            <br/>
            <?php 
				echo $cargo;
			?>
            <a href="perfil.php" class="ir_perfil">ACEPTAR</a>
          </div>
                        <?php else : ?>
                          <body class="Body_error">
 	                      <header>
    						<figure>
        						<img src="Imagenes/banner_ittj.png" class="centrar"/>
         					</figure>
    					  </header>
                        <div class="message_erro">
                            <p>
                                <span class="error">No está autorizado para acceder a esta página.</span> Por favor <a href="index.php">acceda a su cuenta.</a>.
                            </p>
                        <figure>
                        	<img src="Imagenes/explode.png" class="centrar" />
                        </figure>    
                        </div>    
                        <?php endif; ?>
                </article>
        </section>
        <footer>
        	<div class="Pie">
            	<figure style="margin-left:0px">
            		<img src="Imagenes/logo_ittj.png" />
                </figure>
                <div class="Contacto"><?php 
				echo $domicilio;
			?><a href="mailto:ittj@ittlajomulco.edu.mx"><?php echo $email?></a>,<a href="http://www.ittlajomulco.edu.mx/"><?php echo $web?></a> </div>
                <figure class="imgRight">
                	<img src="Imagenes/logo_ittj.png" />
                </figure>
            </div>
        </footer>
</body>
</html>
