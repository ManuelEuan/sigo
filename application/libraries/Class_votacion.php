<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Class_votacion {

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->helper('url');
        //$CI->load->helper('Funciones');    
        $CI->load->model('M_votacion'); 
    }

    function carga_propuestas()
    {

        $propuestas = "";
        $model = new M_votacion();
        $vota = $model->carga_propuestas();
        $inicio_voto = $model->consulta_valor_parametros(7);
        $fin_voto = $model->consulta_valor_parametros(8);


        $inicio = $inicio_voto[0]->vValor;
        $fin = $fin_voto[0]->vValor;
        $dFecha = date("Y-m-d");

        if($vota!=false)
        {
            foreach ($vota as $vres) {
                $fecha = new DateTime($vres->dFecha);
                
                $query_img = $model->carga_adjuntos($vres->iIdPropuesta,1);
                $total_coment = $model->total_comentarios($vres->iIdPropuesta);

                if(isset($_SESSION[PREFIJO.'_idusuario']))
                {
                    
                    $iIdUsuario = $_SESSION[PREFIJO.'_idusuario'];
                    $apoyo = $model->ver_apoyo($vres->iIdPropuesta,$iIdUsuario);
                }
                else $apoyo = -1;

                if(isset($query_img[0])) $urlImg = $query_img[0]->vRutaAdjunto;
                else $urlImg = "img/si_400.jpg";

                $propuestas.='<div class="entry clearfix">
                    <div class="entry-image">
                        <a href="'.base_url().$urlImg.'" data-lightbox="image"><img class="image_fade" src="'.base_url().$urlImg.'" alt="Standard Post with Image"></a>
                    </div>
                    <div class="entry-title">
                        <h2><a target="_blank" href="'.base_url().'propuestas/ind?id='.$vres->iIdPropuesta.'">'.$vres->vTitulo.'</a></h2>
                    </div>
                    <ul class="entry-meta clearfix">
                        <li><i class="icon-calendar3"></i>'.date_format($fecha,'d/m/Y').'</li>
                        <li><a href="#"><i class="icon-comments"></i> '.$total_coment.'</a></li>
                        <li><a href="javascript:"><i class="icon-user"></i> '.$vres->vNombre.' '.$vres->vApellidoPaterno.' '.$vres->vApellidoMaterno.'</a></li>
                    </ul>
                    <div class="entry-content">
                        <p>'.substr(strip_tags($vres->tDescripcion,'<p>'),0,200).'</p>';
                        

                        


                        if($apoyo==-1)
                        {
                            $propuestas.='<div class="col-md-12"><div class="style-msg errormsg" id="error_sesion"><div class="sb-msg"><i class="icon-remove"></i>Para poder votar por esta propuesta debe <a href="'.base_url().'Sitio/login?r=1">iniciar sesión</a> o <a href="'.base_url().'Sitio/registrarse">Registrarse</a></div></div></div>';
                        }
                        else
                        {
                            $inicio = $inicio_voto[0]->vValor;
                            $fin = $fin_voto[0]->vValor;
                            $dFecha = date("Y-m-d");                            

                            if($dFecha>=$inicio && $dFecha<=$fin)
                            {
                                if($apoyo==0)
                                {
                                    $propuestas.='<div class="row" id="div_apoyo_'.$vres->iIdPropuesta.'"><div class="col-md-6"><button id="apoyar_prop" type="button" class="btn btn-outline-success btn-lg btn-block" onclick="apoya_propuesta('.$vres->iIdPropuesta.',1);">A favor</button></div>
                                                            <div class="col-md-6"><button id="apoyar_prop_dislike" type="button" class="btn btn-outline-danger btn-lg btn-block" onclick="apoya_propuesta('.$vres->iIdPropuesta.',0);">En contra</button></div></div>';
                                }
                                elseif($apoyo==1)
                                {
                                    $propuestas.='<div class="col-md-12"><button id="apoyar_prop" type="button" class="btn btn-outline-warning btn-lg btn-block">Usted ya ha apoyado esta propuesta</button></div>';
                                }
                            }
                            elseif($dFecha<$inicio) $propuestas.='<div class="col-md-12"><div class="style-msg errormsg" id="error_sesion"><div class="sb-msg"><i class="icon-remove"></i>Aún no inicia el periodo de votaciones</div></div></div>';
                            elseif($dFecha>$fin) $propuestas.='<div class="col-md-12"><div class="style-msg errormsg" id="error_sesion"><div class="sb-msg"><i class="icon-remove"></i>El período de votaciones ha concluido</div></div></div>';
                        }


                    $propuestas.='</div>
                </div>';  
            }
        }
        else $propuestas.='<h4>Aún no hay propuestas para votar</h4>';
         
        return $propuestas;
    }       
}