<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_utilidad extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        //$this->load->model('M_model');
    }

    // Webservices
    function avance_ods()
    {
        $this->load->model('M_services');
        $model = new M_services();

        $ods = $resp = array();
        for ($i= 1; $i < 18 ; $i++)
        { 
            $ods[$i]['acts'] = 0;
            $ods[$i]['avance'] = 0;
            $ods[$i]['acciones'] = 0;
            $ods[$i]['beneficiarios'] = 0;
            $ods[$i]['porcentaje'] = 0;
            $resp[$i] = 0;
        }

        // Avances del SIGO
        $result = $model->avance_ods_sigo()->result();
        foreach ($result as $row)
        {
            $acc = $model->acciones_ods_sigo($row->iIdOds);
            $ods[$row->iIdOds]['acts'] = $row->acts;
            $ods[$row->iIdOds]['avance'] = $row->avance;
            if($acc)
            {
                $ods[$row->iIdOds]['acciones'] += round($acc->avance);
                $ods[$row->iIdOds]['beneficiarios'] += $acc->beneficiarios;
            }
        }

        // Avances del sigo 2030
        $result = $model->avance_ods_sigo2030()->result();
        foreach ($result as $row)
        {
            $acc = $model->acciones_ods_sigo2030($row->iIdOds);
            $ods[$row->iIdOds]['acts'] += $row->acts;
            $ods[$row->iIdOds]['avance'] += $row->avance;
            if($acc)
            {
                $ods[$row->iIdOds]['acciones'] += round($acc->avance);
                $ods[$row->iIdOds]['beneficiarios'] += $acc->beneficiarios;
            }
        }

        //Avance de obras
        $result = $model->avance_ods_ssop()->result();
        foreach ($result as $row)
        {
            $acc = $model->acciones_ods_ssop($row->iIdOds);
            $ods[$row->iIdOds]['acts'] += $row->acts;
            $ods[$row->iIdOds]['avance'] += $row->avance;
            foreach ($acc as $fila) 
            {
                $ods[$row->iIdOds]['acciones'] += round($fila->avance);
                $ods[$row->iIdOds]['beneficiarios'] += (int)$fila->beneficiarios;
            }
        }

        for ($i=1; $i < 18; $i++)
        { 
            $ods[$i]['porcentaje'] = ($ods[$i]['acts'] > 0) ? round($ods[$i]['avance']/$ods[$i]['acts']):0;
            if($ods[$i]['beneficiarios'] > 2097175) $ods[$i]['beneficiarios'] = 2097175;
        }

        header('Content-Type: application/json');
        echo json_encode($ods);

    }


    // Webservices
    function avance_muni_ods()
    {
        $this->load->model('M_services');
        $model = new M_services();

        $result = $model->municipios()->result();
        $municipios = array();
        foreach ($result as $row)
        {
            $municipios[] = array(  'id' => (int)$row->iIdMunicipio,
                                    'nombre' => $row->vMunicipio,
                                    'value' => 0,
                                    'mayor_accion' => 0,
                                    'ods' => 0,
                                    //'color' => 0,
                                    'mayor' => 0);
        }

       $mayor = 0;

        $ods[1]  = array("name"=> 'FIN DE LA POBREZA', "color"=> '#BE0023', "color2" => '#D2757B');
        $ods[2]  = array("name"=> 'HAMBRE CERO', "color"=> '#C9A315', "color2" => '#DAAD56');
        $ods[3]  = array("name"=> 'SALUD Y BIENESTAR', "color"=> '#5E943A', "color2"=>'#87B983');
        $ods[4]  = array("name"=> 'EDUCACIÓN DE CALIDAD', "color"=> '#A30F2D', "color2"=>'#E6B5B8');
        $ods[5]  = array("name"=> 'IGUALDAD DE GÉNERO', "color"=> '#C64821', "color2"=>'#F5C6C0');
        $ods[6]  = array("name"=> 'AGUA LIMPIA Y SANEAMIENTO', "color"=> '#5AA8D4', "color2" =>'#9DD9E9');
        $ods[7]  = array("name"=> 'ENERGÍA ASEQUIBLE Y NO CONTAMINANTE', "color"=> '#E8BA00',"color2"=>'#F5DB8');
        $ods[8]  = array("name"=> 'TRABAJO DECENTE Y CRECIMIENTO ECONÓMICO', "color"=> '#781535',"color2"=>'#A31C4');
        $ods[9]  = array("name"=> 'INDUSTRIA, INNOVACIÓN E INFRAESTRUCTURA', "color"=> '#D07215',"color2"=>'#E6784');
        $ods[10] = array("name"=> 'REDUCCIÓN DE LAS DESIGUALDADES', "color"=> '#B71B7B',"color2"=>'#D64B7F');
        $ods[11] = array("name"=> 'CIUDADES Y COMUNIDADES SOSTENIBLES', "color"=> '#DFA023',"color2"=>'#EFA449');
        $ods[12] = array("name"=> 'PRODUCCIÓN Y CONSUMO RESPONSABLES', "color"=> '#C28F14', "color2"=>'#D0B078');
        $ods[13] = array("name"=> 'ACCIÓN POR EL CLIMA', "color"=> '#5A7637',"color2"=>'#C7D8C8');
        $ods[14] = array("name"=> 'VIDA SUBMARINA', "color"=> '#1574B2',"color2"=>'#F1F8FB');
        $ods[15] = array("name"=> 'VIDA DE ECOSISTEMAS TERRESTRES', "color"=> '#70A53A',"color2"=>'#69B459');
        $ods[16] = array("name"=> 'PAZ, JUSTICIA E INSTITUCIONES SÓLIDAS', "color"=> '#004F85',"color2"=>'#ACC9DA');
        $ods[17] = array("name"=> 'ALIANZAS PARA LOGRAR LOS OBJETIVOS', "color"=> '#003563',"color2"=>'#426580');

        $result = $model->avance_muni_ods_sigo()->result();
        
        foreach ($result as $row)
        {   
            if($row->avance > $mayor) $mayor = $row->avance;
            $municipios[$row->iIdMunicipio - 1]['value'] += round($row->avance);
            if($row->avance > $municipios[$row->iIdMunicipio - 1]['mayor_accion'] && $row->iIdOds != 17)
            {
                $municipios[$row->iIdMunicipio - 1]['mayor_accion'] = round($row->avance);
                $municipios[$row->iIdMunicipio - 1]['ods'] = (int)$row->iIdOds;
                //$municipios[$row->iIdMunicipio - 1]['color'] = $ods[$row->iIdOds]['color'];
            }
        }
        $municipios[0]['mayor'] = $mayor;

        header('Content-Type: application/json');
        //var_dump($municipios);
        echo json_encode($municipios);
    }

    function calculadora_defuncion()
    {
        $this->load->view('utilidades/calculadora_defuncion');
    }
}
?>