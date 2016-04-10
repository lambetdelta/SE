<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">   
        <meta name="viewport" content="width=device-width; initial-scale=1.0">
        <meta charset="UTF-8">
        <title>Error en la contraseña</title>
        <link href="HojasEstilo/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="HojasEstilo/estiloError.css" rel="stylesheet" type="text/css">
    <script src="js/bootstrap.js" type="text/javascript"></script>
    </head>
    <body class="FondoPrincipal">
        <div id="div-row-principal">
    	<header>
    	<figure>
        	<img src="Imagenes/banner_ittj.png"  class="img-responsive centrar"/>
         </figure>
    </header>
    	<section style="color:#FFF;min-height: 400px">
            <p style="color: #000">Hubo un problema con tu autenticación.</p>
        <?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = '¡ERROR!';
}
?>
        <p style="color: #000"><?php echo $error; ?></p> 
        <a href="index.php"><p>Por favor intente de nuevo</p></a>
        	<figure>
            	<img src="Imagenes/explode.png" class="img-responsive centrar"/>
        	</figure> 
        </section>
        <footer>
        	<figure>
        		<a href="http://www.ittlajomulco.edu.mx/"><img src="Imagenes/logo_ittj.png" class="centrar"/></a>
            </figure>
        </footer>
        </div>
    </body>
    
</html>