<?php
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';
sleep(3);
// ini_set("display_errors", 1);
// Definimos variables generales
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
// TamaÃ±o de la imagen
$imageSize = getimagesize($_FILES['userfile']['tmp_name']);
						
// Verificamos la extensiÃ³n del archivo independiente del tipo mime
$extension = explode('.',$_FILES['userfile']['name']);
$num = count($extension)-1;
// Creamos el nombre del archivo dependiendo la opciÃ³n
$imgFile =fileName.time().'.'.$extension[$num];
// Verificamos el tamaÃ±o vÃ¡lido para los logotipos
if($imageSize[0] <= maxWidth && $imageSize[1] <= maxHeight)
	$pasaImgSize = true;
// Verificamos el status de las dimensiones de la imagen a publicar
if($pasaImgSize == true)
{
	// Verificamos TamaÃ±o y extensiones
	if(in_array($tipo, $fileType) && $tamanio>0 && $tamanio<=maxUpload && ($extension[$num]=='jpg' || $extension[$num]=='png'))
	{
		// Intentamos copiar el archivo
		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			if(move_uploaded_file($_FILES['userfile']['tmp_name'], uploadURL.$imgFile))
			{
				$resultado=buscar_foto($mysqli,$_SESSION['No_control']);
				if($resultado==FALSE)
                                    $mensajeFile = 'No se pudo guardar ruta BD';
                                else{
                                    $mysqli->autocommit(false);
                                    if(guardar_foto_egresado($mysqli,$_SESSION['No_control'],$imgFile)){
                                            $datos=$resultado->fetch_assoc();
                                            if($datos['imagen']!='businessman.png'){	
                                                    if (borrar_foto($datos['imagen'])){
                                                            $mysqli->commit();
                                                            $respuestaFile = 'done';
                                                            $fileName = $imgFile;
                                                            $mensajeFile = $imgFile;
                                                    }else{
                                                            $mysqli->rollback();
                                                            $mensajeFile = 'IMPOSIBLE BORRAR FOTO ANTERIOR';
                                                            $fileName = $datos['imagen'];
                                                            borrar_foto($imgFile);
                                                            }	
                                            }else{
                                                    $mysqli->commit();
                                                    $respuestaFile = 'done';
                                                    $fileName = $imgFile;
                                                    $mensajeFile = $imgFile;
                                                     }
                                    }else{

                                        $mensajeFile = 'No se pudo guardar ruta BD';
                                        borrar_foto($imgFile);
                                    }
                                } //aqui 
			}
			else
				// error del lado del servidor
				$mensajeFile = 'No se pudo subir el archivo';
		}
		else
			// error del lado del servidor
			$mensajeFile = 'No se pudo subir el archivo';
	}
	else
		// Error en el tamaÃ±o y tipo de imagen
		$mensajeFile = 'Verifique el tamaño y tipo de imagen';
					
}
else
	// Error en las dimensiones de la imagen
	$mensajeFile = 'Verifique las dimensiones de la Imagen';
$salidaJson = array("respuesta" => $respuestaFile,
					"mensaje" => $mensajeFile,
					"fileName" => $fileName);
echo json_encode($salidaJson);
