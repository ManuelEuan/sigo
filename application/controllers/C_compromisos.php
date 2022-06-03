<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class C_compromisos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
        $this->load->model('M_compromisos', 'comp');
        $this->load->model('M_componente', 'compt');
        $this->load->model('M_catalogos', 'catlogs');
    }

    public function index()
    {
        $seg = new Class_seguridad();
        $tipo_acceso = $seg->tipo_acceso(25, $_SESSION[PREFIJO . '_idusuario']);
        $tipo_periodorev = $seg->tipo_acceso(22, $_SESSION[PREFIJO . '_idusuario']);
        $all_sec = $seg->tipo_acceso(9, $_SESSION[PREFIJO . '_idusuario']);
        $all_dep = $seg->tipo_acceso(10, $_SESSION[PREFIJO . '_idusuario']);
        $opt =  new Class_options();
        $dep = $sec = 0;

        $periodorevisionactivo = $this->comp->periodorevisionactivo();
        // $revisarEvidencia = $seg->tipo_acceso(20,$_SESSION[PREFIJO.'_idusuario']);

        if ($tipo_acceso > 0) {
            $options = new Class_options();

            //$datos['options_ejes'] = $options->options_tabla('eje');
            $wherec = ['vEntidadMide' => 'Compromiso'];
            $datos['estatus'] = $options->options_tabla('estatus', 0, $wherec);
            //$where_dependencias['iIdEje'] = 0;
            //$datos['options_dependencias'] = $options->options_tabla('dependencias_nombre_largo', 0, $where_dependencias);
            $where_estatus['vEntidadMide'] = 'Avance compromiso';
            //$datos['options_estatus'] = $options->options_tabla('estatus', 0, $where_estatus);
            $datos['permisorevision'] = $tipo_periodorev;
            $datos['periodorevision'] = $periodorevisionactivo;
            $where = array('estatus' => 0, 'fecha' => 0, 'palabra' => '', 'dependencia' => 0, 'eje' => 0);
            if($all_sec > 0) $datos['ejes'] = $opt->options_tabla('eje',"");
            else
            { 
                $sec = $_SESSION[PREFIJO.'_ideje'];
                $where['eje'] = $_SESSION[PREFIJO.'_ideje'];
            }

            if($all_dep > 0)
            { 
                $datos['dependencias'] = (isset($where['eje']) && $where['eje'] > 0) ? $opt->options_tabla('dependencia',"",array('iIdEje' => $where['eje'])):$opt->options_tabla('dependencia',"",'iActivo = 3');
            }
            else
            {
                $dep = $_SESSION[PREFIJO.'_iddependencia'];
                $where['dependencia'] = $dep;
            }
            $datos['sec'] = $sec;
            $datos['dep'] = $dep;
            $datos['tabla_compromisos'] = $this->tabla_compromisos($where);
            $this->load->view('compromisos/index', $datos);


        } else {
            echo '<p>Acceso denegado</p>';
        }

    }

    public function listartablacompromiso()
    {

        if (isset($_POST['palabra'])) {
            $datos['tabla_compromisos'] = $this->tabla_compromisos($_POST);
        } else {
            $datos['tabla_compromisos'] = $this->tabla_compromisos('');
        }
        $this->load->view('compromisos/tabla', $datos);
    }

    public function tabla_compromisos($where)
    {
        $periodorevisionactivo = $this->comp->periodorevisionactivo();
        $periodoactivo = ($periodorevisionactivo == 0) ? '' : 'disabled="disabled"';

        $compromisos = $this->comp->buscar_compromisos($where);
        //  return $compromisos->result();

        $html = '';

        if ($compromisos->num_rows() > 0) {
            $html = '
            <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">';

            $html .= '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
                  <thead>
                        <tr>
                            <th>Estatus</th>
                            <th>#</th>
                            <th>Compromiso</th>
                            <th>Responsable</th>
                            <th>% Avance</th>
                            <th>Última <br> actualización</th>
                            <th width="200px;">Opciones</th>
                        </tr>
            </thead>
            <tbody>';

            $compromisos = $compromisos->result();
            foreach ($compromisos as $c) {
                $option = "confirmar('¿Esta usted seguro?',eliminar_compromiso,$c->iIdCompromiso)";
                $html .= '<tr>';
                            

                            if($c->dPorcentajeAvance >= 0 && $c->dPorcentajeAvance <= 25)
                            {
                                $html.= '<td>
                                    <div class="progress-c mx-auto" data-value="'.$c->dPorcentajeAvance.'">
                                        <span class="progress-c-left">
                                            <span class="progress-c-bar border-danger"></span>
                                        </span>
                                        <span class="progress-c-right">
                                            <span class="progress-c-bar border-danger"></span>
                                        </span>
                                        <div class="progress-c-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="h3 font-weight-bold">'.$c->dPorcentajeAvance.'<sup class="small">%</sup></div>
                                        </div>
                                    </div>
                                </td>';
                            } 
                            elseif($c->dPorcentajeAvance > 25 && $c->dPorcentajeAvance < 100)
                            {
                                $html.= '<td>
                                    <div class="progress-c mx-auto" data-value="'.$c->dPorcentajeAvance.'">
                                        <span class="progress-c-left">
                                            <span class="progress-c-bar border-warning"></span>
                                        </span>
                                        <span class="progress-c-right">
                                            <span class="progress-c-bar border-warning"></span>
                                        </span>
                                        <div class="progress-c-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="h3 font-weight-bold">'.$c->dPorcentajeAvance.'<sup class="small">%</sup></div>
                                        </div>
                                    </div>
                                </td>';
                            }
                            else 
                            {
                                $html.= '<td>
                                    <div class="progress-c mx-auto" data-value="'.$c->dPorcentajeAvance.'">
                                        <span class="progress-c-left">
                                            <span class="progress-c-bar border-success"></span>
                                        </span>
                                        <span class="progress-c-right">
                                            <span class="progress-c-bar border-success"></span>
                                        </span>
                                        <div class="progress-c-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                            <div class="h3 font-weight-bold">'.$c->dPorcentajeAvance.'<sup class="small">%</sup></div>
                                        </div>
                                    </div>
                                </td>';
                            }





                            $html.= '<td>' . $c->iNumero . '</td>
                            <td>' . $c->vCompromiso . '</td>
                            <td>' . $c->vDependencia . '</td>
                            <td>' . $c->dPorcentajeAvance . '</td>
                            <td>' . $c->dUltimaAct . '</td>
                            <td width="200px;">
                            <button title="Editar" type="button" class="btn btn-xs waves-effect waves-light btn-warning" onclick="modificar_financiamiento(' . $c->iIdCompromiso . ')"><i class="mdi mdi-border-color"></i></button>
                            <button title="Modificar componentes" type="button" class="btn btn-xs waves-effect waves-light btn-primary" onclick="modificar_componentes(' . $c->iIdCompromiso . ')"><i class="fa fa-list"></i></button>
                            <button title="Eliminar" type="button" class="btn btn-xs waves-effect waves-light btn-danger" onclick="' . $option . '" ' . $periodoactivo . '><i class="mdi mdi-close"></i></button>
                            </td>
                        </tr>';
            }
            // '.$opciones.'

            $html .= ' </tbody></table>
            <script>
                $(function() {

                $(".progress-c").each(function() {

                    var value = $(this).attr(\'data-value\');
                    var left = $(this).find(\'.progress-c-left .progress-c-bar\');
                    var right = $(this).find(\'.progress-c-right .progress-c-bar\');

                    if (value > 0) {
                        if (value <= 50) {
                            right.css(\'transform\', \'rotate(\' + percentageToDegrees(value) + \'deg)\')
                        } else {
                            right.css(\'transform\', \'rotate(180deg)\')
                            left.css(\'transform\', \'rotate(\' + percentageToDegrees(value - 50) + \'deg)\')
                        }
                    }

                })

                function percentageToDegrees(percentage) {

                    return percentage / 100 * 360

                }

            });
            </script>
            </div>
            </div>
        </div>
    </div>';
        }else{
            $html = '
            <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">';

            $html .= '<table class="table table-striped table-bordered display" style="width:100%" id="grid">
                  <thead>
                        <tr>
                            <th>Estatus</th>
                            <th>#</th>
                            <th>Compromiso</th>
                            <th>Responsable</th>
                            <th>% Avance</th>
                            <th>Última <br> actualización</th>
                            <th width="200px;">Opciones</th>
                        </tr>
            </thead>
            <tbody>';
                $html .= '<tr>
                            <td colspan="7" style="text-align: center"> Sin resultados</td>
                     
                        </tr>';
            // '.$opciones.'

            $html .= ' </tbody></table>
            </div>
            </div>
        </div>
    </div>';
        }

        return $html;

    }

    public function buscar_compromisos()
    {
        if ($_POST) {
            $where = '';
            if ($this->input->post('eje') > 0) $where['ej.iIdEje'] = $this->input->post('eje',TRUE);
            if ($this->input->post('dependencia') > 0) $where['c.iIdDependencia'] = $this->input->post('dependencia',TRUE);
            if ($this->input->post('estatus') > 0) $where['c.iEstatus'] = $this->input->post('estatus',TRUE);
            //if($this->input->post('fecha') != '')
            //if($this->input->post('palabra') != '')
        }
    }

    public function cargar_options()
    {
        $valor = $this->input->post('valor',TRUE);
        $listado = $this->input->post('listado',TRUE);

        if ($listado = 'responsables') {
            $options = new Class_options();

            $where_dependencias['iIdEje'] = $valor;
            echo $options->options_tabla('dependencias_nombre_largo', 0, $where_dependencias);
        }
    }

    public function create()
    {
        $options = new Class_options();

        $datos['options_ejes'] = $options->options_tabla('eje');
        $datos['politica_publica'] = $options->options_tabla('tema');
        $datos['dependencias'] = $options->options_tabla('dependencias');
        $where = ['vEntidadMide' => 'Compromiso'];
        $datos['estatus'] = $options->options_tabla('estatus', 0, $where);
        $this->load->view('compromisos/contenido_agregar', $datos);
    }

    public function update()
    {
        $options = new Class_options();

        $datos['options_ejes'] = $options->options_tabla('eje');
        $datos['politica_publica'] = $options->options_tabla('tema');
        $datos['dependencias'] = $options->options_tabla('dependencias');
        $where = ['vEntidadMide' => 'Compromiso'];
        $datos['estatus'] = $options->options_tabla('estatus', 0, $where);
        $idcopromiso = $this->input->post("id",TRUE);

        $datos['datos_m'] = $this->listarcompromiso($idcopromiso);


        $where = ['c.iIdCompromiso' => $idcopromiso, 'c.iActivo' => 1];
        $datosTabla = $this->compt->listado_componentes($where);
        $datos['datosTabla'] = $datosTabla->result();
        $seg = new Class_seguridad();
        $tipo_periodorev = $seg->tipo_acceso(22, $_SESSION[PREFIJO . '_idusuario']);
        $datos['permisorevision'] = $tipo_periodorev;
        $periodorevisionactivo = $this->comp->periodorevisionactivo();
        $datos['periodorevision'] = $periodorevisionactivo;

        // $where_img=array('iIdCompromiso'=>$idcopromiso, 'iActivo'=>'Fotografía');
        // $datosImagenes = $this->compt->listado_imagenes($where);
        // $datos['datosTablaImagenes']=$datosImagenes->result();
        $datos['galeria']=$this->comp->listar_galeria($idcopromiso);

        $datos['idcompromiso']=$idcopromiso;

        $this->load->view('compromisos/contenido_editar', $datos);
    }

    public function listarcompromiso($id)
    {
        return $this->comp->listarcompromiso($id);
    }
    public function cargar_nueva_galeria(){
        $idcopromiso = $this->input->post("idCompromiso_",TRUE);
        $periodoactivo = $this->input->post("periodo",TRUE);

        $style;
        $aviso;

        if ($periodoactivo != 'disabled="disabled"'){
            $style="none";
            $aviso="<h3 style=\"text-align: center !important;\" class=\"card-title\">Para ver la evidencia fotográfica, el período de revisión debe estar activo</h3>";
        }
        else{
            $style="";
            $aviso="";
        }
        $datos['galeria']=$this->comp->listar_galeria($idcopromiso);
        $galeria=$datos['galeria'];
        $cont = 1;
        if ($galeria != null) {

            echo '<h3 style="text-align: center !important;" class="card-title">Evidencia fotográfica</h3>
                                                      '.$aviso.'
                                                    <h5 style="text-align: center !important;display:'.$style.';" class="card-title">Arraste para poner un orden y presione para seleccionar la foto inicio (orden de izquierda a derecha)</h5>';
            echo '<div style="display:'.$style.';"  class="drag padre" id="image-container">';
            foreach ($galeria as $key) {
                $checked=null;
                if($key['iFotoInicio'] == 1){
                    $checked="checked=\"checked\"";
                }else{
                    $checked="";
                }
                echo '<div id="foto_'.$key['iIdEvidencia'].'" rel="'.$key['iIdEvidencia'].'" class="img-thumbnail">
                                                            ';
                echo ' <input class="check_hidden" type="checkbox" '.$checked.' id="myCheckbox'.$cont.'" />
                                                              <label style="cursor:pointer" class="galeria" for="myCheckbox'.$cont.'">
                                                             
                                                                           <img   style="height: 160px;width:250px;" class="pequeña hijo imagen" rel="' . $key['iIdEvidencia'] . '" src=" '.base_url().'/archivos/documentosImages/' . $key['vEvidencia'] . '" alt="' . $key['vEvidencia'] . '">
                                                                           
                                                            </label>
                                                                        
                                                              
                                                                  
                                                           ';
                $cont++;
                echo '</div>';
            }
            echo ' </div>';
            echo ' <p style="visibility:hidden" id="output">1,2,3</p>
                                                    <div style="display:'.$style.';" id="submit-container">
                                                        <input onclick="guardar_posiciones()" type="button" class="btn btn-success" value="Guardar" />
                                                    </div>';
        } else {
            echo '
                                                    <h2 style="text-align: center !important;" class="card-title">Evidencia fotográfica</h2><h3 style="text-align: center !important;" class="card-title">Sin evidencia fotográfica disponible</h3>';
        }

    }
    public function actualizar_posicion(){

        $imageIdsArray = $_POST['data'];

        //$id_evidencia = explode(",", $imageIdsArray);
        $posicion = 1;
        $inserciones=1;
        $con = $this->comp->iniciar_transaccion();

        foreach ($imageIdsArray as $item){
            $this->comp->ActualizarPosicion_imagenes(
                  $item['iIdEvidencia'],
                  array( "iFotoInicio"=>$item['iFotoInicio'],
                      "iOrdenFoto"=>$item['iOrdenFoto']
                  ),$con
              );

         }
        if ($this->comp->terminar_transaccion($con) == true) {

            echo "correcto";
        } else {
            echo "fallo";
        }


        /*if(trim($id_evidencia[0], " '\t\n\r\0\x0B")!=""){
            for ($i = 0; $i < count($id_evidencia); $i++) {
                $id_convertido = (int)$id_evidencia[$i];

                $datos = [

                    "iOrdenFoto" => $posicion
                ];
                if ($this->comp->ActualizarPosicion_imagenes($id_convertido, $datos)) {
                    //
                } else {
                    echo "incorrecto";
                }
                //$this->comp->ActualizarPosicion_imagenes($id_convertido, $datos);
               //echo var_dump($id_convertido);
               $posicion ++;


            }

        }else{
            echo "fallo";
        }*/




    }

    public function insertarCompromiso()
    {
        $vCompromiso = $this->input->post("vCompromiso",TRUE);
        $iNumero = $this->input->post("iNumero",TRUE);
        $iEstatus = $this->input->post("iEstatus",TRUE);
        $iIdDependencia = $this->input->post("iIdDependencia",TRUE);
        $vFeNotarial = $this->input->post("vFeNotarial",TRUE);
        $vNombreCorto = $this->input->post("vNombreCorto",TRUE);
        $fecha = date("Y-m-d H:i:s");
        $vDescripcion = $this->input->post("vDescripcion",TRUE);
        $iUltUsuarioAct = $_SESSION[PREFIJO . '_idusuario'];
        $iIdTema = $this->input->post("iIdTema",TRUE);
        $vObservaciones = $this->input->post("vObservaciones",TRUE);
        $data = [
            "vCompromiso" => $vCompromiso,
            "iNumero" => $iNumero,
            "iEstatus" => $iEstatus,
            "iRevisado" => 0,
            "dPorcentajeAvance" => 0,
            "iIdDependencia" => $iIdDependencia,
            "vFeNotarial" => "*",
            "vNombreCorto" => $vNombreCorto,
            "dUltimaAct" => $fecha,
            "vDescripcion" => $vDescripcion,
            "iUltUsuarioAct" => NULL,
            "iUltUsuarioRev" => NULL,
            "iIdTema" => $iIdTema,
            "vAntes" => "*",
            "vDespues" => "*",
            "iActivo" => 1,
            "vObservaciones" => base64_encode(utf8_encode($vObservaciones))
        ];
        $idCompromiso = $this->comp->insertarCompromiso($data);
        $this->agregar_CompromisoCorresponsable($idCompromiso);
    }

    public function ActualizarCompromiso()
    {
        $vCompromiso = $this->input->post("vCompromiso",TRUE);
        $iNumero = $this->input->post("iNumero",TRUE);
        $iEstatus = $this->input->post("iEstatus",TRUE);
        $iIdDependencia = $this->input->post("iIdDependencia",TRUE);
        $vFeNotarial = $this->input->post("vFeNotarial",TRUE);
        $vNombreCorto = $this->input->post("vNombreCorto",TRUE);
        $fecha = date("Y-m-d H:i:s");
        $vDescripcion = $this->input->post("vDescripcion",TRUE);
        $iUltUsuarioAct = $_SESSION[PREFIJO . '_idusuario'];
        $iIdTema = $this->input->post("iIdTema",TRUE);
        $vObservaciones = $this->input->post("vObservaciones",TRUE);

        $iIdCompromiso = $this->input->post("iIdCompromiso",TRUE);
        $data = [
            "vCompromiso" => $vCompromiso,
            "iNumero" => $iNumero,
            "iEstatus" => $iEstatus,
            // "iRevisado" =>1,
            "iIdDependencia" => $iIdDependencia,
            "vFeNotarial" => "*",
            "vNombreCorto" => $vNombreCorto,
            "dUltimaAct" => $fecha,
            "vDescripcion" => $vDescripcion,
            "iUltUsuarioAct" => $_SESSION[PREFIJO . '_idusuario'],
            "iUltUsuarioRev" => NULL,
            "iIdTema" => $iIdTema,
            "vAntes" => "*",
            "vDespues" => "*",
            "iActivo" => 1,
            "vObservaciones" => base64_encode(utf8_encode($vObservaciones))
        ];
        $where = [
            "iIdCompromiso" => $iIdCompromiso
        ];
        $this->comp->ActualizarCompromiso($data, $where);
        $this->comp->eliminar_CompromisoCorresponsable($where);
        $this->agregar_CompromisoCorresponsable($iIdCompromiso);
    }

    public function agregar_CompromisoCorresponsable($id)
    {
        $iIdDependenciaCble = $this->input->post('iIdDependenciaCble',TRUE);
        // linea para convertir el string separado por comas en array
        $dependenciascble = explode(",", $iIdDependenciaCble);

        if(trim($dependenciascble[0], " '\t\n\r\0\x0B")!=""){
            for ($i = 0; $i < count($dependenciascble); $i++) {
                $datos = [
                    'iIdCompromiso' => $id,
                    'iIdDependencia' => $dependenciascble[$i]
                ];
                $this->comp->agregar_CompromisoCorresponsable($datos);

            }
            echo "correcto";
        }else{
            echo "correcto";
        }


    }

    public function listarpp()
    {
        $ideje = $this->input->post("iIdEje",TRUE);
        $data = $this->comp->listarpp($ideje);
        echo json_encode($data);
    }

    public function delete()
    {
        if ($this->comp->delete($_POST) === TRUE) {
            echo "correcto";
        } else {
            echo "incorrecto";
        }
    }

    public function actualizarperiodo()
    {
        $where = ["iIdParametro" => 1];
        if ($this->comp->actualizarperiodo($_POST, $where) === TRUE) {
            echo "correcto";
        } else {
            echo "incorrecto";
        }

    }

    public function ActualizarIrevisado()
    {
        $where = ["iIdCompromiso" => $this->input->post("iIdCompromiso")];
        unset($_POST['iIdCompromiso']);
        if ($this->comp->ActualizarIrevisado($_POST, $where) === TRUE) {
            echo "correcto";
        } else {
            echo "incorrecto";
        }

    }
    public function PublicarCompromiso(){
        $con = $this->comp->iniciar_transaccion();

        // buscamos los compromisos revisados de la tabla compromisos

        $where=array('iRevisado' => 1,
                      'iActivo'=>1);


        $data['compromisos_revisados'] =$this->comp->iniciar_copiado_compromisos('Compromiso', $where, $con);

        // Finalizar transaccion
        if ($this->comp->terminar_transaccion($con) == true) {
            echo 'Correcto';
        } else {
            echo 'Error';
        }

    }
}

?>