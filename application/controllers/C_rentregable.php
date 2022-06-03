<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . "/third_party/Spout/Autoloader/autoload.php";

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Row;

class C_rentregable extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->library('Class_options');
        $this->load->library('Class_seguridad');
        $this->load->model('M_reporteEnt', 'mre');
    }

    public function index()
    {
        $seg = new Class_seguridad();
        $opt = new Class_options();
        $datos['all_sec'] = $all_sec = $seg->tipo_acceso(9, $_SESSION[PREFIJO . '_idusuario']);
        $datos['all_dep'] = $all_dep = $seg->tipo_acceso(10, $_SESSION[PREFIJO . '_idusuario']);
        $dep = $sec = 0;

        if ($all_sec > 0) $datos['ejes'] = $opt->options_tabla('eje', "");
        else {
            $sec = $_SESSION[PREFIJO . '_ideje'];
            $where['iIdEje'] = $_SESSION[PREFIJO . '_ideje'];
        }

        if ($all_dep > 0) {
            $datos['dependencias'] = (isset($where['iIdEje'])) ? $opt->options_tabla('dependencia', "", $where) : $opt->options_tabla('dependencia', "", 'iActivo = 3');
        } else {
            $dep = $_SESSION[PREFIJO . '_iddependencia'];
        }

        $this->load->view('reporte/entregable', $datos);
    }

    public function dependencias()
    {
        $ejeid = $this->input->post('id', TRUE);
        $ent = new M_reporteEnt();
        $dep = $ent->dependencias($ejeid);
        if ($dep != false) {
            echo '<option value="0">Seleccione..</option>';
            foreach ($dep as $vdep) {
                echo '<option value="' . $vdep->iIdDependencia . '">' . $vdep->vDependencia . '</option>';
            }
        } else echo '<option value="0">Seleccione..</option>';
    }

    public function reporte_entregable()
    {

        echo 'reporte generado';
    }


    public function reporte()
    {
        $reporte = new PHPExcel();
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $reporte = $reader->load('public/reportes/pruebaBD.xls');

        $reporte->setActiveSheetIndex('0');

        $reporte->getActiveSheet()->SetCellValue('A2', 'Nuevos Dulces');
        $reporte->getActiveSheet()->SetCellValue('B2', 'asdasasdasdas');

        $ruta = 'public/reportes/pruebaBD.xls';
        $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
        $imprimir->save($ruta);
        echo 'ok';
    }


    public function genera_reporte_old()
    {
        $ejeid = $this->input->post('eje', TRUE);
        $depid = $this->input->post('dep', TRUE);
        $anio = $this->input->post('anio', TRUE);
        $resp = array();

        $arr = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");

        $respuesta = $this->mre->carga_actividad($ejeid, $depid, $anio);

        if ($respuesta == false || count($respuesta) == 0) {
            $resp['resp'] = 0;
        } else {
            $reporte = new PHPExcel();

            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/entregables.xls');
            $reporte->setActiveSheetIndex('0');

            $i = 2;

            foreach ($respuesta as $rep) {

                $munici = ($rep->iMunicipalizacion == 1) ? 'Si' : 'No';
                $mben = ($rep->iMismosBeneficiarios == 1) ? 'Si' : 'No';


                if ($rep->iIdUnidadMedida > 0) {
                    $unidad = $this->mre->carga_cat(1, $rep->iIdUnidadMedida);
                    $runi = $unidad[0]->vUnidadMedida;
                } else $runi = '';

                if ($rep->iIdSujetoAfectado > 0) {
                    $sujeto = $this->mre->carga_cat(2, $rep->iIdSujetoAfectado);
                    $rsuj = $sujeto[0]->vSujetoAfectado;
                } else $rsuj = '';

                if ($rep->iIdPeriodicidad > 0) {
                    $period = $this->mre->carga_cat(3, $rep->iIdPeriodicidad);
                    $rper = $period[0]->vPeriodicidad;
                } else $rper = '';

                $avance = $this->mre->carga_avance($rep->iIdDetalleEntregable);
                $rep->iSuspension = ($rep->iSuspension > 0) ? 'Sí' : '';
                if (count($avance) > 0) {
                    foreach ($avance as $rav) {

                        $reporte->getActiveSheet()->SetCellValue('A' . $i, $rep->iIdActividad);
                        $reporte->getActiveSheet()->SetCellValue('B' . $i, ($rep->nAvance / 100));
                        $reporte->getActiveSheet()->SetCellValue('C' . $i, $rep->vActividad);
                        $reporte->getActiveSheet()->SetCellValue('D' . $i, $rep->iAnio);
                        $reporte->getActiveSheet()->SetCellValue('E' . $i, $rep->vDependencia);
                        $reporte->getActiveSheet()->SetCellValue('F' . $i, $rep->vEje);
                        $reporte->getActiveSheet()->SetCellValue('G' . $i, $rep->iIdEntregable);
                        $reporte->getActiveSheet()->SetCellValue('H' . $i, $rep->vEntregable);
                        $reporte->getActiveSheet()->SetCellValue('I' . $i, $rep->nMeta);
                        $reporte->getActiveSheet()->SetCellValue('J' . $i, $runi);
                        $reporte->getActiveSheet()->SetCellValue('K' . $i, $rsuj);
                        $reporte->getActiveSheet()->SetCellValue('L' . $i, $rper);
                        $reporte->getActiveSheet()->SetCellValue('M' . $i, $munici);
                        $reporte->getActiveSheet()->SetCellValue('N' . $i, $mben);
                        $reporte->getActiveSheet()->SetCellValue('O' . $i, $rep->iSuspension);

                        $reporte->getActiveSheet()->SetCellValue('P' . $i, strtr($rav->fecha, $arr));
                        $reporte->getActiveSheet()->SetCellValue('Q' . $i, $rav->vMunicipio);
                        $reporte->getActiveSheet()->SetCellValue('R' . $i, $rav->cant_avance);
                        $reporte->getActiveSheet()->SetCellValue('S' . $i, $rav->cant_ejercido);
                        $reporte->getActiveSheet()->SetCellValue('T' . $i, $rav->ben_h);
                        $reporte->getActiveSheet()->SetCellValue('U' . $i, $rav->ben_m);
                        $reporte->getActiveSheet()->SetCellValue('V' . $i, $rav->disc_h);
                        $reporte->getActiveSheet()->SetCellValue('W' . $i, $rav->disc_m);
                        $reporte->getActiveSheet()->SetCellValue('X' . $i, $rav->len_h);
                        $reporte->getActiveSheet()->SetCellValue('Y' . $i, $rav->len_m);
                        $i++;
                    }

                    $resp['avance'][] = $avance;
                } else {
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $rep->iIdActividad);
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, ($rep->nAvance / 100));
                    $reporte->getActiveSheet()->SetCellValue('C' . $i, $rep->vActividad);
                    $reporte->getActiveSheet()->SetCellValue('D' . $i, $rep->iAnio);
                    $reporte->getActiveSheet()->SetCellValue('E' . $i, $rep->vDependencia);
                    $reporte->getActiveSheet()->SetCellValue('F' . $i, $rep->vEje);
                    $reporte->getActiveSheet()->SetCellValue('G' . $i, $rep->iIdEntregable);
                    $reporte->getActiveSheet()->SetCellValue('H' . $i, $rep->vEntregable);
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $rep->nMeta);
                    $reporte->getActiveSheet()->SetCellValue('J' . $i, $runi);
                    $reporte->getActiveSheet()->SetCellValue('K' . $i, $rsuj);
                    $reporte->getActiveSheet()->SetCellValue('L' . $i, $rper);
                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $munici);
                    $reporte->getActiveSheet()->SetCellValue('N' . $i, $mben);
                    $reporte->getActiveSheet()->SetCellValue('O' . $i, $rep->iSuspension);

                    $i++;
                }
            }

            $ruta = 'public/reportes/entregablesBD_' . $_SESSION[PREFIJO . '_idusuario'] . '.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            $resp['resp'] = 1;
            $resp['url'] = base_url() . $ruta;
        }
        echo json_encode($resp);
    }

    public function genera_reporte()
    {
        ini_set('max_execution_time', 600); // 5 Minutos máximo
        $ejeid  = $this->input->post('eje', TRUE);
        $depid  = $this->input->post('dep', TRUE);
        $anio   = $this->input->post('anio', TRUE);
        $whereAdicional = array();
        if ((int)$this->input->post('mes')  > 0) 
            $whereAdicional['EXTRACT(MONTH from dact."dInicio")='] = (int)$this->input->post('mes', true);

        $resp   = $multipleRows = array();

        $arr = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");


        $respuesta = $this->mre->carga_actividad($ejeid, $depid, $anio, $whereAdicional);

        if ($respuesta == false || count($respuesta) == 0) {
            $resp['resp'] = 0;
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            $ruta = 'public/reportes/entregablesBD_' . $_SESSION[PREFIJO . '_idusuario'] . '.xlsx';
            $writer->openToFile($ruta); // write data to a file or to a PHP stream
            //$writer->openToBrowser('example.xlsx');        

            // Header table
            $cells = [
                WriterEntityFactory::createCell('Año'),
                WriterEntityFactory::createCell('Eje'),
                WriterEntityFactory::createCell('Dependencia'),
                WriterEntityFactory::createCell('iIdActividad'),
                WriterEntityFactory::createCell('% Cumplimiento'),
                WriterEntityFactory::createCell('Actividad'),
                WriterEntityFactory::createCell('iIdEntregable'),
                WriterEntityFactory::createCell('Entregable'),
                WriterEntityFactory::createCell('Meta'),
                WriterEntityFactory::createCell('Meta modificada'),
                WriterEntityFactory::createCell('Unidad de medida'),
                WriterEntityFactory::createCell('Sujeto afectado'),
                WriterEntityFactory::createCell('Periodicidad'),
                WriterEntityFactory::createCell('¿Se entrega por municipio?'),
                WriterEntityFactory::createCell('¿Afecta a los mismos beneficiarios?'),
                WriterEntityFactory::createCell('¿Aparece en el anexo?'),
                WriterEntityFactory::createCell('Título tabla anexo'),
                WriterEntityFactory::createCell('ODS anexo'),
                WriterEntityFactory::createCell('Suspension total o parcial'),
                WriterEntityFactory::createCell('Mes de entrega'),
                WriterEntityFactory::createCell('Municipio'),
                WriterEntityFactory::createCell('Avance'),
                WriterEntityFactory::createCell('Ejercido'),
                WriterEntityFactory::createCell('Beneficiarios Hombres'),
                WriterEntityFactory::createCell('Beneficarios Mujeres'),
                WriterEntityFactory::createCell('Discapacitados Hombres'),
                WriterEntityFactory::createCell('Discapacitados Mujeres'),
                WriterEntityFactory::createCell('Mayahablantes Hombres'),
                WriterEntityFactory::createCell('Mayahablantes Mujeres')
            ];
            $rowStyle = (new StyleBuilder())
                ->setFontBold()
                ->build();
            $singleRow = WriterEntityFactory::createRow($cells, $rowStyle);
            $writer->addRow($singleRow);

            foreach ($respuesta as $rep) {

                $munici = ($rep->iMunicipalizacion == 1) ? 'Si' : 'No';
                $mben = ($rep->iMismosBeneficiarios == 1) ? 'Si' : 'No';
                $anexo = ($rep->iAnexo == 1) ? 'Si' : 'No';
                $tabla = ($rep->iAnexo == 1) ? $rep->vNombreActividad . '. ' . $rep->vNombreEntregable . '.' : '';
                $avance = $this->mre->carga_avance($rep->iIdDetalleEntregable);
                $rep->iSuspension = ($rep->iSuspension > 0) ? 'Sí' : '';

                if (count($avance) > 0) {
                    foreach ($avance as $rav) {
                        $cells = [
                            WriterEntityFactory::createCell((int)$rep->iAnio),
                            WriterEntityFactory::createCell($rep->vEje),
                            WriterEntityFactory::createCell($rep->vDependencia),
                            WriterEntityFactory::createCell((int)$rep->iIdActividad),
                            WriterEntityFactory::createCell((float)$rep->nAvance),
                            WriterEntityFactory::createCell($rep->vActividad),
                            WriterEntityFactory::createCell((int)$rep->iIdEntregable),
                            WriterEntityFactory::createCell($rep->vEntregable),
                            WriterEntityFactory::createCell((float)$rep->nMeta),
                            WriterEntityFactory::createCell((float)$rep->nMetaModificada),
                            WriterEntityFactory::createCell($rep->vUnidadMedida),
                            WriterEntityFactory::createCell($rep->vSujetoAfectado),
                            WriterEntityFactory::createCell($rep->vPeriodicidad),
                            WriterEntityFactory::createCell($munici),
                            WriterEntityFactory::createCell($mben),
                            WriterEntityFactory::createCell($anexo),
                            WriterEntityFactory::createCell($tabla),
                            WriterEntityFactory::createCell((int)$rep->iNumOds),
                            WriterEntityFactory::createCell($rep->iSuspension),
                            WriterEntityFactory::createCell(strtr($rav->fecha, $arr)),
                            WriterEntityFactory::createCell($rav->vMunicipio),
                            WriterEntityFactory::createCell((float)$rav->cant_avance),
                            WriterEntityFactory::createCell((float)$rav->cant_ejercido),
                            WriterEntityFactory::createCell((int)$rav->ben_h),
                            WriterEntityFactory::createCell((int)$rav->ben_m),
                            WriterEntityFactory::createCell((int)$rav->disc_h),
                            WriterEntityFactory::createCell((int)$rav->disc_m),
                            WriterEntityFactory::createCell((int)$rav->len_h),
                            WriterEntityFactory::createCell((int)$rav->len_m)
                        ];

                        $singleRow = WriterEntityFactory::createRow($cells);
                        $writer->addRow($singleRow);
                    }
                } else {
                    $cells = [
                        WriterEntityFactory::createCell((int)$rep->iAnio),
                        WriterEntityFactory::createCell($rep->vEje),
                        WriterEntityFactory::createCell($rep->vDependencia),
                        WriterEntityFactory::createCell((int)$rep->iIdActividad),
                        WriterEntityFactory::createCell((float)$rep->nAvance),
                        WriterEntityFactory::createCell($rep->vActividad),
                        WriterEntityFactory::createCell((int)$rep->iIdEntregable),
                        WriterEntityFactory::createCell($rep->vEntregable),
                        WriterEntityFactory::createCell((float)$rep->nMeta),
                        WriterEntityFactory::createCell((float)$rep->nMetaModificada),
                        WriterEntityFactory::createCell($rep->vUnidadMedida),
                        WriterEntityFactory::createCell($rep->vSujetoAfectado),
                        WriterEntityFactory::createCell($rep->vPeriodicidad),
                        WriterEntityFactory::createCell($munici),
                        WriterEntityFactory::createCell($mben),
                        WriterEntityFactory::createCell($anexo),
                        WriterEntityFactory::createCell($tabla),
                        WriterEntityFactory::createCell((int)$rep->iNumOds),
                        WriterEntityFactory::createCell($rep->iSuspension)
                    ];
                    $singleRow = WriterEntityFactory::createRow($cells);
                    $writer->addRow($singleRow);
                }
            }

            $writer->close();

            $resp['resp'] = 1;
            $resp['url'] = base_url() . $ruta;
        }
        echo json_encode($resp);
    }
}
