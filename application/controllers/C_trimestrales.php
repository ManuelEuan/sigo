<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_trimestrales extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();

        $this->load->helper('url');
        $this->load->model('M_reporteAct');
        $this->load->model('M_reporteTri');
        //$this->load->model('M_seguridad','ms');
    }

    public function index()
    {
        $datos['ejes'] = $this->M_reporteAct->ejes();
        $this->load->view('reporte/trimestral.php', $datos);
    }

    public function temas()
    {
        if ($_REQUEST['id']) {
            $id = $this->input->post('id',true);
            $respuesta = $this->M_reporteTri->temas($id);
            echo $respuesta;
        }
    }

    public function objetivos()
    {
        if ($_REQUEST['id']) {
            $id = $this->input->post('id',true);
            $respuesta = $this->M_reporteTri->objetivos($id);
            echo $respuesta;
        }
    }

    public function estrategias()
    {
        if ($_REQUEST['id']) {
            $id = $this->input->post('id',true);
            $respuesta = $this->M_reporteTri->estrategias($id);
            echo $respuesta;
        }
    }

    public function lineas()
    {
        if ($_REQUEST['id']) {
            $id = $this->input->post('id',true);
            $respuesta = $this->M_reporteTri->lineas($id);
            echo $respuesta;
        }
    }
    
    public function obtenerdatos()
    {
        if ($_REQUEST['id']) {
            $eje = $this->input->post('eje',true);
            $tema = $this->input->post('tema',true);
            $obj = $this->input->post('obj',true);
            $est = $this->input->post('est',true);
            $la = $this->input->post('la',true);
            $tri = $this->input->post('tri',true);
            $anio = $this->input->post('anio',true);
            $dep = $this->input->post('dep',true);
            $inactivas = $this->input->post('inactivas',true);
            $trim = 'tInforme'.$tri;
            
            $response = $this->M_reporteTri->todoslin($anio, $trim, $eje, $tema, $obj, $est, $la, $dep,$inactivas);
            $lin = 1;

            echo $_SESSION['sql'];
            if($response == 'No hay datos')
            {
                echo  0;
            }
            else
            {
                
                $phpWord = new \PhpOffice\PhpWord\PhpWord();
                $section = $phpWord->addSection();
                $eje_ant = '';
                $tema_ant = '';
                $obj_ant = '';
                $est_ant = '';
                $la_ant = '';

                $cobj = 1;
                $cest = 1;
                $cla = 1;

                foreach ($response as $row)
                {                   
                    $fontStyle = new \PhpOffice\PhpWord\Style\Font();
                    $fontStyle->setBold(true);
                    $fontStyle->setName('Arial');
                    $fontStyle->setSize(15);
                    $fontStyle->setColor('17947f');
                    
                    if($tema_ant != $row['vTema']) {
                        $cobj = 1;
                        $myTextElement = $section->addText('EJE: '.$row['vEje']);
                        $myTextElement2 = $section->addText('Tema: '.$row['vTema']);
                        $myTextElement->setFontStyle($fontStyle);
                        $myTextElement2->setFontStyle($fontStyle);

                        $fontStyle2 = new \PhpOffice\PhpWord\Style\Font();
                        $fontStyle2->setBold(false);
                        $fontStyle2->setName('Arial');
                        $fontStyle2->setSize(12);
                        $fontStyle2->setColor('17947f');


                        $tema_ant = $row['vTema'];
                    }
                    
                    if($obj_ant != $row['vObjetivo']) {
                        $cest = 1;
                        $fontStyle2 = new \PhpOffice\PhpWord\Style\Font();
                        $fontStyle2->setBold(false);
                        $fontStyle2->setName('Arial');
                        $fontStyle2->setSize(12);
                        $fontStyle2->setColor('17947f');

                        $myTextElement3 = $section->addText('Objetivo '.$cobj.': '.$row['vObjetivo']);
                        $myTextElement3->setFontStyle($fontStyle2);


                        $cobj++;
                        $obj_ant = $row['vObjetivo'];
                    }

                    if($est_ant != $row['vEstrategia']) {
                        $cla = 1;
                        $myTextElement4 = $section->addText('Estrategia '.$cest.': '.$row['vEstrategia']);
                        $myTextElement4->setFontStyle($fontStyle2);

                        $myTextElementx = $section->addText('Linea de accion '.$cla.': '. $row['vLineaAccion'] .'');
                        $myTextElementx->setFontStyle($fontStyle2);

                        $cest++;
                        $cla++;
                        $est_ant = $row['vEstrategia'];
                    }
                    elseif($la_ant != $row['vLineaAccion']) {
                        $myTextElementx = $section->addText('Linea de accion '.$cla.': '. $row['vLineaAccion'] .'');
                        $myTextElementx->setFontStyle($fontStyle2);
                        $cla++;
                        $la_ant = $row['vLineaAccion'];
                    }

                    $fontStyle3 = new \PhpOffice\PhpWord\Style\Font();
                    $fontStyle3->setBold(true);
                    $fontStyle3->setName('Arial');
                    $fontStyle3->setSize(10.5);
                    //$myTextElement5 = $section->addText($row['vLineaAccion']);
                    $lin++;
                    $myTextElement6 = $section->addText($row['vActividad']);
                    //$myTextElement5->setFontStyle($fontStyle3);
                    $myTextElement6->setFontStyle($fontStyle3);

                    $fontStyle4 = new \PhpOffice\PhpWord\Style\Font();
                    $fontStyle4->setBold(false);
                    $fontStyle4->setName('Arial');
                    $fontStyle4->setSize(11);
                    
                    //Quitamos Tags, convertimos los valores HTML y dejamos los & como una entidad HTML (para corregir BUG)
                    $row['tInforme'] = str_replace('&', '&amp;',html_entity_decode(strip_tags($row['tInforme'])));                        
                    $myTextElement7 = $section->addText($row['tInforme']);
                   
                      
                }

              
                $ruta = 'public/reportes/trimestrales.docx';

                $file = 'trimestrales.docx';
                error_reporting(0);
                /*header("Content-Description: File Transfer");
                header('Content-Disposition: attachment; filename="' . $file . '"');
                header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                header('Content-Transfer-Encoding: binary');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Expires: 0');*/
                $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $xmlWriter->save($ruta);
            }
        }
    }
}
?>