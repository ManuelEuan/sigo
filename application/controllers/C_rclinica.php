<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/Spout/Autoloader/autoload.php";
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Entity\Row;
require_once APPPATH."/libraries/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
use Dompdf\Options;


class C_rclinica extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->model('M_reporteClinicas');
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
        $data['PP'] = $this->M_reporteClinicas->obtenerPP();
        $this->load->view('reporte/clinica', $data);
    }

    public function dependencias(){
        if($_REQUEST['id']){
            $id = $this->input->post('id',true);
            $respuesta = $this->M_reporteClinicas->dependencias($id);
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
        $pp = $this->input->post('selPP',true);
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
            $whereString = $whereString.'AND EXTRACT(MONTH from "DetalleActividad"."dInicio")='. (int)$this->input->post('mes',true);
        }
        

        $mrep = new M_reporteClinicas();
        
        //$query = $mrep->reporte_pat($anio,$dep,$whereString);
        $query = $mrep->obtenerVista($eje,$dep);
        

        $fechaactual = date('m-d-Y h:i:s a');

        //$idActividades = $mrep->obteneridActividades($eje, $dep);

        //$idActividades[0]->iIdActividad
        //$resultado = $mrep->obtenerDatosPorActividad(6001);

        if($query->num_rows() > 0){

            //$resultadosID = $idActividades->result();

            $records = $query->result(); 
            $ruta = 'public/reportes/avancemir.xlsx';
            $writer = WriterEntityFactory::createXLSXWriter();
            $writer->openToFile($ruta);

            $totalMeta = 0;
            $totalAvance = 0;
            $porcentaje = 0;

            foreach ($records as $rec){
                $totalMeta = $totalMeta + $rec->meta;
                $totalAvance = $totalAvance + $rec->nAvance;

            }
            if($totalMeta != 0){
                $porcentaje = ($totalAvance/$totalMeta)*100;
                $porcentajeRedondeado = round($porcentaje, 0);
            }else{
                $porcentaje = 0;
                $porcentajeRedondeado = 0;
            }
            
            $obtenerDep = $mrep->obtenerDep($dep);

            $obtenerEje = $mrep->obtenerEje($eje); 

            $proPre = $mrep->obtenerPPporId($pp);
            

            $rowStyle = (new StyleBuilder())
                            ->setBackgroundColor(Color::BLUE)
                            ->setFontColor(Color::WHITE)
                            ->setFontItalic()
                            ->build();
            
            $tituloexcel = (new StyleBuilder())
            ->setBackgroundColor(Color::WHITE)
            ->setFontColor(Color::BLACK)
            ->setFontSize(22)
            ->build();
            $cells =[
                WriterEntityFactory::createCell('Organismo',$rowStyle),
                WriterEntityFactory::createCell($obtenerDep->vDependencia),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell(''),
                WriterEntityFactory::createCell('REPORTE AVANCE MIR',$tituloexcel),
            ];
            $singleRow = WriterEntityFactory::createRow($cells,$titulo);
            $writer->addRow($singleRow); 


            $rowStyle = (new StyleBuilder())
                            ->setBackgroundColor(Color::BLUE)
                            ->setFontColor(Color::WHITE)
                            ->setFontItalic()
                            ->build();

            $cells =[
                WriterEntityFactory::createCell('Programa Presupuestario',$rowStyle),
                WriterEntityFactory::createCell($proPre->vProgramaPresupuestario),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells =[
                WriterEntityFactory::createCell('Clasificación Programática​', $rowStyle),
                WriterEntityFactory::createCell($proPre->vGrupoGasto), 
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells =[
                WriterEntityFactory::createCell('Eje',$rowStyle),
                WriterEntityFactory::createCell($obtenerEje->vEje),
  
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

            $cells =[
                WriterEntityFactory::createCell(''),
            ];
            $singleRow = WriterEntityFactory::createRow($cells,$rowStyle);
            $writer->addRow($singleRow);
            $cells =[
                WriterEntityFactory::createCell('Fecha',$rowStyle),
                WriterEntityFactory::createCell($fechaactual),
            ];
            $singleRow = WriterEntityFactory::createRow($cells);
            $writer->addRow($singleRow);

			$blueStyle = (new StyleBuilder())
            ->setBackgroundColor(Color::BLUE)
            ->setFontColor(Color::WHITE)
            ->setFontItalic()
            ->build();
           
            $cells = [
                    WriterEntityFactory::createCell('Nivel',$blueStyle),
                    WriterEntityFactory::createCell('Descripción del PP',$blueStyle),
                    WriterEntityFactory::createCell('Resumen Narrativo',$blueStyle),
                    WriterEntityFactory::createCell('Acción o Proyecto',$blueStyle),
                    WriterEntityFactory::createCell('Indicador',$blueStyle),
                    WriterEntityFactory::createCell('Variables',$blueStyle),
                    WriterEntityFactory::createCell('Dato de la variable',$blueStyle),
                    WriterEntityFactory::createCell('Línea Base',$blueStyle), 
                    WriterEntityFactory::createCell('Meta',$blueStyle), 
                    WriterEntityFactory::createCell('Frecuencia',$blueStyle), 
                    WriterEntityFactory::createCell('Avance',$blueStyle), 
                    WriterEntityFactory::createCell('Medio de Verificación',$blueStyle), 
                    WriterEntityFactory::createCell('Supuesto',$blueStyle), 

                   
                ];
            // Agregamos la fila de encabezados
            $rowStyle = (new StyleBuilder())
                            ->setFontBold()
                            ->build();
            $singleRow = WriterEntityFactory::createRow($cells,$rowStyle); 
            $writer->addRow($singleRow);

            foreach ($records as $key => $rec) {
                $total = 0;
                $resultado = $mrep->obtenerIdHija($rec->iIdActividad);

                foreach ($resultado as $key => $r) {
                    $datosHija = $mrep->obtenerDatosHija($r->iIdActividadHija);
                    foreach ($datosHija as $key => $d) {
                       
                        $total = $total + $d->porcentajeavance;
                    }
                }

                $cells = [
                    WriterEntityFactory::createCell($rec->vNivelMIR),
                    WriterEntityFactory::createCell($rec->vProgramaPresupuestario),
                    WriterEntityFactory::createCell($rec->vNombreResumenNarrativo),
                    WriterEntityFactory::createCell($rec->vActividad),
                    WriterEntityFactory::createCell($rec->indicador),
                    WriterEntityFactory::createCell($rec->vnombrevariable),
                    WriterEntityFactory::createCell($rec->ivalor),
                    WriterEntityFactory::createCell($rec->nlineabase),
                    WriterEntityFactory::createCell((int)'100%'),
                    WriterEntityFactory::createCell($rec->periodicidad),
                    WriterEntityFactory::createCell($total.'%'),
                    WriterEntityFactory::createCell($rec->medioverifica),
                    WriterEntityFactory::createCell($rec->supuesto),
                ];

                $singleRow = WriterEntityFactory::createRow($cells);
                $writer->addRow($singleRow);

                
                
                foreach ($resultado as $key => $r) {
                    
                    $datosHija = $mrep->obtenerDatosHija($r->iIdActividadHija);
                    foreach ($datosHija as $key => $d) {
                        $cells = [
                            WriterEntityFactory::createCell($rec->vNivelMIR),
                            WriterEntityFactory::createCell($rec->vProgramaPresupuestario),
                            WriterEntityFactory::createCell($rec->vNombreResumenNarrativo),
                            WriterEntityFactory::createCell($d->vActividad),
                            WriterEntityFactory::createCell($d->vEntregable),
                            WriterEntityFactory::createCell($d->vnombrevariable),
                            WriterEntityFactory::createCell($d->iValor),
                            WriterEntityFactory::createCell($d->nLineaBase),
                            WriterEntityFactory::createCell((int)'100%'),
                            WriterEntityFactory::createCell($d->vPeriodicidad),
                            WriterEntityFactory::createCell($d->porcentajeavance.'%'),
                            WriterEntityFactory::createCell($d->vMedioVerifica),
                            WriterEntityFactory::createCell($rec->supuesto),
                        ];
        
                        $singleRow = WriterEntityFactory::createRow($cells);
                        $writer->addRow($singleRow);
                    }
                    
                }
            }


            $writer->close();
           
            $resp['resp'] = true;
            $resp['url'] = base_url().$ruta;    
        } else {
            $resp['error_message'] = 'Sin registros';
        }
        
        echo json_encode($resp);
    }
    public function generarrepoPDFs(){
        $html='<!doctype html>
        <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
          <title>Reporte de Avance MIR</title>
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
          <style type="text/css">
            
             #inferior{
            
             }
            </style>
        </head>
        <body>
          <div class="container mt-5">
            <h2 class="text-center">REPORTE DE AVANCE MIR</h2>
            <div class="">
             <p>Organismo: </p>
             <p>Programa presupuestaria: </p>
             <p>Clasificación Programática: </p>
             <p>Eje: </p>
             <p>Fecha: </p>
            </div>
            <table class="">
              <thead>
                <tr>
                  <th>Nivel</th>
                  <th>Descripción del PP</th>
                  <th>Resumen Narrativo</th>
                  <th>Acción o Proyecto </th>
                  <th>Indicador</th>
                  <th>Variables</th>
                  <th>Datos de la variable</th>
                  <th>Linea Base</th>
                  <th>Meta</th>
                  <th>Frecuencia</th>
                  <th>Avance</th>
                  <th>Medio de verificación</th>
                  <th>Supuesto</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Airi Satou</td>
                  <td>Accountant</td>
                  <td>Tokyo</td>
                  <td>33</td>
                  <td>2008/11/28</td>
                  <td>$162,700</td>
                </tr>
               
              </tbody>
            </table>
          </div>
          <div style="color: #FFF;
          background: #000;
          position:absolute; /*El div será ubicado con relación a la pantalla*/
          left:0px; /*A la derecha deje un espacio de 0px*/
          right:0px; /*A la izquierda deje un espacio de 0px*/
          bottom:0px; /*Abajo deje un espacio de 0px*/
          height:120px; /*alto del div*/
          z-index:0;
          display: flex;
          text-align: center;" id="inferior">

            <div style="width: 33%; padding-left: 30px;padding-right: 30px;">Elaboró
              <hr style="border-top: 1px solid red;margin-top:70px;">
            </div>
            <div style="width: 33%;padding-left: 30px;padding-right: 30px;">Revisó
              <hr style="border-top: 1px solid red;margin-top:70px;">
            
            </div>
            <div style="width: 33%; padding-left: 30px;padding-right: 30px;">Valida
              <hr style="border-top: 1px solid red;margin-top:70px;">
            
            </div>


          </div>
        </body>
        </html>';
        // $dompdf = new DOMPDF();
        // $dompdf->load_html($html);
        // $dompdf->render();
        // $canvas = $dompdf->get_canvas();
        // $canvas->page_script('
        // if ($pdf->get_page_number() != $pdf->get_page_count()) {
        //     $font = Font_Metrics::get_font("helvetica", "12");                  
        //     $pdf->text(500, 770, "Page {PAGE_NUM} - {PAGE_COUNT}", $font, 10, array(0,0,0));
        //     $pdf->text(260, 770, "Canny Pack", $font, 10, array(0,0,0));
        //     $pdf->text(43, 770, $date, $font, 10, array(0,0,0));
        // }
        // ');
        
// instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4');

        // Render the HTML as PDF
        $dompdf->render();

        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->getCanvas()->page_text(72, 18, "Pag: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
// $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        $pdf = $dompdf->output();
        $nombreDelDocumento = "public/reportes/reporte.pdf";
        $bytes = file_put_contents($nombreDelDocumento, $pdf);
        // $dompdf->stream($nombreDelDocumento, array("Attachment" => 1));   
        $resp['resp'] = true;
        $resp['url'] = base_url().$nombreDelDocumento; 
        echo json_encode($resp); 

    }
    public function generarrepoPDF()
    {   
        $anio = $this->input->post('anio',true);
        $eje = $this->input->post('selEje',true);
        $dep = $this->input->post('selDep',true);
        $pp = $this->input->post('selPP',true);
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
            $whereString = $whereString.'AND EXTRACT(MONTH from "DetalleActividad"."dInicio")='. (int)$this->input->post('mes',true);
        }
        $mrep = new M_reporteClinicas();
        
        //$query = $mrep->reporte_pat($anio,$dep,$whereString);
        $query = $mrep->obtenerVista($eje,$dep);
        

        $fechaactual = date('m-d-Y h:i:s a');
      
        
        $porcentaje = ($totalAvance/$totalMeta)*100;
            $porcentajeRedondeado = round($porcentaje, 0);
            
            $obtenerDep = $mrep->obtenerDep($dep);

            $obtenerEje = $mrep->obtenerEje($eje); 

            $proPre = $mrep->obtenerPPporId($pp);
            $url = 'https://res.cloudinary.com/ddbiqyypn/image/upload/v1657236216/logo-queretaro_c4th0a.png';  
        if($query->num_rows() > 0){
            $records = $query->result();

   
        

        $html= "
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
        <header>
        <img src='$url' width='100' height=90 alt='LOGO'>
        <h2 style='text-align:center;'>REPORTE DE AVANCE MIR</h2>
        <div >
         <p><span style='font-weight: 600;'>Organismo: </span>{$obtenerDep->vDependencia}</p>
         <p><span style='font-weight: 600;'>Programa presupuestaria: </span>{$proPre->vProgramaPresupuestario}</p>
         <p><span style='font-weight: 600;'>Clasificacion Programática: </span>{$proPre->vGrupoGasto} </p>
         <p><span style='font-weight: 600;'>Eje: </span>{$obtenerEje->vEje} </p>
         <p><span style='font-weight: 600;'>Fecha: </span> {$fechaactual}</p>
        </div>
        </header>
        <main>
          <div >
            
            <table border='1' bordercolor='666633' cellpadding='2' cellspacing='0'>
              <thead>
            
                <tr>
                  <th  style='font-size:13px;width:15px;margin:0px;'>Nivel</th>
                  <th style='font-size:13px; width:15px;margin:0px;'>Descripción del PP</th>
                  <th style='font-size:13px;'>Resumen <br> Narrativo</th>
                  <th style='width:15px;margin:0px;font-size:13px'>Acción o <br> Proyecto </th>
                  <th colspan='1'  style='font-size:13px;text-align:center;width:15%;'>Indicador</th>
                  <th style='font-size:13px;'>Variables</th>
                  <th style='font-size:13px;width:5%;'>Datos de la variable</th>
                  <th style='font-size:13px;'>Linea Base</th>
                  <th style='font-size:13px;'>Meta</th>
                  <th style='font-size:13px;'>Frecuencia</th>
                  <th style='font-size:13px;'>Avance</th>
                  <th style='font-size:13px;width:15px;margin:0px;text-align:center;'>Medio de verificación</th>
                  <th style='font-size:13px;'>Supuesto</th>
                </tr>
              </thead>
              <tbody>
                
               
              ";
              
        foreach($records as $key => $rec) {
            $html .= "<tr>
            <td  style='font-size:12px;'>{$rec->vNivelMIR}</td>
            <td  style='font-size:12px;'>{$rec->vProgramaPresupuestario}</td>
            <td colspan='1' style='font-size:12px;width:35px;'>{$rec->vNombreResumenNarrativo}</td>
            <td  style='font-size:12px; '>{$rec->vActividad}</td>
            <td  style='font-size:12px;'>{$rec->vEntregable}</td>
            <td  style='font-size:12px; text-align:center;'>{$rec->vnombrevariable}</td>
            <td  style='font-size:12px;  text-align:center;'>{$rec->iValor}</td>
            <td  style='font-size:12px;  text-align:center;'>{$rec->nLineaBase}</td>
            <td  style='font-size:12px;text-align:center;'>100%</td>
            <td  style='font-size:12px; text-align:center;'>{$rec->vPeriodicidad}</td>
            <td  style='font-size:12px; text-align:center;'>{$rec->porcentajeavance}%</td>
            <td  style='font-size:12px; text-align:center;'>{$rec->vMedioVerifica}</td>
            <td  style='font-size:12px; text-align:center;'>{$rec->vSupuesto}</td>
            
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
       </main>
       
            ";
            
        // $html .='<script type="text/php">';
        // $html .='</script>';
           $html .= "
        </body>
        </html>";
       
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->setIsHtml5ParserEnabled(true);
        // $options->setIsPhpEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A3', 'landscape');
        $dompdf->render();
        

        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->getCanvas()->page_text(775, 805, "Reporte Avance MIR,{$fechaactual} Página: {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0));
// $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        $pdf = $dompdf->output();
        
        // $dompdf->page_text(1,1, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
        // $canvas = $dompdf->getCanvas();
        // $pdf = $canvas->get_cpdf();
        // foreach ($pdf->objects as &$o) {
        //     if ($o['t'] === 'contents') {
        //         $o['c'] = str_replace('DOMPDF_PAGE_COUNT_PLACEHOLDER', $canvas->get_page_count(), $o['c']);
        //     }
        // }

 
        
            // Forzar descarga del PDF
        // $dompdf->set_paper ('a4','landscape');
        // $contenido = $dompdf->output();
        $nombreDelDocumento = "public/reportes/reporte.pdf";
        $bytes = file_put_contents($nombreDelDocumento, $pdf);
        // $dompdf->stream($nombreDelDocumento, array("Attachment" => 1));   
        $resp['resp'] = true;
        $resp['url'] = base_url().$nombreDelDocumento;  
        }else {
            $resp['error_message'] = 'Sin registros';
        }
        echo json_encode($resp); 
        
        
        // $dompdf->stream("mypdf.pdf", [ "Attachment" => true]);
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
