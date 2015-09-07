<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

$form=array();
sleep(3);
if (isset($_POST['form'],$_POST['no_control'],$_POST['registro'],$_POST['select_'])){
	parse_str($_POST['form'],$form);
        $form=anti_xss($form);
        if(is_numeric($_POST['no_control']))
            {
            $mysqli->autocommit(false);
            if(actualizar_dt_empresa($mysqli,$_POST['no_control'],$_POST['registro'],$form['nombre'],$form['giro'],$form['organismo'],$form['razon_social'],$form['tel'],$form['email'],$form['web'],$form['jefe'],$form['puesto'],$form['año_ingreso'],$form['calle'],$form['no_domicilio'],$form['estado'],$form['municipio'],$form['medio_busqueda'],$form['tiempo_busqueda'])){
                if(borrar_requisitos_empresa($mysqli,$_POST['no_control'],$_POST['registro']))
                    {
                    $x=1;
                    $requisto='requisito';
                    while($x<=$_POST['select_'])
                        {//guardar requisitos
                        $requisto=$x.$requisto;
                        guardar_requisito($mysqli,$_POST['no_control'],$_POST['registro'],$form[$requisto]);
                        $requisto='requisito';
                        $x++;
                        }
                    if(($x-1)==$_POST['select_'])
                        {
                        $mysqli->commit();
                        echo '1';
                        }
                    else
                        {
                        $mysqli->rollback();
                        echo "0";
                        }	
                    }
                else
                    {
                    $mysqli->rollback();
                    echo "0";
                    }
                }
            else
                {
                $mysqli->rollback();
                echo "0";
                }//error en la actualización
            }
        else 
            echo '2';
}else
	echo "2";//error con el formulario enviado
	
	
?>
