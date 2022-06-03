<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control_pagina extends CI_Controller
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
		$this->load->helper('url');
		$this->load->model('M_compromisos');

	}

	public function index()
	{
		$data['filas'] = '';
		$data['num_compromiso'] = 0;
		$data['compromisos_10'] = $this->M_compromisos->listar_compromisos10();
		$this->load->view('masterpage/head', $data);
		$this->load->view('V_index_compromiso', $data);
		$this->load->view('masterpage/footer');
	}

	public function ListarCompromisos4()//lista los últimos 4 compromisos actulizados
	{
		$data['filas'] = '';
		$data['num_compromiso'] = 0;
		$data['compromisos_4'] = $this->M_compromisos->listar_compromisos4();
		$objetos_compromisos = $data['compromisos_4'];
		$colors = array('#00A36A', '#212743', '#694688', '#6CBB37');
		$i = 0;
		foreach ($objetos_compromisos as $datos) {

			$data['filas'] .= $this->fila_compromiso($datos['iIdCompromiso'], $datos['vCompromiso'], $datos['iNumero'], $colors[$i], $datos['iIdDependencia']);
			$i++;
		}
	}

	public function fila_compromiso($iIdCompromiso, $nombre, $numero, $color, $id_dependencia)
	{
		$id_compromiso = base64_encode($iIdCompromiso);
		$idDependencia = base64_encode($id_dependencia);
		$html = ' <div class="col-lg-3 featured-box-full featured-box-full-primary" style="background-color: ' . $color . '">
                <a href="' . base_url() . 'compromisos/descripcion/' . $id_compromiso . '/' . $idDependencia . '">
					<h1><strong>' . $numero . '</strong></h1>
                    <h4><strong>Compromiso</strong></h4>
                    <h5 class="font-weight-light" style="text-align: center">' . $nombre . '</h5>
                </a>
            </div>';

		echo $html;
	}
}


