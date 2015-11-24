<?php 
$cad=hash( "sha256",'cadena');
echo $cad;
define("HOST", "localhost");     // El alojamiento al que deseas conectarte
define("USER", "usuario");    // El nombre de usuario de la base de datos
define("PASSWORD", "24681357omega");    // La contraseña de la base de datos
define("DATABASE", "see");    // El nombre de la base de datos
 
define("CAN_REGISTER", "any");
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

  if ($stmt = $mysqli->prepare("select SHA2('cadena',256)")) {
        $stmt->execute();    // Ejecuta la consulta preparada.
        $stmt->store_result();
        // Obtiene las variables del resultado.
        $stmt->bind_result($hash);
        $stmt->fetch();
		echo '////'.$hash;
		}
		
?>