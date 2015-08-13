<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<meta charset="UTF-8">   
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<title>Login</title>
<link href="HojasEstilo/estiloInicio.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="HojasEstilo/bootstrap.css">
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script>
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script type="text/JavaScript" src="js/bootstrap.js"></script>
<script type="text/JavaScript" src="js/respond.min.js"></script>
</head>
<body class="degradado">
<script type="text/javascript">
   navegador();     
</script>
	<header>
    	<figure>
        	<img src="Imagenes/banner_ittj.png"   class="img-responsive" style="margin:auto" />
         </figure>
    </header>
    <section>
   		<div class="row">
        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
                <form method="post" action="includes/process_login.php" name="login_form">
                    <h1 style="color:#FFF">Sesión</h1>
                    <input type="text" placeholder="Ingrese No: de Control" name="No_control" id="No_control"/><br />
                    <input type="password" placeholder="Ingrese Contraseña"  name="password" id="password"/><br />
                    <input type="submit" value="Iniciar" />
                </form>    
			</div>
        </div>
    </section>
<footer >
<div class="define">
	<figure>
    	<a href="http://www.ittlajomulco.edu.mx/"> <img src="Imagenes/logo_ittj.png" width="73" height="76"  class="centrar"/></a>
	</figure>
 </div>
</footer>
</body>
</html>
