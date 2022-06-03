<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_rvistas extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->model('M_rvista','mv');
    }

    public function index()
    {
    	$tabla = '';
    	$q_vavances = $this->mv->vavances();
    	$q_vcapdiaria = $this->mv->vcapdiaria();
    	$q_vnocaptura = $this->mv->vnocaptura();
    	$q_vultcapt = $this->mv->vultcapt();

    	//	Tabla vavances
    	if($q_vavances->num_rows() > 0)
    	{
    		$fila1 = $q_vavances->row();
    		$tabla = '<thead><tr>';
    		foreach ($fila1 as $key => $value)
    		{
    			$tabla.= '<th>'.$key.'</th>';
    		}
    		$tabla.= '</tr></thead>';

    		$query = $q_vavances->result();
    		foreach ($query as $fila)
    		{
    			$tabla.= '<tr>';
    			foreach ($fila1 as $key => $value)
	    		{
	    			$tabla.= '<td>'.$fila->{$key}.'</td>';
	    		}
    			$tabla.= '</tr>';
    		}

    		$datos['vavances'] = '<table id="t_vavances" class="table table-responsive">'.$tabla.'</table>';
    	}
    	else
    	{
    		$datos['vavances'] = '';
    	}

    	//	Tabla vcapdiaria
    	if($q_vcapdiaria->num_rows() > 0)
    	{
    		$fila1 = $q_vcapdiaria->row();
    		$tabla = '<thead><tr>';
    		foreach ($fila1 as $key => $value)
    		{
    			$tabla.= '<th>'.$key.'</th>';
    		}
    		$tabla.= '</tr></thead>';

    		$query = $q_vcapdiaria->result();
    		foreach ($query as $fila)
    		{
    			$tabla.= '<tr>';
    			foreach ($fila1 as $key => $value)
	    		{
	    			$tabla.= '<td>'.$fila->{$key}.'</td>';
	    		}
    			$tabla.= '</tr>';
    		}

    		$datos['vcapdiaria'] = '<table id="t_vcapdiaria" class="table table-responsive">'.$tabla.'</table>';
    	}
    	else
    	{
    		$datos['vcapdiaria'] = '';
    	}

    	//	Tabla vnocaptura
    	if($q_vnocaptura->num_rows() > 0)
    	{
    		$fila1 = $q_vnocaptura->row();
    		$tabla = '<thead><tr>';
    		foreach ($fila1 as $key => $value)
    		{
    			$tabla.= '<th>'.$key.'</th>';
    		}
    		$tabla.= '</tr></thead>';

    		$query = $q_vnocaptura->result();
    		foreach ($query as $fila)
    		{
    			$tabla.= '<tr>';
    			foreach ($fila1 as $key => $value)
	    		{
	    			$tabla.= '<td>'.$fila->{$key}.'</td>';
	    		}
    			$tabla.= '</tr>';
    		}

    		$datos['vnocaptura'] = '<table id="t_vnocaptura" class="table table-responsive">'.$tabla.'</table>';
    	}
    	else
    	{
    		$datos['vnocaptura'] = '';
    	}

    	//	Tabla vultcapt
    	if($q_vultcapt->num_rows() > 0)
    	{
    		$fila1 = $q_vultcapt->row();
    		$tabla = '<thead><tr>';
    		foreach ($fila1 as $key => $value)
    		{
    			$tabla.= '<th>'.$key.'</th>';
    		}
    		$tabla.= '</tr></thead>';

    		$query = $q_vultcapt->result();
    		foreach ($query as $fila)
    		{
    			$tabla.= '<tr>';
    			foreach ($fila1 as $key => $value)
	    		{
	    			$tabla.= '<td>'.$fila->{$key}.'</td>';
	    		}
    			$tabla.= '</tr>';
    		}

    		$datos['vultcapt'] = '<table id="t_vultcapt" class="table table-responsive">'.$tabla.'</table>';
    	}
    	else
    	{
    		$datos['vultcapt'] = '';
    	}

    	
    	$this->load->view('reporte/vistas',$datos);
    }

    public function ventact()
    {
        $i = 2;
        $entregables = $this->mv->ventact();
        
        $reporte = new PHPExcel();        
        $reporte->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

        $reporte->setActiveSheetIndex('0');
        
        $reporte->getActiveSheet()->SetCellValue('A1', 'Entregable ID');
        $reporte->getActiveSheet()->SetCellValue('B1', 'Entregable');
        $reporte->getActiveSheet()->SetCellValue('C1', 'Municipalización');
        $reporte->getActiveSheet()->SetCellValue('D1', 'Mismo beneficiario');
        $reporte->getActiveSheet()->SetCellValue('E1', 'Año');
        $reporte->getActiveSheet()->SetCellValue('F1', 'Actividad ID');
        $reporte->getActiveSheet()->SetCellValue('G1', 'Actividad');
        $reporte->getActiveSheet()->SetCellValue('H1', 'Descripción');
        $reporte->getActiveSheet()->SetCellValue('I1', 'Objeivo actividad');
        $reporte->getActiveSheet()->SetCellValue('J1', 'Eje');
        $reporte->getActiveSheet()->SetCellValue('K1', 'Política Pública');
        $reporte->getActiveSheet()->SetCellValue('L1', 'Dependencia');


        if($entregables!=false)
        {
            foreach ($entregables as $vent) {
                $mun = ($vent->iMunicipalizacion == 1) ? "SI" : "NO" ;
                $ben = ($vent->iMismosBeneficiarios == 1) ? "SI" : "NO" ;

                $reporte->getActiveSheet()->SetCellValue('A'.$i, $vent->iIdEntregable);
                $reporte->getActiveSheet()->SetCellValue('B'.$i, $vent->vEntregable);
                $reporte->getActiveSheet()->SetCellValue('C'.$i, $mun);
                $reporte->getActiveSheet()->SetCellValue('D'.$i, $ben);
                $reporte->getActiveSheet()->SetCellValue('E'.$i, $vent->iAnio);
                $reporte->getActiveSheet()->SetCellValue('F'.$i, $vent->iIdActividad);
                $reporte->getActiveSheet()->SetCellValue('G'.$i, $vent->vActividad);
                $reporte->getActiveSheet()->SetCellValue('H'.$i, $vent->vDescripcion);
                $reporte->getActiveSheet()->SetCellValue('I'.$i, $vent->vObjetivo);
                $reporte->getActiveSheet()->SetCellValue('J'.$i, $vent->vEje);
                $reporte->getActiveSheet()->SetCellValue('K'.$i, $vent->vTema);
                $reporte->getActiveSheet()->SetCellValue('L'.$i, $vent->vDependencia); 
                $i++;
            }
        }

        $ruta = 'public/reportes/Entregables_act.xls';
        $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
        $imprimir->save($ruta);
        echo '<a download class="btn btn-success" href="'.base_url().$ruta.'">Descargar reporte</a>';

    }
}
?>