<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_roles extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->library('Class_options');
        $this->load->model('M_roles','mr');
    }

    //Muestra la vista principal
    public function index(){

        $lib = new Class_options();

        $data['roles'] = $lib->options_tabla('roles');
        $data['consulta'] = $this->mr->mostrar_roles();
        $this->load->view('roles/principal',$data);
    }

    //Muestra la pagina para agregar roles
    public function create(){

        $this->load->view('roles/contenido_agregar');
    }

    //Funcion para insertar
    public function insert(){

        if(isset($_POST['rol'])){

            $data = array();

            $data['vRol'] = $this->input->post('rol',true);
            $data['iActivo']= 1;
            
            $resultado = $this->mr->insertar_rol($data);
            echo $resultado;
        }else{
            echo "no recibe el post";
        }
    }

    //Muestra la pantalla de edicion para el update
    public function edit(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);
            $data['consulta'] = $this->mr->preparar_update($id);

            $this->load->view('roles/contenido_modificar',$data);
        }else{
            echo "error";
        }       
    }

    //Muestra la vistapara editar los permisos de determinado rol
    public function editpermisos(){

        if(isset($_POST['id'])){

            $idrol = $this->input->post('id',true);
            //$mensaje = "Reestablecer los permisos dados por el Rol del usuario hara que se deshabilite cualquier permiso otorgado anteriormente";

            //$data['consulta'] = $this->mu->preparar_update($id);
            $data['menu'] = $this->contenido_permisos($idrol);
            //$data['id_rol'] = $idrol;
            //$data['mensaje'] = $mensaje;

            $this->load->view('roles/asignar_permisos',$data);

        }else{
            echo "error";
        }  
    }

    //Funcion para modificar
    public function update(){

        if(isset($_POST['id']) && isset($_POST['rol'])){

            $data = array();
            $id = $this->input->post('id',TRUE);
            $data['vRol'] = $this->input->post('rol',true);
            
            $resultado = $this->mr->modificar_rol($id,$data);
            echo $resultado;
        }else{
            echo "no recibe el post";
        }
    }

    //Funcion para eliminar
    public function delete(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);

            $resultado = $this->mr->eliminar_rol($id);

            echo $resultado;

        }else{
            echo "algo salio mal";
        }
    }

    //Funcion de busquedas
    public function search(){

        $rol = null;
        
        if(isset($_POST['rol']) && !empty($_POST['rol'])){

            $rol = $this->input->post('rol',true);
        }
       
        $data['consulta'] = $this->mr->mostrar_roles($rol);
        $this->load->view('roles/contenido_tabla',$data);
    }

    //Genera el contenido de los permisos por rol
    public function contenido_permisos($idrol){

        $id_rol = $idrol;

        $str = '<div class="row">
                    <div class="col-md-6">
                        <h4>Opciones del menu</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>Tipo de acceso</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>';

        //Obtiene el listado de menus principal
        $menu = $this->mr->consultar_menu_sistema(0,1);

        foreach($menu as $padre){

            $str.= '<div class="row">
                        <div class="col-md-6">
                            <h6>'.$padre->vPermiso.'</h6>
                        </div>
                        ';  
            //Obtiene el listado de submenu            
            $submenu = $this->mr->consultar_menu_sistema($padre->iIdPermiso,1);

                //Valida el menu principal para ver si tiene asignado un permiso la tabla de permisos por rol
                $checkrol = $this->mr->mostrar_permisos_rol($id_rol,$padre->iIdPermiso,0,1);

                if(count($checkrol) > 0){

                    foreach ($checkrol as $value) {

                        if($value->iTipoAcceso == 0){

                            $opc_0='checked';
                            $opc_1='';
                            $opc_2='';
                        
                        }
                        if($value->iTipoAcceso == 1){

                            $opc_0='';
                            $opc_1='checked';
                            $opc_2='';
                            
                        }
                        if($value->iTipoAcceso == 2){

                            $opc_0='';
                            $opc_1='';
                            $opc_2='checked';
                            
                        }
                        $default = 1;
                    }
                }else {
                    
                    $opc_0='';
                    $opc_1='';
                    $opc_2='';
                    $default = 0;
                }
            
            $str.='<div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_0.' id="rbt1'.$padre->iIdPermiso.'" name="'.$padre->iIdPermiso.'" value="0" onclick="changecheck(id,'.$padre->iIdPermiso.','.$padre->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt1'.$padre->iIdPermiso.'">Denegado</label>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_1.' id="rbt2'.$padre->iIdPermiso.'" name="'.$padre->iIdPermiso.'" value="1" onclick="changecheck(id,'.$padre->iIdPermiso.','.$padre->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt2'.$padre->iIdPermiso.'">Lectura</label>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_2.' id="rbt3'.$padre->iIdPermiso.'" name="'.$padre->iIdPermiso.'" value="2" onclick="changecheck(id,'.$padre->iIdPermiso.','.$padre->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt3'.$padre->iIdPermiso.'">Lectura y escritura</label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="val['.$padre->iIdPermiso.']" id="val'.$padre->iIdPermiso.'" value="'.$default.'">
                <div class="dropdown-divider"></div>';

            if(count($submenu) > 0){

                foreach($submenu as $hijo){

                //Valida el submenu para ver si tiene asignado un permiso la tabla de permisos por rol
                $checkrol_submenu = $this->mr->mostrar_permisos_rol($id_rol,$hijo->iIdPermiso,$padre->iIdPermiso,1);
                
                if(count($checkrol_submenu) > 0){

                    foreach ($checkrol_submenu as $value) {

                        if($value->iTipoAcceso == 0){

                            $opc_0='checked';
                            $opc_1='';
                            $opc_2='';
                                        
                        }
                        if($value->iTipoAcceso == 1){

                            $opc_0='';
                            $opc_1='checked';
                            $opc_2='';
                                        
                        }
                        if($value->iTipoAcceso == 2){

                            $opc_0='';
                            $opc_1='';
                            $opc_2='checked';
                                        
                        }
                        $default = 1;
                    }
                }else {
                                
                    $opc_0='';
                    $opc_1='';
                    $opc_2='';
                    $default = 0;
                }

                $str.='<div class="row">
                    <div class="col-md-4 text-right">
                        <label class="">'.$hijo->vPermiso.'</label>
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_0.' id="rbt1'.$hijo->iIdPermiso.'" name="'.$hijo->iIdPermiso.'" value="0" onclick="changecheck(id,'.$hijo->iIdPermiso.','.$hijo->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt1'.$hijo->iIdPermiso.'">Denegado</label>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_1.' id="rbt2'.$hijo->iIdPermiso.'" name="'.$hijo->iIdPermiso.'" value="1" onclick="changecheck(id,'.$hijo->iIdPermiso.','.$hijo->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt2'.$hijo->iIdPermiso.'">Lectura</label>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_2.' id="rbt3'.$hijo->iIdPermiso.'" name="'.$hijo->iIdPermiso.'" value="2" onclick="changecheck(id,'.$hijo->iIdPermiso.','.$hijo->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt3'.$hijo->iIdPermiso.'">Lectura y escritura</label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="val['.$hijo->iIdPermiso.']" id="val'.$hijo->iIdPermiso.'" value="'.$default.'">
                <div class="dropdown-divider"></div>';
                }

            }else{

                
            }

        }

        $str.='<br><br><br>';

        $str.= '<div class="row">
                    <div class="col-md-6">
                        <h4>Acciones especificas</h4>
                    </div>
                    <div class="col-md-6">
                        <h4>Tipo de acceso</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>';
        
        //Obtiene el listado de permisos especificos
        $menu = $this->mr->consultar_menu_sistema(0,2);

        foreach($menu as $funciones){

            $str.= '<div class="row">
                        <div class="col-md-6">
                            <h6>'.$funciones->vPermiso.'</h6>
                        </div>
                        ';

            //Valida el menu principal para ver si tiene asignado un permiso la tabla de permisos por rol
                $checkrol = $this->mr->mostrar_permisos_rol($id_rol,$funciones->iIdPermiso,0,2);

                if(count($checkrol) > 0){

                    foreach ($checkrol as $value) {

                        if($value->iTipoAcceso == 0){

                            $opc_0='checked';
                            $opc_1='';
                            $opc_2='';
                            
                        }
                        if($value->iTipoAcceso == 1){

                            $opc_0='';
                            $opc_1='checked';
                            $opc_2='';
                            
                        }
                        if($value->iTipoAcceso == 2){

                            $opc_0='';
                            $opc_1='';
                            $opc_2='checked';
                            
                        }
                        $default = 1;
                    }
                }else{

                    $opc_0='';
                    $opc_1='';
                    $opc_2='';
                    $default = 0;
                }            
            
            $str.='<div class="col-md-6">
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_0.' id="rbt1'.$funciones->iIdPermiso.'" name="'.$funciones->iIdPermiso.'" value="0" onclick="changecheck(id,'.$funciones->iIdPermiso.','.$funciones->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt1'.$funciones->iIdPermiso.'">Denegado</label>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_1.' id="rbt2'.$funciones->iIdPermiso.'" name="'.$funciones->iIdPermiso.'" value="1" onclick="changecheck(id,'.$funciones->iIdPermiso.','.$funciones->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt2'.$funciones->iIdPermiso.'">Lectura</label>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" '.$opc_2.' id="rbt3'.$funciones->iIdPermiso.'" name="'.$funciones->iIdPermiso.'" value="2" onclick="changecheck(id,'.$funciones->iIdPermiso.','.$funciones->iIdPermisoPadre.')">
                                <label class="custom-control-label" for="rbt3'.$funciones->iIdPermiso.'">Lectura y escritura</label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="val['.$funciones->iIdPermiso.']" id="val'.$funciones->iIdPermiso.'" value="'.$default.'">
                <div class="dropdown-divider"></div>';
        }

        $str.='<input type="hidden" name="id_rol" value="'.$id_rol.'">
                <center>
                    <button id="guardarpermisos" class="btn waves-effect waves-light btn-success" type="submit" disabled="true">Guardar</button>
                    <button type="reset" class="btn waves-effect waves-light btn-inverse" onclick="regresar()">Cancelar</button>
                </center>';

        return $str;

    }

    //Sobreescribe los permisos asignados por Rol
    public function restart(){

        $var = $this->input->post('val',true);
        $id_rol = $this->input->post('id_rol',true);

        if($this->mr->validar_rolpermisos($id_rol) == TRUE){

            $this->mr->eliminar_rolpermisos($id_rol);

        }

        foreach($var as $valor => $value){

            if($value == 1){

                $resultado = $_POST[$valor];

                $data['iIdRol'] = $id_rol;
                $data['iIdPermiso'] = $valor;
                $data['iTipoAcceso'] = $resultado;

                $this->mr->agregar_rolpermisos($data);

            }else{
                
            }

        }
        echo "correcto";
    }
}

?>