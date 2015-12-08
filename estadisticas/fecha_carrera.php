<?php

include '../includes/conexion-bd-adm.php';
include '../includes/functions_adm.php';
include '../includes/phpExcel/PHPExcel.php';

if(isset($_POST['fecha'],$_POST['carrera'])){
    $fecha=  anti_xss_cad($_POST['fecha']);
    $carrera=  anti_xss_cad($_POST['carrera']);
    $resultado=  estadistica_fecha_carrera($fecha, $carrera, $mysqli);
    if($resultado==FALSE)
        echo 'Falla en BD';
    else {
        if($resultado->num_rows>0){
            $hojaExcel = new PHPExcel();
    //Informacion del excel
            $hojaExcel->
             getProperties()
                 ->setCreator("www.SEITTJ.com")
                 ->setTitle('SE Egresados')
                 ->setSubject("Egresados")
                 ->setDescription("Egresados del año ".$fecha .' de la carrera de '.$carrera); 
            $x=2;
            $hojaExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Nombre')
                ->setCellValue('B1', 'No: control')
                ->setCellValue('C1', 'Codigo Especialidad');
            while ($fila=$resultado->fetch_assoc()){
             $hojaExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$x, $fila['nombre'].' '.$fila['apellido_m'].' '.$fila['apellido_p'])
                ->setCellValue('B'.$x, $fila['no_control'])
                ->setCellValue('C'.$x, $fila['codigo_especialidadfk']);  
             $x=$x+1;
            }
            $hojaExcel->getActiveSheet()->setTitle('SE Egresados');
            $hojaExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="SE_estadisticas.xlsx"');
            header('Cache-Control: max-age=0');
            $objLec = PHPExcel_IOFactory::createWriter($hojaExcel, 'Excel2007');
            $objLec->save('php://output');
    }else
            echo 'Sin coicidencias';
    }
    
}else
    echo 'Falla en envio de datos';

