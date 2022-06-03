<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_pps extends CI_Controller {
	public function __construct(){

        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->model('M_pps', 'm');
        $this->load->model('M_seguridad','mseg');
    }

    public function index(){
        $data['consulta'] = $this->m->mostrar_pps()->result();
    	$this->load->view('pps/inicio', $data);
    }

    public function buscar()
    {
        $key  = trim($this->input->post('keyword',true));
        $data['consulta'] = $this->m->mostrar_pps($key)->result();
        $this->load->view('pps/vTabla', $data);
    }

    public function capturar(){
        $id = $this->input->post('id');

        if($id > 0)
        {
            $query = $this->m->mostrar_pps('',$id);

            $fila = $query->row();
            foreach ($fila as $key => $value)
            {
               $datos[$key] = $value;
            }
        }
        else
        {
            $datos['iIdProgramaPresupuestario'] = 0;
            $datos['iNumero'] = '';
            $datos['vProgramaPresupuestario'] = '';
        }

        $this->load->view('pps/capturar', $datos);
    }

    function guardar()
    {
        $datos['resp'] = false;
        $datos['mensaje'] = '';

        if(isset($_POST['iIdProgramaPresupuestario']))
        {
            $where['iIdProgramaPresupuestario'] = $this->input->post('iIdProgramaPresupuestario');
            $d_pp['vProgramaPresupuestario'] = trim($this->input->post('vProgramaPresupuestario'));
            $d_pp['iNumero'] = intval(trim($this->input->post('iNumero')));

            $con = $this->mseg->iniciar_transaccion();

            if($where['iIdProgramaPresupuestario'] > 0)
            {
                $iIdProgramaPresupuestario = $this->mseg->actualiza_registro('ProgramaPresupuestario',$where,$d_pp,$con);
            }
            else
            {
                $iIdProgramaPresupuestario = $this->mseg->inserta_registro('ProgramaPresupuestario',$d_pp,$con);
            }

            if($this->mseg->terminar_transaccion($con)) $datos['resp'] = true;
            else $datos['mensaje'] = 'El registro no pudo ser eliminado';

        }

        echo json_encode($datos);
    }

    public function eliminar(){
        $key = $this->input->post('key',true);
        $where['iIdProgramaPresupuestario'] = $key;
        $datos['iActivo'] = 0;

        echo json_encode($this->mseg->actualiza_registro('ProgramaPresupuestario',$where,$datos));
        
    }

    public function sequence(){
        $rows = $this->m->sequence();

        foreach ($rows as $row) {
            $val_sequence = $this->m->last_val_sequence($row->seqname);
            $val_id = $this->m-> max_value($row->tabname,$row->column) + 1;

            if($val_sequence != $val_id) echo "ALTER SEQUENCE {$row->seqname} RESTART WITH $val_id;<br>";
        }
    }
}