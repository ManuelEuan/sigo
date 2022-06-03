<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_rcompromisos extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        session_start();

        $this->load->helper('url');
        $this->load->library('excel');
        $this->load->model('M_reporteAct');
        $this->load->model('M_reporteTri');
        $this->load->model('M_rcompromisos');
        //$this->load->model('M_seguridad','ms');
    }
    public function index()
    {
        $datos['ejes'] = $this->M_reporteAct->ejes();
        $this->load->view('reporte/compromisos', $datos);
    }

    public function datoscompromisoSSBD()
    {
        if ($_REQUEST['id']) {
            $eje = $this->input->get('eje',true);
            $dep = $this->input->get('dep',true);

            $response='';

            if($eje == '' || $eje == null){
                $response = $this->M_rcompromisos->rcomSSBD2();
            }else{
                $response = $this->M_rcompromisos->rcomSSBD($eje, $dep);
            }
           

            if($response == 'no hay datos'){
                echo 0;
            }else{
                $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/compromisosbd.xls');
            $reporte->setActiveSheetIndex('0');
            $datosEX = '';
            $i = 3;
            foreach ($response as $row) {
                $datosEX = $this->M_rcompromisos->datosEX($row['iIdCompromiso']);


                $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
                $reporte->getActiveSheet()->SetCellValue('D' . $i, $row['vEje']);
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
                $reporte->getActiveSheet()->SetCellValue('F' . $i, $row['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('G' . $i, $datosEX);
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                $i++;
            }


            $ruta = 'public/reportes/compromisobd.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
            }
        }
    }

    public function datoscompromisoSCBD()
    {
        if ($_REQUEST['id']) {
            $eje = $this->input->get('eje',true);
            $dep = $this->input->get('dep',true);


            $response='';

            if($eje == '' || $eje == null){
                $response = $this->M_rcompromisos->rcomSSBD2();
            }else{
                $response = $this->M_rcompromisos->rcomSSBD($eje, $dep);
            }

            if($response == 'no hay datos'){
                echo 0;
            }else{
                $reporte = new PHPExcel();
                $reader = PHPExcel_IOFactory::createReader('Excel5');
                $reporte = $reader->load('public/reportes/compromisosbd.xls');
                $reporte->setActiveSheetIndex('0');
                $datosEX = '';
                $i = 3;
                foreach ($response as $row) {
                    $datosEX = $this->M_rcompromisos->datosEX($row['iIdCompromiso']);
    
    
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                    $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
                    $reporte->getActiveSheet()->SetCellValue('D' . $i, $row['vEje']);
                    $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
                    $reporte->getActiveSheet()->SetCellValue('F' . $i, $row['vDependencia']);
                    $reporte->getActiveSheet()->SetCellValue('G' . $i, $datosEX);
                    $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                    $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                    $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                    $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                    $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                    $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                    $i++;
                }
    
    
                $ruta = 'public/reportes/compromisobd.xls';
                $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
                $imprimir->save($ruta);
                echo 'we';
            }

           
        }
    }

    public function datoscompromisoCABD()
    {
        if ($_REQUEST['id']) {
            $eje = $this->input->get('eje',true);
            $dep = $this->input->get('dep',true);

            $response='';

            if($eje == '' || $eje == null){
                $response = $this->M_rcompromisos->rcomCABD2();
            }else{
                $response = $this->M_rcompromisos->rcomCABD($eje, $dep);
            }
            
            if($response = 'no hay datos'){
                echo 0;
            }else{
                $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/compromisosbd.xls');
            $reporte->setActiveSheetIndex('0');
            $datosEX = '';
            $i = 3;
            foreach ($response as $row) {
                $datosEX = $this->M_rcompromisos->datosEX($row['iIdCompromiso']);


                $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
                $reporte->getActiveSheet()->SetCellValue('D' . $i, $row['vEje']);
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
                $reporte->getActiveSheet()->SetCellValue('F' . $i, $row['vDependencia']);
                $reporte->getActiveSheet()->SetCellValue('G' . $i, $datosEX);
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                $reporte->getActiveSheet()->SetCellValue('Q' . $i, $row['vEvidencia']);
                $reporte->getActiveSheet()->SetCellValue('R' . $i, $row['vTipo']);
                $reporte->getActiveSheet()->SetCellValue('U' . $i, $row['iFotoInicio']);
                $i++;
            }


            $ruta = 'public/reportes/compromisobd.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
            }
        }
    }

    public function celdas1(){
        if ($_REQUEST['id']) {
            $eje = $this->input->get('eje',true);
            $dep = $this->input->get('dep',true);

            $response='';
            $contador= '';

            if($eje == '' || $eje == null){
                $response = $this->M_rcompromisos->rcomCABD2();
            $contador = $this->M_rcompromisos->contador2();
            }else{
                $response = $this->M_rcompromisos->rcomCABD($eje, $dep);
            $contador = $this->M_rcompromisos->contador($eje, $dep);
            }

            
            
            if($response == 'no hay datos'){
                echo 0;
            }else{
                $num = '';
            $com ='';
            $ncorto= '';
            $ej = '';
            $tem='';
            $depe='';
            $porc ='';
            $antes='';
            $despues='';
            $fe = '';
            $esta = '';
            $icom = '';
            $vcom = '';
            $pon= '';
            $av = '';
            $vev = '';
            $tip = '';
            $foto ='';

            

            
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/compromisoscc.xls');
            $reporte->setActiveSheetIndex('0');

            //$reporte->getActiveSheet()->SetCellValue('A10', $contador);
            
            $ex=0;
            
            $datosEX = '';
            $a= 0;
            $u=0;
            $i = 3;
            
            $an = 0;
            $bn = 0;
            $cn = 0;
            $dn = 0;
            $en = 0;
            $fn = 0;
            $gn = 0;
            $hn = 0;
            $in = 0;
            $jn = 0;
            $kn = 0;
            $ln = 0;
            $mn = 0;
            $nn = 0;
            $on = 0;
            $pn = 0;
            $qn = 0;
            $rn = 0;
            $sn = 0;
            $tn = 0;
            $un = 0;

            
            
            foreach ($response as $row) {
                $datosEX = $this->M_rcompromisos->datosEX($row['iIdCompromiso']);

                $reporte->getActiveSheet()->SetCellValue('G' . $i, $datosEX);
                
                $a='A'.$i;
                $c='C'.$i;
                
                $f='F'.$i;
                $g='G'.$i;
                $h='H'.$i;
                $y='I'.$i;
                $j='J'.$i;
                $k='K'.$i;
                $l='L'.$i;
                $m='M'.$i;
                $n='N'.$i;
                $o='O'.$i;
                $p='P'.$i;
                $q='Q'.$i;
                $r='R'.$i;
                $s='S'.$i;
                $t='T'.$i;
                $u='U'.$i;
                $e='E'.$i;
                $d='D'.$i;
                $ai='A'.($i-1);
                $b='B'.$i;
                $bi='B'.($i-1);
                $u=$i-1;
                $ci='C'.($i-1);
                $di='D'.($i-1);
                $ei='E'.($i-1);
                $fi='F'.($i-1);
                $gi='G'.($i-1);
                $hi='H'.($i-1);
                $ii='I'.($i-1);
                $ji='J'.($i-1);
                $ki='K'.($i-1);
                $li='L'.($i-1);
                $mi='M'.($i-1);
                $ni='N'.($i-1);
                $oi='O'.($i-1);
                $pi='P'.($i-1);
                $qi='Q'.($i-1);
                $ri='R'.($i-1);
                $si='S'.($i-1);
                $ti='T'.($i-1);
                $ui='U'.($i-1);
               

                $ani = 'A'.$an;
                $bni = 'B'.$bn;
                $cni = 'C'.$cn;
                $dni = 'D3';
                $eni = 'E'.$en;
                $fni = 'F'.$fn;
                $gni = 'G'.$gn;
                $hni = 'H'.$hn;
                $ini = 'I'.$in;
                $jni = 'J'.$jn;
                $kni = 'K'.$kn;
                $lni = 'L'.$ln;
                $mni = 'M'.$mn;
                $nni = 'N'.$nn;
                $oni = 'O'.$on;
                $pni = 'P'.$pn;
                $qni = 'Q'.$qn;
                $rni = 'R'.$rn;
                $sni = 'S'.$sn;
                $tni = 'T'.$tn;
                $uni = 'U'.$un;
                
               
                if($num == '' || $num == null){
                    $num = $row['iNumero'];
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    $an = $i;

                    echo '(va'.$num. ' '. $an.')';
                }elseif($num == $row['iNumero']){
                    
                    //$reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    echo '(si'.$num. ' '. $an. ' '. $ani .' '. $a.')';
                    if($i == ($contador+2)){
                        $reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                    }
                    
                }elseif($row['iNumero'] != $num){
                    $reporte->setActiveSheetIndex()->mergeCells($ani.':'.$ai);
                    $num = '';
                    $num = $row['iNumero'];
                    $an = 0;
                    $an = $i;
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    echo '(no'.$num. ' '. $an.' '. $ai.')';
                }

               
                if($com == '' || $com == null){
                    $com = $row['vCompromiso'];
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                    $bn = $i;

                    echo '(va'.$num. ' '. $an.')';
                }elseif($com == $row['vCompromiso']){
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                if($i == ($contador+2)){
                    $reporte->setActiveSheetIndex()->mergeCells($bni.':'.$b);
                }
                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
            }elseif($row['vCompromiso'] != $com){
                $reporte->setActiveSheetIndex()->mergeCells($bni.':'.$bi);
                $com = '';
                $com = $row['vCompromiso'];
                $bn = 0;
                $bn = $i;
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
            }

            
            if($ncorto == '' || $ncorto == null){
                $ncorto = $row['vNombreCorto'];
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
                $cn = $i;

                echo '(va'.$num. ' '. $an.')';
            }elseif($ncorto == $row['vNombreCorto']){
            $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
            if($i == ($contador+2)){
                $reporte->setActiveSheetIndex()->mergeCells($cni.':'.$c);
            }
            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
        }elseif($row['vNombreCorto'] != $ncorto){
            $reporte->setActiveSheetIndex()->mergeCells($cni.':'.$ci);
                $ncorto = '';
                $ncorto = $row['vNombreCorto'];
                $cn = 0;
                $cn = $i;
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
            }

            $reporte->getActiveSheet()->SetCellValue('D' . $i, $row['vEje']);
            $reporte->getActiveSheet()->SetCellValue('F' . $i, $row['vDependencia']);

            if($tem == '' || $tem == null){
                $tem = $row['vTema'];
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
                $en = $i;

                echo '(va'.$num. ' '. $an.')';
            }elseif($tem == $row['vTema']){
            $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
            if($i == ($contador+2)){
                $reporte->setActiveSheetIndex()->mergeCells($eni.':'.$e);
            }
            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
        }elseif($row['vTema'] != $tem){
            $reporte->setActiveSheetIndex()->mergeCells($eni.':'.$ei);
                $tem = '';
                $tem = $row['vTema'];
                $en = 0;
                $en = $i;
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
            }

            if($porc == '' || $porc == null){
                $porc = $row['dPorcentajeAvance'];
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                $hn = $i;
            }elseif($porc == $row['dPorcentajeAvance']){
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                if($i == ($contador+2)){
                    $reporte->setActiveSheetIndex()->mergeCells($hni.':'.$h);
                }
                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
            }elseif($row['dPorcentajeAvance'] != $porc){
                $reporte->setActiveSheetIndex()->mergeCells($hni.':'.$hi);
                    $porc = '';
                    $porc = $row['dPorcentajeAvance'];
                    $hn = 0;
                    $hn = $i;
                    $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                }

                if($antes == '' || $antes == null){
                    $antes = $row['vAntes'];
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    $in = $i;
                }elseif($antes == $row['vAntes']){
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    if($i == ($contador+2)){
                        $reporte->setActiveSheetIndex()->mergeCells($ini.':'.$y);
                    }
                    //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                }elseif($row['vAntes'] != $antes){
                    $reporte->setActiveSheetIndex()->mergeCells($ini.':'.$ii);
                        $antes = '';
                        $antes = $row['vAntes'];
                        $in = 0;
                        $in = $i;
                        $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    }

                    if($despues == '' || $despues == null){
                        $despues = $row['vDespues'];
                        $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        $jn = $i;
                    }elseif($despues == $row['vDespues']){
                        $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        if($i == ($contador+2)){
                            $reporte->setActiveSheetIndex()->mergeCells($jni.':'.$j);
                        }
                        //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                    }elseif($row['vDespues'] != $despues){
                        $reporte->setActiveSheetIndex()->mergeCells($jni.':'.$ji);
                            $despues = '';
                            $despues = $row['vDespues'];
                            $jn = 0;
                            $jn = $i;
                            $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        }

                        if($fe == '' || $fe == null){
                            $fe = $row['vFeNotarial'];
                            $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            $kn = $i;
                        }elseif($fe == $row['vFeNotarial']){
                            $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            if($i == ($contador+2)){
                                $reporte->setActiveSheetIndex()->mergeCells($kni.':'.$k);
                            }
                            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                        }elseif($row['vFeNotarial'] != $fe){
                            $reporte->setActiveSheetIndex()->mergeCells($kni.':'.$ki);
                                $fe = '';
                                $fe = $row['vFeNotarial'];
                                $kn = 0;
                                $kn = $i;
                                $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            }

                            if($esta == '' || $esta == null){
                                $esta = $row['vEstatus'];
                                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                $ln = $i;
                            }elseif($esta == $row['vEstatus']){
                                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                if($i == ($contador+2)){
                                    $reporte->setActiveSheetIndex()->mergeCells($lni.':'.$l);
                                }
                                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                            }elseif($row['vEstatus'] != $esta){
                                $reporte->setActiveSheetIndex()->mergeCells($lni.':'.$li);
                                    $esta = '';
                                    $esta = $row['vEstatus'];
                                    $ln = 0;
                                    $ln = $i;
                                    $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                }


                                if($icom == '' || $icom == null){
                                    $icom = $row['iIdComponente'];
                                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                                    $mn = $i;
                
                                    echo '(va'.$icom. ' '. $an.')';
                                }elseif($icom == $row['iIdComponente']){
                                    
                                    //$reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                                    if($i == ($contador+2)){
                                        $reporte->setActiveSheetIndex()->mergeCells($mni.':'.$m);
                                    }
                                    echo '(si'.$icom. ' '. $an. ' '. $ani .' '. $a.')';
                                    
                                }elseif($row['iIdComponente'] != $icom){
                                    $reporte->setActiveSheetIndex()->mergeCells($mni.':'.$mi);
                                    $icom = '';
                                    $icom = $row['iIdComponente'];
                                    $mn = 0;
                                    $mn = $i;
                                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                                    echo '(no'.$num. ' '. $an.' '. $ai.')';
                                }

                                if($vcom == '' || $vcom == null){
                                    $vcom = $row['vComponente'];
                                    $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                                    $nn = $i;
                                }elseif($vcom == $row['vComponente']){
                                    $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                                    if($i == ($contador+2)){
                                        $reporte->setActiveSheetIndex()->mergeCells($nni.':'.$n);
                                    }
                                    //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                }elseif($row['vComponente'] != $vcom){
                                    $reporte->setActiveSheetIndex()->mergeCells($nni.':'.$ni);
                                        $vcom = '';
                                        $vcom = $row['vComponente'];
                                        $nn = 0;
                                        $nn = $i;
                                        $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                                    }

                                    if($pon == '' || $pon == null){
                                        $pon = $row['nPonderacion'];
                                        $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                                        $on = $i;
                                    }elseif($pon == $row['nPonderacion']){
                                        $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                                        if($i == ($contador+2)){
                                            $reporte->setActiveSheetIndex()->mergeCells($oni.':'.$o);
                                        }
                                        //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                    }elseif($row['nPonderacion'] != $pon){
                                        $reporte->setActiveSheetIndex()->mergeCells($oni.':'.$oi);
                                            $pon = '';
                                            $pon = $row['nPonderacion'];
                                            $on = 0;
                                            $on = $i;
                                            $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                                        }
                
                
                                        if($av == '' || $av == null){
                                            $av = $row['nAvance'];
                                            $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                                            $pn = $i;
                                        }elseif($av == $row['nAvance']){
                                            $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                                            if($i == ($contador+2)){
                                                $reporte->setActiveSheetIndex()->mergeCells($pni.':'.$p);
                                            }
                                            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                        }elseif($row['nAvance'] != $av){
                                            $reporte->setActiveSheetIndex()->mergeCells($pni.':'.$pi);
                                                $av = '';
                                                $av = $row['nAvance'];
                                                $pn = 0;
                                                $pn = $i;
                                                $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                                            }

                                            if($vev == '' || $vev == null){
                                                $vev = $row['vEvidencia'];
                                                $reporte->getActiveSheet()->SetCellValue('Q' . $i, $row['vEvidencia']);
                                                $qn = $i;
                                            }elseif($vev == $row['vEvidencia']){
                                                $reporte->getActiveSheet()->SetCellValue('Q' . $i, $row['vEvidencia']);
                                                if($i == ($contador+2)){
                                                    $reporte->setActiveSheetIndex()->mergeCells($qni.':'.$q);
                                                }
                                                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                            }elseif($row['vEvidencia'] != $vev){
                                                $reporte->setActiveSheetIndex()->mergeCells($qni.':'.$qi);
                                                    $vev = '';
                                                    $vev = $row['vEvidencia'];
                                                    $qn = 0;
                                                    $qn = $i;
                                                    $reporte->getActiveSheet()->SetCellValue('Q' . $i, $row['vEvidencia']);
                                                }

                                               
                                    
                                                if($tip == '' || $tip == null){
                                                    $tip = $row['vTipo'];
                                                    $reporte->getActiveSheet()->SetCellValue('R' . $i, $row['vTipo']);
                                                    $rn= $i;
                                                }elseif($tip == $row['vTipo']){
                                                    $reporte->getActiveSheet()->SetCellValue('R' . $i, $row['vTipo']);
                                                    if($i == ($contador+2)){
                                                        $reporte->setActiveSheetIndex()->mergeCells($rni.':'.$r);
                                                    }
                                                    //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                                }elseif($row['vTipo'] != $tip){
                                                    $reporte->setActiveSheetIndex()->mergeCells($rni.':'.$ri);
                                                        $tip = '';
                                                        $tip = $row['vTipo'];
                                                        $rn = 0;
                                                        $rn = $i;
                                                        $reporte->getActiveSheet()->SetCellValue('R' . $i, $row['vTipo']);
                                                    }
                                    
                                                if($foto == '' || $foto == null){
                                                    $foto = $row['iFotoInicio'];
                                                    $reporte->getActiveSheet()->SetCellValue('U' . $i, $row['iFotoInicio']);
                                                    $un = $i;
                                                }elseif($foto == $row['iFotoInicio']){
                                                    $reporte->getActiveSheet()->SetCellValue('U' . $i, $row['iFotoInicio']);
                                                    if($i == ($contador+2)){
                                                        $reporte->setActiveSheetIndex()->mergeCells($uni.':'.$u);
                                                    }
                                                    //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                                }elseif($row['iFotoInicio'] != $foto){
                                                    $reporte->setActiveSheetIndex()->mergeCells($uni.':'.$ui);
                                                        $foto = '';
                                                        $foto = $row['iFotoInicio'];
                                                        $un = 0;
                                                        $un = $i;
                                                        $reporte->getActiveSheet()->SetCellValue('U' . $i, $row['iFotoInicio']);
                                                    }
                    
            
            $i++;
            

                
                
            }

            $exe = 'D'.($i-1);
            $exe2 = 'F'.($i-1);
            $reporte->setActiveSheetIndex()->mergeCells('D3:'.$exe);
            $reporte->setActiveSheetIndex()->mergeCells('F3:'.$exe2);
        
            $ruta = 'public/reportes/compromisocc.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
            }
            
            
        }
    }

    public function celdas3(){
        if ($_REQUEST['id']) {
            $eje = $this->input->get('eje',true);
            $dep = $this->input->post('dep',true);

            $response='';
            $contador= '';

            if($eje == '' || $eje == null){
                $response = $this->M_rcompromisos->rcomCABD2();
            $contador = $this->M_rcompromisos->contador2();
            }else{
                $response = $this->M_rcompromisos->rcomCABD($eje, $dep);
            $contador = $this->M_rcompromisos->contador($eje, $dep);
            }

            
            
            if($response == 'no hay datos'){
                echo 0;
            }else{
                $num = '';
            $com ='';
            $ncorto= '';
            $ej = '';
            $tem='';
            $depe='';
            $porc ='';
            $antes='';
            $despues='';
            $fe = '';
            $esta = '';
            $icom = '';
            $vcom = '';
            $pon= '';
            $av = '';
            $vev = '';
            $tip = '';
            $foto ='';

            

            
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/compromisoscc.xls');
            $reporte->setActiveSheetIndex('0');

            //$reporte->getActiveSheet()->SetCellValue('A10', $contador);
            
            $ex=0;
            
            $datosEX = '';
            $a= 0;
            $u=0;
            $i = 3;
            
            $an = 0;
            $bn = 0;
            $cn = 0;
            $dn = 0;
            $en = 0;
            $fn = 0;
            $gn = 0;
            $hn = 0;
            $in = 0;
            $jn = 0;
            $kn = 0;
            $ln = 0;
            $mn = 0;
            $nn = 0;
            $on = 0;
            $pn = 0;
            $qn = 0;
            $rn = 0;
            $sn = 0;
            $tn = 0;
            $un = 0;

            
            
            foreach ($response as $row) {
                $datosEX = $this->M_rcompromisos->datosEX($row['iIdCompromiso']);

                $reporte->getActiveSheet()->SetCellValue('G' . $i, $datosEX);
                
                $a='A'.$i;
                $c='C'.$i;
                
                $f='F'.$i;
                $g='G'.$i;
                $h='H'.$i;
                $y='I'.$i;
                $j='J'.$i;
                $k='K'.$i;
                $l='L'.$i;
                $m='M'.$i;
                $n='N'.$i;
                $o='O'.$i;
                $p='P'.$i;
                $q='Q'.$i;
                $r='R'.$i;
                $s='S'.$i;
                $t='T'.$i;
                $u='U'.$i;
                $e='E'.$i;
                $d='D'.$i;
                $ai='A'.($i-1);
                $b='B'.$i;
                $bi='B'.($i-1);
                $u=$i-1;
                $ci='C'.($i-1);
                $di='D'.($i-1);
                $ei='E'.($i-1);
                $fi='F'.($i-1);
                $gi='G'.($i-1);
                $hi='H'.($i-1);
                $ii='I'.($i-1);
                $ji='J'.($i-1);
                $ki='K'.($i-1);
                $li='L'.($i-1);
                $mi='M'.($i-1);
                $ni='N'.($i-1);
                $oi='O'.($i-1);
                $pi='P'.($i-1);
                $qi='Q'.($i-1);
                $ri='R'.($i-1);
                $si='S'.($i-1);
                $ti='T'.($i-1);
                $ui='U'.($i-1);
               

                $ani = 'A'.$an;
                $bni = 'B'.$bn;
                $cni = 'C'.$cn;
                $dni = 'D3';
                $eni = 'E'.$en;
                $fni = 'F'.$fn;
                $gni = 'G'.$gn;
                $hni = 'H'.$hn;
                $ini = 'I'.$in;
                $jni = 'J'.$jn;
                $kni = 'K'.$kn;
                $lni = 'L'.$ln;
                $mni = 'M'.$mn;
                $nni = 'N'.$nn;
                $oni = 'O'.$on;
                $pni = 'P'.$pn;
                $qni = 'Q'.$qn;
                $rni = 'R'.$rn;
                $sni = 'S'.$sn;
                $tni = 'T'.$tn;
                $uni = 'U'.$un;
                
               
                if($num == '' || $num == null){
                    $num = $row['iNumero'];
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    $an = $i;

                    echo '(va'.$num. ' '. $an.')';
                }elseif($num == $row['iNumero']){
                    
                    //$reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    echo '(si'.$num. ' '. $an. ' '. $ani .' '. $a.')';
                    if($i == ($contador+2)){
                        $reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                    }
                    
                }elseif($row['iNumero'] != $num){
                    $reporte->setActiveSheetIndex()->mergeCells($ani.':'.$ai);
                    $num = '';
                    $num = $row['iNumero'];
                    $an = 0;
                    $an = $i;
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    echo '(no'.$num. ' '. $an.' '. $ai.')';
                }

               
                if($com == '' || $com == null){
                    $com = $row['vCompromiso'];
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                    $bn = $i;

                    echo '(va'.$num. ' '. $an.')';
                }elseif($com == $row['vCompromiso']){
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                if($i == ($contador+2)){
                    $reporte->setActiveSheetIndex()->mergeCells($bni.':'.$b);
                }
                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
            }elseif($row['vCompromiso'] != $com){
                $reporte->setActiveSheetIndex()->mergeCells($bni.':'.$bi);
                $com = '';
                $com = $row['vCompromiso'];
                $bn = 0;
                $bn = $i;
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
            }

            
            if($ncorto == '' || $ncorto == null){
                $ncorto = $row['vNombreCorto'];
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
                $cn = $i;

                echo '(va'.$num. ' '. $an.')';
            }elseif($ncorto == $row['vNombreCorto']){
            $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
            if($i == ($contador+2)){
                $reporte->setActiveSheetIndex()->mergeCells($cni.':'.$c);
            }
            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
        }elseif($row['vNombreCorto'] != $ncorto){
            $reporte->setActiveSheetIndex()->mergeCells($cni.':'.$ci);
                $ncorto = '';
                $ncorto = $row['vNombreCorto'];
                $cn = 0;
                $cn = $i;
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
            }

            $reporte->getActiveSheet()->SetCellValue('D' . $i, $row['vEje']);
            $reporte->getActiveSheet()->SetCellValue('F' . $i, $row['vDependencia']);

            if($tem == '' || $tem == null){
                $tem = $row['vTema'];
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
                $en = $i;

                echo '(va'.$num. ' '. $an.')';
            }elseif($tem == $row['vTema']){
            $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
            if($i == ($contador+2)){
                $reporte->setActiveSheetIndex()->mergeCells($eni.':'.$e);
            }
            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
        }elseif($row['vTema'] != $tem){
            $reporte->setActiveSheetIndex()->mergeCells($eni.':'.$ei);
                $tem = '';
                $tem = $row['vTema'];
                $en = 0;
                $en = $i;
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
            }

            if($porc == '' || $porc == null){
                $porc = $row['dPorcentajeAvance'];
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                $hn = $i;
            }elseif($porc == $row['dPorcentajeAvance']){
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                if($i == ($contador+2)){
                    $reporte->setActiveSheetIndex()->mergeCells($hni.':'.$h);
                }
                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
            }elseif($row['dPorcentajeAvance'] != $porc){
                $reporte->setActiveSheetIndex()->mergeCells($hni.':'.$hi);
                    $porc = '';
                    $porc = $row['dPorcentajeAvance'];
                    $hn = 0;
                    $hn = $i;
                    $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                }

                if($antes == '' || $antes == null){
                    $antes = $row['vAntes'];
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    $in = $i;
                }elseif($antes == $row['vAntes']){
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    if($i == ($contador+2)){
                        $reporte->setActiveSheetIndex()->mergeCells($ini.':'.$y);
                    }
                    //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                }elseif($row['vAntes'] != $antes){
                    $reporte->setActiveSheetIndex()->mergeCells($ini.':'.$ii);
                        $antes = '';
                        $antes = $row['vAntes'];
                        $in = 0;
                        $in = $i;
                        $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    }

                    if($despues == '' || $despues == null){
                        $despues = $row['vDespues'];
                        $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        $jn = $i;
                    }elseif($despues == $row['vDespues']){
                        $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        if($i == ($contador+2)){
                            $reporte->setActiveSheetIndex()->mergeCells($jni.':'.$j);
                        }
                        //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                    }elseif($row['vDespues'] != $despues){
                        $reporte->setActiveSheetIndex()->mergeCells($jni.':'.$ji);
                            $despues = '';
                            $despues = $row['vDespues'];
                            $jn = 0;
                            $jn = $i;
                            $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        }

                        if($fe == '' || $fe == null){
                            $fe = $row['vFeNotarial'];
                            $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            $kn = $i;
                        }elseif($fe == $row['vFeNotarial']){
                            $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            if($i == ($contador+2)){
                                $reporte->setActiveSheetIndex()->mergeCells($kni.':'.$k);
                            }
                            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                        }elseif($row['vFeNotarial'] != $fe){
                            $reporte->setActiveSheetIndex()->mergeCells($kni.':'.$ki);
                                $fe = '';
                                $fe = $row['vFeNotarial'];
                                $kn = 0;
                                $kn = $i;
                                $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            }

                            if($esta == '' || $esta == null){
                                $esta = $row['vEstatus'];
                                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                $ln = $i;
                            }elseif($esta == $row['vEstatus']){
                                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                if($i == ($contador+2)){
                                    $reporte->setActiveSheetIndex()->mergeCells($lni.':'.$l);
                                }
                                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                            }elseif($row['vEstatus'] != $esta){
                                $reporte->setActiveSheetIndex()->mergeCells($lni.':'.$li);
                                    $esta = '';
                                    $esta = $row['vEstatus'];
                                    $ln = 0;
                                    $ln = $i;
                                    $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                }                    
            
            $i++;
            

                
                
            }

            $exe = 'D'.($i-1);
            $exe2 = 'F'.($i-1);
            $reporte->setActiveSheetIndex()->mergeCells('D3:'.$exe);
            $reporte->setActiveSheetIndex()->mergeCells('F3:'.$exe2);
        
            $ruta = 'public/reportes/compromisocc.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
            }
            
            
        }
    }

    public function celdas2(){
        if ($_REQUEST['id']) {
            $eje = $this->input->get('eje',true);
            $dep = $this->input->get('dep',true);


            $response='';
            $contador= '';

            if($eje == '' || $eje == null){
                $response = $this->M_rcompromisos->rcomCABD2();
            $contador = $this->M_rcompromisos->contador2();
            }else{
                $response = $this->M_rcompromisos->rcomCABD($eje, $dep);
            $contador = $this->M_rcompromisos->contador($eje, $dep);
            }

            
            if($response == 'no hay datos'){
                echo 0;
            }else{
                $num = '';
            $com ='';
            $ncorto= '';
            $ej = '';
            $tem='';
            $depe='';
            $porc ='';
            $antes='';
            $despues='';
            $fe = '';
            $esta = '';
            $icom = '';
            $vcom = '';
            $pon= '';
            $av = '';
            $vev = '';
            $tip = '';
            $foto ='';

            

            
            $reporte = new PHPExcel();
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $reporte = $reader->load('public/reportes/compromisoscc.xls');
            $reporte->setActiveSheetIndex('0');

            //$reporte->getActiveSheet()->SetCellValue('A10', $contador);
            
            $ex=0;
            
            $datosEX = '';
            $a= 0;
            $u=0;
            $i = 3;
            
            $an = 0;
            $bn = 0;
            $cn = 0;
            $dn = 0;
            $en = 0;
            $fn = 0;
            $gn = 0;
            $hn = 0;
            $in = 0;
            $jn = 0;
            $kn = 0;
            $ln = 0;
            $mn = 0;
            $nn = 0;
            $on = 0;
            $pn = 0;
            $qn = 0;
            $rn = 0;
            $sn = 0;
            $tn = 0;
            $un = 0;

            
            
            foreach ($response as $row) {
                $datosEX = $this->M_rcompromisos->datosEX($row['iIdCompromiso']);

                $reporte->getActiveSheet()->SetCellValue('G' . $i, $datosEX);
                
                $a='A'.$i;
                $c='C'.$i;
                
                $f='F'.$i;
                $g='G'.$i;
                $h='H'.$i;
                $y='I'.$i;
                $j='J'.$i;
                $k='K'.$i;
                $l='L'.$i;
                $m='M'.$i;
                $n='N'.$i;
                $o='O'.$i;
                $p='P'.$i;
                $q='Q'.$i;
                $r='R'.$i;
                $s='S'.$i;
                $t='T'.$i;
                $u='U'.$i;
                $e='E'.$i;
                $d='D'.$i;
                $ai='A'.($i-1);
                $b='B'.$i;
                $bi='B'.($i-1);
                $u=$i-1;
                $ci='C'.($i-1);
                $di='D'.($i-1);
                $ei='E'.($i-1);
                $fi='F'.($i-1);
                $gi='G'.($i-1);
                $hi='H'.($i-1);
                $ii='I'.($i-1);
                $ji='J'.($i-1);
                $ki='K'.($i-1);
                $li='L'.($i-1);
                $mi='M'.($i-1);
                $ni='N'.($i-1);
                $oi='O'.($i-1);
                $pi='P'.($i-1);
                $qi='Q'.($i-1);
                $ri='R'.($i-1);
                $si='S'.($i-1);
                $ti='T'.($i-1);
                $ui='U'.($i-1);
               

                $ani = 'A'.$an;
                $bni = 'B'.$bn;
                $cni = 'C'.$cn;
                $dni = 'D3';
                $eni = 'E'.$en;
                $fni = 'F'.$fn;
                $gni = 'G'.$gn;
                $hni = 'H'.$hn;
                $ini = 'I'.$in;
                $jni = 'J'.$jn;
                $kni = 'K'.$kn;
                $lni = 'L'.$ln;
                $mni = 'M'.$mn;
                $nni = 'N'.$nn;
                $oni = 'O'.$on;
                $pni = 'P'.$pn;
                $qni = 'Q'.$qn;
                $rni = 'R'.$rn;
                $sni = 'S'.$sn;
                $tni = 'T'.$tn;
                $uni = 'U'.$un;
                
               
                if($num == '' || $num == null){
                    $num = $row['iNumero'];
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    $an = $i;

                    echo '(va'.$num. ' '. $an.')';
                }elseif($num == $row['iNumero']){
                    
                    //$reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    echo '(si'.$num. ' '. $an. ' '. $ani .' '. $a.')';
                    if($i == ($contador+2)){
                        $reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                    }
                    
                }elseif($row['iNumero'] != $num){
                    $reporte->setActiveSheetIndex()->mergeCells($ani.':'.$ai);
                    $num = '';
                    $num = $row['iNumero'];
                    $an = 0;
                    $an = $i;
                    $reporte->getActiveSheet()->SetCellValue('A' . $i, $row['iNumero']);
                    echo '(no'.$num. ' '. $an.' '. $ai.')';
                }

               
                if($com == '' || $com == null){
                    $com = $row['vCompromiso'];
                    $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                    $bn = $i;

                    echo '(va'.$num. ' '. $an.')';
                }elseif($com == $row['vCompromiso']){
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
                if($i == ($contador+2)){
                    $reporte->setActiveSheetIndex()->mergeCells($bni.':'.$b);
                }
                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
            }elseif($row['vCompromiso'] != $com){
                $reporte->setActiveSheetIndex()->mergeCells($bni.':'.$bi);
                $com = '';
                $com = $row['vCompromiso'];
                $bn = 0;
                $bn = $i;
                $reporte->getActiveSheet()->SetCellValue('B' . $i, $row['vCompromiso']);
            }

            
            if($ncorto == '' || $ncorto == null){
                $ncorto = $row['vNombreCorto'];
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
                $cn = $i;

                echo '(va'.$num. ' '. $an.')';
            }elseif($ncorto == $row['vNombreCorto']){
            $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
            if($i == ($contador+2)){
                $reporte->setActiveSheetIndex()->mergeCells($cni.':'.$c);
            }
            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
        }elseif($row['vNombreCorto'] != $ncorto){
            $reporte->setActiveSheetIndex()->mergeCells($cni.':'.$ci);
                $ncorto = '';
                $ncorto = $row['vNombreCorto'];
                $cn = 0;
                $cn = $i;
                $reporte->getActiveSheet()->SetCellValue('C' . $i, $row['vNombreCorto']);
            }

            $reporte->getActiveSheet()->SetCellValue('D' . $i, $row['vEje']);
            $reporte->getActiveSheet()->SetCellValue('F' . $i, $row['vDependencia']);

            if($tem == '' || $tem == null){
                $tem = $row['vTema'];
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
                $en = $i;

                echo '(va'.$num. ' '. $an.')';
            }elseif($tem == $row['vTema']){
            $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
            if($i == ($contador+2)){
                $reporte->setActiveSheetIndex()->mergeCells($eni.':'.$e);
            }
            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
        }elseif($row['vTema'] != $tem){
            $reporte->setActiveSheetIndex()->mergeCells($eni.':'.$ei);
                $tem = '';
                $tem = $row['vTema'];
                $en = 0;
                $en = $i;
                $reporte->getActiveSheet()->SetCellValue('E' . $i, $row['vTema']);
            }

            if($porc == '' || $porc == null){
                $porc = $row['dPorcentajeAvance'];
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                $hn = $i;
            }elseif($porc == $row['dPorcentajeAvance']){
                $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                if($i == ($contador+2)){
                    $reporte->setActiveSheetIndex()->mergeCells($hni.':'.$h);
                }
                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
            }elseif($row['dPorcentajeAvance'] != $porc){
                $reporte->setActiveSheetIndex()->mergeCells($hni.':'.$hi);
                    $porc = '';
                    $porc = $row['dPorcentajeAvance'];
                    $hn = 0;
                    $hn = $i;
                    $reporte->getActiveSheet()->SetCellValue('H' . $i, $row['dPorcentajeAvance']);
                }

                if($antes == '' || $antes == null){
                    $antes = $row['vAntes'];
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    $in = $i;
                }elseif($antes == $row['vAntes']){
                    $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    if($i == ($contador+2)){
                        $reporte->setActiveSheetIndex()->mergeCells($ini.':'.$y);
                    }
                    //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                }elseif($row['vAntes'] != $antes){
                    $reporte->setActiveSheetIndex()->mergeCells($ini.':'.$ii);
                        $antes = '';
                        $antes = $row['vAntes'];
                        $in = 0;
                        $in = $i;
                        $reporte->getActiveSheet()->SetCellValue('I' . $i, $row['vAntes']);
                    }

                    if($despues == '' || $despues == null){
                        $despues = $row['vDespues'];
                        $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        $jn = $i;
                    }elseif($despues == $row['vDespues']){
                        $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        if($i == ($contador+2)){
                            $reporte->setActiveSheetIndex()->mergeCells($jni.':'.$j);
                        }
                        //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                    }elseif($row['vDespues'] != $despues){
                        $reporte->setActiveSheetIndex()->mergeCells($jni.':'.$ji);
                            $despues = '';
                            $despues = $row['vDespues'];
                            $jn = 0;
                            $jn = $i;
                            $reporte->getActiveSheet()->SetCellValue('J' . $i, $row['vDespues']);
                        }

                        if($fe == '' || $fe == null){
                            $fe = $row['vFeNotarial'];
                            $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            $kn = $i;
                        }elseif($fe == $row['vFeNotarial']){
                            $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            if($i == ($contador+2)){
                                $reporte->setActiveSheetIndex()->mergeCells($kni.':'.$k);
                            }
                            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                        }elseif($row['vFeNotarial'] != $fe){
                            $reporte->setActiveSheetIndex()->mergeCells($kni.':'.$ki);
                                $fe = '';
                                $fe = $row['vFeNotarial'];
                                $kn = 0;
                                $kn = $i;
                                $reporte->getActiveSheet()->SetCellValue('K' . $i, $row['vFeNotarial']);
                            }

                            if($esta == '' || $esta == null){
                                $esta = $row['vEstatus'];
                                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                $ln = $i;
                            }elseif($esta == $row['vEstatus']){
                                $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                if($i == ($contador+2)){
                                    $reporte->setActiveSheetIndex()->mergeCells($lni.':'.$l);
                                }
                                //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                            }elseif($row['vEstatus'] != $esta){
                                $reporte->setActiveSheetIndex()->mergeCells($lni.':'.$li);
                                    $esta = '';
                                    $esta = $row['vEstatus'];
                                    $ln = 0;
                                    $ln = $i;
                                    $reporte->getActiveSheet()->SetCellValue('L' . $i, $row['vEstatus']);
                                }


                                if($icom == '' || $icom == null){
                                    $icom = $row['iIdComponente'];
                                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                                    $mn = $i;
                
                                    echo '(va'.$icom. ' '. $an.')';
                                }elseif($icom == $row['iIdComponente']){
                                    
                                    //$reporte->setActiveSheetIndex()->mergeCells($ani.':'.$a);
                                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                                    if($i == ($contador+2)){
                                        $reporte->setActiveSheetIndex()->mergeCells($mni.':'.$m);
                                    }
                                    echo '(si'.$icom. ' '. $an. ' '. $ani .' '. $a.')';
                                    
                                }elseif($row['iIdComponente'] != $icom){
                                    $reporte->setActiveSheetIndex()->mergeCells($mni.':'.$mi);
                                    $icom = '';
                                    $icom = $row['iIdComponente'];
                                    $mn = 0;
                                    $mn = $i;
                                    $reporte->getActiveSheet()->SetCellValue('M' . $i, $row['iIdComponente']);
                                    echo '(no'.$num. ' '. $an.' '. $ai.')';
                                }

                                if($vcom == '' || $vcom == null){
                                    $vcom = $row['vComponente'];
                                    $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                                    $nn = $i;
                                }elseif($vcom == $row['vComponente']){
                                    $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                                    if($i == ($contador+2)){
                                        $reporte->setActiveSheetIndex()->mergeCells($nni.':'.$n);
                                    }
                                    //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                }elseif($row['vComponente'] != $vcom){
                                    $reporte->setActiveSheetIndex()->mergeCells($nni.':'.$ni);
                                        $vcom = '';
                                        $vcom = $row['vComponente'];
                                        $nn = 0;
                                        $nn = $i;
                                        $reporte->getActiveSheet()->SetCellValue('N' . $i, $row['vComponente']);
                                    }

                                    if($pon == '' || $pon == null){
                                        $pon = $row['nPonderacion'];
                                        $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                                        $on = $i;
                                    }elseif($pon == $row['nPonderacion']){
                                        $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                                        if($i == ($contador+2)){
                                            $reporte->setActiveSheetIndex()->mergeCells($oni.':'.$o);
                                        }
                                        //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                    }elseif($row['nPonderacion'] != $pon){
                                        $reporte->setActiveSheetIndex()->mergeCells($oni.':'.$oi);
                                            $pon = '';
                                            $pon = $row['nPonderacion'];
                                            $on = 0;
                                            $on = $i;
                                            $reporte->getActiveSheet()->SetCellValue('O' . $i, $row['nPonderacion']);
                                        }
                
                
                                        if($av == '' || $av == null){
                                            $av = $row['nAvance'];
                                            $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                                            $pn = $i;
                                        }elseif($av == $row['nAvance']){
                                            $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                                            if($i == ($contador+2)){
                                                $reporte->setActiveSheetIndex()->mergeCells($pni.':'.$p);
                                            }
                                            //$reporte->setActiveSheetIndex()->mergeCells($bi.':'.$b);
                                        }elseif($row['nAvance'] != $av){
                                            $reporte->setActiveSheetIndex()->mergeCells($pni.':'.$pi);
                                                $av = '';
                                                $av = $row['nAvance'];
                                                $pn = 0;
                                                $pn = $i;
                                                $reporte->getActiveSheet()->SetCellValue('P' . $i, $row['nAvance']);
                                            }
                    
            
            $i++;
            

                
                
            }

            $exe = 'D'.($i-1);
            $exe2 = 'F'.($i-1);
            $reporte->setActiveSheetIndex()->mergeCells('D3:'.$exe);
            $reporte->setActiveSheetIndex()->mergeCells('F3:'.$exe2);
        
            $ruta = 'public/reportes/compromisocc.xls';
            $imprimir = PHPExcel_IOFactory::createWriter($reporte, 'Excel2007');
            $imprimir->save($ruta);
            echo 'we';
            }
            
            
        }
    }
}
?>