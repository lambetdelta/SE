<?php 
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';


$datos=array();
$datos['mensaje']='Error en envío';
$datos['respuesta']='0';
if (isset($_POST['form'],$_POST['no_control'],$_POST['registro'],$_POST['select_'])){
	parse_str($_POST['form'],$form);
        $form=anti_xss($form);
        if((is_numeric($_POST['no_control']))&&(is_numeric($_POST['registro'])))
            {
            $mysqli->autocommit(false);
            $validar=  validarEmpresa($form['nombre'],$form['giro'],$form['organismo'],$form['razon_social'],$form['tel'],$form['email'],$form['web'],$form['jefe'],$form['año_ingreso'],$form['estado'],$form['municipio'], $mysqli);
            if($validar){
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
                        $datos['mensaje']='hecho';
                        $datos['respuesta']='1';
                        }
                    else
                        {
                        $mysqli->rollback();
                        }	
                    }
                else
                    {
                    $mysqli->rollback();
                    }
                }
            else
                {
                $mysqli->rollback();
                }//error en la actualización
            }else
                $datos['mensaje']=$validar['mensaje'];
            }
}


echo json_encode($datos);

