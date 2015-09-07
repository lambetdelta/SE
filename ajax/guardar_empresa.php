<?php 
include_once '../includes/functions.php';
include_once '../includes/db_connect.php';

sleep(3);//guardar datos empresa 
$form=array();
if (isset($_POST['form'],$_POST['no_control'],$_POST['select_']))
{
    parse_str($_POST['form'],$form);
    if(is_numeric($_POST['no_control']))
    {
        $form=anti_xss($form);
        if(!contar_empresa($mysqli,$_POST['no_control']))
        {
            if(guardar_dt_empresa($mysqli,$_POST['no_control'],$form['nombre'],$form['giro'],$form['organismo'],$form['razon_social'],$form['tel'],$form['email'],$form['web'],$form['jefe'],$form['puesto'],$form['año_ingreso'],$form['calle'],$form['no_domicilio'],$form['estado'],$form['municipio'],$form['medio_busqueda'],$form['tiempo_busqueda']))
            {
                $id=id_empresa($mysqli);
                $x=1;
                $requisto='requisito';
                while($x<=$_POST['select_'])
                {//guardar requisitos
                    $requisto=$x.$requisto;
                    guardar_requisito($mysqli,$_POST['no_control'],$id['id'],$form[$requisto]);
                    $requisto='requisito';
                    $x++;
                }
                echo "1";
            }//exito
            else
                echo "0";//error en guardado
        }
        else
            echo "3";//error demaciados registros
    }
    else 
        echo '2';
}else
    echo "2";//error con el formulario enviado

?>