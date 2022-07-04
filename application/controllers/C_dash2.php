<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dash2 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_dash');
        $this->load->model('M_dash2');
        $this->load->helper('funciones');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
        $this->load->library('session');
    }

    public function main_dependencia()
    {
        $opt = new Class_options();
        $data['depencencias'] = $opt->options_tabla('dependenciaSelector');
        $this->load->view('dash2/main_dependencia',$data);
    }

    public function buscar_dep()
    {
        //$text = $this->input->post('text',true);
        $nombredep = $this->input->post('SelDep',true);
        $result = $this->M_dash2->buscar_dep($nombredep);

        switch ($result->num_rows())
        {
            case 0:
                echo 'No se han encontrado resultados para mostrar.';
                break;
            case 1:
                $this->ficha_dep($result->row()->iIdDependencia);
                break;
            default:
                $this->listado_deps($result);    
                break;
        }        
    }

    public function listado_deps($result = null)
    {
        $data['result'] = $result->result();
        print_r($data['result']);
        $this->load->view('dash2/listado_deps',$data);
    }

    public function ficha_dep($idDep = 0)
    {
        if($idDep == 0) $idDep = $this->input->post('idDep',true);
        $data['idDep'] = $idDep;
        $result = $this->M_dash2->AniosDep($idDep);
        $data['anios'] = '';
        $anio = 0;
        if($result->num_rows() > 0)
        {
            $result = $result->result();
            foreach ($result as $row) {
                if($anio == 0){
                  $anio = $row->iAnio;  
                  $data['anios'].= '<option value="'.$row->iAnio.'" selected>'.$row->iAnio.'</option>'; 
                }else {
                    $data['anios'].= '<option value="'.$row->iAnio.'">'.$row->iAnio.'</option>'; 
                }
                
            }
        } else {
            $anio = 2018;
        }

        
        // Número de actividades
        $data['n_actividades'] = $this->M_dash2->num_acts_by_dep($idDep,$anio);
        // Número de entregables
        $data['n_entregables'] = $this->M_dash2->num_ent_by_dep($idDep,$anio);
        // Gasto ejercido 
        $data['gasto'] = $this->M_dash2->ejercido_by_dep($idDep,$anio);

        // Datos de la dependencia
        $data['dependencia'] = $this->M_dash2->datos_dep($idDep,$anio);
        // Avance por año
        $avances = $this->M_dash2->avance_dep_by_anio($idDep,$anio);
        $background = $series = '';
        $count = 0;
        $width = 15;
        $inner = 80;
        foreach ($avances as $row)
        {
            $avance = ($row->numact == 0) ? 0:round($row->sumaavance / $row->numact);
            if($background != '') $background.= ',';
            if($series != '') $series.= ',';
            $outer = $inner + $width; 
            $background.= "{
                                outerRadius: '$outer%',
                                innerRadius: '$inner%',
                                backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[$count]).setOpacity(0.3).get(),
                                borderWidth: 0
                            }";
            $series.= "{
                            name: '$row->iAnio',
                            borderColor: Highcharts.getOptions().colors[$count],
                            data: [{
                                color: Highcharts.getOptions().colors[$count],
                                radius: '$outer%',
                                innerRadius: '$inner%',
                                y: $avance
                            }]
                        }";
            $inner = $outer + 1;
            $count++;
        }
        $data['background'] = $background;
        $data['series'] = $series;

        $data['actividades'] = $this->M_dash->list_actividades($anio,$idDep);
        $data['compromisos'] = $this->M_dash2->compromisos_by_dep($idDep);
        $data['est_compromiso'] = $this->M_dash2->compromisos_estatus_by_dep($idDep);
        $data['obras'] = '';

        foreach($data['actividades'] as $query){
            $_avances        =  $this->M_dash->avance_por_detalle($query->iIdDetalleActividad);
            $totalAvance    = 0;
            $totalPagado    = 0;
            
            foreach($_avances as $avance){
                $totalAvance    = $totalAvance  + $avance->nBeneficiariosH + $avance->nBeneficiariosM+
                $avance->nDiscapacitadosH + $avance->nDiscapacitadosM+
                $avance->nLenguaH + $avance->nLenguaM+
                $avance->nTerceraEdadH + $avance->nTerceraEdadM+
                $avance->nAdolescenteH + $avance->nAdolescenteM;
                $ejercido       = $avance->nEjercido == '' ? 0 :  $avance->nEjercido;
                $totalPagado    = $totalPagado  + $ejercido;
            }
            $query->beneficiario = $totalAvance;

            $detalle        = $this->M_dash->getDetalleActividad($query->iIdDetalleActividad);
            $autorizado     = $detalle[0]->nPresupuestoAutorizado == '' ? 0 : $detalle[0]->nPresupuestoAutorizado;
            $presupuesto    = $autorizado == 0 ? 0 : ($totalPagado * 100)/$autorizado; 
            /* echo("autorizado: ".$autorizado);
            echo("###  Pagado: ".$totalPagado);
            echo("<br>"); */
            $query->presupuesto  = $presupuesto;
        }

        $this->load->view('dash2/ficha_dep',$data);
    }

    public function avan_anio($idDep = 0)
    {
        $idDep = $this->input->post('idDep',true);
        $anio = $this->input->post('anio',true);
        
        // Número de actividades
        $data['n_actividades'] = $this->M_dash2->num_acts_by_dep($idDep,$anio);
        // Número de entregables
        $data['n_entregables'] = $this->M_dash2->num_ent_by_dep($idDep,$anio);
        // Gasto ejercido 
        $data['gasto'] = $this->M_dash2->ejercido_by_dep($idDep,$anio);

        // Datos de la dependencia
        $data['dependencia'] = $this->M_dash2->datos_dep($idDep,$anio);
        // Avance por año
        $avances = $this->M_dash2->avance_dep_by_anio($idDep,$anio);
        $background = $series = '';
        $count = 0;
        $width = 15;
        $inner = 80;
        foreach ($avances as $row)
        {
            $avance = ($row->numact == 0) ? 0:round($row->sumaavance / $row->numact);
            if($background != '') $background.= ',';
            if($series != '') $series.= ',';
            $outer = $inner + $width; 
            $background.= "{
                                outerRadius: '$outer%',
                                innerRadius: '$inner%',
                                backgroundColor: Highcharts.Color(Highcharts.getOptions().colors[$count]).setOpacity(0.3).get(),
                                borderWidth: 0
                            }";
            $series.= "{
                            name: '$row->iAnio',
                            borderColor: Highcharts.getOptions().colors[$count],
                            data: [{
                                color: Highcharts.getOptions().colors[$count],
                                radius: '$outer%',
                                innerRadius: '$inner%',
                                y: $avance
                            }]
                        }";
            $inner = $outer + 1;
            $count++;
        }
        $data['background'] = $background;
        $data['series'] = $series;

        $data['actividades'] = $this->M_dash->list_actividades($anio,$idDep);

        $this->load->view('dash2/avan_anio',$data);
    }

    public function main_sectores()
    {
        $this->load->view('dash2/sectores/main');
    }

    public function find_in_sector()
    {
        $seg = new Class_seguridad();
        $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $ideje = ($all_sec > 0) ? 0:$_SESSION[PREFIJO.'_ideje'];
        $iddep = $_SESSION[PREFIJO.'_iddependencia'];

        if(isset($_POST['anio']) && !empty($_POST['anio']))
        {
            $keyword = trim($this->input->post('anio',TRUE));
            $an = (int) $keyword;

            if($an > 2017 && $an < 2100)
            {
                // Si es un año mostramos el dash anual
                $this->dash_sectores($an,$ideje);
            }
            else
            {
                // Si no, realiazamos una búsqueda por terminos (Actividad o dependencia)
                $result = $this->M_dash->buscar_act_dep($keyword,$ideje);

                switch ($result->num_rows()) {
                    case 0:
                        echo 'No se encontraron resultados para la búsqueda';
                        break;
                    case 1:
                        if($result->row()->tipo == 1) $this->ficha_dep($result->row()->id);
                        else $this->ver_actividad($result->row()->id);
                        break;
                    default:
                        $data['result'] = $result->result();
                        $this->load->view('dash/resultado_busqueda',$data);
                        break;
                }
            } 
        }
    }

    public function dash_sectores($anio=0,$ideje=0)
    {
        $seg = new Class_seguridad();
        $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $ideje = ($all_sec > 0) ? 0:$_SESSION[PREFIJO.'_ideje'];
        $iddep = $_SESSION[PREFIJO.'_iddependencia'];

        $an = ($anio == 0) ? $this->input->post('anio',true):$anio;
        $data = array();
        $data['all_sec'] = $all_sec;
        $data['all_dep'] = $all_dep;
        
        $data['anio'] = $an;
        // Datos totales (Núumeralia inicial)
        $data['pat_totales'] = 0;
        $data['act_totales'] = 0;
        $data['ent_totales'] = 0;
        $data['apro_totales'] = 0;
        $data['ejer_totales'] = 0;
        $data['papro_totales'] = 0;

        $where['s.iAnio'] = $an;
        $q_sectores = $this->M_dash2->sectores();
        $q_info = $this->M_dash2->info_dash_sector($where);

        if($q_sectores->num_rows() > 0)
        {
            $sectores = $q_sectores->result();

            foreach ($sectores as $sector)
            {
                $cifras[$sector->iIdEje] = array( 
                    'eje'       => $sector->vEje,
                    'icono'     => $sector->vIcono,
                    'color'     => $sector->vColorDesca,
                    'avance'    => 0,
                    'pat'       => 0,
                    'actividades'   => 0,
                    'entregables'   => 0,
                    'ejercido'      => 0,
                    'presupuesto'   => 0,
                    'autorizado'    => 0,
                    'porcentajeAutorizado' => 0
                );
            }

            $infos = $q_info->result();
            foreach ($infos as $info)
            {
                $data['mujeres'] = 0;
                $data['hombres'] = 0;
                $dependencias    = $this->M_dash->dependencias_por_eje($info->iIdEje);
                
                

                foreach($dependencias as $dependencia){
                    $beneficiarios   =  $this->M_dash->avance_por_dependencia($dependencia->iIdDependencia, $an);
                    foreach($beneficiarios as $beneficiario){
                        $data['hombres'] = $data['hombres'] 
                            + $beneficiario->nbeneficiariosh
                            + $beneficiario->ndiscapacitadosh
                            + $beneficiario->nlenguah
                            + $beneficiario->nterceraedadh
                            + $beneficiario->nadolescenteh;

                        $data['mujeres'] = $data['mujeres'] 
                            + $beneficiario->nbeneficiariosm
                            + $beneficiario->ndiscapacitadosm
                            + $beneficiario->nlenguam
                            + $beneficiario->nterceraedadm
                            + $beneficiario->nadolescentem;
                    }
                }
                $retos = $this->M_dash->retos_por_eje($info->iIdEje);
                
                $avance = ((int)$info->actividades > 0) ? round(($info->avance / (int)$info->actividades)):0;
                $cifras[$info->iIdEje]['avance']        = $avance;
                $cifras[$info->iIdEje]['pat']           = (int)$info->pats;
                $cifras[$info->iIdEje]['actividades']   = (int)$info->actividades;
                $cifras[$info->iIdEje]['entregables']   = (int)$info->entregables;
                $cifras[$info->iIdEje]['ejercido']      = round((float)$info->ejercido);
                $cifras[$info->iIdEje]['empresas']      = round((float)$info->empresas);
                $cifras[$info->iIdEje]['presupuesto']   = round((float)$info->presupuesto);
                $cifras[$info->iIdEje]['autorizado']    = round((float)$info->autorizado);
                $cifras[$info->iIdEje]['mujeres']       = $data['mujeres'];
                $cifras[$info->iIdEje]['hombres']       = $data['hombres'];
                
                $cifras[$info->iIdEje]['retos']         = $retos;

                $porcentajeAutorizado = ($info->ejercido * 100)/ $info->autorizado;
                $porcentajeAutorizado =  round($porcentajeAutorizado, 2, PHP_ROUND_HALF_UP);
                $cifras[$info->iIdEje]['porcentajeAutorizado'] = $porcentajeAutorizado;

                $data['pat_totales'] += $cifras[$info->iIdEje]['pat'];
                $data['act_totales'] += $cifras[$info->iIdEje]['actividades'];
                $data['ent_totales'] += $cifras[$info->iIdEje]['entregables'];
                $data['apro_totales'] += $cifras[$info->iIdEje]['autorizado'];
                $data['ejer_totales'] += $cifras[$info->iIdEje]['ejercido'];
                $porcentaje            = ($data['ejer_totales'] * 100)/$data['apro_totales']; 
                $empresas = $cifras[$info->iIdEje]['ejercido'];
                $data['papro_totales'] = round($porcentaje, 2, PHP_ROUND_HALF_UP);
            }
            $data['cifras'] = $cifras;

            $this->load->view('dash2/sectores/sectores', $data);
        } 
        else
        {
            echo 'No se encontraron resultados para la búsqueda';
        }


        


        
        // Obras para (datos para el eje 9)
        /*$datos['av_obras'] = $this->M_dash->avance_obras($an);
        $datos['pre_obras'] = $this->M_dash->presupuesto_obras($an);*/        
    }

    public function deps_anio_sector()
    {        
        $data['anio'] = $this->input->post('anio',true);
        $data['eje'] = $this->input->post('eje',true);
        
        $data['query'] = $this->M_dash2->deps_anio_eje($data['anio'],$data['eje']);

        $this->load->view('dash2/sectores/dependencias_list',$data);
    }
}
?>