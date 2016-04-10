<?php
try{
    include '../includes/conexion-bd-adm.php';
    include '../includes/functions_adm.php';
    include '../includes/phpExcel/PHPExcel.php';
    session_start();
    if(isset($_POST['fecha'],$_POST['carrera'],$_POST['clave'])){
        $fecha=  anti_xss_cad($_POST['fecha']);
        $carrera=  anti_xss_cad($_POST['carrera']);
        $validar_carrera=  validarCarrera($carrera, $mysqli);
        $clave=anti_xss_cad($_POST['clave']);
        if(strlen($clave)==13){
            if((is_numeric($fecha))&&$validar_carrera==FALSE){
                $_SESSION['mensage']='Fecha o carrera inválida';
                header('Location: ../mensage.php');
            }else{
                //cosulta mysql
                $resultado=  estadistica_fecha_carrera($fecha, $carrera, $mysqli);
                if($resultado==FALSE){
                    $_SESSION['mensage']='Falla en BD';
                    header('Location: ../mensage.php');}
                else {
                    if($resultado->num_rows>0){
                        //arreglo nombres de los campos
                        $campos=array('Nombre','Apellido Paterno','Apellido Materno','CURP','No: Control','Género',
                            'Estado','Municipio','CP','Ciudad o localidad','Colonia','Calle','No:casa',
                           'Email','Telefono','Carrera','Fecha de inicio','Fecha de finalización','Titulado');
                        //crear hoja de excel
                        $hojaExcel=excel_query($resultado, $campos, 'SE', 'www.seITTJ.com', 'Estadísticas',$clave);
                        if($hojaExcel==FALSE){
                            $_SESSION['mensage']='ERROR';
                            header('Location: ../mensage.php');
                        }else{
                            //archivo de excel
                            $hojaExcel->getActiveSheet()->setTitle('SE Egresados');
                            $hojaExcel->setActiveSheetIndex(0);
                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment;filename="SE_estadisticas.xlsx"');
                            header('Cache-Control: max-age=0');
                            $objLec = PHPExcel_IOFactory::createWriter($hojaExcel, 'Excel2007');
                            $objLec->save('php://output');}
                    }else{
                        $_SESSION['mensage']='SIN COINCIDENCIAS';
                        header('Location: ../mensage.php');
                    }
                }
            }
        }else{
            $_SESSION['mensage']='Clave de estudios inválida '.$clave;
            header('Location: ../mensage.php');
        }
    }else{
        $_SESSION['mensage']='Falla en envio de datos';
         header('Location: ../mensage.php');
    }
}  catch (Exception $e){
    $_SESSION['mensage']='ERROR'.$e;
     header('Location: ../mensage.php');
}
