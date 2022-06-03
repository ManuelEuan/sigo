<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Class_propuestas {

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->helper('url');
        //$CI->load->helper('Funciones');    
        $CI->load->model('M_propuestas'); 
    }

    function carga_propuestas($pagina=0,$iIdSector=0,$iIdTema=0)
    {
        $propuestas = "";
        $model = new M_propuestas();
        //$query_prop = $model->carga_propuestas(0,$pagina);
        $query_prop = $model->busqueda_prop($pagina,0,$iIdSector,$iIdTema);
        if($query_prop!=false)
        { 
            foreach ($query_prop as $vprop) {              
                $fecha = new DateTime($vprop->dFecha);
                $query_img = $model->carga_adjuntos($vprop->iIdPropuesta,1);
                $total_coment = $model->total_comentarios($vprop->iIdPropuesta);
                $text_coment = ($total_coment>1)? "Comentarios":"Comentario";

                //carga el total de votaciones de la propuesta
                $total_vot = $model->total_vot($vprop->iIdPropuesta);
                //fecha e inicio de votaciones
                $inicio_voto = $model->consulta_valor_parametros(7);
                $fin_voto = $model->consulta_valor_parametros(8);

                if(isset($query_img[0])) $urlImg = $query_img[0]->vRutaAdjunto;
                else $urlImg = "img/si_860.jpg";                

                $propuestas.='<div class="card" style="margin-top: 3%; margin-bottom: 2%;">
                    <div class="entry clearfix card-body">
                                <div class="entry-image">
                                    <a href="'.base_url().$urlImg.'" data-lightbox="image"><img class="image_fade" src="'.base_url().$urlImg.'" alt="Standard Post with Image"></a>
                                </div>
                                <div class="entry-title">
                                    <h2><a target="_blank" href="'.base_url().'propuestas/ind?id='.$vprop->iIdPropuesta.'">'.$vprop->vTitulo.'</a> <span>Clave: '.$vprop->vCodigo.'</span></h2>
                                </div>
                                <div class="tagcloud">
                                    <a href="javascript:">'.$vprop->vTema.'</a>                                 
                                </div><br><br>
                                <ul class="entry-meta clearfix">
                                    <li><a href="javascript:"><i class="icon-comments"></i> '.$total_coment.' '.$text_coment.' </a></li>
                                    <li><i class="icon-calendar3"></i> '.date_format($fecha,'d/m/Y').'</li>';
                                    //$propuestas.='<li><a href="javascript:"><i class="icon-checkbox-checked"></i> '.$total_vot.'</a></li>';
                                    $propuestas.='<li><a href="javascript:"><i class="icon-user"></i> '.$vprop->vNombre.' '.$vprop->vApellidoPaterno.' '.$vprop->vApellidoMaterno.'</a></li>
                                </ul>
                                <div class="entry-content">'.substr(strip_tags($vprop->tDescripcion,'<p>'),0,200).'<br>';
                                /*if(isset($_SESSION[PREFIJO.'_idusuario']))
                                    $propuestas.='<a href="javascript:" onclick="propuesta_simple('.$vprop->iIdPropuesta.');" class="btn btn-success">Apoyar</a>';
                                else $propuestas.='<div class="style-msg errormsg"><div class="sb-msg"><i class="icon-remove"></i>Inicie sesión para apoyar la propuesta</div></div>'; */

                                $propuestas.='</div>
                            </div>';

                            if(isset($_SESSION[PREFIJO.'_idusuario']))
                            {
                                $iIdUsuario = $_SESSION[PREFIJO.'_idusuario'];
                                $apoyo = $model->ver_apoyo($vprop->iIdPropuesta,$iIdUsuario);
                            }
                            else $apoyo = -1;

                            $propuestas.='<div class="row" style="margin-bottom: 2%;">
                                <div class="col-md-8" style="border-right: 2px dotted #9a9a9a; " id="div_apoyo_'.$vprop->iIdPropuesta.'">';
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
                                            $propuestas.='<div class="row"><div class="col-md-6">
                                                <button id="apoyar_prop" type="button" class="btn btn-outline-primary btn-lg btn-block" onclick="apoya_propuesta('.$vprop->iIdPropuesta.',1);">A favor <i class="icon-like"></i></button>
                                            </div>
                                            <div class="col-md-6">
                                                <button id="apoyar_prop_dislike" type="button" class="btn btn-outline-danger btn-lg btn-block" onclick="apoya_propuesta('.$vprop->iIdPropuesta.',0);">En contra <i class="icon-like icon-rotate-180"></i></button>
                                            </div></div>';
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
                                <div class="col-md-3">
                                    <a target="_blank" href="'.base_url().'propuestas/ind?id='.$vprop->iIdPropuesta.'" class="btn btn-outline-secondary btn-lg btn-block">Consultar <i class="icon-search"></i></a>
                                </div>
                            </div>';
                        $propuestas.='</div>';
            }
        }
        else $propuestas.='<h1>Sin propuestas</h1>';
        return $propuestas;
    }

    function prop_index()
    {
        $model = new M_propuestas();
        $query_prop = $model->carga_propuestas(0,0,4);

        $propuestas = '';
        if($query_prop!=false)
        {
            foreach ($query_prop as $vprop) {
                $fecha = new DateTime($vprop->dFecha);
                $query_img = $model->carga_adjuntos($vprop->iIdPropuesta,1);
                //carga el total de comentarios
                $total_coment = $model->total_comentarios($vprop->iIdPropuesta);
                $text_coment = ($total_coment!=1)? "Comentarios":"Comentario";

                //carga el total de votaciones de la propuesta
                $total_vot = $model->total_vot($vprop->iIdPropuesta);

                //carga la imagen de la propuesta
                if(isset($query_img[0]))  
                {
                    $urlImg = str_replace("imagenes", "imagenes/thumbnail", $query_img[0]->vRutaAdjunto);
                     //$urlImg = $query_img[0]->vRutaAdjunto;
                }
                else $urlImg = "img/si_450.jpg";

                $propuestas.='<div class="col-lg-6 bottommargin">
                    <div class="team team-list clearfix">
                        <div class="team-image">
                            <img src="'.base_url().''.$urlImg.'" alt="John Doe">
                        </div>
                        <div class="team-desc">
                            <div class="team-title"><h4></h4><span>'.$vprop->vTitulo.'</span></div>
                            <ul class="entry-meta clearfix">
                                <li><a href="javascript:"><i class="icon-comments"></i> '.$total_coment.' '.$text_coment.' </a></li>
                                <li>'.date_format($fecha,'d/m/Y').'</li>';
                                //$propuestas.='<li><a href="javascript:"><i class="icon-checkbox-checked"></i> '.$total_vot.'</a></li>';
                                $propuestas.='<li><a href="javascript:"><i class="icon-user"></i> '.$vprop->vNombre.' '.$vprop->vApellidoPaterno.' '.$vprop->vApellidoMaterno.'</a></li>
                            </ul>
                            <div class="team-content">'.substr(strip_tags($vprop->tDescripcion,'<p>'),0,200).'</div>
                            <br><a target="_blank" href="'.base_url().'propuestas/ind?id='.$vprop->iIdPropuesta.'" class="btn btn-success">Consultar</a>                                      
                        </div>
                    </div>
                </div>';
            }
        }
        else $propuestas.="<h4>Aún no existen propuestas</h4>";

        return $propuestas;
    }

    function datos_sectores()
    {
        $model = new M_propuestas();
        $query = $model->datos_sectores();
        return $query;
    }

    function datos_temas($iIdSector)
    {
        $model = new M_propuestas();
        $query = $model->datos_temas($iIdSector);
        return $query;
    }

    function prop_votos()
    {
        $model = new M_propuestas();
        $query = $model->votos_propuestas();
        $propuesta = "";
        if($query!=false)
        {
            foreach ($query as $vprop) {
                
                $query_img = $model->carga_adjuntos($vprop->iIdPropuesta,1);
                if(isset($query_img[0])) $urlImg = $query_img[0]->vRutaAdjunto;
                else $urlImg = "img/si_400.jpg";

                $propuesta.= '<div class="col-md-4 nobottommargin">
                            <div class="feature-box media-box">
                                <div class="fbox-media">
                                    <img src="'.base_url().$urlImg.'" alt="">
                                </div>
                                <div class="fbox-desc">
                                    <h3><span>'.$vprop->vTitulo.'</span></h3>
                                    <ul class="entry-meta clearfix"><li><i class="icon-calendar3"></i> Desde el '.$vprop->dFecha.'</li></ul>
                                    <p>'.substr(strip_tags($vprop->tDescripcion,'<p>'),0,200).'</p>
                                    <br><a target="_blank" href="'.base_url().'propuestas/ind?id='.$vprop->iIdPropuesta.'" class="btn btn-success">Consultar</a>
                                </div>
                            </div>
                        </div>';
            }
        }
        else $propuesta.="<div class='col_one_third'></div><div class='col_one_third'><h4>Aún no existen propuestas votadas</h4></div>";
        
        return $propuesta;
    }

    function num_index()
    {
        $model = new M_propuestas();
        $total['tot_part'] = $model->total_part();
        $total['tot_prop'] = $model->total_prop();
        $total['tot_acep'] = $model->total_acep();
        $total['tot_vot'] = $model->total_vot();

        return $total;
    }

    function total_propuestas($iIdSector=0,$iIdTema=0)
    {
        $model = new M_propuestas();
        //$query_total = $model->total_propuestas();
        $query_total = $model->busqueda_total($iIdSector,$iIdTema);
        if($query_total!=false) return $query_total;
        else return false;
    }    

   
}