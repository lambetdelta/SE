
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Error en la contraseña</title>
    <link href="HojasEstilo/estiloError.css" rel="stylesheet" type="text/css">
    </head>
    <body class="FondoPrincipal">
    	<header>
    	<figure>
        	<img src="Imagenes/banner_ittj.png"  class="centrar"/>
         </figure>
    </header>
    	<section style="color:#FFF">
        <h1>Hubo un problema con tu autenticación.</h1>
        <?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = '¡ERROR!';
}
?>
        <p class="error"><?php echo $error; ?></p> 
        <a href="index.php"><p>Por favor intente de nuevo</p></a>
        	<figure>
            	<img src="Imagenes/explode.png" class="centrar"/>
        	</figure> 
        </section>
        <footer>
        	<figure>
        		<a href="http://www.ittlajomulco.edu.mx/"><img src="Imagenes/logo_ittj.png" class="centrar"/></a>
            </figure>
        </footer>
    </body>
</html>