<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

sleep(3);//guardar datos academicos 
$form=array();
if (isset($_POST['form'],$_POST['no_control']))
{
    parse_str($_POST['form'],$form);
    if(is_numeric($_POST['no_control']))
    {
        $form=anti_xss($form);
        if(!contar_carrera($mysqli,$_POST['no_control']))
        {
            if(guardar_dt_academicos($mysqli,$_POST['no_control'],$form['fecha_inicio'],$form['fecha_fin'],$form['carrera'],$form['especialidad'],$form['titulado']))
                echo "1";//exito
            else
                echo "0";//error en guardado
        }
        else
            echo "3";//error demaciados registros
    }
    else 
        echo '2';
}
else
    echo "2";//error con el formulario enviado