<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_compromisos_descripcion extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		//session_start();
		$this->load->helper('url');
		$this->load->model('M_compromisos');
		//$this->load->library('session');
	}

	public function index()
	{
		$key = base64_decode($this->uri->segment(3));
		$id_dependencia = base64_decode($this->uri->segment(4));

		$data['descripcion'] = $this->M_compromisos->listar_descripcion_compromiso($key);
		$data['responsable'] = $this->M_compromisos->listar_responsable($id_dependencia);
		$data['participantes'] = $this->M_compromisos->listar_participantes($key);
		$data['imagenes_portada'] = $this->M_compromisos->listar_fotos_portada($key);
		$data['galeria_fotos'] = $this->M_compromisos->listar_galeria($key);
		$data['videos'] = $this->M_compromisos->listar_videos($key);
		$data['documentos'] = $this->M_compromisos->listar_documentos($key);
		$this->load->view('masterpage/head');
		$this->load->view('V_descripcion_compromiso', $data);
		$this->load->view('masterpage/footer');
	}

	public function ListarComponentes()
	{
		$id_compromiso = base64_decode($this->uri->segment(4));
		$data['filas'] = '';
		$data['num_componentes'] = 0;
		$data['componentes'] = $this->M_compromisos->listar_componentes($id_compromiso);
		$objetos_componente = $data['componentes'];
		$i = 0;
		if ($objetos_componente != null) {
			foreach ($objetos_componente as $datos) {
				$data['filas'] .= $this->fila_componente($datos['iIdComponente'], $datos['vComponente'], $datos['nAvance'], $datos['vDescripcion']);
			}
		} else {
			echo '<label style="margin-bottom: 0px"><strong>Sin datos disponibles </strong></label>';
		}

	}

	public function fila_componente($iIdComponente, $nombre, $porcentaje, $descripcion)
	{
		$html = '<label style="margin-bottom: 0px"><strong>' . $nombre . ' </strong></label>
							<br>
							<label style="color: #000; margin-top: 0px !important;"><strong>Avance:</strong></label>
							<label style="color: #000;"><strong>' . $porcentaje . ' %</strong></label>

							<hr style="background: #777 !important;margin-bottom: 3rem!important;margin-top: 0px!important;      margin: 7px 0 !important; margin-top: 0rem !important; border: 1 !important; border-top: 1px solid rgba(0, 0, 0, 0.1) !important;">
							<p>' . $descripcion . ' </p>';
		echo $html;
	}
}


