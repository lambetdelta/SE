<?php

include_once '/includes/db_connect.php';
include '/includes/function_ext.php';

//$salt= hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
//echo '<br>este es el salt '.$salt.'<br>';
//$pass=  hash('sha512','1');
//$password = hash('sha512','3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'.'uwicq37ypirg9pf508vqo7spkcppewz01rogiszt6p160093f233ue0ul07802s54iparn67ko5rcxcptulaavm27jckua9zu6l6p1y38nu8e8bh830e3h1q16bo6a57');
//echo '<br>este es el salt '.$salt;
//echo '<br>este es el password que se envia por web '.$pass;
//echo '<br>este es el password final guardado en bd '.$password;


//enviar_email('10940256', 'lambetdelta@hotmail.com', $mysqli);

//$contenido_html =  '<p>Hola, me llamo <em><strong>jc-mouse</strong></em> y quiero hacer una pregunta. </p>
//<p>&iquest;POR QUE QUEREIS MATAR A BIN LADEN, SI &quot;OS<em><strong>AMA</strong></em>&quot; ?</p>
//<p><strong>:)</strong></p>';
//
//$email = new email();
//if ( $email->enviar( 'lambetdelta@hotmail.com' , 'Osvaldo Uriel Garcia Gomez' , 'Tengo una pregunta' ,  $contenido_html ) )
//   echo 'Mensaje enviado';
//else
//{
//   echo 'El mensaje no se pudo enviar ';
//   $email->ErrorInfo;
//}
//$no_control='10940256';
//$cadena = $no_control.rand(1,9999999).date('Y-m-d');
//
//if ($stmt = $mysqli->prepare("INSERT INTO reseteo_contrasena (no_controlfk,token,fecha) VALUES (?,?,NOW())")) {
//					$stmt->bind_param('ss', $no_control,$cadena); 
//					$stmt->execute();    // Ejecuta la consulta preparada.
//					if($stmt->affected_rows >0)
//                                            echo '2';
//					else
//                                            echo '3';
//}else
//    return FALSE;
$link='kjhkj';
echo '<html>
                <head>
                <meta charset="UTF-8">  
                   <title>Restablece tu contraseña</title>
                </head>
                <body>
                  <p>Hemos recibido una petición para restablecer la contraseña de tu cuenta en el Sistema de Seguimiento de Egresados del ITTJ.</p>
                  <p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
                  <p>
                    <strong>Enlace para restablecer tu contraseña</strong><br>
                    <a href="'.$link.'" > Click Aqui </a>
                    <a>uno</a>    
                  </p>
                </body>
            </html>';