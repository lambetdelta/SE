<?php
include '../includes/functions_adm.php';
$datos=Array();
$datos['respuesta']='0';
$datos['mensaje']='Error en envío de datos';
$form=array();
    if(isset($_POST['form'])){
        parse_str($_POST['form'],$form);
        $form=  anti_xss($form);
        $validar=  validar_escuela($form['director'], $form['tel'], $form['web'], $form['email'], $form['domicilio'], $form['cargo'], $form['fecha']);
        if($validar['resultado']==TRUE){
            $res=guardar_dt_escuela($form['director'], $form['tel'], $form['web'], $form['email'], $form['domicilio'], $form['cargo'], $form['fecha']);
            if($res==TRUE){
               $datos['respuesta']='1';
                $datos['mensaje']='Exito'; 
            }else
                $datos['mensaje']='Error';
            
        }else
            $datos['mensaje']=$validar['mensaje'];
    }

echo json_encode($datos);

