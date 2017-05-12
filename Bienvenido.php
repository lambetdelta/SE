<?php
/* Cualquier duda repecto al código o en que diablos estaba pensando cuando lo hice :) enviar un correo 
 *  con el asunto SE a la siguiente direccion lambetdelta@hotmail.com con el  Ing. Osvaldo Uriel Garcia Gomez*/ 
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
<link href="HojasEstilo/bootstrap.css" rel="stylesheet" type="text/css" />
</head>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
     <?php if (login_check($mysqli) == true) : ?>
     <body>
 	<header>
    	<figure>
        	<img src="Imagenes/banner_ittj.png" class=" img-responsive centrar"/>
         </figure>
    </header>
         <div id="div-row-section" class="row">
             <section> 
          <div class="frase">
          	<?php 
				list($fechaCon,$direccion,$cargo,$domicilio,$tel,$email,$web)=datos();
				echo $fechaCon;
			?>
          </div>
          <div class="fecha">
			  <?php $fecha=fecha();
              echo $fecha; ?>
          </div>
          <article class="Escolar" style="color:#333">
              <div id="div-col-mensaje" class="col-xs-12 Mensagge">
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
               <div id="div-row-mensaje" class="row">
                   <div id="dov-col-mensaje" class="col-lg-6 col-xs-12">
                    <p>ATENTAMENTE</p>
                    <i>Educando Para La Sociedad Actual Y Los Retos Del Futuro</i>
                    <figure style="margin-left:0%">
                             <img src="Imagenes/firmaDirector.png" />
                    </figure>
                     <?php 
                                     echo $direccion;
                                 ?>
                    <br/>
                    <?php 
                                     echo $cargo;
                             ?>
                   </div>
                   <div id="div-col-boton" class="col-lg-6 col-xs-12">
                    <a href="perfil.php" class="ir_perfil">ACEPTAR</a>
                    </div>
                </div>
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
         </div>
        <footer>
        	<div class="Pie">
                <div class="Contacto">
                    <h3>Contacto</h3>
                    <?php 
				echo $domicilio.$tel;
			?><a href="mailto:ittj@ittlajomulco.edu.mx"><?php echo $email?></a>,<a href="http://www.ittlajomulco.edu.mx/"><?php echo $web?></a> </div>
            </div>
        </footer>
</body>
<script src="js/bootstrap.js" type="text/javascript"></script>
</html>