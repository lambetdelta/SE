<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

$form=array();
sleep(3);
if (isset($_POST['no_control'],$_POST['registro']))
{
    if(is_numeric($_POST['no_control'])&& is_numeric($_POST['registro']))
    {
        if(borrar_historial($mysqli,$_POST['no_control'],$_POST['registro']))
            echo '1';
        else
            echo '3';
    }
    else 
       echo'2';     
}	
else
    echo "2";//error con el formulario enviado
	
	
?>