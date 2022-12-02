<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class C_logs extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('funciones');
        $this->load->model('M_logs', 'ml');
        $this->load->model('M_pat', 'mpat');
        $this->load->model('M_seguridad', 'mseg');
        $this->load->model('M_entregables','me');
        $this->load->library('Class_seguridad');
        $this->load->library('Class_options');
    }
    public function index(){
        $data['logs'] = $this->ml->obtenerLogs();

        $this->load->view('Logs/index', $data);
    }

    public function obtenerCambios(){
        $id = $this->input->post('id',true);
        //$cambios = $this->ml->obtenerCambios();
    }

    public function detalle(){
        $id = $this->input->post('id',true);
        $cambios = $this->ml->obtenerCambios($id);

        /**
         * Aqui va todo
         */
        $tipo = $cambios->iTipoCambio;
        if($tipo == 'Indicador'){
            $datosAntes = $this->ml->obtenerAntesIndicador($cambios->iIdCambio);
        }
        if($tipo == 'Acción'){
            $datosAntes = $this->ml->obtenerAntesAccion($cambios->iIdCambio);
        }
        $antes = json_decode($cambios->iAntesCambio);
        $despues = json_decode($cambios->iDespuesCambio);
        $result ='';
        $arrayAntes = array();
        $colum = array();
        $arraySoloValores = array();
        $arraySoloLlaves = array();
        $valorFinal = array();
        $antes ->  datosAntes = $datosAntes;
     
        
       
        if($tipo == 'Acción'){
            //dependencia antes
            if(!empty($despues->iIdDependencia))
            {
                $dep = $this->ml->obtenerDependencia($antes->iIdDependencia);
                $antes->depen = $dep[0]->vDependencia;
               
            }else{
                $antes->depen = 'sin cambios'; 
            }
            //dependencia despues
            if(!empty($antes->iIdDependencia))
            {
                $dep = $this->ml->obtenerDependencia($despues->iIdDependencia);
                $despues->depen1 = $dep[0]->vDependencia;
              
            }else{
                $antes->depen1 = 'sin cambios'; 
            }


            //dependencia despues
            if(!empty($despues->iIdProyectoPrioritario))
            {
                $proypri = $this->ml->obtenerProyPri($despues->iIdProyectoPrioritario);
                $despues->prioritario = $proypri[0]->vProyectoPrioritario;
            }else{
                $despues->prioritario = '----'; 
                //dependencia antes
            }
            if(!empty($antes->iIdProyectoPrioritario))
            {
                $proypri = $this->ml->obtenerProyPri($antes->iIdProyectoPrioritario);
                $antes->prioritario = $proypri[0]->vProyectoPrioritario;
            }else{
                $antes->prioritario = '----'; 
            }
          
          
            
            
            if(!empty($despues->vResumenNarrativo) && $despues->vResumenNarrativo != '.'){
            $vRN = $this->ml->obtenerResumenNarrativo($despues->vResumenNarrativo);
            $antes-> resumen =  $vRN[0]->vNombreResumenNarrativo;
             }else{
            $antes->resumen = 'sin cambios'; 
            }
            if(!empty($antes->vResumenNarrativo) && $antes->vResumenNarrativo != '.'){
                $vRN = $this->ml->obtenerResumenNarrativo($antes->vResumenNarrativo);
                $despues-> resumen =  $vRN[0]->vNombreResumenNarrativo;
                 }else{
                $despues->resumen = 'sin cambios'; 
                }
           
            if(!empty($despues->iIdNivelMIR)){
                $mir = $this->ml->obtenerMIR($despues->iIdNivelMIR);
                $antes->mir =  $mir[0]->vNivelMIR;
            }else{
                $antes->mir = 'sin cambios'; 
            }
            if(!empty($antes->iIdNivelMIR)){
                $mir = $this->ml->obtenerMIR($antes->iIdNivelMIR);
                $despues->mir =  $mir[0]->vNivelMIR;
            }else{
                $despues->mir = 'sin cambios'; 
            }


            if(!empty($despues->iideje)){
                $eje = $this->ml->obtenerEje($despues->iideje);
                $antes->ejes =  $eje[0]->vEje;
            }else{
                $antes->ejes = 'sin cambios'; 
            }
            if(!empty($antes->iideje)){
                $eje = $this->ml->obtenerEje($antes->iideje);
                $despues->ejes =  $eje[0]->vEje;
            }else{
                $despues->ejes = 'sin cambios'; 
            }


            if(!empty($despues->iReto)){
                $reto = $this->ml->obtenerReto($despues->iReto);
                $antes->reto =  $reto[0]->vDescripcion;
            }else{
                $antes->reto = 'sin cambios'; 
            }
            if(!empty($antes->iReto)){
                $reto = $this->ml->obtenerReto($antes->iReto);
                $despues->reto =  $reto[0]->vDescripcion;
            }else{
                $despues->reto = 'sin cambios'; 
            }


            if(!empty($despues->vResponsable) && $despues->vResponsable != '.'){
                $arearesp = $this->ml->obtenerAreaResp($despues->vResponsable);
                $antes->resp =  $arearesp[0]->vAreaResponsable;
            }else{
                $antes->resp = 'sin cambios'; 
            }
            if(!empty($antes->vResponsable) && $antes->vResponsable != '.'){
                $arearesp = $this->ml->obtenerAreaResp($despues->vResponsable);
                $despues->resp =  $arearesp[0]->vAreaResponsable;
            }else{
                $despues->resp = 'sin cambios'; 
            }


            if(!empty($despues->iODS)){
                $ods = $this->ml->obternerODS($despues->iODS);
                $antes->ods =  $ods[0]->vOds;
            }else{
                $antes->ods = 'sin cambios'; 
            }
            if(!empty($antes->iODS)){
                $ods = $this->ml->obternerODS($antes->iODS);
                $despues->ods =  $ods[0]->vOds;
            }else{
                $despues->ods = 'sin cambios'; 
            }
             //Datos Antes
            array_push($arraySoloValores, $antes->vActividad);
            array_push($arraySoloValores, $antes->vDescripcion);
            array_push($arraySoloValores, $antes->prioritario);
            array_push($arraySoloValores, $antes->dInicio);
            array_push($arraySoloValores, $antes->dFin);
            array_push($arraySoloValores, $antes->ejes);
            array_push($arraySoloValores, $antes->depen);
            array_push($arraySoloValores, $antes->ods);
            array_push($arraySoloValores, $antes->reto);
            array_push($arraySoloValores, $antes->resp);
            array_push($arraySoloValores, $antes->vObjetivo);
            array_push($arraySoloValores, $antes->vEstrategia);
            array_push($arraySoloValores, $antes->vtipoactividad);
            array_push($arraySoloValores, $antes->iAutorizado);
            array_push($arraySoloValores, $antes->iIncluyeMIR);
            array_push($arraySoloValores, $antes->mir);
            array_push($arraySoloValores, $antes->iAglomeraMIR);
            array_push($arraySoloValores, $antes->programapresu);
            array_push($arraySoloValores, $antes->resumen);
            array_push($arraySoloValores, $antes->vSupuesto);
            array_push($arraySoloValores, $antes->vJustificaCambio);
        
            //Datos Despúes 
            array_push($valorFinal, $despues->vActividad);
            array_push($valorFinal, $despues->vDescripcion);
            array_push($valorFinal, $despues->prioritario);
            array_push($valorFinal, $despues->dInicio);
            array_push($valorFinal, $despues->dFin);
            array_push($valorFinal, $despues->ejes);
            array_push($valorFinal, $despues->depen1);
            array_push($valorFinal, $despues->ods);
            array_push($valorFinal, $despues->reto);
            array_push($valorFinal, $despues->resp);
            array_push($valorFinal, $despues->vObjetivo);
            array_push($valorFinal, $despues->vEstrategia);
            array_push($valorFinal, $despues->vtipoactividad);
            array_push($valorFinal, $despues->iAutorizado);
            array_push($valorFinal, $despues->iIncluyeMIR);
            array_push($valorFinal, $despues->mir);
            array_push($valorFinal, $despues->iAglomeraMIR);
            array_push($valorFinal, $despues->presu);
            array_push($valorFinal, $despues->resumen);
            array_push($valorFinal, $despues->vSupuesto);
            array_push($valorFinal, $despues->vJustificaCambio);
        
    //columna indicador
            array_push($arraySoloLlaves, 'Nombre de la acción');
            array_push($arraySoloLlaves, 'Descripción');
            array_push($arraySoloLlaves, 'proyecto prioritario');
            array_push($arraySoloLlaves,'Fecha de inicio');
            array_push($arraySoloLlaves, 'Fecha Fin');
            array_push($arraySoloLlaves, 'eje rector');
            array_push($arraySoloLlaves, 'Dependencia');
            array_push($arraySoloLlaves, 'ODS');
            array_push($arraySoloLlaves, 'Reto');
            array_push($arraySoloLlaves, 'Area Responsable');
            array_push($arraySoloLlaves, 'Objetivo Anual');
            array_push($arraySoloLlaves, 'Estrategia');
            array_push($arraySoloLlaves, 'Tipo de Acción');
            array_push($arraySoloLlaves, 'Monto Autorizado');
            array_push($arraySoloLlaves, 'Incluye MIR');
            array_push($arraySoloLlaves, 'Nivel MIR');
            array_push($arraySoloLlaves, 'tiene aglomeración');
            array_push($arraySoloLlaves, 'Programa Presupuestario');
            array_push($arraySoloLlaves, 'Resumen Narrativo');
            array_push($arraySoloLlaves, 'Supuesto');
            array_push($arraySoloLlaves, 'Justificación del Cambio');

    }
    if($tipo == 'Indicador'){
    
            
        if(!empty($antes->iIdPeriodicidad)){
            $rsp = $this->ml->obtenerPeriodicidad($antes->iIdPeriodicidad);
            $antes->Periodicidad =  $rsp[0]->vPeriodicidad;
        }else{
            $antes->Periodicidad = 'sin cambios'; 
        }
             
        if(!empty($despues->iIdPeriodicidad)){
            $rsp = $this->ml->obtenerPeriodicidad($despues->iIdPeriodicidad);
            $despues->Periodicidad =  $rsp[0]->vPeriodicidad;
        }else{
            $despues->Periodicidad = 'sin cambios'; 
        }


        if(!empty($antes->iIdProgramaPresupuestario)){
            $progpres = $this->ml->obtenerProgramaPresu($antes->iIdProgramaPresupuestario);
            $antes->presu =  $progpres[0]->vProgramaPresupuestario;
        }else{
            $antes->presu = 'sin cambios'; 
        }


        if(!empty($antes->iIdFormaInd)){
            $rsp = $this->ml->obtenerFormaInd($antes->iIdFormaInd);
            $antes->fomaind = $rsp[0]->vDescripcion;
        }else{
            $antes->fomaind = 'sin cambios'; 
        }
        if(!empty($despues->iIdFormaInd)){
            $rsp = $this->ml->obtenerFormaInd($despues->iIdFormaInd);
            $despues->fomaind = $rsp[0]->vDescripcion;
        }else{
            $despues->fomaind = 'sin cambios'; 
        }


        if(!empty($antes->iIdDimensionInd)){
            $rsp = $this->ml->obtenerDimenInd($antes->iIdDimensionInd);
            $antes->dimenind= $rsp[0]->vDescripcion;
        }else{
            $antes->dimenind= 'sin cambios'; 
        }
        if(!empty($despues->iIdDimensionInd)){
            $rsp = $this->ml->obtenerDimenInd($despues->iIdDimensionInd);
            $despues->dimenind= $rsp[0]->vDescripcion;
        }else{
            $despues->dimenind= 'sin cambios'; 
        }


        if(!empty($antes->iIdUnidadMedida)){
            $rsp = $this->ml->obtenerUnidadMedida($antes->iIdUnidadMedida);
            $antes->Unidadmedida= $rsp[0]->vUnidadMedida;
        }else{
            $antes->Unidadmedida= 'sin cambios'; 
        }
        if(!empty($despues->iIdUnidadMedida)){
            $rsp = $this->ml->obtenerUnidadMedida($despues->iIdUnidadMedida);
            $despues->Unidadmedida= $rsp[0]->vUnidadMedida;
        }else{
            $despues->Unidadmedida= 'sin cambios'; 
        }

        if(!empty($antes->vResumenNarrativo) && $antes->vResumenNarrativo != '.'){
            $vRN = $this->ml->obtenerResumenNarrativo($antes->vResumenNarrativo);
            $antes->ResumenNarrativo =  $vRN[0]->vNombreResumenNarrativo;
        }else{
            $antes-> ResumenNarrativo = 'sin cambios'; 
        }

        
        if(!empty($antes->iAcumulativo) && $antes->iAcumulativo == 1){
            $antes->Acumulativo =  'Acumulativo';
        }elseif(!empty($antes->iAcumulativo) && $antes->iAcumulativo == 2){
            $antes->Puntual =  'Puntual';
        }
        else{
            $antes-> Acumulativo= 'sin cambios'; 
            $antes-> Puntual= 'sin cambios'; 
        }

       

//datos antes indicador 
    array_push($arraySoloValores, $antes->vEntregable);
    array_push($arraySoloValores, $antes->fomaind);
    array_push($arraySoloValores, $antes->dimenind);
    array_push($arraySoloValores, $antes->nLineaBase);
    array_push($arraySoloValores, $antes->vMedioVerifica);
    array_push($arraySoloValores, $antes->vFormula);
    array_push($arraySoloValores, $antes->nMeta);
    array_push($arraySoloValores, $antes->Unidadmedida);
    array_push($arraySoloValores, $antes->Periodicidad);
    array_push($arraySoloValores, $antes->Acumulativo);
    array_push($arraySoloValores, $antes->dFechaInicio);
    array_push($arraySoloValores, $antes->dFechaFin);

      
   //datos despues indicador 
   array_push($valorFinal, $despues->vEntregable);
   array_push($valorFinal, $despues->fomaind);
   array_push($valorFinal, $despues->dimenind);
   array_push($valorFinal, $despues->nLineaBase);
   array_push($valorFinal, $despues->vMedioVerifica);
   array_push($valorFinal, $despues->vFormula);
   array_push($valorFinal, $despues->nMeta);
   array_push($valorFinal, $despues->Unidadmedida);
   array_push($valorFinal, $despues->Periodicidad);
   array_push($valorFinal, $despues->iAcumulativo);
   array_push($valorFinal, $despues->dFechaInicio);
   array_push($valorFinal, $despues->dFechaFin);

    //columna indicador
    array_push($colum , 'Nombre del indicador');
    array_push($colum , 'Forma indicador');
    array_push($colum , 'Dimensión');
    array_push($colum ,'Base indicador');
    array_push($colum , 'Medio de verificación');
    array_push($colum , 'Calculo de la variable');
    array_push($colum , 'Meta');
    array_push($colum , 'Unidad de medida');
    array_push($colum , 'periocidad');
    array_push($colum , 'tipo');
    array_push($colum , 'fecha de inicio');
    array_push($colum , 'fecha final');


    }
  

       /* if($tipo == 'Acción'){

            foreach($antes as $key => $d)
           { 
                switch ($key) {
                    
                    case 'iIdDependencia':
                        if(!empty($despues->iIdDependencia)){
                            $dep = $this->ml->obtenerDependencia($despues->iIdDependencia);
                            array_push($arraySoloValores, $dep[0]->vDependencia);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iIdProyectoPrioritario':
                        if(!empty($despues->iIdProyectoPrioritario)){
                            $proypri = $this->ml->obtenerProyPri($despues->iIdProyectoPrioritario);
                            array_push($arraySoloValores, $proypri[0]->vProyectoPrioritario);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'vResumenNarrativo':
                        if(!empty($despues->vResumenNarrativo) && $despues->vResumenNarrativo != '.'){
                            $vRN = $this->ml->obtenerResumenNarrativo($despues->vResumenNarrativo);
                            array_push($arraySoloValores, $vRN[0]->vNombreResumenNarrativo);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iIdProgramaPresupuestario':
                        if(!empty($despues->iIdProgramaPresupuestario)){
                            $progpres = $this->ml->obtenerProgramaPresu($despues->iIdProgramaPresupuestario);
                            array_push($arraySoloValores, $progpres[0]->vProgramaPresupuestario);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iIdNivelMIR':
                        if(!empty($despues->iIdNivelMIR)){
                            $mir = $this->ml->obtenerMIR($despues->iIdNivelMIR);
                            array_push($arraySoloValores, $mir[0]->vNivelMIR);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iideje':
                        if(!empty($despues->iideje)){
                            $eje = $this->ml->obtenerEje($despues->iideje);
                            array_push($arraySoloValores, $eje[0]->vEje);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iReto':
                        if(!empty($despues->iReto)){
                            $reto = $this->ml->obtenerReto($despues->iReto);
                            array_push($arraySoloValores, $reto[0]->vDescripcion);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                        
                    case 'vResponsable':
                        if(!empty($despues->vResponsable) && $despues->vResponsable != '.'){
                            $arearesp = $this->ml->obtenerAreaResp($despues->vResponsable);
                            array_push($arraySoloValores, $arearesp[0]->vAreaResponsable);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
    
                    case 'iODS':
                        if(!empty($despues->iODS)){
                            $ods = $this->ml->obternerODS($despues->iODS);
                            array_push($arraySoloValores, $ods[0]->vOds);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                    
                    default:
                        array_push($arraySoloValores, $d);
                        break;
                }
            }

            foreach($datosDespues[0] as $key => $k){
                array_push($arraySoloLlaves, $key);
            
            }
    
            foreach($arraySoloLlaves as $key => $llave){
                $valorFinal[$llave] = $arraySoloValores[$key];
           
            }
        }

        if($tipo == 'Indicador'){

            foreach($valorFinal as $key => $d){
                switch ($key) {
                    case 'iIdPeriodicidad':
                        if(!empty($antes->iIdPeriodicidad)){
                            $rsp = $this->ml->obtenerPeriodicidad($antes->iIdPeriodicidad);
                            array_push($arraySoloValores, $rsp[0]->vPeriodicidad);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                        case 'iIdProgramaPresupuestario':
                            if(!empty($antes->iIdProgramaPresupuestario)){
                                $progpres = $this->ml->obtenerProgramaPresu($antes->iIdProgramaPresupuestario);
                                array_push($arraySoloValores, $progpres[0]->vProgramaPresupuestario);
                            }else{
                                array_push($arraySoloValores, $d);
                            }
                            break;
                    case 'iIdFormaInd':
                        if(!empty($antes->iIdFormaInd)){
                            $rsp = $this->ml->obtenerFormaInd($antes->iIdFormaInd);
                            array_push($arraySoloValores, $rsp[0]->vDescripcion);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;

                    case 'iIdDimensionInd':
                        if(!empty($antes->iIdDimensionInd)){
                            $rsp = $this->ml->obtenerDimenInd($antes->iIdDimensionInd);
                            array_push($arraySoloValores, $rsp[0]->vDescripcion);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                    
                    case 'iIdUnidadMedida':
                        if(!empty($antes->iIdUnidadMedida)){
                            $rsp = $this->ml->obtenerUnidadMedida($antes->iIdUnidadMedida);
                            array_push($arraySoloValores, $rsp[0]->vUnidadMedida);
                        }else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                    case 'iAcumulativo':
                        if(!empty($antes->iAcumulativo) && $antes->iAcumulativo == 1){
                            array_push($arraySoloValores, 'Acumulativo');
                        }elseif(!empty($antes->iAcumulativo) && $antes->iAcumulativo == 2){
                            array_push($arraySoloValores, 'Puntual');
                        }
                        else{
                            array_push($arraySoloValores, $d);
                        }
                        break;
                        case 'vResumenNarrativo':
                            if(!empty($antes->vResumenNarrativo) && $antes->vResumenNarrativo != '.'){
                                $vRN = $this->ml->obtenerResumenNarrativo($antes->vResumenNarrativo);
                                array_push($arraySoloValores, $vRN[0]->vNombreResumenNarrativo);
                            }else{
                                array_push($arraySoloValores, $d);
                            }
                            break;

                    default:
                        array_push($arraySoloValores, $d);
                        break;
                }
            }
            foreach($datosAntes[0] as $key => $k){
                array_push($arraySoloLlaves, $key);
            }
    
            foreach($arraySoloLlaves as $key => $llave){
                $valorFinal[$llave] = $arraySoloValores[$key];
             
            }
            
        }*/

       switch ($tipo) {
            case 'Indicador':
                # code...
                for($i=0; $i<count($arraySoloValores); $i++){
                    if($arraySoloValores[$i] != $valorFinal[$i]){
                        $result .= '
                                <tr>
                                
                                <td ><p>'.$colum[$i].'</p></td>
                                <td ><p style="background-color: rgba(248,81,73,0.4);">'.$arraySoloValores[$i].'</p></td>
                                <td><p style="background-color: rgba(46,160,67,0.4);">'.$valorFinal[$i].'</p></td>
                                </tr>';
                    }else{
                        $result .= '
                            <tr> 
                            <td ><p >'.$colum[$i].'</p></td> 
                            <td>'.$arraySoloValores[$i].'</td>
                            <td>'.$valorFinal[$i].'</td></tr>';
                    }
                }
            

                break;
            
            case 'Acción':
                # code...

                /*foreach($datosDespues[0] as $key => $value ){

                    // $result =$antes[$key];
                
                    if($value != $valorFinal[$key]){
                        $result .= '
                                <tr>
                                <td ><p >'.$key.'</p></td>
                                <td ><p style="background-color: rgba(46,160,67,0.4);">'.$value.'</p></td>
                                <td><p style="background-color: rgba(248,81,73,0.4);">'.$valorFinal[$key].'</p></td>
                                </tr>';
                    }else{
                        $result .= '
                            <tr> 
                            <td ><p >'.$key.'</p></td>
                            <td>'.$value.'</td>
                            <td>'.$valorFinal[$key].'</td></tr>';
                    }
                    // var_dump($despues);
                    // var_dump($antes);

                }*/
              
                for($i=0; $i<count($arraySoloValores); $i++){
                    if($arraySoloValores[$i] != $valorFinal[$i]){
                        $result .= '
                                <tr>
                                <td ><p>'.$arraySoloLlaves[$i].'</p></td>
                                <td ><p style="background-color: rgba(248,81,73,0.4);">'.$arraySoloValores[$i].'</p></td>
                                <td><p style="background-color: rgba(46,160,67,0.4);">'.$valorFinal[$i].'</p></td>
                                </tr>';
                    }else{
                        $result .= '
                            <tr> 
                            <td ><p >'.$arraySoloLlaves[$i].'</p></td>
                            <td>'.$arraySoloValores[$i].'</td>
                            <td>'.$valorFinal[$i].'</td></tr>';
                    }
                }
            

                break;
            
            default:
                # code...
                break;
        }
        $data['tipo'] = $tipo;
        $data['cambios'] = $result;
        $data['antes'] = $arraySoloValores;
        $data['key'] = $key;
        $this->load->view('Logs/detalle', $data);
    }
    public function aprobarCambios(){
        $id = $this->input->post('iIdAccion',true);
        $iIdCambio = $this->input->post('iIdCambio',true);
        $cambios = $this->ml->obtenerCambios($id);

        /**
         * Aqui va todo
         */
        $tipo = $cambios->iTipoCambio;
 

        $antes = json_decode($cambios->iAntesCambio);
        $despues = json_decode($cambios->iDespuesCambio);
        $result ='';
        $arrayAntes = array();
        $data = array();
        $dataLog = array();

        foreach($antes as $value){
            array_push($arrayAntes, $value);
        }

        switch ($tipo) {
            case 'Indicador':
                # code...
                foreach($despues as $key => $value ){

                    // $result =$antes[$key];
                  
                    if($value != $antes->$key){
                        $data[$key] = $value;
                        $where = "iIdEntregable =".$iIdCambio;
                        $table = 'Entregable';

                        // if($this->me->modificacion_general($where,$table,$data))
                          
                        $this->me->modificacion_general($where,$table,$data);
                        $dataLog['iAprovacion'] = 1;
                        $this->ml->updateLog($id, $dataLog);
                    }else{
                        // $result .= '
                        //    <tr> 
                        //    <td ><p >'.$key.'</p></td>
                        //    <td>'.$value.'</td>
                        //    <td>'.$antes->$key.'</td></tr>';

                    }
                    // var_dump($despues);
                    // var_dump($antes);

                }

                
                
                break;
            
            case 'Acción':
                # code...
                foreach($despues as $key => $value ){

                    // $result =$antes[$key];
                  
                    if($value != $antes->$key){
                        $data[$key] = $value;
                        $where['iIdActividad'] = $iIdCambio;
                     
                        
                        $this->mseg->actualiza_registro('Actividad', $where, $data, $con);
                        $dataLog['iAprovacion'] = 1;
                        $this->ml->updateLog($id, $dataLog);


                    }else{
                        // $result .= '
                        //    <tr> 
                        //    <td ><p >'.$key.'</p></td>
                        //    <td>'.$value.'</td>
                        //    <td>'.$antes->$key.'</td></tr>';

                    }
                    // var_dump($despues);
                    // var_dump($antes);

                }

                
                
                break;
            
            default:
                # code...
                break;
        }
        // $data['cambios'] = $result;
        echo json_encode($data);
        // $this->load->view('Logs/detalle', $data);
    }

}