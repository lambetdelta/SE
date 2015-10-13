<?php
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
define("maxUpload", 1048576);
define("maxWidth", 700);
define("maxHeight", 700);
define("uploadURL", '../fotos_egresados/');
define("fileName", 'foto_');
// Tipos MIME
$fileType = array('image/jpeg','image/pjpeg','image/png');
// Bandera para procesar imagen
$pasaImgSize = false;
sec_session_start();
//bandera de error al procesar la imagen
$respuestaFile = false;
// nombre por default de la imagen a subir
$fileName = '';
// error del lado del servidor
$mensajeFile = 'ERROR EN EL SCRIPT';
// Obtenemos los datos del archivo
$tamanio = $_FILES['userfile']['size'];
$tipo = $_FILES['userfile']['type'];
$archivo = $_FILES['userfile']['name'];
// Tamaño de la imagen
$imageSize = getimagesize($_FILES['userfile']['tmp_name']);
						
// Verificamos la extensión del archivo independiente del tipo mime
$extension = explode('.',$_FILES['userfile']['name']);
$num = count($extension)-1;
// Creamos el nombre del archivo dependiendo la opción
$imgFile =fileName.time().'.'.$extension[$num];
// Verificamos el tamaño válido para los 
if($imageSize[0] <= maxWidth && $imageSize[1] <= maxHeight)
	$pasaImgSize = true;
// Verificamos el status de las dimensiones de la imagen a publicar
if($pasaImgSize == true)
{
	// Verificamos Tamaño y extensiones
	if(in_array($tipo, $fileType) && $tamanio>0 && $tamanio<=maxUpload && ($extension[$num]=='jpg' || $extension[$num]=='png'))
	{
		// Intentamos copiar el archivo
		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			if(move_uploaded_file($_FILES['userfile']['tmp_name'], uploadURL.$imgFile))
			{
				$resultado=buscar_foto($mysqli,$_SESSION['No_control']);
				$mysqli->autocommit(false);
				if(guardar_foto_egresado($mysqli,$_SESSION['No_control'],$imgFile)){
					$num=$resultado->num_rows;
					if($num>0){
					$url=$resultado->fetch_assoc();	
						if (borrar_foto($mysqli,$url['imagen'])){
							$mysqli->commit();
							$respuestaFile = 'done';
							$fileName = $imgFile;
							$mensajeFile = $imgFile;
						}else{
							$mysqli->rollback();
							$mensajeFile = 'IMPOSIBLE BORRAR FOTO ANTERIOR';
							$fileName = $url['imagen'];
							}	
					}else{
						$respuestaFile = 'done';
						$fileName = $imgFile;
						$mensajeFile = $imgFile;
						 }
				}else
					$mensajeFile = 'Fallo en BD';
			}
			else
				// error del lado del servidor
				$mensajeFile = 'Fallo en carga';
		}
		else
			// error del lado del servidor
			$mensajeFile = 'Fallo en carga';
	}
	else
		// Error en el tamaño y tipo de imagen
		$mensajeFile = 'Foto muy pesada';
					
}
else
	// Error en las dimensiones de la imagen
	$mensajeFile = 'Error en Imagen';
$salidaJson = array("respuesta" => $respuestaFile,
					"mensaje" => $mensajeFile,
					"fileName" => $fileName);
echo json_encode($salidaJson);
?>