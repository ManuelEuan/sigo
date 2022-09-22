<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . "/third_party/Spout/Autoloader/autoload.php";

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Entity\Style\CellAlignment;

require_once APPPATH . "/libraries/dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

class C_reporteCombinado extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->model('M_reporteCombinado');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
    }

    public function index()
    {
        $seg = new Class_seguridad();
        $opt = new Class_options();
        $data['all_sec'] = $all_sec = $seg->tipo_acceso(9, $_SESSION[PREFIJO . '_idusuario']);
        $data['all_dep'] = $all_dep = $seg->tipo_acceso(10, $_SESSION[PREFIJO . '_idusuario']);

        $dep = $sec = 0;

        if ($all_sec > 0) $data['ejes'] = $opt->options_tabla('eje', "");
        else {
            $sec = $_SESSION[PREFIJO . '_ideje'];
            $where['iIdEje'] = $_SESSION[PREFIJO . '_ideje'];
        }

        if ($all_dep > 0) {
            $data['dependencias'] = (isset($where['iIdEje'])) ? $opt->options_tabla('dependencia', "", $where) : $opt->options_tabla('dependencia', "", 'iActivo = 3');
        } else {
            $dep = $_SESSION[PREFIJO . '_iddependencia'];
        }
        $data['PP'] = $this->M_reporteCombinado->obtenerPP();
        $this->load->view('reporte/reporteCombinado', $data);
    }

    public function dependencias()
    {
        if ($_REQUEST['id']) {
            $id = $this->input->post('id', true);
            $respuesta = $this->M_reportePOA->dependencias($id);
            echo '<option value="0">Seleccione..</option>';
            if ($respuesta != false) {
                foreach ($respuesta as $vdep) {
                    echo '<option value="' . $vdep->iIdDependencia . '">' . $vdep->vDependencia . '</option>';
                }
            }
        }
    }

    public function generarrepo()
    {
        ini_set('max_execution_time', 600); // 5 Minutos máximo
        $anio = $this->input->post('anio', true);
        $eje = $this->input->post('selEje', true);
        $mes = $this->input->post('mes', true);
        $dep = $this->input->post('selDep', true) ?: 0;
        $resp = array('resp' => false, 'error_message' => '', 'url' => '');
        $tabla = array();
        $pp = $this->input->post('selPP', true);

        if (isset($_POST['fuentes'])) $tabla['fuentes'] = 1;
        if (isset($_POST['ubp'])) $tabla['ubp'] = 1;
        if (isset($_POST['ped'])) $tabla['ped'] = 1;
        if (isset($_POST['entregables'])) $tabla['entregables'] = 1;
        if (isset($_POST['compromisos'])) $tabla['compromisos'] = 1;
        if (isset($_POST['metasmun'])) $tabla['metasmun'] = 1;
        if (isset($_POST['avances'])) $tabla['avances'] = 1;
        $group = $this->input->post('agrupar', true);
        $whereString = '';
        if ((int)$this->input->post('mes')  > 0) {
            $whereString = $whereString . 'AND EXTRACT(MONTH from "DetalleActividad"."dInicio")=' . (int)$this->input->post('mes', true);
        }


        $mrep = new M_reporteCombinado();
        if ($pp == 0) {
            $ppFinal = '';
        } else {
            $ppFinal = $pp;
        }


        $query = $mrep->reporte_pat($anio, $dep, $eje, $whereString, $mes, $ppFinal);
        $proPre = $mrep->obtenerPPporId($pp);

        $fechaactual = date('m-d-Y h:i:s a');
        $obtenerDep = $mrep->obtenerDep($dep);

        if ($query->num_rows() > 0) {

            $records = $query->result();
            $ruta = 'public/reportes/reporteCombinado.xlsx';
            $writer = WriterEntityFactory::createXLSXWriter();
            $writer->openToFile($ruta);



            $obtenerEje = $mrep->obtenerObj($eje);

            $rowStyle = (new StyleBuilder())
                ->setBackgroundColor(Color::BLUE)
                ->setFontColor(Color::WHITE)
                ->setFontItalic()
                ->build();

            $tituloexcel = (new StyleBuilder())
                ->setBackgroundColor(Color::WHITE)
                ->setFontColor(Color::BLACK)
                ->setFontSize(20)
                ->build();

            $azulStyle = (new StyleBuilder())
                ->setBackgroundColor(Color::BLUE)
                ->setFontColor(Color::WHITE)
                ->setFontItalic()
                ->build();
            $amaStyle = (new StyleBuilder())
                ->setBackgroundColor('FFD9A8')
                ->setFontColor(Color::BLACK)
                ->setFontItalic()
                ->setFontBold()
                ->setCellAlignment(CellAlignment::CENTER)
                ->build();
            $simpleStyle = (new StyleBuilder())
                ->setFontColor(Color::BLACK)
                ->setCellAlignment(CellAlignment::CENTER)
                ->build();
            $cells = [
                WriterEntityFactory::createCell('Organismo', $azulStyle),
                WriterEntityFactory::createCell($obtenerDep->vDependencia),
            ];
            $singleRow = WriterEntityFactory::createRow($cells, $titulo);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Programa Presupuestario', $azulStyle),
                WriterEntityFactory::createCell($proPre->vProgramaPresupuestario),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $rowStyle = (new StyleBuilder())
                ->setBackgroundColor(Color::BLUE)
                ->setFontColor(Color::WHITE)
                ->setFontItalic()
                ->build();

            $cells = [
                WriterEntityFactory::createCell('Clasificación Programatica (Grupo de Gasto)', $azulStyle),
                WriterEntityFactory::createCell($proPre->vGrupoGasto),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Clasificación Programatica (Grupo de Programa)', $azulStyle),
                WriterEntityFactory::createCell($proPre->vGrupoPrograma),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Clasificación Programatica (Modalidad)', $azulStyle),
                WriterEntityFactory::createCell($proPre->vModalidad),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Gasto de Orden', $azulStyle),
                WriterEntityFactory::createCell($proPre->vGastoOrden),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Eje', $azulStyle),
                WriterEntityFactory::createCell($obtenerEje->vEje),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Objetivo de Gobierno', $azulStyle),
                WriterEntityFactory::createCell($obtenerEje->vObjetivoGobierno),

            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);


            $cells = [
                WriterEntityFactory::createCell(' ', $azulStyle),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Estrategia', $azulStyle),

            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell(' ', $azulStyle),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell('Fecha', $azulStyle),
                WriterEntityFactory::createCell($fechaactual),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell('Reporte Combinado', $tituloexcel),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell(''),
            ];
            $singleRow = WriterEntityFactory::createRow($cells, $rowStyle);
            $writer->addRow($singleRow);

            $cells = [
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell('Elementos', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell('Avance', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
                WriterEntityFactory::createCell(' ', $azulStyle),
            ];
            $singleRow = WriterEntityFactory::createRow($cells, $rowStyle);
            $writer->addRow($singleRow);


            $cells = [
                WriterEntityFactory::createCell('Nivel'),
                WriterEntityFactory::createCell('Resumen Presupuestario'),
                WriterEntityFactory::createCell('Tipo'),
                WriterEntityFactory::createCell('Dimension'),
                WriterEntityFactory::createCell('Accion'),
                WriterEntityFactory::createCell('Clave'),
                WriterEntityFactory::createCell('Indicador'),
                WriterEntityFactory::createCell('Meta'),
                WriterEntityFactory::createCell('Frecuencia'),
                WriterEntityFactory::createCell('Operacion'),
                WriterEntityFactory::createCell('Variable'),
                WriterEntityFactory::createCell('Unidad de medida (Variable)'),
                WriterEntityFactory::createCell('Formula'),
                WriterEntityFactory::createCell('Medio Verificacion'),
                WriterEntityFactory::createCell('ENE'),
                WriterEntityFactory::createCell('FEB'),
                WriterEntityFactory::createCell('MAR'),
                WriterEntityFactory::createCell('ABR'),
                WriterEntityFactory::createCell('MAY'),
                WriterEntityFactory::createCell('JUN'),
                WriterEntityFactory::createCell('JUL'),
                WriterEntityFactory::createCell('AGO'),
                WriterEntityFactory::createCell('SEP'),
                WriterEntityFactory::createCell('OCT'),
                WriterEntityFactory::createCell('NOV'),
                WriterEntityFactory::createCell('DIC'),
                WriterEntityFactory::createCell('Total acumulado'),
            ];


            // Agregamos la fila de encabezados
            $rowStyle = (new StyleBuilder())
                ->setBackgroundColor(Color::BLUE)
                ->setFontColor(Color::WHITE)
                ->setFontItalic()
                ->build();
            $singleRow = WriterEntityFactory::createRow($cells, $rowStyle);
            $writer->addRow($singleRow);

            $arrayaglomerados = array();
            foreach ($records as $rec){
                $resultado = $mrep->obtenerIdHija($rec->idact);
            
                foreach ($resultado as $key => $value) {
                    array_push($arrayaglomerados, (int)$value->iIdActividadHija);
                }
            }
                    foreach ($records as $rec) {
                        if(!in_array((int)$rec->iIdActividad, $arrayaglomerados)){
                        $totalEne = 0;
                        $totalFeb = 0;
                        $totalMar = 0;
                        $totalAbr = 0;
                        $totalMay = 0;
                        $totalJun = 0;
                        $totalJul = 0;
                        $totalAgo = 0;
                        $totalSep = 0;
                        $totalOct = 0;
                        $totalNov = 0;
                        $totalDic = 0;
                        $totalAcumulado = 0;
                        $hija = $mrep->obtenerIdHija($rec->idact);
                        foreach ($hija as $rhija) {
                            $hijadatos = $mrep->reporteHija($rhija->iIdActividadHija);
                            // var_dump($hijadatos);
                            foreach ($hijadatos as $h) {
                                if ($h->isactivo == 1) {
                                    $totalEne = $totalEne + $h->enero;
                                    $totalFeb = $totalFeb + $h->febrero;
                                    $totalMar = $totalMar + $h->marzo;
                                    $totalAbr = $totalAbr + $h->abril;
                                    $totalMay = $totalMay + $h->mayo;
                                    $totalJun = $totalJun + $h->junio;
                                    $totalJul = $totalJul + $h->julio;
                                    $totalAgo = $totalAgo + $h->agosto;
                                    $totalSep = $totalSep + $h->septiembre;
                                    $totalOct = $totalOct + $h->octubre;
                                    $totalNov = $totalNov + $h->noviembre;
                                    $totalDic = $totalDic + $h->diciembre;
                                }
                            }
                            $totalAcumulado = $totalEne +
                                $totalFeb  +  $totalMar + $totalAbr  + $totalMay + $totalJun  + $totalJul  + $totalAgo  + $totalSep + $totalOct  + $totalNov  + $totalDic;
                        }
                        $total = 0;
                        $total = $rec->enero + $rec->febrero + $rec->marzo + $rec->abril + $rec->mayo + $rec->junio + $rec->julio + $rec->agosto + $rec->septiembre + $rec->octubre + $rec->noviembre + $rec->diciembre;
                        // Obtenemos el ID de los primeros
                        $cells = [
                            WriterEntityFactory::createCell($rec->nivel),
                            WriterEntityFactory::createCell($rec->resumennarrativo),
                            WriterEntityFactory::createCell($rec->tipo),
                            WriterEntityFactory::createCell($rec->dimension),
                            WriterEntityFactory::createCell($rec->accion),
                            WriterEntityFactory::createCell($rec->clave),
                            WriterEntityFactory::createCell($rec->indicador),
                            WriterEntityFactory::createCell($rec->meta),
                            WriterEntityFactory::createCell($rec->frecuencia),
                            WriterEntityFactory::createCell($rec->operacion),
                            WriterEntityFactory::createCell($rec->vvariable),
                            WriterEntityFactory::createCell($rec->unidadmedida),
                            WriterEntityFactory::createCell($rec->formula),
                            WriterEntityFactory::createCell($rec->umedioverifica),
                            WriterEntityFactory::createCell($rec->enero, $amaStyle),
                            WriterEntityFactory::createCell($rec->febrero, $amaStyle),
                            WriterEntityFactory::createCell($rec->marzo, $amaStyle),
                            WriterEntityFactory::createCell($rec->abril, $amaStyle),
                            WriterEntityFactory::createCell($rec->mayo, $amaStyle),
                            WriterEntityFactory::createCell($rec->junio, $amaStyle),
                            WriterEntityFactory::createCell($rec->julio, $amaStyle),
                            WriterEntityFactory::createCell($rec->agosto, $amaStyle),
                            WriterEntityFactory::createCell($rec->septiembre, $amaStyle),
                            WriterEntityFactory::createCell($rec->octubre, $amaStyle),
                            WriterEntityFactory::createCell($rec->noviembre, $amaStyle),
                            WriterEntityFactory::createCell($rec->diciembre, $amaStyle),
                            WriterEntityFactory::createCell($total, $amaStyle),
                        ];
                        $singleRow = WriterEntityFactory::createRow($cells);
                        $writer->addRow($singleRow);
        
                        foreach ($hija as $rhija) {
                            $hijadatos = $mrep->reporteHija($rhija->iIdActividadHija);
                            // var_dump($hijadatos);
                            foreach ($hijadatos as $h) {
                                if ($h->isactivo == 1 || $h->isactivo == ''  && $h->isentregable == 1) {
                                    $totalMeses = $h->enero + $h->febrero + $h->marzo + $h->abril + $h->mayo + $h->junio + $h->julio + $h->agosto + $h->septiembre + $h->octubre + $h->noviembre + $h->diciembre;
                                    $cells = [
                                        WriterEntityFactory::createCell($rec->nivel),
                                        WriterEntityFactory::createCell($rec->resumennarrativo),
                                        WriterEntityFactory::createCell($rec->tipo),
                                        WriterEntityFactory::createCell($rec->dimension),
                                        WriterEntityFactory::createCell($h->accion),
                                        WriterEntityFactory::createCell($h->clave),
                                        WriterEntityFactory::createCell($h->indicador),
                                        WriterEntityFactory::createCell($rec->meta),
                                        WriterEntityFactory::createCell($rec->frecuencia),
                                        WriterEntityFactory::createCell($rec->operacion),
                                        WriterEntityFactory::createCell($rec->vvariable),
                                        WriterEntityFactory::createCell($rec->unidadmedida),
                                        WriterEntityFactory::createCell($rec->formula),
                                        WriterEntityFactory::createCell($rec->umedioverifica),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->enero : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->febrero : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->marzo : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->abril : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->mayo : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->junio : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->julio : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->agosto : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->septiembre : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->octubre : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->noviembre : '', $simpleStyle),
                                        WriterEntityFactory::createCell(($h->isactivo == 1) ? $h->diciembre : '', $simpleStyle),
                                        WriterEntityFactory::createCell($totalMeses),
                                    ];
                                    $singleRow = WriterEntityFactory::createRow($cells);
                                    $writer->addRow($singleRow);
                                }
                            }
                        }
                }
            
            }

            $writer->close();

            $resp['resp'] = true;
            $resp['url'] = base_url() . $ruta;
        } else {
            $resp['error_message'] = 'Sin registros';
        }
        echo json_encode($resp);
    }
    public function generarrepoPDF()
    {
        ini_set('max_execution_time', 600); // 5 Minutos máximo
        $anio = $this->input->post('anio', true);
        $eje = $this->input->post('selEje', true);
        $mes = $this->input->post('mes', true);
        $dep = $this->input->post('selDep', true) ?: 0;
        $resp = array('resp' => false, 'error_message' => '', 'url' => '');
        $tabla = array();
        $pp = $this->input->post('selPP', true);

        if (isset($_POST['fuentes'])) $tabla['fuentes'] = 1;
        if (isset($_POST['ubp'])) $tabla['ubp'] = 1;
        if (isset($_POST['ped'])) $tabla['ped'] = 1;
        if (isset($_POST['entregables'])) $tabla['entregables'] = 1;
        if (isset($_POST['compromisos'])) $tabla['compromisos'] = 1;
        if (isset($_POST['metasmun'])) $tabla['metasmun'] = 1;
        if (isset($_POST['avances'])) $tabla['avances'] = 1;
        $group = $this->input->post('agrupar', true);
        $whereString = '';
        if ((int)$this->input->post('mes')  > 0) {
            $whereString = $whereString . 'AND EXTRACT(MONTH from "DetalleActividad"."dInicio")=' . (int)$this->input->post('mes', true);
        }


        $mrep = new M_reporteCombinado();
        if ($pp == 0) {
            $ppFinal = '';
        } else {
            $ppFinal = $pp;
        }
        $query = $mrep->reporte_pat($anio, $dep, $eje, $whereString, $mes, $ppFinal);
        $proPre = $mrep->obtenerPPporId($pp);

        $fechaactual = date('m-d-Y h:i:s a');
        $obtenerDep = $mrep->obtenerDep($dep);
        $url = 'https://res.cloudinary.com/ddbiqyypn/image/upload/v1657236216/logo-queretaro_c4th0a.png';
        if ($query->num_rows() > 0) {
            $records = $query->result();

            $obtenerEje = $mrep->obtenerObj($eje);




            $html = "
        <html>
        <head>
        
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <style>
            footer{
                position:fixed;
                bottom:0px;
                left:0px;
                height:50px;
                color:black;
                text-align: left;
            }
            

        </style>
        </head>
        <body>
          <div >
            <img src='$url' width='100' height=90 alt='LOGO'>
            <h2 style='text-align:center;'>Reporte Combinado</h2>
            <div >
             <p><span style='font-weight: 600;'>Organismo: </span>{$obtenerDep->vDependencia}</p>
             <p><span style='font-weight: 600;'>Programa presupuestaria: </span>{$proPre->vProgramaPresupuestario}</p>
             <p><span style='font-weight: 600;'>Clasificación Programática(Grupo de Gasto): </span>{$proPre->vGrupoGasto} </p>
             <p><span style='font-weight: 600;'>Clasificación Programática(Grupo de Programa): </span>{$proPre->vGrupoPrograma} </p>
             <p><span style='font-weight: 600;'>Clasificación Programática(Modalidad): </span>{$proPre->vModalidad} </p>
             <p><span style='font-weight: 600;'>Gasto de Orden: </span>{$proPre->vGastoOrden} </p>
             <p><span style='font-weight: 600;'>Eje: </span>{$obtenerEje->vEje} </p>
             <p><span style='font-weight: 600;'>Objetivo del Gobierno: </span> {$obtenerEje->vObjetivoGobierno} </p>
             <p><span style='font-weight: 600;'>Estatrategia: </span></p>
          
             <p><span>Fecha: </span>{$fechaactual}</p>
            </div>
            <table border='1' bordercolor='666633' cellpadding='2' cellspacing='0'>
              <thead>
                <tr>
             
                  <th style='font-size:11px;text-align:center;' >Nivel</th>
                  <th style='font-size:11px;text-align:center;'>Resumen Presupuestario</th>
                  <th style='font-size:11px;text-align:center;'>Tipo </th>
                  <th style='font-size:11px;text-align:center;'>Dimension</th>
                  <th style='font-size:11px;text-align:center;'>Accion</th>
                  <th style='font-size:11px;text-align:center;'>Clave</th>
                  <th style='font-size:11px;text-align:center;'>Indicador</th>
                  <th style='font-size:11px;text-align:center;'>Meta</th>
                  <th style='font-size:11px;text-align:center;'>Frecuencia</th>
                  <th style='font-size:11px;text-align:center;'>Operacion</th>
                  <th style='font-size:11px;text-align:center;'>Variable</th>
                  <th style='font-size:11px;text-align:center;'>Unidad de medida (Variable)</th>
                  <th style='font-size:11px;text-align:center;'>Formula</th>
                  <th style='font-size:11px;text-align:center;'>Medio Verificacion</th>
                  <th style='font-size:11px;text-align:center;'>ENE</th>
                  <th style='font-size:11px;text-align:center;'>FEB</th>
                  <th style='font-size:11px;text-align:center;'>MAR</th>
                  <th style='font-size:11px;text-align:center;'>ABR</th>
                  <th style='font-size:11px;text-align:center;'>MAY</th>
                  <th style='font-size:11px;text-align:center;'>JUN</th>
                  <th style='font-size:11px;text-align:center;'>JUL</th>
                  <th style='font-size:11px;text-align:center;'>AGO</th>
                  <th style='font-size:11px;text-align:center;'>SEP</th>
                  <th style='font-size:11px;text-align:center;'>OCT</th>
                  <th style='font-size:11px;text-align:center;'>NOV</th>
                  <th style='font-size:11px;text-align:center;'>DIC</th>
                  <th style='font-size:11px;text-align:center;'>Total acumulado</th>
                  
                </tr>
              </thead>
              <tbody>
                
               
              ";

            foreach ($records as $key => $rec) {
                $total = 0;
                $total = $rec->enero + $rec->febrero + $rec->marzo + $rec->abril + $rec->mayo + $rec->junio + $rec->julio + $rec->agosto + $rec->septiembre + $rec->octubre + $rec->noviembre + $rec->diciembre;

                $html .= "<tr>
            <td  style='font-size:11px;text-align:center;'>{$rec->nivel}</td>
            <td  style='font-size:11px;text-align:center;'>{$rec->resumennarrativo}</td>
            <td style='font-size:11px;text-align:center;'>{$rec->tipo}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->dimension}</td>
            <td  style='font-size:11px;text-align:center;'>{$rec->accion}</td>
            <td style='font-size:11px;text-align:center;' >{$rec->clave}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->indicador}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->meta}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->frecuencia}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->operacion}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->vvariable}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->unidadmedida}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->formula}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->umedioverifica}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->enero}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->febrero}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->marzo}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->abril}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->mayo}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->junio}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->julio}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->agosto}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->septiembre}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->octubre}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->noviembre}</td>
            <td  style='font-size:11px;text-align:justify;'>{$rec->diciembre}</td>
            <td  style='font-size:11px;text-align:justify;'>{$total}</td>
          
            
          </tr>";
            }
            $html .= "</tbody>
            
            </table>
        </div>
        <br><br>
         <table class='' cellspacing='1' style='border-collapse: collapse' bordercolor='#111111' width='100%' height='100%'>
              <thead>
                <tr>
                  <th>Elaboró</th>
                  <th></th>
                  <th>Revisó</th>
                  <th></th>
                  <th>Valida</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style='border-bottom:2px solid #000;'><br><br></td>
                  <td></td>
                  <td style='border-bottom:2px solid #000;'></td>
                  <td></td>
                  <td style='border-bottom:2px solid #000;'></td>
                  
                </tr>
               
              </tbody>
        </table>
        
        </body>
        </html>";
            $options = new Options();
            $options->setIsRemoteEnabled(true);
            $options->setIsHtml5ParserEnabled(true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('a3', 'landscape');
            $dompdf->render();

            $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
            $dompdf->getCanvas()->page_text(775, 805, "Reporte Combinado,{$fechaactual} Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0, 0, 0));
            $pdf = $dompdf->output();
            $nombreDelDocumento = "public/reportes/reportecombinado.pdf";
            $bytes = file_put_contents($nombreDelDocumento, $pdf);
            $resp['resp'] = true;
            $resp['url'] = base_url() . $nombreDelDocumento;
        } else {
            $resp['error_message'] = 'Sin registros';
        }
        echo json_encode($resp);


        // $dompdf->stream("mypdf.pdf", [ "Attachment" => true]);
    }
    function injectPageCount(Dompdf $dompdf): void
    {
        /** @var CPDF $canvas */
        $canvas = $dompdf->getCanvas();
        $pdf = $canvas->get_cpdf();
        foreach ($pdf->objects as &$o) {
            if ($o['t'] === 'contents') {
                $o['c'] = str_replace('DOMPDF_PAGE_COUNT_PLACEHOLDER', $canvas->get_page_count(), $o['c']);
            }
        }
    }
    public function generarrepo_()
    {
        $anio = $this->input->get('anio', true);
        $eje = $this->input->get('eje', true);
        $dep = $this->input->get('dep', true);

        $respuesta = $this->M_reporteAct->generar2($anio);
        if ($respuesta == 'no hay datos') {
            echo  0;
        } else {
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/actividades.xls');
            $reporte->setActiveSheetIndex('0');

            $valores = array();
            $valores2 = array();
            $suma1 = '';
            $suma2 = '';

            $i = 2;
            foreach ($respuesta as $rep) {

                $suma1 = $this->M_reporteAct->recolectarsuma1($rep['iIdActividad']);
                $suma2 = $this->M_reporteAct->recolectarsuma2($rep['iIdAvance']);
                array_push($valores, $suma1);
                array_push($valores2, $suma2);

                $reporte->getActiveSheet()->SetCellValue('A' . $i, $rep['iIdActividad']);

                if ($rep['iActivo'] == 1) {
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, 'Activo');
                } else {
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, 'Inactivo');
                }
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $rep['vActividad']);
                $reporte->getActiveSheet()->SetCellValue('D' . $i, $rep['objetivoactividad']);
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $rep['vPoblacionObjetivo']);
                $reporte->getActiveSheet()->SetCellValue('F' . $i, $rep['vDescripcion']);
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $rep['dInicio']);
                $reporte->getActiveSheet()->SetCellValue('I' . $i, $rep['dFin']);
                $reporte->getActiveSheet()->SetCellValue('J' . $i, $rep['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('K' . $i, $rep['claveff']);
                $reporte->getActiveSheet()->SetCellValue('L' . $i, $rep['vFinanciamiento']);
                $reporte->getActiveSheet()->SetCellValue('M' . $i, $rep['monto']);
                $reporte->getActiveSheet()->SetCellValue('N' . $i, $rep['vLineaAccion']);
                $reporte->getActiveSheet()->SetCellValue('O' . $i, $rep['vEstrategia']);
                $reporte->getActiveSheet()->SetCellValue('P' . $i, $rep['valorobjetivo']);
                $reporte->getActiveSheet()->SetCellValue('Q' . $i, $rep['vTema']);
                $reporte->getActiveSheet()->SetCellValue('R' . $i, $rep['vEje']);
                $reporte->getActiveSheet()->SetCellValue('S' . $i, $rep['claveubp']);
                $reporte->getActiveSheet()->SetCellValue('T' . $i, $rep['vUBP']);
                $reporte->getActiveSheet()->SetCellValue('U' . $i, $rep['iIdEntregable']);
                $reporte->getActiveSheet()->SetCellValue('V' . $i, $rep['vEntregable']);
                $reporte->getActiveSheet()->SetCellValue('W' . $i, $rep['nMeta']);
                $reporte->getActiveSheet()->SetCellValue('X' . $i, $rep['vUnidadMedida']);
                $reporte->getActiveSheet()->SetCellValue('Y' . $i, $rep['vSujetoAfectado']);
                $reporte->getActiveSheet()->SetCellValue('Z' . $i, $rep['vPeriodicidad']);

                if ($rep['iMunicipalizacion'] == 1) {
                    $reporte->getActiveSheet()->SetCellValue('AA' . $i, "Si");
                } else {
                    $reporte->getActiveSheet()->SetCellValue('AA' . $i, "No");
                }
                $reporte->getActiveSheet()->SetCellValue('AB' . $i, $rep['nAvance']);
                $reporte->getActiveSheet()->SetCellValue('AC' . $i, $rep['nEjercido']);

                $i++;
            }

            $j = $i - 2;
            $l = 2;
            for ($k = 0; $k < $j; $k++) {
                $reporte->getActiveSheet()->SetCellValue('G' . $l, $valores[$k]);
                $reporte->getActiveSheet()->SetCellValue('AD' . $l, $valores2[$k]);
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
        $anio = $this->input->get('anio', true);
        $eje = $this->input->get('eje', true);

        $respuesta = $this->M_reporteAct->generar3($eje, $anio);
        if ($respuesta == 'No hay datos') {
            echo  0;
        } else {
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/actividades.xls');
            $reporte->setActiveSheetIndex('0');

            $valores = array();
            $valores2 = array();
            $suma1 = '';
            $suma2 = '';

            $i = 2;
            foreach ($respuesta as $rep) {

                $suma1 = $this->M_reporteAct->recolectarsuma1($rep['iIdActividad']);
                $suma2 = $this->M_reporteAct->recolectarsuma2($rep['iIdAvance']);
                array_push($valores, $suma1);
                array_push($valores2, $suma2);

                $reporte->getActiveSheet()->SetCellValue('A' . $i, $rep['iIdActividad']);
                if ($rep['iActivo'] == 1) {
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, 'Activo');
                } else {
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, 'Inactivo');
                }

                $reporte->getActiveSheet()->SetCellValue('C' . $i, $rep['vActividad']);
                $reporte->getActiveSheet()->SetCellValue('D' . $i, $rep['objetivoactividad']);
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $rep['vPoblacionObjetivo']);
                $reporte->getActiveSheet()->SetCellValue('F' . $i, $rep['vDescripcion']);
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $rep['dInicio']);
                $reporte->getActiveSheet()->SetCellValue('I' . $i, $rep['dFin']);
                $reporte->getActiveSheet()->SetCellValue('J' . $i, $rep['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('K' . $i, $rep['claveff']);
                $reporte->getActiveSheet()->SetCellValue('L' . $i, $rep['vFinanciamiento']);
                $reporte->getActiveSheet()->SetCellValue('M' . $i, $rep['monto']);
                $reporte->getActiveSheet()->SetCellValue('N' . $i, $rep['vLineaAccion']);
                $reporte->getActiveSheet()->SetCellValue('O' . $i, $rep['vEstrategia']);
                $reporte->getActiveSheet()->SetCellValue('P' . $i, $rep['valorobjetivo']);
                $reporte->getActiveSheet()->SetCellValue('Q' . $i, $rep['vTema']);
                $reporte->getActiveSheet()->SetCellValue('R' . $i, $rep['vEje']);
                $reporte->getActiveSheet()->SetCellValue('S' . $i, $rep['claveubp']);
                $reporte->getActiveSheet()->SetCellValue('T' . $i, $rep['vUBP']);
                $reporte->getActiveSheet()->SetCellValue('U' . $i, $rep['iIdEntregable']);
                $reporte->getActiveSheet()->SetCellValue('V' . $i, $rep['vEntregable']);
                $reporte->getActiveSheet()->SetCellValue('W' . $i, $rep['nMeta']);
                $reporte->getActiveSheet()->SetCellValue('X' . $i, $rep['vUnidadMedida']);
                $reporte->getActiveSheet()->SetCellValue('Y' . $i, $rep['vSujetoAfectado']);
                $reporte->getActiveSheet()->SetCellValue('Z' . $i, $rep['vPeriodicidad']);
                if ($rep['iMunicipalizacion'] == 1) {
                    $reporte->getActiveSheet()->SetCellValue('AA' . $i, "Si");
                } else {
                    $reporte->getActiveSheet()->SetCellValue('AA' . $i, "No");
                }
                $reporte->getActiveSheet()->SetCellValue('AB' . $i, $rep['nAvance']);
                $reporte->getActiveSheet()->SetCellValue('AC' . $i, $rep['nEjercido']);

                $i++;
            }

            $j = $i - 2;
            $l = 2;
            for ($k = 0; $k < $j; $k++) {
                $reporte->getActiveSheet()->SetCellValue('G' . $l, $valores[$k]);
                $reporte->getActiveSheet()->SetCellValue('AD' . $l, $valores2[$k]);
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
        $anio = $this->input->post('anio', true);
        $eje = $this->input->post('eje', true);
        $dep = $this->input->post('dep', true);

        $respuesta = $this->M_reporteAct->generar($eje, $dep, $anio);
        print_r($respuesta);
        if ($respuesta == 'no hay datos') {
            echo  0;
        } else {
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/actividades.xls');
            $reporte->setActiveSheetIndex('0');

            $valores = array();
            $valores2 = array();
            $suma1 = '';
            $suma2 = '';

            $i = 2;
            foreach ($respuesta as $rep) {

                $suma1 = $this->M_reporteAct->recolectarsuma1($rep['iIdActividad']);
                $suma2 = $this->M_reporteAct->recolectarsuma2($rep['iIdAvance']);
                array_push($valores, $suma1);
                array_push($valores2, $suma2);

                $reporte->getActiveSheet()->SetCellValue('A' . $i, $rep['iIdActividad']);
                if ($rep['iActivo'] == 1) {
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, 'Activo');
                } else {
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, 'Inactivo');
                }

                $reporte->getActiveSheet()->SetCellValue('C' . $i, $rep['vActividad']);
                $reporte->getActiveSheet()->SetCellValue('D' . $i, $rep['objetivoactividad']);
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $rep['vPoblacionObjetivo']);
                $reporte->getActiveSheet()->SetCellValue('F' . $i, $rep['vDescripcion']);
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $rep['dInicio']);
                $reporte->getActiveSheet()->SetCellValue('I' . $i, $rep['dFin']);
                $reporte->getActiveSheet()->SetCellValue('J' . $i, $rep['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('K' . $i, $rep['claveff']);
                $reporte->getActiveSheet()->SetCellValue('L' . $i, $rep['vFinanciamiento']);
                $reporte->getActiveSheet()->SetCellValue('M' . $i, $rep['monto']);
                $reporte->getActiveSheet()->SetCellValue('N' . $i, $rep['vLineaAccion']);
                $reporte->getActiveSheet()->SetCellValue('O' . $i, $rep['vEstrategia']);
                $reporte->getActiveSheet()->SetCellValue('P' . $i, $rep['valorobjetivo']);
                $reporte->getActiveSheet()->SetCellValue('Q' . $i, $rep['vTema']);
                $reporte->getActiveSheet()->SetCellValue('R' . $i, $rep['vEje']);
                $reporte->getActiveSheet()->SetCellValue('S' . $i, $rep['claveubp']);
                $reporte->getActiveSheet()->SetCellValue('T' . $i, $rep['vUBP']);
                $reporte->getActiveSheet()->SetCellValue('U' . $i, $rep['iIdEntregable']);
                $reporte->getActiveSheet()->SetCellValue('V' . $i, $rep['vEntregable']);
                $reporte->getActiveSheet()->SetCellValue('W' . $i, $rep['nMeta']);
                $reporte->getActiveSheet()->SetCellValue('X' . $i, $rep['vUnidadMedida']);
                $reporte->getActiveSheet()->SetCellValue('Y' . $i, $rep['vSujetoAfectado']);
                $reporte->getActiveSheet()->SetCellValue('Z' . $i, $rep['vPeriodicidad']);
                if ($rep['iMunicipalizacion'] == 1) {
                    $reporte->getActiveSheet()->SetCellValue('AA' . $i, "Si");
                } else {
                    $reporte->getActiveSheet()->SetCellValue('AA' . $i, "No");
                }
                $reporte->getActiveSheet()->SetCellValue('AB' . $i, $rep['nAvance']);
                $reporte->getActiveSheet()->SetCellValue('AC' . $i, $rep['nEjercido']);

                $i++;
            }

            $j = $i - 2;
            $l = 2;
            for ($k = 0; $k < $j; $k++) {
                $reporte->getActiveSheet()->SetCellValue('G' . $l, $valores[$k]);
                $reporte->getActiveSheet()->SetCellValue('AD' . $l, $valores2[$k]);
                $l++;
            }

            $ruta = 'public/reportes/actividadesBD.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
        }
    }



    public function eliminar()
    {
        if ($_REQUEST['id']) {
            unlink('public/reportes/actividadesBD.xls');
            echo 'si';
        }
    }


    public function listar_actividades()
    {
        if (isset($_POST['anio']) && isset($_POST['selEje']) && isset($_POST['selDep'])) {
            $anio = $this->input->post('anio');
            $eje = $this->input->post('selEje');
            $dep = $this->input->post('selDep');

            $mod = new M_reporteAct();

            $where['da.iAnio'] = $anio;
            if ($eje > 0) $where['dej.iIdEje'] = $eje;
            if ($dep > 0) $where['ac.iIdDependencia'] = $dep;
            $query = $mod->listado_actividades($where);
            //echo $_SESSION['sql'];
            //var_dump($query);
            echo json_encode($query);
        }
    }

    public function comprimir_directorio()
    {
        if (isset($_POST['dir']) && !empty($_POST['dir'])) {
            $dir = $this->input->post('dir');
            $archive_name = __DIR__ . '/../../public/reportes/' . $dir . '.zip'; // name of zip file
            $archive_folder =  __DIR__ . '/../../public/reportes/' . $dir . '/'; // the folder which you archivate
            $resp['status'] = false;
            $zip = new ZipArchive;
            if ($zip->open($archive_name, ZipArchive::CREATE) === TRUE) {
                //$dir = preg_replace('/[\/]{2,}/', '/', $archive_folder."/");

                $this->addFolderToZip($archive_folder, $zip);

                $zip->close();

                if (file_exists($archive_name)) {
                    $resp['status'] = true;
                    $rest['zip'] = $dir;
                    // $this->eliminarDirectorio($archive_folder);
                }
            } else {
                $resp['error'] =  'EL archivo zip no pudo ser generado';
            }

            echo json_encode($resp);
        }
    }

    public function addFolderToZip($dir, $zipArchive, $zipdir = '')
    {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {

                //Add the directory
                if (!empty($zipdir)) $zipArchive->addEmptyDir($zipdir);

                // Loop through all the files
                while (($file = readdir($dh)) !== false) {

                    //If it's a folder, run the function again!
                    if (!is_file($dir . $file)) {
                        // Skip parent and root directories
                        if (($file !== ".") && ($file !== "..")) {
                            $this->addFolderToZip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                        }
                    } else {
                        // Add the files
                        $zipArchive->addFile($dir . $file, $zipdir . $file);
                    }
                }
            }
        }
    }

    public function eliminarDirectorio($dir)
    {
        if (is_dir($dir)) {
            //var_dump($this->is_dir_empty($dir));
            if ($dh = opendir($dir)) {
                // Loop through all the files
                while (($file = readdir($dh)) !== false) {

                    //If it's a folder, run the function again!
                    if (!is_file($dir . $file)) {
                        if (($file !== ".") && ($file !== "..")) {
                            $this->eliminarDirectorio($dir . $file . "/");
                        }
                    } else {
                        // Eliminamos el archivo                        
                        unlink($dir . $file);
                    }
                }
            }

            /*if($this->is_dir_empty($dir)) rmdir(substr($dir, 0, -1));
            else $this->eliminarDirectorio($dir);*/
        }
    }

    function is_dir_empty($dir)
    {
        if (!is_readable($dir)) return NULL;
        return (count(scandir($dir)) == 2);
    }

    function principal_bd()
    {
        $data[] = '';
        $this->load->view('reportes/principal_bd', $data);
    }

    function catalogos()
    {
        $this->load->view('reporte/catalogos');
    }

    function descargar_catalogo()
    {
        if (isset($_POST['tipo']) && !empty($_POST['tipo'])) {
            $tipo = $this->input->post('tipo', true);
            $query = $this->M_reporteAct->catalogos($tipo);

            if ($query->num_rows() > 0) {
                $result = $query->result();

                $reporte = new PHPExcel();
                $reporte->setActiveSheetIndex(0);
                $reporte->getActiveSheet()->setTitle('BD');
                $row = 1;
                $col = -1;
                if ($tipo == 1) {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdFinanciamiento');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vClave');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vFinanciamiento');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iAnio');
                }

                if ($tipo == 2) {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdEje');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vEje');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vColorDesca');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdTema');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vTema');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdObjetivo');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vObjetivo');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdEstrategia');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vEstrategia');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdLineaAccion');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vLineaAccion');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdOds');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vOds');
                }

                if ($tipo == 3) {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdProgramaPresupuestario');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iNumero');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vProgramaPresupuestario');
                }

                if ($tipo == 4) {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdSujetoAfectado');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vSujetoAfectado');
                }

                if ($tipo == 5) {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdUbp');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vUBP');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iAnio');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdTipoUbp');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vTipoUbp');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdProgramaPresupuestario');
                }

                if ($tipo == 6) {
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'iIdUnidadMedida');
                    $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, 'vUnidadMedida');
                }

                $row++;

                foreach ($result as $record) {
                    $col = -1;
                    if ($tipo == 1) {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdFinanciamiento);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vClave);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vFinanciamiento);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iAnio);
                    }

                    if ($tipo == 2) {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdEje);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vEje);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vColorDesca);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdTema);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vTema);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdObjetivo);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vObjetivo);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdEstrategia);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vEstrategia);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdLineaAccion);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vLineaAccion);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdOds);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vOds);
                    }


                    if ($tipo == 3) {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdProgramaPresupuestario);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iNumero);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vProgramaPresupuestario);
                    }


                    if ($tipo == 4) {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdSujetoAfectado);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vSujetoAfectado);
                    }


                    if ($tipo == 5) {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdUbp);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vUBP);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iAnio);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdTipoUbp);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vTipoUbp);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdProgramaPresupuestario);
                    }

                    if ($tipo == 6) {
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->iIdUnidadMedida);
                        $reporte->getActiveSheet()->setCellValueByColumnAndRow($col = $col + 1, $row, $record->vUnidadMedida);
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
