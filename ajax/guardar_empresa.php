<?php 
include '../includes/db_connect.php';
include '../includes/functions.php';

$form=array();
$datos=array();
$datos['mensaje']='Error en envío';
$datos['respuesta']='0';
if (isset($_POST['form'],$_POST['no_control'],$_POST['select_']))
{
    parse_str($_POST['form'],$form);
    if(is_numeric($_POST['no_control']))
    {
        $form=anti_xss($form);
        if(!contar_empresa($mysqli,$_POST['no_control']))
        {
            $validar=  validarEmpresa($form['nombre'],$form['giro'],$form['organismo'],$form['razon_social'],$form['tel'],$form['email'],$form['web'],$form['jefe'],$form['año_ingreso'],$form['estado'],$form['municipio'], $mysqli);
            if($validar){  
                if(guardar_dt_empresa($mysqli,$_POST['no_control'],$form['nombre'],$form['giro'],$form['organismo'],$form['razon_social'],$form['tel'],$form['email'],$form['web'],$form['jefe'],$form['puesto'],$form['año_ingreso'],$form['calle'],$form['no_domicilio'],$form['estado'],$form['municipio'],$form['medio_busqueda'],$form['tiempo_busqueda']))
                {
                    $id=id_empresa($mysqli,$_POST['no_control']);
                    if($id===FALSE)
                        $datos['mensaje']='Empresa guardada pero sin los requisitos';
                    else{
                        $x=1;
                        $requisto='requisito';
                        while($x<=$_POST['select_'])
                        {//guardar requisitos
                            $requisto=$x.$requisto;
                            guardar_requisito($mysqli,$_POST['no_control'],$id['id'],$form[$requisto]);
                            $requisto='requisito';
                            $x++;
                        }
                        $datos['mensaje']='hecho';
                        $datos['respuesta']='1';               
                    }
                }
            }else
                $datos['mensaje']=$validar['mensaje'];
            
        }
        else
            $datos['respuesta']='3';//error demaciados registros
    }
}

echo json_encode($datos);
