<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/Spout/Autoloader/autoload.php";
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Entity\Row;


class C_rmir extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->model('M_reporteMir');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
    }

    public function index()
    {
        $seg = new Class_seguridad();
        $opt = new Class_options();
        $data['all_sec'] = $all_sec = $seg->tipo_acceso(9,$_SESSION[PREFIJO.'_idusuario']);
        $data['all_dep'] = $all_dep = $seg->tipo_acceso(10,$_SESSION[PREFIJO.'_idusuario']);

        $dep = $sec = 0;

        if($all_sec > 0) $data['ejes'] = $opt->options_tabla('eje',"");
        else
        { 
            $sec = $_SESSION[PREFIJO.'_ideje'];
            $where['iIdEje'] = $_SESSION[PREFIJO.'_ideje'];
        }

        if($all_dep > 0)
        { 
            $data['dependencias'] = (isset($where['iIdEje'])) ? $opt->options_tabla('dependencia',"",$where):$opt->options_tabla('dependencia',"",'iActivo = 3');
        }
        else
        {
            $dep = $_SESSION[PREFIJO.'_iddependencia'];
        }
        $this->load->view('reporte/mir', $data);
    }

    public function dependencias(){
        if($_REQUEST['id']){
            $id = $this->input->post('id',true);
            $respuesta = $this->M_reporteMir->dependencias($id);
            echo '<option value="0">Seleccione..</option>';
            if($respuesta!=false)
            {
                foreach ($respuesta as $vdep) {
                    echo '<option value="'.$vdep->iIdDependencia.'">'.$vdep->vDependencia.'</option>';
                }
            }
        }
    }

    public function generarrepo()
    {
        ini_set('max_execution_time', 600); // 5 Minutos máximo
        $anio = $this->input->post('anio',true);
        $eje = $this->input->post('selEje',true);
        $dep = $this->input->post('selDep',true);
        $resp = array('resp' => false, 'error_message' => '', 'url' => '');
        $tabla = array();

	

        if(isset($_POST['fuentes'])) $tabla['fuentes'] = 1;
        if(isset($_POST['ubp'])) $tabla['ubp'] = 1;
        if(isset($_POST['ped'])) $tabla['ped'] = 1;
        if(isset($_POST['entregables'])) $tabla['entregables'] = 1;
        if(isset($_POST['compromisos'])) $tabla['compromisos'] = 1;
        if(isset($_POST['metasmun'])) $tabla['metasmun'] = 1;
        if(isset($_POST['avances'])) $tabla['avances'] = 1;
        $group = $this->input->post('agrupar',true);
        $whereString = '';
        if((int)$this->input->post('mes')  > 0){
            $whereString = $whereString.'AND EXTRACT(MONTH from dat."dInicio")='. (int)$this->input->post('mes',true);
        }
        

        $mrep = new M_reporteMir();
        
        $query = $mrep->reporte_pat($anio,$eje,$dep,$tabla,$whereString);

        if($query->num_rows() > 0)
        {

            $records = $query->result(); 
            $ruta = 'public/reportes/mirBD.xlsx';
            $writer = WriterEntityFactory::createXLSXWriter();
            $writer->openToFile($ruta);            
			$zebraWhiteStyle = (new StyleBuilder())
            ->setBackgroundColor(Color::WHITE)
            ->setFontColor(Color::BLACK)
            ->setFontItalic()
            ->build();
            $cells = [
                    WriterEntityFactory::createCell('Eje',$zebraWhiteStyle),
                    WriterEntityFactory::createCell('Dependencia'),
                    WriterEntityFactory::createCell('Año'),
                    WriterEntityFactory::createCell('Nivel'),
                    WriterEntityFactory::createCell('Clave'),
                    WriterEntityFactory::createCell('Programa presupuestario'),
                    WriterEntityFactory::createCell('Objetivo del gobierno'),
                    WriterEntityFactory::createCell('Estrategia'),
                    WriterEntityFactory::createCell('Resumen'),
                    WriterEntityFactory::createCell('Supuestos'),
                    WriterEntityFactory::createCell('Area Responsable'),
                    WriterEntityFactory::createCell('Indicadores'), 
                    WriterEntityFactory::createCell('Medio verifica'), 

                   
                ];
            if(isset($tabla['fuentes']))
            {
                $cells[] = WriterEntityFactory::createCell('Fuente de financiamiento');
                $cells[] = WriterEntityFactory::createCell('Monto de financimiento');
            }

/*
            if(isset($tabla['ubp']))
            {
                $cells[] = WriterEntityFactory::createCell('Clave PP');
                $cells[] = WriterEntityFactory::createCell('Nombre PP');
                $cells[] = WriterEntityFactory::createCell('Clave UBP');
                $cells[] = WriterEntityFactory::createCell('Nombre UBP');
            }*/

            if(isset($tabla['ped']))
            {
                $cells[] = WriterEntityFactory::createCell('Eje');
                $cells[] = WriterEntityFactory::createCell('Tema');
                $cells[] = WriterEntityFactory::createCell('Objetivo');
                $cells[] = WriterEntityFactory::createCell('Estrategia');
                $cells[] = WriterEntityFactory::createCell('Línea de acción');
            }

            if(isset($tabla['entregables']))
            {
                $cells[] = WriterEntityFactory::createCell('ID Entregable');
                $cells[] = WriterEntityFactory::createCell('ID Detalle Entregable');
                $cells[] = WriterEntityFactory::createCell('Entregable');
                $cells[] = WriterEntityFactory::createCell('Ponderación');
                $cells[] = WriterEntityFactory::createCell('Meta');
                $cells[] = WriterEntityFactory::createCell('Meta modificada');
                $cells[] = WriterEntityFactory::createCell('Unidad de medida');
                $cells[] = WriterEntityFactory::createCell('Suspendido');
                $cells[] = WriterEntityFactory::createCell('Sujeto afectado');
                $cells[] = WriterEntityFactory::createCell('Periodicidad');
                $cells[] = WriterEntityFactory::createCell('Municipalizable');
                $cells[] = WriterEntityFactory::createCell('Entrega a los mismos beneficiarios');
            }

            if(isset($tabla['compromisos']))
            {
                $cells[] = WriterEntityFactory::createCell('# Compromiso');
                $cells[] = WriterEntityFactory::createCell('Compromiso');
                $cells[] = WriterEntityFactory::createCell('Componente');
            }

            if(isset($tabla['metasmun']))
            {
                $cells[] = WriterEntityFactory::createCell('Municipio');
                $cells[] = WriterEntityFactory::createCell('Meta municipio');
                $cells[] = WriterEntityFactory::createCell('Meta modificada municipio');
            }

            if(isset($tabla['avances']))
            {
                $cells[] = WriterEntityFactory::createCell('Municipio del avance');
                $cells[] = WriterEntityFactory::createCell('Fecha');
                $cells[] = WriterEntityFactory::createCell('Aprobado');
                $cells[] = WriterEntityFactory::createCell('Avance');
                $cells[] = WriterEntityFactory::createCell('Ejercido');
                $cells[] = WriterEntityFactory::createCell('Beneficiarios H');
                $cells[] = WriterEntityFactory::createCell('Beneficiarios M');
                $cells[] = WriterEntityFactory::createCell('Discapacitados H');
                $cells[] = WriterEntityFactory::createCell('Discapacitados M');
                $cells[] = WriterEntityFactory::createCell('Mayahablentes H');
                $cells[] = WriterEntityFactory::createCell('Mayahablantes M');
            }
		
	
            // Agregamos la fila de encabezados
            $rowStyle = (new StyleBuilder())
                            ->setFontBold()
                            ->build();
            $singleRow = WriterEntityFactory::createRow($cells,$rowStyle); 
            $writer->addRow($singleRow);

            foreach ($records as $rec)
            {
                $cells = [
                   
                    WriterEntityFactory::createCell($rec->ejedependencia),
                    WriterEntityFactory::createCell($rec->vDependencia),
                    WriterEntityFactory::createCell((int)$rec->iAnio),
                    WriterEntityFactory::createCell($rec->vNivelMIR),
                    WriterEntityFactory::createCell((int)$rec->iIdActividad),
                    WriterEntityFactory::createCell($rec->vActividad),
                    // WriterEntityFactory::createCell($rec->vDescripcion),
                    WriterEntityFactory::createCell($rec->objetivoact),
                    WriterEntityFactory::createCell($rec->estrategiaact),
                    WriterEntityFactory::createCell($rec->vResumenNarrativo),
                    WriterEntityFactory::createCell($rec->vSupuesto),
                    WriterEntityFactory::createCell($rec->vAreaResponsable),
                    WriterEntityFactory::createCell($rec->vEntregable),
                    WriterEntityFactory::createCell($rec->vMedioVerifica),
                    
                ];

                if(isset($tabla['fuentes']))
                {
                    $cells[] = WriterEntityFactory::createCell($rec->vFinanciamiento);
                    $cells[] = WriterEntityFactory::createCell((float)$rec->monto);
                }

/*
                if(isset($tabla['ubp']))
                {
                    $cells[] = WriterEntityFactory::createCell($rec->clavepp);
                    $cells[] = WriterEntityFactory::createCell($rec->vProgramaPresupuestario);
                    $cells[] = WriterEntityFactory::createCell($rec->claveubp);
                    $cells[] = WriterEntityFactory::createCell($rec->vUBP);
                }
                */

                if(isset($tabla['ped']))
                {
                    $cells[] = WriterEntityFactory::createCell($rec->vEje);
                    $cells[] = WriterEntityFactory::createCell($rec->vTema);
                    $cells[] = WriterEntityFactory::createCell($rec->vObjetivo);
                    $cells[] = WriterEntityFactory::createCell($rec->vEstrategia);
                    $cells[] = WriterEntityFactory::createCell($rec->vLineaAccion);
                }

                if(isset($tabla['entregables']))
                {
                    $rec->iSuspension = ($rec->iSuspension == 1) ? 'Sí':'No';
                    $rec->iMunicipalizacion = ($rec->iMunicipalizacion == 1) ? 'Sí':'No';
                    $rec->iMismosBeneficiarios = ($rec->iMismosBeneficiarios == 1) ? 'Sí':'No';
                    $cells[] = WriterEntityFactory::createCell((int)$rec->iIdEntregable);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->iIdDetalleEntregable);
                    $cells[] = WriterEntityFactory::createCell($rec->vEntregable);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->iPonderacion);
                    $cells[] = WriterEntityFactory::createCell((float)$rec->nMeta);
                    $cells[] = WriterEntityFactory::createCell((float)$rec->nMetaModificada);
                    $cells[] = WriterEntityFactory::createCell($rec->vUnidadMedida);
                    $cells[] = WriterEntityFactory::createCell($rec->iSuspension);
                    $cells[] = WriterEntityFactory::createCell($rec->vSujetoAfectado);
                    $cells[] = WriterEntityFactory::createCell($rec->vPeriodicidad);
                    $cells[] = WriterEntityFactory::createCell($rec->iMunicipalizacion);
                    $cells[] = WriterEntityFactory::createCell($rec->iMismosBeneficiarios);
                }

                if(isset($tabla['compromisos']))
                {
                    $cells[] = WriterEntityFactory::createCell($rec->iNumero);
                    $cells[] = WriterEntityFactory::createCell($rec->vCompromiso);
                    $cells[] = WriterEntityFactory::createCell($rec->vComponente);
                }

                if(isset($tabla['metasmun']))
                {
                    $cells[] = WriterEntityFactory::createCell($rec->municipiometa);
                    $cells[] = WriterEntityFactory::createCell((float)$rec->metamunicipio);
                    $cells[] = WriterEntityFactory::createCell((float)$rec->metamodificadamunicipio);
                }

                if(isset($tabla['avances']))
                {
                    $rec->aprobado = ($rec->aprobado == 1) ? 'Sí':'No';
                    $cells[] = WriterEntityFactory::createCell($rec->municipioavance);
                    $cells[] = WriterEntityFactory::createCell($rec->fecha);
                    $cells[] = WriterEntityFactory::createCell($rec->aprobado);
                    $cells[] = WriterEntityFactory::createCell((float)$rec->avance);
                    $cells[] = WriterEntityFactory::createCell((float)$rec->ejercido);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->benh);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->benm);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->disch);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->discm);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->lengh);
                    $cells[] = WriterEntityFactory::createCell((int)$rec->lengm);
                }

                $singleRow = WriterEntityFactory::createRow($cells);
                $writer->addRow($singleRow);
            }

            $writer->close();
           
            $resp['resp'] = true;
            $resp['url'] = base_url().$ruta;    
        } else {
            $resp['error_message'] = 'Sin registros';
        }
        echo json_encode($resp);
    }

    public function generarrepo_()
    {
        $anio = $this->input->get('anio',true);
        $eje = $this->input->get('eje',true);
        $dep = $this->input->get('dep',true);

        $respuesta=$this->M_reporteAct->generar2($anio);
        if($respuesta == 'no hay datos'){
            echo  0;
        }else{
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/actividades.xls');
            $reporte->setActiveSheetIndex('0');
            
            $valores = array();
            $valores2 = array();
            $suma1 = '';
            $suma2 = '';

            $i = 2;
            foreach($respuesta as $rep){

                $suma1 = $this->M_reporteAct->recolectarsuma1($rep['iIdActividad']);
                $suma2 = $this->M_reporteAct->recolectarsuma2($rep['iIdAvance']);
                array_push($valores, $suma1);
                array_push($valores2, $suma2);

                $reporte->getActiveSheet()->SetCellValue('A'.$i,$rep['iIdActividad']);
                
                if($rep['iActivo'] == 1){
                    $reporte->getActiveSheet()->SetCellValue('B'.$i, 'Activo');
                }else{
                    $reporte->getActiveSheet()->SetCellValue('B'.$i, 'Inactivo');
                }
                $reporte->getActiveSheet()->SetCellValue('C'.$i,$rep['vActividad']);
                $reporte->getActiveSheet()->SetCellValue('D'.$i,$rep['objetivoactividad']);
                $reporte->getActiveSheet()->SetCellValue('E'.$i,$rep['vPoblacionObjetivo']);
                $reporte->getActiveSheet()->SetCellValue('F'.$i,$rep['vDescripcion']);
                $reporte->getActiveSheet()->SetCellValue('H'.$i,$rep['dInicio']);
                $reporte->getActiveSheet()->SetCellValue('I'.$i,$rep['dFin']);
                $reporte->getActiveSheet()->SetCellValue('J'.$i,$rep['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('K'.$i,$rep['claveff']);
                $reporte->getActiveSheet()->SetCellValue('L'.$i,$rep['vFinanciamiento']);
                $reporte->getActiveSheet()->SetCellValue('M'.$i,$rep['monto']);
                $reporte->getActiveSheet()->SetCellValue('N'.$i,$rep['vLineaAccion']);
                $reporte->getActiveSheet()->SetCellValue('O'.$i,$rep['vEstrategia']);
                $reporte->getActiveSheet()->SetCellValue('P'.$i,$rep['valorobjetivo']);
                $reporte->getActiveSheet()->SetCellValue('Q'.$i,$rep['vTema']);
                $reporte->getActiveSheet()->SetCellValue('R'.$i,$rep['vEje']);
                $reporte->getActiveSheet()->SetCellValue('S'.$i,$rep['claveubp']);
                $reporte->getActiveSheet()->SetCellValue('T'.$i,$rep['vUBP']);
                $reporte->getActiveSheet()->SetCellValue('U'.$i,$rep['iIdEntregable']);
                $reporte->getActiveSheet()->SetCellValue('V'.$i,$rep['vEntregable']);
                $reporte->getActiveSheet()->SetCellValue('W'.$i,$rep['nMeta']);
                $reporte->getActiveSheet()->SetCellValue('X'.$i,$rep['vUnidadMedida']);
                $reporte->getActiveSheet()->SetCellValue('Y'.$i,$rep['vSujetoAfectado']);
                $reporte->getActiveSheet()->SetCellValue('Z'.$i,$rep['vPeriodicidad']);
                
                if($rep['iMunicipalizacion'] == 1){
                    $reporte->getActiveSheet()->SetCellValue('AA'.$i, "Si");
                }else{
                    $reporte->getActiveSheet()->SetCellValue('AA'.$i, "No");
                }
                $reporte->getActiveSheet()->SetCellValue('AB'.$i,$rep['nAvance']);
                $reporte->getActiveSheet()->SetCellValue('AC'.$i,$rep['nEjercido']);
                
                $i++;

            }

            $j=$i-2;
            $l = 2;
            for($k = 0; $k<$j; $k++){
                $reporte->getActiveSheet()->SetCellValue('G'.$l,$valores[$k]);
                $reporte->getActiveSheet()->SetCellValue('AD'.$l,$valores2[$k]);
                $l++;
            }

            $ruta = 'public/reportes/actividadesBD.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
        }                  
   }

   public function generarrepo2()
   {
        $anio = $this->input->get('anio',true);
        $eje = $this->input->get('eje',true);
   
        $respuesta=$this->M_reporteAct->generar3($eje,$anio);
       if($respuesta == 'No hay datos'){
                echo  0;
        }else{
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/actividades.xls');
            $reporte->setActiveSheetIndex('0');
            
            $valores = array();
            $valores2 = array();
            $suma1 = '';
            $suma2 = '';

            $i = 2;
            foreach($respuesta as $rep){

                $suma1 = $this->M_reporteAct->recolectarsuma1($rep['iIdActividad']);
                $suma2 = $this->M_reporteAct->recolectarsuma2($rep['iIdAvance']);
                array_push($valores, $suma1);
                array_push($valores2, $suma2);

                $reporte->getActiveSheet()->SetCellValue('A'.$i,$rep['iIdActividad']);
                if($rep['iActivo'] == 1){
                    $reporte->getActiveSheet()->SetCellValue('B'.$i, 'Activo');
                }else{
                    $reporte->getActiveSheet()->SetCellValue('B'.$i, 'Inactivo');
                }
                
                $reporte->getActiveSheet()->SetCellValue('C'.$i,$rep['vActividad']);
                $reporte->getActiveSheet()->SetCellValue('D'.$i,$rep['objetivoactividad']);
                $reporte->getActiveSheet()->SetCellValue('E'.$i,$rep['vPoblacionObjetivo']);
                $reporte->getActiveSheet()->SetCellValue('F'.$i,$rep['vDescripcion']);
                $reporte->getActiveSheet()->SetCellValue('H'.$i,$rep['dInicio']);
                $reporte->getActiveSheet()->SetCellValue('I'.$i,$rep['dFin']);
                $reporte->getActiveSheet()->SetCellValue('J'.$i,$rep['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('K'.$i,$rep['claveff']);
                $reporte->getActiveSheet()->SetCellValue('L'.$i,$rep['vFinanciamiento']);
                $reporte->getActiveSheet()->SetCellValue('M'.$i,$rep['monto']);
                $reporte->getActiveSheet()->SetCellValue('N'.$i,$rep['vLineaAccion']);
                $reporte->getActiveSheet()->SetCellValue('O'.$i,$rep['vEstrategia']);
                $reporte->getActiveSheet()->SetCellValue('P'.$i,$rep['valorobjetivo']);
                $reporte->getActiveSheet()->SetCellValue('Q'.$i,$rep['vTema']);
                $reporte->getActiveSheet()->SetCellValue('R'.$i,$rep['vEje']);
                $reporte->getActiveSheet()->SetCellValue('S'.$i,$rep['claveubp']);
                $reporte->getActiveSheet()->SetCellValue('T'.$i,$rep['vUBP']);
                $reporte->getActiveSheet()->SetCellValue('U'.$i,$rep['iIdEntregable']);
                $reporte->getActiveSheet()->SetCellValue('V'.$i,$rep['vEntregable']);
                $reporte->getActiveSheet()->SetCellValue('W'.$i,$rep['nMeta']);
                $reporte->getActiveSheet()->SetCellValue('X'.$i,$rep['vUnidadMedida']);
                $reporte->getActiveSheet()->SetCellValue('Y'.$i,$rep['vSujetoAfectado']);
                $reporte->getActiveSheet()->SetCellValue('Z'.$i,$rep['vPeriodicidad']);
                if($rep['iMunicipalizacion'] == 1){
                    $reporte->getActiveSheet()->SetCellValue('AA'.$i, "Si");
                }else{
                    $reporte->getActiveSheet()->SetCellValue('AA'.$i, "No");
                }
                $reporte->getActiveSheet()->SetCellValue('AB'.$i,$rep['nAvance']);
                $reporte->getActiveSheet()->SetCellValue('AC'.$i,$rep['nEjercido']);
                
                $i++;

            }

            $j=$i-2;
            $l = 2;
            for($k = 0; $k<$j; $k++){
                $reporte->getActiveSheet()->SetCellValue('G'.$l,$valores[$k]);
                $reporte->getActiveSheet()->SetCellValue('AD'.$l,$valores2[$k]);
                $l++;
            }

            $ruta = 'public/reportes/actividadesBD.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
        }
                      
    }

    public function generarrepo3()
    {
        $anio = $this->input->post('anio',true);
        $eje= $this->input->post('eje',true);
        $dep= $this->input->post('dep',true);
  
        $respuesta=$this->M_reporteAct->generar($eje,$dep,$anio);
        print_r($respuesta);
        if($respuesta == 'no hay datos'){
            echo  0;
        }else{
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/actividades.xls');
            $reporte->setActiveSheetIndex('0');
            
            $valores = array();
            $valores2 = array();
            $suma1 = '';
            $suma2 = '';

            $i = 2;
            foreach($respuesta as $rep){

                $suma1 = $this->M_reporteAct->recolectarsuma1($rep['iIdActividad']);
                $suma2 = $this->M_reporteAct->recolectarsuma2($rep['iIdAvance']);
                array_push($valores, $suma1);
                array_push($valores2, $suma2);

                $reporte->getActiveSheet()->SetCellValue('A'.$i,$rep['iIdActividad']);
                if($rep['iActivo'] == 1){
                    $reporte->getActiveSheet()->SetCellValue('B'.$i, 'Activo');
                }else{
                    $reporte->getActiveSheet()->SetCellValue('B'.$i, 'Inactivo');
                }
                
                $reporte->getActiveSheet()->SetCellValue('C'.$i,$rep['vActividad']);
                $reporte->getActiveSheet()->SetCellValue('D'.$i,$rep['objetivoactividad']);
                $reporte->getActiveSheet()->SetCellValue('E'.$i,$rep['vPoblacionObjetivo']);
                $reporte->getActiveSheet()->SetCellValue('F'.$i,$rep['vDescripcion']);
                $reporte->getActiveSheet()->SetCellValue('H'.$i,$rep['dInicio']);
                $reporte->getActiveSheet()->SetCellValue('I'.$i,$rep['dFin']);
                $reporte->getActiveSheet()->SetCellValue('J'.$i,$rep['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('K'.$i,$rep['claveff']);
                $reporte->getActiveSheet()->SetCellValue('L'.$i,$rep['vFinanciamiento']);
                $reporte->getActiveSheet()->SetCellValue('M'.$i,$rep['monto']);
                $reporte->getActiveSheet()->SetCellValue('N'.$i,$rep['vLineaAccion']);
                $reporte->getActiveSheet()->SetCellValue('O'.$i,$rep['vEstrategia']);
                $reporte->getActiveSheet()->SetCellValue('P'.$i,$rep['valorobjetivo']);
                $reporte->getActiveSheet()->SetCellValue('Q'.$i,$rep['vTema']);
                $reporte->getActiveSheet()->SetCellValue('R'.$i,$rep['vEje']);
                $reporte->getActiveSheet()->SetCellValue('S'.$i,$rep['claveubp']);
                $reporte->getActiveSheet()->SetCellValue('T'.$i,$rep['vUBP']);
                $reporte->getActiveSheet()->SetCellValue('U'.$i,$rep['iIdEntregable']);
                $reporte->getActiveSheet()->SetCellValue('V'.$i,$rep['vEntregable']);
                $reporte->getActiveSheet()->SetCellValue('W'.$i,$rep['nMeta']);
                $reporte->getActiveSheet()->SetCellValue('X'.$i,$rep['vUnidadMedida']);
                $reporte->getActiveSheet()->SetCellValue('Y'.$i,$rep['vSujetoAfectado']);
                $reporte->getActiveSheet()->SetCellValue('Z'.$i,$rep['vPeriodicidad']);
                if($rep['iMunicipalizacion'] == 1){
                    $reporte->getActiveSheet()->SetCellValue('AA'.$i, "Si");
                }else{
                    $reporte->getActiveSheet()->SetCellValue('AA'.$i, "No");
                }
                $reporte->getActiveSheet()->SetCellValue('AB'.$i,$rep['nAvance']);
                $reporte->getActiveSheet()->SetCellValue('AC'.$i,$rep['nEjercido']);
                
                $i++;

            }

            $j=$i-2;
            $l = 2;
            for($k = 0; $k<$j; $k++){
                $reporte->getActiveSheet()->SetCellValue('G'.$l,$valores[$k]);
                $reporte->getActiveSheet()->SetCellValue('AD'.$l,$valores2[$k]);
                $l++;
            }

            $ruta = 'public/reportes/actividadesBD.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
        }
    }
    


    public function eliminar(){
        if($_REQUEST['id']){
            unlink('public/reportes/actividadesBD.xls');
                echo 'si';
            
        }

    }


    public function listar_actividades()
    {
        if(isset($_POST['anio']) && isset($_POST['selEje']) && isset($_POST['selDep']))
        {
            $anio = $this->input->post('anio');
            $eje = $this->input->post('selEje');
            $dep = $this->input->post('selDep');

            $mod = new M_reporteAct();
            
            $where['da.iAnio'] = $anio;
            if($eje > 0) $where['dej.iIdEje'] = $eje;
            if($dep > 0) $where['ac.iIdDependencia'] = $dep;
            $query = $mod->listado_actividades($where);
            //echo $_SESSION['sql'];
            //var_dump($query);
            echo json_encode($query);
        }
    }

    public function comprimir_directorio()
    {
        if(isset($_POST['dir']) && !empty($_POST['dir']))
        {
            $dir = $this->input->post('dir');
            $archive_name = __DIR__.'/../../public/reportes/'.$dir.'.zip'; // name of zip file
            $archive_folder =  __DIR__.'/../../public/reportes/'.$dir.'/'; // the folder which you archivate
            $resp['status'] = false;
            $zip = new ZipArchive;
            if ($zip->open($archive_name, ZipArchive::CREATE) === TRUE)
            {
                //$dir = preg_replace('/[\/]{2,}/', '/', $archive_folder."/");
               
                $this->addFolderToZip($archive_folder, $zip);
               
                $zip->close();
                
                if(file_exists($archive_name))
                {
                    $resp['status'] = true;
                    $rest['zip'] = $dir;
                   // $this->eliminarDirectorio($archive_folder);
                }
                
            }
            else
            {
                $resp['error'] =  'EL archivo zip no pudo ser generado';
            }

            echo json_encode($resp);
        }
    }

    public function addFolderToZip($dir, $zipArchive, $zipdir = '')
    {
        if(is_dir($dir)) 
        {
            if ($dh = opendir($dir)) 
            {

                //Add the directory
                if(!empty($zipdir)) $zipArchive->addEmptyDir($zipdir);
              
                // Loop through all the files
                while (($file = readdir($dh)) !== false) 
                {
              
                    //If it's a folder, run the function again!
                    if(!is_file($dir . $file))
                    {
                        // Skip parent and root directories
                        if( ($file !== ".") && ($file !== ".."))
                        {
                            $this->addFolderToZip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                        }
                      
                    }
                    else
                    {
                        // Add the files
                        $zipArchive->addFile($dir . $file, $zipdir . $file);
                    }
                }
            }
        }
    }

    public function eliminarDirectorio($dir)
    {
        if (is_dir($dir))
        {
            //var_dump($this->is_dir_empty($dir));
            if ($dh = opendir($dir)) 
            {                
                // Loop through all the files
                while (($file = readdir($dh)) !== false) {
              
                    //If it's a folder, run the function again!
                    if(!is_file($dir.$file))
                    {
                        if( ($file !== ".") && ($file !== ".."))
                        {
                            $this->eliminarDirectorio($dir . $file . "/");
                        }
                    }
                    else
                    {
                        // Eliminamos el archivo                        
                        unlink($dir.$file);
                    }
                }
            }

            /*if($this->is_dir_empty($dir)) rmdir(substr($dir, 0, -1));
            else $this->eliminarDirectorio($dir);*/
        }
    }

    function is_dir_empty($dir) {
      if (!is_readable($dir)) return NULL; 
      return (count(scandir($dir)) == 2);
    }

    function principal_bd()
    {
        $data[] = '';
        $this->load->view('reportes/principal_bd',$data);
    }

    function catalogos()
    {
        $this->load->view('reporte/catalogos');
    }

    function descargar_catalogo(){
        if(isset($_POST['tipo']) && !empty($_POST['tipo']))
        {
            $tipo = $this->input->post('tipo',true);
            $query = $this->M_reporteAct->catalogos($tipo);

            if($query->num_rows() > 0)
            {
                $result = $query->result();

                $reporte = new PHPExcel();
                $reporte->setActiveSheetIndex(0);
                $reporte->getActiveSheet()->setTitle('BD');                 
                $row = 1;
                $col = -1;
                if($tipo == 1)
                {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdFinanciamiento');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vClave');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vFinanciamiento');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iAnio');

                }

                if($tipo == 2)
                {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdEje');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vEje');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vColorDesca');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdTema');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vTema');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdObjetivo');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vObjetivo');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdEstrategia');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vEstrategia');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdLineaAccion');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vLineaAccion');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdOds');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vOds');
                }

                if($tipo == 3)
                {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdProgramaPresupuestario');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iNumero');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vProgramaPresupuestario');
                }

                if($tipo == 4)
                {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdSujetoAfectado');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vSujetoAfectado');
                }

                if($tipo == 5)
                {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdUbp');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vUBP');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iAnio');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdTipoUbp');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vTipoUbp');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdProgramaPresupuestario');
                }

                if($tipo == 6)
                {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'iIdUnidadMedida');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, 'vUnidadMedida');
                }

                $row++;

                foreach ($result as $record)
                {
                    $col = -1;
                    if($tipo == 1)
                    {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdFinanciamiento);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vClave);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vFinanciamiento);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iAnio);
                    }

                    if($tipo == 2)
                    {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdEje);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vEje);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vColorDesca);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdTema);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vTema);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdObjetivo);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vObjetivo);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdEstrategia);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vEstrategia);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdLineaAccion);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vLineaAccion);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdOds);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vOds);
                    }


                    if($tipo == 3)
                    {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdProgramaPresupuestario);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iNumero);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vProgramaPresupuestario);
                    }


                    if($tipo == 4)
                    {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdSujetoAfectado);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vSujetoAfectado);
                    }


                    if($tipo == 5)
                    {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdUbp);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vUBP);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iAnio);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdTipoUbp);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vTipoUbp);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdProgramaPresupuestario);
                    }

                     if($tipo == 6)
                    {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->iIdUnidadMedida);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col=$col+1, $row, $record->vUnidadMedida);
                    }

                    $row++;
                }

                $ruta = 'public/reportes/catalogos.xlsx';
                $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
                $imprimir->save($ruta);

            }
        }
    }
}
