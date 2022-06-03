<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_registro_cc extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_registro_cc','rcc');
        $this->load->model('M_seguridad','mseg');
        $this->load->library('Class_options');
    }

    //Muestra la vista principal
    public function index()
    {
        $data['consulta'] = $this->rcc->mostrar_registros();      
        $this->load->view('registro_cc/principal',$data);
    }

    public function capturar(){

        if(isset($_POST['id']))
        {
            $opt = new Class_options();
            $id = $this->input->post('id',true);
            if($id == 0)
            {
                $vTurno = (date('G') > 14) ? 'Vespertino':'Matutino';                
                $data = array(
                    'iIdRegistro' => $id,
                    'vNombre' => '',
                    'vPrimerApellido' => '',
                    'vSegundoApellido' => '',
                    'dFechaNacimiento' => '',
                    'iEdad' => '',
                    'vSexo' => '',
                    'iDiscapacidad' => '',
                    'iMayaHablante' => '',
                    'vOcupacion' => '',
                    'vCalleNum' => '',
                    'vColonia' => '',
                    'vCP' => '',
                    'iIdMunicipio' => 0,
                    'vProgramaMef' => '',
                    'iDependendientes' => '',
                    'vProgramaInteres' => '',
                    'vProblemaWeb' => '',
                    'vProblemaEspecificar' => '',
                    'vTurno' => $vTurno,
                    'tiempo' => date('Y-m-d H:i:s'),
                    'iIdProgramaCC' => 0,
                    'iIdMotivoCC' => 0
                );
            }
            else
            {
                $query = $this->rcc->consultar_registro($id);
                $data = array();
                foreach ($query as $key => $value) 
                {                    
                    $data[$key] = $value;
                }
                $data['dFechaNacimiento'] = cambiaf_a_normal($data['dFechaNacimiento']);
            }
            $data['options_municipio'] = $opt->options_tabla('municipios',$data['iIdMunicipio']);
            $data['options_programacc'] = $opt->options_tabla('programascc',$data['iIdProgramaCC']);
            $data['options_motivocc'] = $opt->options_tabla('motivoscc',$data['iIdMotivoCC']);
            $this->load->view('registro_cc/capturar',$data);

        }
    }

    //Funcion para modificar
    public function guardar(){

        if(isset($_POST['iIdRegistro']))
        {
            $datos = array(
                    'vNombre' => trim($this->input->post('vNombre',true)),
                    'vPrimerApellido' => trim($this->input->post('vPrimerApellido',true)),
                    'vSegundoApellido' => trim($this->input->post('vSegundoApellido',true)),
                    'dFechaNacimiento' => cambiaf_a_mysql($this->input->post('dFechaNacimiento')),
                    'vSexo' => $this->input->post('vSexo',true),
                    'iDiscapacidad' => (isset($_POST['iDiscapacidad'])) ? 1:0,
                    'iMayaHablante' => (isset($_POST['iMayaHablante'])) ? 1:0,
                    'vOcupacion' => trim($this->input->post('vOcupacion',true)),
                    'vCalleNum' => trim($this->input->post('vCalleNum',true)),
                    'vColonia' => trim($this->input->post('vColonia',true)),
                    'vCP' => trim($this->input->post('vCP',true)),
                    'iIdMunicipio' => (int)$this->input->post('iIdMunicipio',true),
                    'vProgramaMef' => trim($this->input->post('vProgramaMef',true)),
                    'iDependendientes' => (int)$this->input->post('iDependendientes'),
                    'vProgramaInteres' => '',
                    'vProblemaEspecificar' => trim($this->input->post('vProblemaEspecificar')),
                    'vTurno' => $this->input->post('vTurno'),
                    'iIdProgramaCC' => $this->input->post('iIdProgramaCC'),
                    'iIdMotivoCC' => $this->input->post('iIdMotivoCC')
                );
            // Calculamos la edad 
            $fechanac = new DateTime($datos['dFechaNacimiento']);
            $hoy = new DateTime(date('Y-m-d'));
            $anios = $hoy->diff($fechanac);
            $datos['iEdad'] = $anios->format('%Y');

            $id = $this->input->post('iIdRegistro');
            $con = $this->mseg->iniciar_transaccion();
            if($id > 0)
            {
                $where['iIdRegistro'] = $id;
                $id = $this->mseg->actualiza_registro('RegistroCC',$where,$datos,$con);
            }
            else
            {
                $datos['vProblemaWeb'] = '';
                // Tiempo de llamada
                $tiempo1 = new DateTime($this->input->post('tiempo'));
                $tiempo2 = new DateTime(date('Y-m-d H:i:s'));
                $intervalo = $tiempo1->diff($tiempo2);


                $datos['tDuracionLlamada'] = $intervalo->format('%H:%i:%s');
                $datos['dFechaCaptura'] = date('Y-m-d H:i:s');
                $id = $this->mseg->inserta_registro('RegistroCC',$datos,$con);
            }

            if($this->mseg->terminar_transaccion($con)) echo 0;
            else echo 'Error el registro no pudo guardarse';
        }
    }

    //Funcion para eliminar
    public function eliminar()
    {
        if(isset($_POST['id']))
        {
            $id = $this->input->post('id',true);
            $where['iIdRegistro'] = $id;
            $datos['iActivo'] = 0;
            $con = $this->mseg->iniciar_transaccion();
            $id = $this->mseg->actualiza_registro('RegistroCC',$where,$datos,$con);
            if($this->mseg->terminar_transaccion($con)) echo 0;
            else echo 'Error el registro no pudo eliminarse';

        }
        else
        {
            echo "algo salio mal";
        }
    }

    //Funcion de busquedas
    public function buscar()
    {        
        $keyword = trim($this->input->post('keyword',true));

        $data['consulta'] = $this->rcc->mostrar_registros($keyword);      
        $this->load->view('registro_cc/contenido_tabla',$data);
    }

    public function reporte()
    {             
        $this->load->view('reporte/registroscc');
    }

    public function generar_reporte()
    {
        $resp = array();

        if(isset($_POST['finicio']) && isset($_POST['ffin']) && !empty($_POST['finicio']) && !empty($_POST['ffin']))
        {
            $this->load->library('excel');
            $finicio = cambiaf_a_mysql($this->input->post('finicio',true));
            $ffin = cambiaf_a_mysql($this->input->post('ffin',true));

            //$mrep = new M_reporteAct();
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel2007');
            $reader->setReadDataOnly(true);
            $reader->setLoadSheetsOnly(array('registros','resumen')); // Sólo cargamos la hoja que necesitamos 
            $reporte = $reader->load('public/reportes/plantilla_registroscc.xlsx');
            $reporte->setActiveSheetIndex('0');

            $finicio.= ' 00:00:00';
            $ffin.= ' 23:59:59';
            $where = '"dFechaCaptura" BETWEEN \''.$finicio.'\' AND \''.$ffin.'\'';
            $records =  $this->rcc->mostrar_registros('',$where);
            $resumen = $this->rcc->resumen_llamadas($where);
            $i = 2;
            foreach ($records as $row) 
            {
                $reporte->getActiveSheet()->SetCellValue('A'.$i,$row->iIdRegistro);
                $reporte->getActiveSheet()->SetCellValue('B'.$i,$row->vNombre);
                $reporte->getActiveSheet()->SetCellValue('C'.$i,$row->vPrimerApellido);
                $reporte->getActiveSheet()->SetCellValue('D'.$i,$row->vSegundoApellido);

                $reporte->getActiveSheet()->SetCellValue('E'.$i,$row->dFechaNacimiento);
                $reporte->getActiveSheet()->SetCellValue('F'.$i,$row->iEdad);

                $reporte->getActiveSheet()->SetCellValue('G'.$i,$row->vSexo);
                $reporte->getActiveSheet()->SetCellValue('H'.$i,$row->iDiscapacidad);
                $reporte->getActiveSheet()->SetCellValue('I'.$i,$row->iMayaHablante);

                $reporte->getActiveSheet()->SetCellValue('J'.$i,$row->vOcupacion);
                $reporte->getActiveSheet()->SetCellValue('K'.$i,$row->vCalleNum);
                // PED
                $reporte->getActiveSheet()->SetCellValue('L'.$i,$row->vColonia);
                $reporte->getActiveSheet()->SetCellValue('M'.$i,$row->vCP);
                $reporte->getActiveSheet()->SetCellValue('N'.$i,$row->vMunicipio);
                $reporte->getActiveSheet()->SetCellValue('O'.$i,$row->vProgramaMef);
                $reporte->getActiveSheet()->SetCellValue('P'.$i,$row->iDependendientes);
                // Financiamiento
                $reporte->getActiveSheet()->SetCellValue('Q'.$i,$row->vProgramaCC);
                $reporte->getActiveSheet()->SetCellValue('R'.$i,$row->vMotivoCC);
                // UBP
                $reporte->getActiveSheet()->SetCellValue('S'.$i,$row->vProblemaEspecificar);
                $reporte->getActiveSheet()->SetCellValue('T'.$i,$row->vTurno);
                $reporte->getActiveSheet()->SetCellValue('U'.$i,$row->tDuracionLlamada);
                // Entregable
                $reporte->getActiveSheet()->SetCellValue('V'.$i,$row->dFechaCaptura);
               
              
                $i++;
            }

            $reporte->setActiveSheetIndex('1');

            $reporte->getActiveSheet()->SetCellValue('A1','Llamadas');
            $reporte->getActiveSheet()->SetCellValue('B1','Programa');
            $i = 2;
            $total = 0;
            foreach ($resumen as $row) 
            {
                $reporte->getActiveSheet()->SetCellValue('A'.$i,$row->llamadas);
                $reporte->getActiveSheet()->SetCellValue('B'.$i,$row->vProgramaCC);
                $total+= $row->llamadas;

                $i++;
            }

            $reporte->getActiveSheet()->SetCellValue('A'.$i,'Total');
            $reporte->getActiveSheet()->SetCellValue('B'.$i,$total);
           

            $ruta = 'public/reportes/reporte_registroscc.xlsx';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);

            $resp['resp'] = 1;
            $resp['url'] = base_url().$ruta;
        }
        else
        {
             $resp['resp'] = 0;
        }

        echo json_encode($resp);
      
    }

}
?>