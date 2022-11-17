<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dash extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_dash');
        $this->load->helper('funciones');
        $this->load->library('Class_seguridad');
    }    

    public function index()
    {   
        $this->load->view('dash/dashboard');
    }

    public function datosdash()
    {
        $seg = new Class_seguridad();
        $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $ideje = ($all_sec > 0) ? 0:$_SESSION[PREFIJO.'_ideje'];
        $iddep = $_SESSION[PREFIJO.'_iddependencia'];

        if(isset($_POST['anio']) && !empty($_POST['anio']))
        {
            $keyword = trim($this->input->post('anio',TRUE));
            $eje = (int) $this->input->post('eje', TRUE);
            $an = (int) $keyword;

            if($an > 0)
            {
                if($eje == 0)
                {
                    // Busqueda por año, se muestra el dash principal
                    $datos = array();
                    $datos['anio'] = $an;
                    // Devuelve información general acerca de un año
                    $q_avance = $this->M_dash->avance_anio_eje($an,$ideje);
                    $q_presupuesto = $this->M_dash->presupuesto_anio_eje($an,$ideje);
                    $q_ejercido = $this->M_dash->ejercido_anio_eje($an,$ideje);
                    $q_ejes = $this->M_dash->ejes_icono($ideje);
                    $q_benef = $this->M_dash->beneficiarios_anio_eje($an,$ideje);
                    $q_entregables = $this->M_dash->ent_por_anio($an,$ideje);
                    
                    // Datos totales
                    $datos['pat_totales'] = 0;
                    $datos['act_totales'] = 0;
                    $datos['ent_totales'] = 0;
                    for ($i=1; $i < 10; $i++) { 
                        $datos['eje_'.$i] = array('avance'=> 0, 'avance_t' => 0, 'avance_r' => 0,'presupuesto' => 0, 'ejercido' => 0, 'beneficiarios' => 0);
                    }

                    // AVANCE POR EJE RECTOR
                    $q_avance = $q_avance->result();
                    foreach ($q_avance as $d) {                
                        $datos['eje_'.$d->iIdEje]['avance_t'] = $d->numact * 100;
                        $datos['eje_'.$d->iIdEje]['avance_r'] = $d->avance_r;
                        $datos['eje_'.$d->iIdEje]['avance'] = Decimal(($d->avance_r * 100) / ($d->numact * 100));
                        $datos['eje_'.$d->iIdEje]['actividades'] = $d->numact;
                        $datos['act_totales'] +=  $d->numact;

                        $q_pat = $this->M_dash->pat_anio($d->iIdEje, $an);
                        $q_pat = $q_pat->result();
                        $datos['eje_'.$d->iIdEje]['pat'] = count($q_pat);
                        $datos['pat_totales'] += count($q_pat);

                    }

                    // Entregables por eje
                    $q_entregables = $q_entregables->result();
                    foreach ($q_entregables as $d) {
                        $datos['eje_'.$d->iIdEje]['entregables'] = $d->nument;
                        $datos['ent_totales'] +=  $d->nument;
                    }

                    //  Presupuesto por eje
                    $q_presupuesto = $q_presupuesto->result();
                    foreach ($q_presupuesto as $d) {
                        $datos['eje_'.$d->iIdEje]['presupuesto'] = Decimal($d->presupuesto);
                    }
                    //  Ejercido por eje
                    $q_ejercido = $q_ejercido->result();
                    foreach ($q_ejercido as $d) {
                        $datos['eje_'.$d->iIdEje]['ejercido'] = Decimal($d->ejercido);
                    }

                    // Beneficiarios por eje
                    $q_benef = $q_benef->result();
                    foreach ($q_benef as $b) {
                        $datos['eje_'.$b->iIdEje]['beneficiarios'] = Decimal($b->beneficiarios);
                    }

                    $datos['q_ejes'] = $q_ejes->result();
                    $datos['ejes'] = $this->M_dash->ejes();
                    $datos['avejes'] = $this->M_dash->avacetotalejes($an);

                    $data = $this->M_dash->ejes();
                    $valores = array();
                    $rec = '';
                    foreach($data as $dat)
                    {

                        $rec = $this->M_dash->avacetotaleje($dat['iIdEje'], $an);
                        array_push($valores, $rec);
                    }
                    
                    //  Ejercido por municipios
                    $q_mun = $this->M_dash->ejercido_municipio($an);
                    $datos['maxGasto'] = 1;
                    $cont = 0;
                    $top_gasto = array();

                    if($q_mun->num_rows() > 0)
                    {
                        $q_mun = $q_mun->result();
                        $datamun = '';
                        foreach ($q_mun as $mun)
                        {
                            if($cont < 10)
                            {
                                $top_gasto[] = array('mun' => $mun->vMunicipio ,'ejercido' => $mun->ejercido);
                                $cont++;
                            }

                            if($mun->ejercido > $datos['maxGasto']) $datos['maxGasto'] = $mun->ejercido;
                            if($datamun != '') $datamun .= ',';
                            $datamun.= "{name: '".$mun->vMunicipio."',id: ".$mun->iIdMunicipio.", value:".$mun->ejercido.", population:".$mun->iTotalPoblacion."}";
                        }
                        $datos['datamun'] = $datamun;
                    }else $datos['datamun'] = false;

                    $datos['top_gasto'] = $top_gasto;
                          

                    // Datos de compromisos
                    $datos['comp_est'] = $this->M_dash->compromisos_estatus();


                    //  Datos de compromisos por eje
                    $q_comp = $this->M_dash->compromisos_eje($ideje);
                    for ($i=0; $i < count($data); $i++)
                    { 
                        if(isset($q_comp[$i]))
                        {
                            $q_comp[$i]->estatus = $this->M_dash->estatus_compromisos_eje($q_comp[$i]->iIdEje);
                        }
                    }
                    $datos['comp'] = $q_comp;

                    $this->load->view('dash/dash_ejes', $datos);
                }
                else
                {
                    // Listado por año y eje
                    $act_query = $this->M_dash->listado_actividades($an,$eje);
                    $datos['eje'] = $eje;
                    // Pestañas a petición del ing. Luis Dávalos
                    $list = array();
                    foreach ($act_query as $row)
                    {
                        $list[$row->iIdActividad]['iIdActividad'] = $row->iIdActividad;
                        $list[$row->iIdActividad]['vActividad'] = $row->vActividad;
                        $list[$row->iIdActividad]['iIdDetalleActividad'] = $row->iIdDetalleActividad;
                        $list[$row->iIdActividad]['vDependencia'] = $row->vDependencia;
                        $list[$row->iIdActividad]['vEntregable'] = $row->vEntregable;

                        /*
                        if(isset($list[$row->iIdActividad]['avance']))
                        {
                            $list[$row->iIdActividad]['avance']+= $row->nAvance;
                            $list[$row->iIdActividad]['ejercido']+= $row->ejercido;
                            $list[$row->iIdActividad]['beneficiarios']+= ($row->iMismosBeneficiarios == 1) ? $row->bene:$row->beneficiarios; 

                        }
                        else
                        {
                        */
                            $list[$row->iIdActividad]['avance']= $row->nAvance;
                            $list[$row->iIdActividad]['ejercido']= $row->ejercido;
                            $list[$row->iIdActividad]['beneficiarios']= ($row->iMismosBeneficiarios == 1) ? $row->bene:$row->beneficiarios;
                        /*}*/                    
                    }

                    // Datos para el mapa de ejercido
                    $datos['maxGasto'] = 1;
                    $q_mun = $this->M_dash->ejercido_mun_eje_anio_acciones($eje,$an);
                    if($q_mun->num_rows() > 0)
                    {
                        $q_mun = $q_mun->result();
                        $datamun = '';
                        foreach ($q_mun as $mun)
                        {
                            if($mun->ejercido > $datos['maxGasto']) $datos['maxGasto'] = $mun->ejercido;
                            if($datamun != '') $datamun .= ',';
                            $datamun.= "{name: '$mun->vMunicipio',id: '$mun->iIdMunicipio', value: '".number_format($mun->ejercido, 2, '.', '')."', population: '$mun->iTotalPoblacion', op:1 }";
                        }
                        $datos['datamun'] = $datamun;
                    }else $datos['datamun'] = false;

                    $datos['query'] = $list;
                    $datos['an'] = $an;
                    $datos['eje'] = $eje;
                    $this->load->view('dash/listado',$datos);
                }
            }
            else
            {
                //  Búsqueda por palabra clave

                // Al ingresar un texto, se realiza una búsqueda por:
                // 1.- Dependencia
                // 2.- Actividad

                $act_query = $this->M_dash->busqueda($keyword,$ideje);
                $datos['eje'] = 0;
                
                if(count($act_query) == 1)
                {
                    // Si la búsqueda devuelve un sólo resultado se muestra la ficha de la actividad
                    $this->ficha($act_query[0]->iIdActividad);
                }
                else
                {
                    $act_query = $this->M_dash->listado_actividades_by_keyword($keyword,0,$ideje);
                    $list = array();
                    foreach ($act_query as $row)
                    {
                        $list[$row->iIdActividad]['iIdActividad'] = $row->iIdActividad;
                        $list[$row->iIdActividad]['vActividad'] = $row->vActividad;
                        $list[$row->iIdActividad]['iIdDetalleActividad'] = $row->iIdDetalleActividad;
                        $list[$row->iIdActividad]['vDependencia'] = $row->vDependencia;
                        $list[$row->iIdActividad]['vEntregable'] = $row->vEntregable;

                        if(isset($list[$row->iIdActividad]['avance']))
                        {
                            $list[$row->iIdActividad]['avance']+= $row->avance;
                            $list[$row->iIdActividad]['ejercido']+= $row->ejercido;
                            $list[$row->iIdActividad]['beneficiarios']+= ($row->iMismosBeneficiarios == 1) ? $row->bene:$row->beneficiarios; 

                        }
                        else
                        {
                            $list[$row->iIdActividad]['avance']= $row->avance;
                            $list[$row->iIdActividad]['ejercido']= $row->ejercido;
                            $list[$row->iIdActividad]['beneficiarios']= ($row->iMismosBeneficiarios == 1) ? $row->bene:$row->beneficiarios;
                        }                    
                    }
                    $datos['query'] = $list;
                    $this->load->view('dash/listado_keyword',$datos);
                   
                }
              
            }
        }
    }

    // Funciones para la búsqueda de información del buscador principal

    public function filtrar_listado_act()
    {
        $op = $this->input->post('op');
        $eje = $this->input->post('eje');
        $an = $this->input->post('anio');
        $mun = $this->input->post('mun');

        if($op == 1 || $op == 3)
        {
            $act_query = $this->M_dash->listado_actividades($an,$eje,$mun);
            $list = array();
            if(count($act_query) > 0)
            {
                    
                foreach ($act_query as $row)
                {
                    $list[$row->iIdActividad]['iIdActividad'] = $row->iIdActividad;
                    $list[$row->iIdActividad]['vActividad'] = $row->vActividad;
                    $list[$row->iIdActividad]['iIdDetalleActividad'] = $row->iIdDetalleActividad;
                    $list[$row->iIdActividad]['vDependencia'] = $row->vDependencia;
                    $list[$row->iIdActividad]['vEntregable'] = $row->vEntregable;

                    if(isset($list[$row->iIdActividad]['avance']))
                    {
                        $list[$row->iIdActividad]['avance']+= $row->avance;
                        $list[$row->iIdActividad]['ejercido']+= $row->ejercido;
                        $list[$row->iIdActividad]['beneficiarios']+= ($row->iMismosBeneficiarios == 1) ? $row->bene:$row->beneficiarios; 

                    }
                    else
                    {
                        $list[$row->iIdActividad]['avance']= $row->avance;
                        $list[$row->iIdActividad]['ejercido']= $row->ejercido;
                        $list[$row->iIdActividad]['beneficiarios']= ($row->iMismosBeneficiarios == 1) ? $row->bene:$row->beneficiarios;
                    }                    
                }

                echo ' <table id="lista_act" class="table table-hover datatable">
                            <thead class="bg-inverse text-white">
                                <tr>
                                    <th>Id</th>
                                    <th>Actividad</th>
                                    <th>Dependencia</th>';            
                if($eje > 0)
                {
                    echo '<th>Avance</th><th>Ejercido</th><th>Beneficiarios</th>';
                }
                echo '          </tr>
                            </thead>
                            <tbody>';
                
                foreach ($list as $row)
                {
                    echo '<tr title="Haga click para ver más" style="cursor:pointer;" onclick="verMas('.$row['iIdActividad'].');">';
                    echo '<td>'.$row['iIdActividad'].'</td>';
                    echo '<td>'.$row['vActividad'].'</td>';
                    echo '<td>'.$row['vDependencia'].'</td>';
                    if($eje > 0)
                    {
                        echo "<td>$".Decimal($row['avance'])."</td>";
                        echo "<td>".DecimalMoneda($row['ejercido'])."</td>";
                        echo "<td>".Decimal($row['beneficiarios'])."</td>";
                    }
                    echo "</tr>";
                }
                
                echo ' </tbody>
                        </table>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#lista_act").DataTable();
                    });
                </script>';
            }
            else
            {
                echo '<p>No se encontraron resultados que coincidan con su búsqueda</p>';
            }
        }
    }

    public function mostrar_mapa_op()
    {
        $op = $this->input->post('op');
        $eje = $this->input->post('eje');
        $an = $this->input->post('anio');

        // Datos para el mapa de ejercido
        $datos['maxGasto'] = 1;
        $datos['op'] = $op;

        if($op == 1 || $op == 2 )
        {
            if($op == 1) $q_mun = $this->M_dash->ejercido_mun_eje_anio_acciones($eje,$an);
            else $q_mun = $this->M_dash->ejercido_mun_eje_anio_obras($eje,$an);

            if($q_mun->num_rows() > 0)
            {
                $q_mun = $q_mun->result();
                $datamun = '';
                foreach ($q_mun as $mun)
                {
                    if($mun->ejercido > $datos['maxGasto']) $datos['maxGasto'] = $mun->ejercido;
                    if($datamun != '') $datamun .= ',';

                    if($op == 1)
                        $datamun.= "{name: '$mun->vMunicipio',id: '$mun->iIdMunicipio', value: '$mun->ejercido', population: '$mun->iTotalPoblacion', op:$op }";
                    elseif($op == 2)
                        $datamun.= "{name: '$mun->vMunicipio',id: '$mun->iIdMunicipio', value: '$mun->ejercido', acciones: '$mun->acciones', op:$op }";
                }
                $datos['datamun'] = $datamun;
            }else $datos['datamun'] = false;
        } 
        else
        {
            $q_mun = $this->M_dash->ejercido_mun_eje_anio_acciones($eje,$an)->result();
            
            $data = array();
            foreach ($q_mun as $mun)
            {
                $data[$mun->iIdMunicipio]['iIdMunicipio'] = $mun->iIdMunicipio;
                $data[$mun->iIdMunicipio]['vMunicipio'] = $mun->vMunicipio;
                $data[$mun->iIdMunicipio]['ejercido'] = $mun->ejercido;
                $data[$mun->iIdMunicipio]['iTotalPoblacion'] = $mun->iTotalPoblacion;
            }
            $q_mun = $this->M_dash->ejercido_mun_eje_anio_obras($eje,$an)->result();

            foreach ($q_mun as $mun)
            {
                if(isset($data[$mun->iIdMunicipio]))
                {
                    $data[$mun->iIdMunicipio]['ejercido'] += $mun->ejercido;   
                }
                else
                {
                    $data[$mun->iIdMunicipio]['iIdMunicipio'] = $mun->iIdMunicipio;
                    $data[$mun->iIdMunicipio]['vMunicipio'] = $mun->vMunicipio;
                    $data[$mun->iIdMunicipio]['ejercido'] = $mun->ejercido;
                    $data[$mun->iIdMunicipio]['iTotalPoblacion'] = $mun->iTotalPoblacion;
                }
            }

            if(count($data) > 0)
            {
                $datamun = '';
                foreach ($data as $mun) {
                    if($mun['ejercido'] > $datos['maxGasto']) $datos['maxGasto'] = $mun['ejercido'];
                    if($datamun != '') $datamun .= ',';
                    $datamun.= "{name: '".$mun['vMunicipio']."',id: '".$mun['iIdMunicipio']."', value: '".$mun['ejercido']."', population: '".$mun['iTotalPoblacion']."', op:".$op."}";
                }
                $datos['datamun'] = $datamun;
            }else $datos['datamun'] = false;
        } 
        

        $datos['an'] = $an;
        $datos['eje'] = $eje;
        $this->load->view('dash/mapa_acciones_obras',$datos);
    }

    public function mostrar_datos_municipio()
    {
        $municipio = $this->input->post('mun');
        $eje = $this->input->post('eje');
        $anio = $this->input->post('anio');
        $op = $this->input->post('op');
        $acciones = 0;
        $ejercido = 0;
        $beneficiarios = 0;

        if($op == 1 || $op == 2)
        {
            if($op == 1) $query = $this->M_dash->monto_municipio_eje_anio_acciones($municipio,$eje,$anio)->result();
            else $query = $this->M_dash->datos_mun_eje_anio_obras($municipio, $eje,$anio)->result();           

            foreach ($query as $row) {
                $acciones+= $row->acciones;
                $ejercido+= $row->ejercido;
                //$beneficiarios+= ($row->iMismosBeneficiarios == 0) ? $row->beneficiarios: $row->bene;
               
            }
        }
        else
        {
            $query = $this->M_dash->monto_municipio_eje_anio_acciones($municipio,$eje,$anio)->result();
            foreach ($query as $row)
            {
                $acciones+= $row->acciones;
                $ejercido+= $row->ejercido; 
            }
            $query = $this->M_dash->datos_mun_eje_anio_obras($municipio,$eje,$anio)->result();
            foreach ($query as $row)
            {
                $acciones+= $row->acciones;
                $ejercido+= $row->ejercido; 
            }
        }

        echo '<h3 class="card-title">Monto invertido</h3>
            <p class="card-text">$'.DecimalMoneda(round($ejercido)).'</p>
            <h3 class="card-title">Número de acciones</h3>
            <p class="card-text">'.Decimal(round($acciones)).'</p>';

    }

    public function ficha($id)
    {
        $id = intval($id); //iIdActividad
        $datos = array();


        //  Datos generales
        $q_act = $this->M_dash->datos_actividad($id);
        foreach ($q_act as $key => $value)
        {
            $datos[$key] = $value;
        }


        //  Datos para las gráficas de financiamiento
        $g_pre = $this->M_dash->presupuesto_by_anio($id);
        $g_mod = $this->M_dash->presupuesto_mod_by_anio($id);
        $g_ejer = $this->M_dash->ejercido_by_anio($id);
        $g_av = $this->M_dash->av_by_anio($id);       
        $g_ben = $this->M_dash->ben_by_anio($id);
        $anios = $this->M_dash->avent_by_anio($id);
        $datos_anio = array();
        $maxanio = count($anios);
        $g_av_ent['entids'] = array();

        foreach ($anios as $vanios)
        {
            
            $g_av_ent['anios'][] = $vanios->iAnio;

            $val_ent = $this->M_dash->avent_by_anio($id, $vanios->iAnio);

            foreach ($val_ent as $vent)
            { 

                if(!in_array($vent->iIdEntregable, $g_av_ent['entids']))
                {
                    $g_av_ent['entids'][] = $vent->iIdEntregable;
                    $dat_entreg[] = array('entid' => $vent->iIdEntregable, 'nombre' => $vent->vEntregable);
                }

                $datos_anio[$vanios->iAnio][$vent->iIdEntregable] = $vent->nAvance;
            }
        }

        $g_av_ent['ent'] = $datos_anio;

        // Presupuesto autorizado y modificado
        $array_aut = $array_mod = array();
        foreach ($g_mod as $row)
        {
            $array_mod[$row->iAnio] = $row->presupuesto_modificado;
            $array_aut[$row->iAnio] = $row->presupuesto_autorizado;
        }
       
        // Presupuesto ejercido
        $array_temp = array();
        foreach ($g_ejer as $row)
        {
            $array_temp[$row->iAnio] = $row->ejercido;
        }

       
        $categories_pre = '';
        $data_presupuesto = '';
        $data_modificado = '';
        $data_ejercido = '';
        foreach ($g_pre as $row)
        {
            if($categories_pre != '') $categories_pre.=',';
            if($data_presupuesto != '') $data_presupuesto.=',';
            if($data_modificado != '') $data_modificado.=',';
            if($data_ejercido != '') $data_ejercido.=',';
            $categories_pre.= $row->iAnio;
            $data_presupuesto.= $row->presupuesto;
            $data_modificado.= (isset($array_mod[$row->iAnio])) ? $array_mod[$row->iAnio]:0;
            $data_ejercido.= (isset($array_temp[$row->iAnio])) ? $array_temp[$row->iAnio]:0; 
        }
        
        $datos['categories_pre'] = $categories_pre;
        $datos['data_presupuesto'] = $data_presupuesto;
        $datos['data_modificado'] = $data_modificado;
        $datos['data_ejercido'] = $data_ejercido;
        $datos['av'] = $g_av;
        $datos['ben'] = $g_ben;
        $datos['av_ent'] = $g_av_ent;
        $datos['dat_entreg'] = $dat_entreg;
        
        //  Financiamientos
        $q_fin = $this->M_dash->anios_financiamientos($id);
        $datos['tablas_fin'] = array(); 
        foreach ($q_fin as $row)
        {
            $modificado = (isset($array_mod[$row->iAnio])) ? DecimalMoneda($array_mod[$row->iAnio]):0;
            $autorizado = (isset($array_aut[$row->iAnio])) ? DecimalMoneda($array_aut[$row->iAnio]):0;
            
            $tabla = '<h5>'.$row->iAnio.'</h5>';        
            $tabla.= '<div class="row">
                        <div class="col-6"><h4><b>Presupuesto Autorizado:</b> $ '.$autorizado.'</h4></div>
                        <div class="col-6"><h4><b>Presupuesto Modificado:</b> $ '.$modificado.'</h4></div>
                    </div>';

            $tabla.= '<table class="table table-hover table-bordered">
                <thead class="bg-inverse text-white">
                    <tr>
                        <th>Financiamiento</th>
                        <th align="right">Monto</th>
                    </tr>
                </thead>
                <tbody>';
            $q_montos = $this->M_dash->datos_financiamientos($id,$row->iAnio);
            $cont = $total = 0;
            foreach ($q_montos as $row2)
            {
                $tabla.= '<tr>
                        <td>'.$row2->vFinanciamiento.'</td>
                        <td align="right"> $'.DecimalMoneda($row2->monto).'</td>
                    </tr>';
                $total+= $row2->monto;
                $cont++;
            }

            if($cont > 1)
            {
                $tabla.= '<tr>
                    <td align="right"><b>Total</b></td>
                    <td align="right"><b>$'.DecimalMoneda($total).'</b></td>
                </tr>';
            }
                   
            $tabla.= '</tbody>
            </table>';
            
            $datos['tablas_fin'][] = $tabla;
        }

        //  Entregables 
        $q_ent = $this->M_dash->anios_entregables($id);
        //$datos['tablas_ent'] = array(); 
        foreach ($q_ent as $row)
        {
            $porcentaje = (int)$row->nAvance;
            $tbody = '';
            $t_benh = $t_benm = $t_ejer = 0;
            $q_ent = $this->M_dash->entregables_por_anio($id,$row->iAnio);
            foreach ($q_ent as $row2)
            {
                if($row2->iMismosBeneficiarios == 1)
                {
                    $q_ejer = $this->M_dash->benef_mes_entregable($row2->iIdDetalleEntregable,$row2->maxfecha);
                    $benh = $q_ejer->benh;
                    $benm = $q_ejer->benm;

                }
                else
                {
                    $benh = $row2->benh;
                    $benm = $row2->benm;
                }

                $t_benh += $benh;
                $t_benm += $benm;
                $t_ejer += $row2->ejercido;


                $tbody.= '<tr style="cursor:pointer;" title="Haga clic para ver más">
                        <td>'.$row2->vEntregable.'</td>
                        <td align="right">'.Decimal($row2->nMeta).'</td>
                        <td>'.$row2->vUnidadMedida.'</td>
                        <td align="right">'.DecimalMoneda($row2->avance).'</td>
                        <td><i  class="fa-lg mdi mdi-human-male text-primary"></i>'.Decimal($benh).'<br>
                        <i  class="fa-lg mdi mdi-human-female rosa"></i>'.Decimal($benm).'</td>
                        <td align="right">$'.DecimalMoneda($row2->ejercido).'</td>
                    </tr>';
            }

            $datos['tablas_entregables'][] = '<div class="row">
                        <div class="col-6"><h3>'.$row->iAnio.'</h3></div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="ml-auto">
                                        <h3 class="font-light text-right">'.$row->nAvance.' %</h3>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: '.$porcentaje.'%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>                    
                    <div class="row">
                        <div class="col-4">
                            <div class="p-10 bg-light">
                               <div class="d-flex align-items-center" >
                                    <div>
                                        <h3 class="font-light m-b-5">'.Decimal($t_benh).'</h3>
                                        <span class="text-muted">Hombre(s) beneficiado(s)</span>
                                    </div>
                                    <div class="ml-auto">
                                        <h1><i class="mdi mdi-human-male text-primary"></i></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-10 bg-light">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h3 class="font-light m-b-5">'.Decimal($t_benm).'</h3>
                                        <span class="text-muted">Mujere(s) beneficiada(s)</span>
                                    </div>
                                    <div class="ml-auto">
                                        <h1><i class="mdi mdi-human-female rosa"></i></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-10 bg-light">
                                <div class="d-flex align-items-center">
                                    <div>
                                            <h3 class="font-light m-b-5">'.Decimal($t_ejer).'</h3>
                                        <span class="text-muted">Pesos ejercidos</span>
                                    </div>
                                    <div class="ml-auto">
                                        <h1><i class="mdi mdi-coin text-success"></i></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
            <table class="table table-hover table-bordered">
                <thead class="bg-inverse text-white">
                    <tr>
                        <th>Entregable</th>
                        <th align="right">Meta</th>
                        <th align="right">U. Medida</th>
                        <th align="right">Avance</th>
                        <th>Beneficiarios</th>
                        <th align="right">Gasto ejercido</th>
                    </tr>
                </thead>
                <tbody>';
            $datos['tablas_entregables'][].= $tbody.'</tbody>
            </table>
            <hr>';
            
            
        }
        /* Aqui va un comentario
        ljrlkjlrj4
        lkkrj4lrjl4
        */
        // Datos para la gráfica Avance por Entregable
        /*$avances_entregables = $this->M_dash->avances_entregables($id);
        $d_avance = array('categories'=> array(),'series'=>'');
        foreach ($avances_entregables as $row)
        {
            if(!in_array($row->vEntregable, $d_avance['categories'])) $d_avance['categories'][] = $row->vEntregable;

            $d_avance['series'][] = array('' => '' );

        }*/

        $this->load->view('dash/ficha',$datos);
    }

    public function despliegue(){
        if($_REQUEST['id']){
            if($_REQUEST['an']){
                $id = $this->input->get('id',true);
                $an = $this->input->get('an',true);
                $this->session->set_userdata('anio', $an);
                $datos['dependencias'] = $this->M_dash->dependencias($id);
                $datos['av'] = $this->M_dash->avacetotaleje($id, $an);
                $datos['temas'] = $this->M_dash->temas($id);
                $datos['actividades'] = $this->M_dash->actividades($id,$an);
                $data = $this->M_dash->temas($id);
                $valores = array();
                $rec = '';
                foreach($data as $dat){

                    $rec = $this->M_dash->totaltemas($dat['iIdTema']);
                    array_push($valores, $rec);
                }
                $datos['avance'] = $valores;
                
                //print_r($datos['avance']);
                $this->load->view('dash/desp', $datos);
            }
        }
    }
    
    public function desplieguetabla(){
        if($_REQUEST['id']){
            $an = $this->session->userdata('anio');
            $id = $this->input->get('id',true);
            $datos['actividades2'] = $this->M_dash->actividades2($id, $an);
            $this->load->view('dash/tablaactividades', $datos);
        }
    }

    public function ficha_eje()
    {
        $datos =  array();
        $iIdEje = $datos['iIdEje'] = $this->input->post('id');
        $anio = $datos['anio'] = $this->input->post('anio');
        $datos['row_eje'] = $this->M_dash->nombre_eje($iIdEje);
        $datos['total_actividades'] = 0;
     
     


        for ($i=1; $i < 5 ; $i++)
        { 
            $datos['trim'.$i] = '';
            $query = $this->M_dash->num_actividades_avance($iIdEje,$anio,$i);
            if($query->num_rows() == 1)
            {
                $row = $query->row();
                $faltantes = $row->count - $row->sum;
                if($row->count > 0) $datos['total_actividades'] = $row->count;
                $datos['trim'.$i] = "{
                                        name: 'Sin avance',
                                        y: $faltantes,
                                        sliced: true,
                                        selected: true,
                                        color: '#CC0000',
                                        trimestre: $i,
                                        op: 0
                                        
                                    },
                                    {
                                        name: 'Con avance',
                                        y: $row->sum,
                                        color: '#3E5F8A',
                                        trimestre: $i,
                                        op: 1
                                    }";
            }
        }

        $this->load->view('dash/ficha_eje',$datos);
    }

    function tabla_act()
    {
        $ideje = $this->input->post('id');
        $anio = $this->input->post('anio');
        $trim = $datos['trim'] = $this->input->post('trim');
        $tipo = $this->input->post('op');

        $rows = $this->M_dash->actividades_eje_trim($ideje,$anio,$trim,$tipo)->result();
        foreach ($rows as $key => $value)
        {
            $rows[$key]->entregables = $this->M_dash->lista_entregables($rows[$key]->iIdDetalleActividad,$anio,$trim);
        }
        $datos['rows'] = $rows;

        $this->load->view('dash/listado_actividades',$datos);
    }

    function enviar_correo()
    {
        $mensaje = $this->input->post('mensaje',true);
        $correo = $this->input->post('correo',true);
        $resp['resp'] = false;
        $resp['mensaje'] = 'El servidor de correo ha fallado'; 
        if(filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $resp['resp'] = mail($correo, 'Mensaje SIGO', $mensaje);
        } else $resp['mensaje'] = 'El correo no es válido';

        echo json_encode($resp);
    }

    function options_actividades()
    {
        $seg = new Class_seguridad();
        $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $ideje = ($all_sec > 0) ? 0:$_SESSION[PREFIJO.'_ideje'];
        $iddep = $_SESSION[PREFIJO.'_iddependencia'];

        $anio = $this->input->get('anio');
        $term = $this->input->get('term');

        $array['pagination'] = array('more' => false );

        if(strlen($term) > 3)
        {

            $query = $this->M_dash->nombre_actividades($term,$anio,$ideje);
            
            if($query->num_rows() > 0)
            {
                $query = $query->result();

                foreach ($query as $row)
                {
                    $array['results'][] = array('id' => $row->iIdDetalleActividad, 'text' => $row->vActividad);
                }
            }
            else
            {           
                $array['results'][] = array();
                
            }
        }
        else
        {           
            $array['results'][] = array();
            
        }
       
        echo json_encode($array);
    }

    function option_entregables()
    {
        $this->load->library('Class_options');
        $opt = new Class_options();

        $where['de.iIdDetalleActividad'] = $this->input->post('id');
        echo $opt->options_tabla('det_entregables',"",$where);
    }


    function update_mapa_gasto()
    {
        $anio = $this->input->post('anio',true);
        $idDetAct = $this->input->post('idDetAct',true);
        $idDetEnt = $this->input->post('idDetEnt',true);

        $q_mun = $this->M_dash->ejercido_municipio($anio,$idDetAct,$idDetEnt);

        $datos['maxGasto'] = 1;
        $cont = 0;
        $top_gasto = array();

        if($q_mun->num_rows() > 0)
        {
            $q_mun = $q_mun->result();
            
            foreach ($q_mun as $mun)
            {
                if($cont < 10)
                {
                    $top_gasto[] = array('mun' => $mun->vMunicipio ,'ejercido' => $mun->ejercido);
                    $cont++;
                }

                if($mun->ejercido > $datos['maxGasto']) $datos['maxGasto'] = floatval($mun->ejercido);
                $datos['datamun'][] = array(
                                            'name' => $mun->vMunicipio,
                                            'id' => $mun->iIdMunicipio,
                                            'value' => floatval($mun->ejercido),
                                            'avance' => floatval($mun->avance),
                                            'population' => $mun->iTotalPoblacion
                                        );
                //if($datamun != '') $datamun .= ',';
                //$datamun.= "{name: '".$mun->vMunicipio."',id: ".$mun->iIdMunicipio.", value:".$mun->ejercido.", population:".$mun->iTotalPoblacion."}";
            }
        }else $datos['datamun'][] = array();
        $datos['tooltip'] = '<h4 class="font-weight-bold text-center">{point.name}</h4><br>Ejercido: <b>${point.value:,.2f}</b>';
        if($idDetEnt > 0) $datos['tooltip'].= '<br>Avance: <b>{point.avance:,.2f}</b>';
        $datos['top_gasto'] = $top_gasto;
        echo json_encode($datos);
    }

    public function deps_anio_eje()
    {
        $model          = new M_dash();
        $data['anio']   = $this->input->post('anio',true);
        $data['eje']    = $this->input->post('eje',true);
        $name    = $this->input->post('name',true);
        $data['query']  = $model->deps_anio_eje($data['anio'],$data['eje']);
        $this->load->model('M_dash2');
        
        $where['s.iAnio']           = $data['anio'];
        $where['s.iIdEje']          = $data['eje'];
        
        foreach($data['query'] as $query){
            $avances        =  $this->M_dash->avance_por_dependencia($query->iIdDependencia, $data['anio']);
            $totalAvance    = 0;
            foreach($avances as $avance){
                $totalAvance = $totalAvance  + $avance->nBeneficiariosH + $avance->nBeneficiariosM+
                $avance->nDiscapacitadosH + $avance->nDiscapacitadosM+
                $avance->nLenguaH + $avance->nLenguaM+
                $avance->nTerceraEdadH + $avance->nTerceraEdadM+
                $avance->nAdolescenteH + $avance->nAdolescenteM
                ;
            }
            $query->beneficiario = $totalAvance;


            $where['s.iIdDependencia']  = $query->iIdDependencia;
            $q_info         = $this->M_dash2->info_dash_sector($where);
            $autorizado     = $q_info->result();
            
            $dependencia    = $this->M_dash->presupuesto_por_dependencia($data['eje'], $query->iIdDependencia, $data['anio']);
            $pagado         = $dependencia[0]->ejercido  == '' ? 0 : $dependencia[0]->ejercido;
            $montoAutor     = $autorizado[0]->autorizado == '' ? 0 : $autorizado[0]->autorizado;
            
            $query->presupuesto =  $montoAutor == 0 ? 0 : round(($pagado * 100)/$montoAutor, 2);
            $query->cadena =  $name;
   
        }
        $this->load->view('dash/list_deps',$data);
    }

    public function list_acts()
    {
        // Listado de actividades por año y dependencia
        $data['anio'] = $this->input->post('anio',true);
        $data['eje'] = $this->input->post('eje',true);
        $data['dep'] = $this->input->post('dep',true);

        $data['query'] = $this->M_dash->list_actividades($data['anio'],$data['dep'], $data['eje']);

        foreach($data['query'] as $query){
            $avances        =  $this->M_dash->avance_por_detalle($query->iIdDetalleActividad);
            $totalAvance    = 0;
            $totalPagado    = 0;
            
            foreach($avances as $avance){
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
     
        $this->load->view('dash/list_acts',$data);
    }

    public function ver_actividad($idAct = 0)
    {
        if($idAct == 0)
        {
            $datos['anio'] = $anio = $this->input->post('anio',true);
            $datos['eje'] = $this->input->post('eje',true);
            $datos['dep'] = $this->input->post('dep',true);
            $datos['idAct'] = $idAct = $this->input->post('idAct',true);
        }
        else
        {
            $datos['idAct'] = $idAct;
            $datos['anio'] = $anio = date('Y');
            $datos['eje'] = 0;
            $datos['dep'] = 0;
        }

      //echo "aaaawe";
        // Datos de la actividad
        $q_act = $this->M_dash->datos_actividad($idAct,$anio);
       //echo "product list<pre>";
        //print_r($q_act);
        //echo "</pre>";


        $meses = array(
            '01'  => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
            '01'  => 'Enero'
            );

         $html_avance = '<div class="accordion" id="meses">';

          foreach($meses as $mes => $value)
        {   
            $obser = $this->M_dash->avance_por_dependencia_mes($datos['dep'], $anio, $mes, $idAct);

            
            $html_avance.= '<div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#mes'.$mes.'" aria-expanded="true" aria-controls="mes'.$mes.'" style="cursor:pointer">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#mes'.$mes.'" aria-expanded="true" aria-controls="mes'.$mes.'" >
                                    '.$value.'
                                </button>
                            </div>
                        </div>
                        
                    </div>';
                    $html_avance .='<div id="mes'.$mes.'" class="collapse" aria-labelledby="headingOne" data-parent="meses">
                        <div class="card-body">';
                            foreach ($obser as $item) {
                                $html_avance.='<div>'.$item->vObservaciones.'<hr></div>';
                            }
                        $html_avance .='</div>
                    </div>';
                $html_avance .='</div>';
        }

        $html_avance.= '</div>';


        foreach ($q_act as $key => $value)
        {
            $datos[$key] = $value;
        }

        // Alineación ODS
        $datos['ods'] = $this->M_dash->alineacion_actividad_ods($idAct);

        // Avance por año
        $query = $this->M_dash->avance_anios($idAct);
        $background = $series = '';
        $count = 0;
        $width = 15;
        $inner = 50;
        foreach ($query as $row)
        {
            $row->nAvance = round($row->nAvance);
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
                                y: $row->nAvance
                            }]
                        }";
            $inner = $outer + 1;
            $count++;
        }
        $datos['background'] = $background;
        $datos['series'] = $series;
        // Datos financieros
        $datos['data_fin'] = $this->datos_grafica_financierosXmes($idAct,$anio);
       
        //Listado de entregables (Select)
        $datos['ent'] = $this->M_dash->list_entregables_by_idact($idAct);
        //Gráfica de entregables
        if(count($datos['ent']) > 0)
        {
            $datos['unidad'] = $datos['ent'][0]->vUnidadMedida;
            $datos['data'] = $this->datos_graficas_entregable_mes($idAct,$datos['ent'][0]->iIdEntregable,$anio);
        }
       $datos['avance_mes'] = $html_avance;
        //echo 'Data '.$datos;
        $this->load->view('dash/ver_actividad',$datos);
    }

    function ver_graf_entregable()
    {
        $idAct = $this->input->post('idAct');
        $idEnt = $this->input->post('idEnt');
        $anio = $this->input->post('anio');

        $datos['unidad'] = 'acciones';
        $datos['data'] = $this->datos_graficas_entregable($idAct,$idEnt,$anio);
        $this->load->view('dash/graphs/g-entregables',$datos);
    }

    function datos_grafica_financieros($idAct,$anio=0)
    {
        if($anio == 0) $anio = date('Y');
        $anios = $series = "";
        $dpre = $dau = $dmod = $deje = array();
        $array_fin = array();
        for ($i=2021; $i <= $anio; $i++)
        { 
            $anios.= ($anios != '') ? ','.$i:$i;

            $query = $this->M_dash->finanzas_by_anio($idAct,$i);
            
            if($query->num_rows() == 1)
            {   
                
                $array_fin['Presupuesto'][$i] = $dpre[] = floatval($query->row()->presupuesto);
                $array_fin['Autorizado'][$i] = $dau[] = floatval($query->row()->autorizado);
                $array_fin['Modificado'][$i] = $dmod[] = floatval($query->row()->modificado);
                $array_fin['Ejercido'][$i] = $deje[] = floatval(round($this->M_dash->ejercido_by_idact($query->row()->iIdDetalleActividad),2));
            }
            else
            {
                $array_fin['Presupuesto'][$i] = $array_fin['Autorizado'][$i] = $array_fin['Modificado'][$i] = $array_fin['Ejercido'][$i] = $dpre[] = $dau[] = $dmod[] = $deje[] = 0;
            }
        }
        
        $series = ", {
                name: 'Autorizado',
                data: [".json_encode($dau).",".json_encode($dau)."],
                color: '#005b96'

            }, {
                name: 'Ejercido',
                data: [".json_encode($deje).", ".json_encode($deje)."],
                color: '#b3cde0'

            },";

        return $resp = array('anios' => $anios, 'series' => $series, 'arrayFin' => json_encode($array_fin));
    }

    function datos_grafica_financierosXmes($idAct,$anio=0)
    {
        if($anio == 0) $anio = date('Y');
        $anios = $series = "";
        $dpre = $dau = $dmod = $deje = $meses = array();
        $array_fin = array();
        for ($i=2021; $i <= $anio; $i++)
        { 
            $anios.= ($anios != '') ? ','.$i:$i;

            $query = $this->M_dash->finanzas_by_anio_mes($idAct,$i);
            
            for($a = 0 ; $a < $query->num_rows(); $a ++){
                $get_datos = $query->result_array();
                array_push($dpre, floatval($get_datos[$a]["presupuesto"]));
                array_push($dau, floatval($get_datos[$a]["autorizado"]));
                array_push($dmod, floatval($get_datos[$a]["modificado"]));
                array_push($deje, floatval(round($this->M_dash->ejercido_by_idact($get_datos[$a]["iIdDetalleActividad"]))));

                $array_fin['Presupuesto'][$i] = $dpre;
                $array_fin['Autorizado'][$i] = $dau;
                $array_fin['Modificado'][$i] = $dmod;
                $array_fin['Ejercido'][$i] = $deje;

                setlocale(LC_ALL, 'es_MX');
                $monthNum  = $get_datos[$a]["mes"];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = strftime('%B', $dateObj->getTimestamp());
                switch($monthName){
                    case 'January':
                        $monthName = 'Enero';
                    break;
                    case 'Febrary':
                        $monthName = 'Febrero';
                        break;
                        case 'March':
                            $monthName = 'Marzo';
                            break;
                            case 'April':
                                $monthName = 'Abril';
                                break;
                                case 'May':
                                    $monthName = 'Mayo';
                                    break;
                                    case 'June':
                                        $monthName = 'Junio';
                                        break;
                                        case 'July':
                                            $monthName = 'Julio';
                                            break;
                                            case 'August':
                                                $monthName = 'Agosto';
                                                break;
                                                case 'September':
                                                    $monthName = 'Septiembre';
                                                    break;
                                                    case 'October':
                                                        $monthName = 'Octubre';
                                                        break;
                                                        case 'November':
                                                            $monthName = 'Noviembre';
                                                            break;
                                                            case 'December':
                                                                $monthName = 'Diciembre';
                                                                break;
                        
                }
                array_push($meses, $monthName." ".$anio);

            }
        }
        $series = " {
                name: 'Autorizado',
                data: ".json_encode($dau).",
                color: '#005b96'

            }, {
                name: 'Ejercido',
                data: ".json_encode($deje).",
                color: '#b3cde0'

            },";
            
        
        return $resp = array('anios' => $anios, 'series' => $series, 'arrayFin' => json_encode($array_fin), 'categorias' => json_encode($meses));
    }


    function datos_graficas_entregable($idAct,$idEnt,$anio=0)
    {
        if($anio == 0) $anio = date('Y');

        $d_avan = $d_ejer = '';
        // Para la grafica de metas
        $anios = $series = "";
        $no_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];


        for ($i=2021; $i <= $anio; $i++)
        {            
            
            //Datos graf Avan vs Metas
            $anios.= ($anios != '') ? ','.$i:$i;
            $query = $this->M_dash->metas_av_anio($idAct,$idEnt,$i);
            if($query->num_rows() == 1)
            {
                $avanceM = ($query->row()->nMeta > 0) ? round(($query->row()->avance * 100) / $query->row()->nMeta):0;
                $avanceMod = ($query->row()->nMetaModificada > 0) ? round(($query->row()->avance * 100) / $query->row()->nMetaModificada):0;
                if($avanceM > 100) $avanceM = 100;
                if($avanceMod > 100) $avanceMod = 100;
                $dmet[] = array('y'=> floatval($query->row()->nMeta),'avance'=> ' [<b>'.$avanceM.'%</b> cumplido]');
                $dmod[] = array('y'=> floatval($query->row()->nMetaModificada),'avance'=>' [<b>'.$avanceMod.'%</b> cumplido]');                
                $davan[] = array('y'=> floatval($query->row()->avance),'avance'=>'');
            }
            else
            {
                $dmet[] = $dmod[] = $davan[] = array('y' => 0, 'avance' => '');;
            }

            $series = "{
                name: 'Meta',
                data: ".json_encode($dmet).",
                color: '#CBC9C9',
                pointPadding: 0.3
            }, {
                name: 'Avance',
                data: ".json_encode($davan).",
                color: '#456FE8',
                pointPadding: 0.4

            }";


            $avan = $ejer = $no_data;
            $query = $this->M_dash->avan_ejer_anio($idAct,$idEnt,$i);
            if(count($query) > 0)
            {
                foreach ($query as $row)
                {
                    $avan[$row->mes] = floatval($row->avance);
                    $ejer[$row->mes] = floatval($row->ejercido);
                }
            }
            $visible = ($i == $anio) ? 'true':'false';
            if($d_avan != '') $d_avan.= ',';
            $d_avan.= "{
                        name: '$i',
                        data: ".json_encode($avan).",
                        visible: $visible
                    }";

            if($d_ejer != '') $d_ejer.= ',';
            $d_ejer.= "{
                        name: '$i',
                        data: ".json_encode($ejer).",
                        visible: $visible
                    }";
        }        

        return $resp = array('d_avan' => $d_avan, 'd_ejer' => $d_ejer, 'anios' => $anios, 'series' => $series);        
    }

    function datos_graficas_entregable_mes($idAct,$idEnt,$anio=0)
    {
        if($anio == 0) $anio = date('Y');

        $d_avan = $d_ejer = '';
        // Para la grafica de metas
        $anios = $series = "";
        $no_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];


        for ($i=2021; $i <= $anio; $i++)
        {            
            
            //Datos graf Avan vs Metas
            $anios.= ($anios != '') ? ','.$i:$i;
            $query = $this->M_dash->metas_av_anio_mes($idAct,$idEnt,$i);

               
                $dmet =  $dmod = $davan = array();
                for($a = 0; $a < $query->num_rows(); $a ++){

                    
                    
                    
                    $get_datos = $query->result_array();
                    $avanceM = ($get_datos[$a]["nMeta"] > 0) ? round(($get_datos[$a]["avance"] * 100) / $get_datos[$a]["avance"]):0;
                    $avanceMod = ($get_datos[$a]["nMetaModificada"] > 0) ? round(($get_datos[$a]["avance"]* 100) / $get_datos[$a]["nMetaModificada"]):0;
                    if($avanceM > 100) $avanceM = 100;
                    if($avanceMod > 100) $avanceMod = 100;

                    // $get_datos[$a]["presupuesto"]
                    $pre_dmet_y = floatval($get_datos[$a]["nMeta"]);
                    $pre_dmet_avance = ' [<b>'.$avanceM.'%</b> cumplido]';
                    $pre_dmod_y = floatval($get_datos[$a]["nMetaModificada"]);
                    $pre_dmod_avance =' [<b>'.$avanceMod.'%</b> cumplido]';
                    $pre_davanm_y = floatval( $get_datos[$a]["avance"]);
                    $pre_davanm_avance = '';

                    // $dmet += array('y'=> $pre_dmet_y,'avance'=> $pre_dmet_avance);
                    // $dmod += array('y'=>  $pre_dmod_y ,'avance'=> $pre_dmod_avance);                
                    // $davan += array('y'=> $pre_davanm_y,'avance'=>$pre_davanm_avance);
                    
                    array_push($dmet, array('y'=> $pre_dmet_y,'avance'=> $pre_dmet_avance));
                    array_push($dmod, array('y'=>  $pre_dmod_y ,'avance'=> $pre_dmod_avance));
                    array_push($davan, array('y'=> $pre_davanm_y,'avance'=>$pre_davanm_avance));

                }



            


            $series = "{
                name: 'Meta',
                data: ".json_encode($dmet).",
                color: '#CBC9C9',
                pointPadding: 0.3
            }, {
                name: 'Avance',
                data: ".json_encode($davan).",
                color: '#456FE8',
                pointPadding: 0.4

            }";


            $avan = $ejer = $no_data;
            $query = $this->M_dash->avan_ejer_anio($idAct,$idEnt,$i);
            if(count($query) > 0)
            {
                $cont = 1;
                foreach ($query as $row)
                {
                    // if(cont >9)
                    $avan[$row->mes] = floatval($row->avance);
                    $ejer[$row->mes] = floatval($row->ejercido);
                }
            
            }
            array_splice($avan,0,9);
            array_splice($ejer,0,9);
            array_push($avan,0);
            array_push($ejer,0);

            $visible = ($i == $anio) ? 'true':'false';
            if($d_avan != '') $d_avan.= ',';
            $d_avan.= "{
                        name: '$i',
                        data: ".json_encode($avan).",
                        visible: $visible
                    }";

            if($d_ejer != '') $d_ejer.= ',';
            $d_ejer.= "{
                        name: '$i',
                        data: ".json_encode($ejer).",
                        visible: $visible
                    }";
        }        

        return $resp = array('d_avan' => $d_avan, 'd_ejer' => $d_ejer, 'anios' => $anios, 'series' => $series);        
    }
    public function buscar() {
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
                $this->dash_ejes($an,$ideje);
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

    public function ver_detalle() {
        $id = $this->input->post('id',true);
        $tipo = $this->input->post('tipo',true);

        if($tipo == 1) $this->ficha_dep($id);
        else $this->ver_actividad($id);
    }

    public function dash_ejes($anio=0,$ideje=0) {
        $seg = new Class_seguridad();
        $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);
        $ideje = ($all_sec > 0) ? 0:$_SESSION[PREFIJO.'_ideje'];
        $iddep = $_SESSION[PREFIJO.'_iddependencia'];

        $an     = ($anio == 0) ? $this->input->post('anio',true):$anio;
        $datos  = array();
        $datos['all_sec']   = $all_sec;
        $datos['all_dep']   = $all_dep;
        $datos['anio']      = $an;

        // Devuelve información general acerca de un año
        $q_avance       = $this->M_dash->avance_anio_eje($an,$ideje);
        $q_presupuesto  = $this->M_dash->presupuesto_anio_eje($an,$ideje);
        $q_ejercido     = $this->M_dash->ejercido_anio_eje($an,$ideje);
        $q_ejes         = $this->M_dash->ejes_icono($ideje);
        $q_benef        = $this->M_dash->beneficiarios_anio_eje($an,$ideje);
        $q_entregables  = $this->M_dash->ent_por_anio($an,$ideje);
        
        // Datos totales
        $datos['pat_totales'] = 0;
        $datos['act_totales'] = 0;
        $datos['ent_totales'] = 0;
        for ($i=1; $i < 10; $i++) { 
            $datos['eje_'.$i] = array('avance'=> 0, 'avance_t' => 0, 'avance_r' => 0,'presupuesto' => 0, 'ejercido' => 0, 'pa' => 0, 
            'entregables' => 0, 'actividades' => 0, 'beneficiarios' => 0, 'hombres' => 0, 'mujeres' => 0, 'total' => 0);
        }

        // AVANCE POR EJE RECTOR
        $q_avance = $q_avance->result(); 
        foreach ($q_avance as $d) {                
            $datos['eje_'.$d->iIdEje]['avance_t'] = $d->numact * 100;
            $datos['eje_'.$d->iIdEje]['avance_r'] = $d->avance_r;
            $datos['eje_'.$d->iIdEje]['avance'] = Decimal(($d->avance_r * 100) / ($d->numact * 100));
            $datos['eje_'.$d->iIdEje]['actividades'] = $d->numact;
            $datos['act_totales'] +=  $d->numact;

            $q_pat = $this->M_dash->pat_anio($d->iIdEje, $an);
            $q_pat = $q_pat->result();
            // Pat po eje
            $datos['eje_'.$d->iIdEje]['pat'] = count($q_pat);
            // Pat totales
            $datos['pat_totales'] += count($q_pat);


            //Obtengo las dependencias por eje para así tener el numero de beneficiarios
            $mujeres = 0;
            $hombres = 0;
            $dependencias    = $this->M_dash->dependencias_por_eje($d->iIdEje);
            
            foreach($dependencias as $dependencia){
                $beneficiarios   =  $this->M_dash->avance_por_dependencia($dependencia->iIdDependencia, $an);
                foreach($beneficiarios as $beneficiario){
                    $datos['eje_'.$d->iIdEje]['hombres'] = $hombres  + $beneficiario->nBeneficiariosH;
                    $datos['eje_'.$d->iIdEje]['mujeres'] = $mujeres  + $beneficiario->nBeneficiariosM;
                }
                $datos['eje_'.$d->iIdEje]['total'] = $datos['eje_'.$d->iIdEje]['hombres'] + $datos['eje_'.$d->iIdEje]['mujeres'];
            }
        }

        // Obras para (datos para el eje 9)
        $datos['av_obras'] = $this->M_dash->avance_obras($an);
        $datos['pre_obras'] = $this->M_dash->presupuesto_obras($an);

        // Entregables por eje
        $q_entregables = $q_entregables->result();
        foreach ($q_entregables as $d) {
            $datos['eje_'.$d->iIdEje]['entregables'] = $d->nument;
            $datos['ent_totales'] +=  $d->nument;
        }
       
        //  Ejercido por eje
        $q_ejercido = $q_ejercido->result();
        foreach ($q_ejercido as $d) {
            $datos['eje_'.$d->iIdEje]['ejercido'] = Decimal($d->ejercido);
        }

      
        $datos['q_ejes'] = $q_ejes->result();
        $datos['ejes'] = $this->M_dash->ejes();
        $datos['avejes'] = $this->M_dash->avacetotalejes($an);

        $data = $this->M_dash->ejes();
        $valores = array();
        $rec = '';
        foreach($data as $dat)
        {

            $rec = $this->M_dash->avacetotaleje($dat['iIdEje'], $an);
            array_push($valores, $rec);
        }
        
        //  Ejercido por municipios
        $q_mun = $this->M_dash->ejercido_municipio($an);
        $datos['maxGasto'] = 1;
        $cont = 0;
        $top_gasto = array();

        if($q_mun->num_rows() > 0)
        {
            $q_mun = $q_mun->result();
            $datamun = '';
            foreach ($q_mun as $mun)
            {
                if($cont < 10)
                {
                    $top_gasto[] = array('mun' => $mun->vMunicipio ,'ejercido' => $mun->ejercido);
                    $cont++;
                }

                if($mun->ejercido > $datos['maxGasto']) $datos['maxGasto'] = $mun->ejercido;
                if($datamun != '') $datamun .= ',';
                $datamun.= "{name: '".$mun->vMunicipio."',id: ".$mun->iIdMunicipio.", value:".$mun->ejercido.", population:".$mun->iTotalPoblacion."}";
            }
            $datos['datamun'] = $datamun;
        }else $datos['datamun'] = false;

        $datos['top_gasto'] = $top_gasto;
              

        // Datos de compromisos
        $datos['comp_est'] = $this->M_dash->compromisos_estatus();


        //  Datos de compromisos por eje
        $q_comp = $this->M_dash->compromisos_eje($ideje);
        for ($i=0; $i < count($data); $i++)
        { 
            if(isset($q_comp[$i]))
            {
                $q_comp[$i]->estatus = $this->M_dash->estatus_compromisos_eje($q_comp[$i]->iIdEje);
            }
        }
        $datos['comp'] = $q_comp;

        $this->load->view('dash/dash_ejes', $datos);
    }

    public function ficha_dep($idDep = 0)
    {
        $this->load->model('M_dash2');
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

        $data['actividades'] = $this->M_dash->list_actividades($anio,$idDep, '');
        $data['compromisos'] = $this->M_dash2->compromisos_by_dep($idDep);
        $data['est_compromiso'] = $this->M_dash2->compromisos_estatus_by_dep($idDep);
        $data['obras'] = '';

        $this->load->view('dash2/ficha_dep',$data);
    }

    public function avan_anio($idDep = 0)
    {
        $this->load->model('M_dash2');
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

        $data['actividades'] = $this->M_dash->list_actividades($anio,$idDep, '');

        $this->load->view('dash2/avan_anio',$data);
    }

    // Tablero de obra
    function mostrar_tablero_obras()
    {
        $datos['anio'] = $this->input->post('anio', TRUE);
        $model = new M_dash();

        $datos['obras_ej'] = $obras_ej = $model->obras_por_ejecutora($datos['anio']);

        // Obras por ejecutor
        $categories = $series1 = $series2 = $series3 = $series4 = '';
        $obras_ej = $obras_ej->result();
        foreach ($obras_ej as $da)
        {
            $categories.= ($categories != '') ? ",'$da->vDependencia'":"'$da->vDependencia'";
            // Licitadas
            $series1.= ($series1 != '') ? ','.$da->licitadas:$da->licitadas;
            // concluidas
            $series2.= ($series2 != '') ? ','.$da->concluidas:$da->concluidas;
            // no concluidas
            $series3.= ($series3 != '') ? ','.$da->noiniciadas:$da->noiniciadas;
        }
        $series = "{name: 'Licitadas', data: [$series1]}, {name: 'Concluidas', data: [$series2]}, {name: 'No iniciadas', data: [$series3]}";

        $data1 = array('id' => 4, 'type'=>'bar','titulo'=>'', 'categories' => $categories, 'series' => $series);

        $datos['graph4'] = $this->load->view('dash/graphs/g-obrasejecutores',$data1,true);

        $this->load->view('dash/tablero_obras',$datos);
    }

    function actualizar_grafica()
    {
        $iIdGraph = $this->input->post('iIdGraph');
        $iId = $this->input->post('iId');

        $model = new M_dash();
        $categories = $series1 = $series2 = $series3 = $series4 = '';

        if($iIdGraph == 4)
        {
            // Obras por ejecutor
            $obras_ej = $model->obras_por_ejecutora(0,$iId)->result();
            foreach ($obras_ej as $da)
            {
                $categories.= ($categories != '') ? ",'$da->vDependencia'":"'$da->vDependencia'";
                // Licitadas
                $series1.= ($series1 != '') ? ','.$da->licitadas:$da->licitadas;
                // concluidas
                $series2.= ($series2 != '') ? ','.$da->concluidas:$da->concluidas;
                // no concluidas
                $series3.= ($series3 != '') ? ','.$da->noiniciadas:$da->noiniciadas;
            }
            $series = "{name: 'Licitadas', data: [$series1]}, {name: 'Concluidas', data: [$series2]}, {name: 'No iniciadas', data: [$series3]}";

            $data1 = array('id' => 4, 'type'=>'bar','titulo'=>'', 'categories' => $categories, 'series' => $series);
        }

        if($iId > 0) $data1['boton'] = 1;
        $this->load->view('dash/graphs/g-obrasejecutores',$data1);
    }

    function mostrar_datos_obras()
    {
        $id = $this->input->post('id');
        $tipo = $this->input->post('tipo');
        $anio = $this->input->post('anio');

        $model = new M_dash();
        $tabla = '';

        // Por ejecutor
        if($tipo == 4)
        {
            $rows = $model->list_obras_ejecutor($anio,$id);
            $tabla = '<table class="datatable table-bordered table table-striped table-hover" id="tabla-data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Obra</th>
                            <th>Presupuesto</th>
                            <th>Ficha</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($rows as $row) 
            {
                $tabla.= '<tr>
                        <td>'.$row->iIdObra.'</td>
                        <td>'.$row->vNombre.'</td>
                        <td align="right">$ '.DecimalMoneda($row->presupuesto).'</td>
                        <td><a title="Haga clic para descargar ficha de la obra" style="cursor:pointer" onclick="descargar_reporte('.$row->iIdObra.');"><i class="text-danger mdi mdi-file-pdf-box"></i></a></td>
                    </tr>';
            }

            $tabla.= '</tbody>
            </table>';
        }

        $tabla.= '<script>
            $(document).ready(function(){
                $("#tabla-data-table").DataTable();
            });
        </script>';
        echo $tabla;
    }
}