<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Class_seguridad {

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->helper('url');
        $CI->load->model('M_seguridad');
    }

    function generar_menu($idusuario)
    {
        $resp = array('menu'=>'','modulo_inicial'=>'');
        $str = $modulo_inicial = '';
        $id_permiso_ant = 0;
        $modseguridad =  new M_seguridad();
        $menu = $modseguridad->consultar_menu_sistema($idusuario, 0);

        $ids = array(); // Para validar si el permiso se repite

        if($menu)
        {
            if($menu->num_rows () > 0)
            {
                $menu = $menu->result();
                
                $str = '<nav class="sidebar-nav">
                            <ul id="sidebarnav">';
                foreach ($menu as $padre)
                {                    if(!in_array($padre->iIdPermiso, $ids))
                    {
                        $ids[] = $padre->iIdPermiso;
                        
                        // Subpermisos o submenú
                        $submenu = $modseguridad->consultar_menu_sistema($idusuario, $padre->iIdPermiso);

                        if($padre->iTipoAcceso > 0)
                        {

                            if($submenu != false && $submenu->num_rows() > 0)
                            {
                                $submenu = $submenu->result();

                                $str.= '<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="'.$padre->vClass.'"></i><span class="hide-menu">'.$padre->vPermiso.'</span></a>';
                                $str.= '<ul aria-expanded="false" class="collapse  first-level">';
                                
                                foreach ($submenu as $hijo)
                                {                                    
                                    if(!in_array($hijo->iIdPermiso, $ids))
                                    {
                                        $ids[] = $hijo->iIdPermiso;

                                        if($hijo->iTipoAcceso > 0)
                                        {
                                            if($modulo_inicial == '' && $hijo->iInicial > 0) $modulo_inicial = base_url().$hijo->vUrl;
                                            $str.= '<li class="sidebar-item"><a style="cursor:pointer;" onclick="cargar(\''.base_url().$hijo->vUrl.'\',\'#contenido\');" class="sidebar-link"><i class="'.$hijo->vClass.'"></i><span class="hide-menu"> '.$hijo->vPermiso.'</span></a></li>';
                                        }
                                    }
                                }
                       
                                $str.= '</ul>';
                                $str.= '<li>';
                            }
                            else
                            {
                                if($modulo_inicial == '' && $padre->iInicial > 0) $modulo_inicial = base_url().$padre->vUrl;
                                $str .= '<li class="sidebar-item">
                                        <a class="sidebar-link waves-effect waves-dark" style="cursor:pointer;" onclick="cargar(\''.base_url().$padre->vUrl.'\',\'#contenido\');" aria-expanded="false"><i class="'.$padre->vClass.'"></i><span class="hide-menu">'.$padre->vPermiso.'</span></a>
                                    </li>';
                            }
                        }
                    }
                }

                $str .= '   </ul>
                        </nav>';
            }
        }

        $resp['menu'] = $str;
        $resp['modulo_inicial'] = $modulo_inicial;

        return $resp;
    }
    
    function tipo_acceso($permiso, $id_usuario=0)
    {
        $acceso = -1;
        $ms = new M_seguridad();
        $qp = $ms->tipo_acceso($permiso,$id_usuario);
        if($qp != false)
        {
            if($qp->num_rows() == 1)
            {
                $registro = $qp->row();
                if($registro->acceso_usuario > $acceso) $acceso = $registro->acceso_usuario;
                if($acceso == -1) $acceso = $registro->acceso_rol;
            }
        }

        return $acceso;
    }
   
    
}