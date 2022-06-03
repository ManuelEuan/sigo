<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_usuarios extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->model('M_usuarios','mu');
        $this->load->library('Class_options');
    }

    //Muestra la vista principal
    public function index(){
        $lib = new Class_options();

        $data['roles'] = $lib->options_tabla('roles');
        $data['consulta'] = $this->mu->mostrar_usuarios();    
    	$this->load->view('usuarios/principal',$data);
    }

    //Muestra la pagina para agregar usuarios
    public function create(){

        $lib = new Class_options();

        $data['dependencias'] = $lib->options_tabla('dependencias');
        $data['roles'] = $lib->options_tabla('roles');
        $data['formacion_academica'] = $lib->options_tabla('formacion_academica');
        $data['nivel_academico'] = $lib->options_tabla('maximo_nivel_academico');

        $this->load->view('usuarios/contenido_agregar',$data);
    }

    //Funcion para insertar
    public function insert(){

        if(isset($_POST['dependencia']) && isset($_POST['nombre']) && isset($_POST['correoinst'])&& 
        isset($_POST['nombreusuario']) && isset($_POST['rol']) && isset($_POST['apepat']) 
        && isset($_POST['correopersonal']) && isset($_POST['contrasenia']) && isset($_POST['formacionacademica']) 
        && isset($_POST['apemat']) && isset($_POST['telefono']) && isset($_POST['confirmarcontrasenia']) 
        && isset($_POST['maxnivelacademico']) && isset($_POST['cargo']) && isset($_POST['celular']) 
        && isset($_POST['fechanc'])){

            //Validacion de la contraseña y la confirmacion
            if($_POST['contrasenia'] == $_POST['confirmarcontrasenia']){

                $data = array();

                $data['iIdDependencia'] = $this->input->post('dependencia',true);
                $data['vNombre'] = trim($this->input->post('nombre',true));
                $data['vCorreo'] = trim($this->input->post('correoinst',true));
                $data['vUsuario'] = trim($this->input->post('nombreusuario',true));
                $data['iIdRol'] = $this->input->post('rol',true);
                $data['vPrimerApellido'] = trim($this->input->post('apepat',true));
                $data['vCorreoPersonal'] = trim($this->input->post('correopersonal',true));
                $data['vPassword'] = sha1($this->input->post('contrasenia',true));
                $data['iIdFormacionAcademica'] = $this->input->post('formacionacademica',true);
                $data['vSegundoApellido'] = $this->input->post('apemat',true);
                $data['vTelefono'] = $this->input->post('telefono',true);
                $data['iIdMaxNivelAcademico'] = $this->input->post('maxnivelacademico',true);
                $data['vCargo'] = trim($this->input->post('cargo',true));
                $data['vCelular'] = $this->input->post('celular',true);
                $data['dFechaNacimiento'] = $this->input->post('fechanc',true);
                $data['dFechaRegistro'] = date("Y-m-d");
                $data['iActivo']= 1;

                //valida que el nombre de usuario no se encuentre en la DB
                $validarus = $this->mu->validar_usuario($data['vUsuario']);

                if($validarus == TRUE){

                    //Valida que el correo institucional no se encuentren registrados en la DB
                    $validarcorreo = $this->mu->validar_correos($data['vCorreo'], $data['vCorreoPersonal'], 1);

                    if($validarcorreo == TRUE){

                        //Valida que el correo personal no se encuentren registrados en la DB
                        $validarcorreo = $this->mu->validar_correos($data['vCorreo'], $data['vCorreoPersonal'], 2);

                        if($validarcorreo == TRUE){

                            $this->mu->guardar_usuario($data);
                            echo "correcto";

                        }else{
                            echo "validar_correo_per";
                        }

                    }else{
                        echo "validar_correo_inst";
                    }
                }else{
                    echo "validar_usuario";
                }
            }else{
                echo "validar_pass";
            }                      
        }else{
            //Mensaje en caso de que no reciba el POST
            echo "error";
        }
    }

    //Muestra la pantalla de edicion para el update
    public function edit(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);
            
            $lib = new Class_options();

            $data['consulta'] = $this->mu->preparar_update($id);

            $data['dependencias'] = $lib->options_tabla('dependencias',$data['consulta']->iIdDependencia);
            $data['roles'] = $lib->options_tabla('roles',$data['consulta']->iIdRol);
            $data['formacion_academica'] = $lib->options_tabla('formacion_academica',$data['consulta']->iIdFormacionAcademica);
            $data['nivel_academico'] = $lib->options_tabla('maximo_nivel_academico',$data['consulta']->iIdMaxNivelAcademico);  

            $this->load->view('usuarios/contenido_modificar',$data);

        }else{
            echo "error";
        }       
    }

    //Muestra la vista para editar la contraseña
    public function editpassword(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);

            $data['consulta'] = $this->mu->preparar_update($id); 

            $this->load->view('usuarios/modificar_password',$data);

        }else{
            echo "error";
        }  

    }

    //Muestra la vista para editar los permisos de determinado usuario
    public function editpermisos(){

        if(isset($_POST['id'])){

            $idus = $this->input->post('id',true);
            $mensaje = "Reestablecer los permisos dados por el Rol del usuario hara que se deshabilite cualquier permiso otorgado anteriormente";

            //$data['consulta'] = $this->mu->preparar_update($id);
            $data['menu'] = $this->contenido_permisos($idus);
            $data['id_us'] = $idus;
            $data['mensaje'] = $mensaje;

            $this->load->view('usuarios/asignar_permisos',$data);

        }else{
            echo "error";
        }  
    }

    //Funcion para modificar
    public function update(){

        if(isset($_POST['id']) && isset($_POST['dependencia']) && isset($_POST['nombre']) 
        && isset($_POST['nombreusuario']) && isset($_POST['rol']) && isset($_POST['apepat']) 
        && isset($_POST['correopersonal']) && isset($_POST['formacionacademica']) && isset($_POST['apemat']) 
        && isset($_POST['telefono']) && isset($_POST['maxnivelacademico']) && isset($_POST['cargo']) 
        && isset($_POST['celular']) && isset($_POST['fechanc']) && isset($_POST['correoinst'])){

            $data = array();

            $id = $this->input->post('id');
            $data['iIdDependencia'] = $this->input->post('dependencia',true);
            $data['vNombre'] = trim($this->input->post('nombre',true));
            $data['vCorreo'] = trim($this->input->post('correoinst',true));
            $data['vUsuario'] = trim($this->input->post('nombreusuario',true));
            $data['iIdRol'] = $this->input->post('rol',true);
            $data['vPrimerApellido'] = trim($this->input->post('apepat',true));
            $data['vCorreoPersonal'] = trim($this->input->post('correopersonal',true));
            //$data['vPassword'] = sha1($this->input->post('contrasenia'));
            $data['iIdFormacionAcademica'] = $this->input->post('formacionacademica',true);
            $data['vSegundoApellido'] = trim($this->input->post('apemat',true));
            $data['vTelefono'] = $this->input->post('telefono',true);
            //$data['iAnio'] = $this->input->post('confirmarcontrasenia');
            $data['iIdMaxNivelAcademico'] = $this->input->post('maxnivelacademico',true);
            $data['vCargo'] = $this->input->post('cargo',true);
            $data['vCelular'] = $this->input->post('celular',true);
            $data['dFechaNacimiento'] = $this->input->post('fechanc',true);
            $data['dFechaRegistro'] = date("Y-m-d");
            $data['iActivo']= 1;

                //valida que el nombre de usuario no se encuentre en la DB
                $validarus = $this->mu->validar_usuario($data['vUsuario'], $id);

                if($validarus == TRUE){

                    //Valida que el correo institucional no se encuentren registrados en la DB
                    $validarcorreo = $this->mu->validar_correos($data['vCorreo'], $data['vCorreoPersonal'], 1, $id);

                    if($validarcorreo == TRUE){

                        //Valida que el correo personal no se encuentren registrados en la DB
                        $validarcorreo = $this->mu->validar_correos($data['vCorreo'], $data['vCorreoPersonal'], 2, $id);

                        if($validarcorreo == TRUE){

                            $this->mu->modificar_usuario($id,$data);
                            echo "correcto";

                        }else{
                            echo "validar_correo_per";
                        }

                    }else{
                        echo "validar_correo_inst";
                    }
                }else{
                    echo "validar_usuario";
                }

        }else{
            //Mensaje en caso de que no reciba el POST
            echo "error";
        }
    }

    //Funcion para modificar la contraseña
    public function updatepass(){

        if(isset($_POST['id']) && isset($_POST['newcontrasenia']) && isset($_POST['confcontrasenia'])){

            $id = $this->input->post('id',true);
            //$pass_old = SHA1(trim($this->input->post('excontrasenia')));
            $pass_new = SHA1(trim($this->input->post('newcontrasenia',true)));
            $pass_conf = SHA1(trim($this->input->post('confcontrasenia',true)));

            if($pass_new == $pass_conf){

                $data = array();

                $data['vPassword'] = $pass_new;

                $this->mu->modificar_usuario($id,$data);

                echo "correcto";

            }else{
                echo "error_passnew";
            }

        }else{
            //Mensaje en caso de que no reciba el POST
            echo "error";
        }
    }

    //Funcion para eliminar
    public function delete(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);

            $resultado = $this->mu->eliminar_usuario($id);

            echo $resultado;

        }else{
            echo "error";
        }
    }

    //Funcion de busquedas
    public function search(){

        $rol = $usuario = null;
        if(isset($_POST['usuario']) && !empty($_POST['usuario'])){

            $usuario = trim($this->input->post('usuario',true));
        }
        
        if(isset($_POST['rol']) && !empty($_POST['rol'])){

            $rol = $this->input->post('rol',true);
        }
       
        $data['consulta'] = $this->mu->mostrar_usuarios($usuario, $rol);
        $this->load->view('usuarios/contenido_tabla',$data);
    }

    //Genera el contenido de los permisos de cada usuario
    public function contenido_permisos($idus){

        $idusuario = $idus;
        

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
        $menu = $this->mu->consultar_menu_sistema(0,1);

        foreach($menu as $padre){

            $str.= '<div class="row">
                        <div class="col-md-6">
                            <h6>'.$padre->vPermiso.'</h6>
                        </div>
                        ';  
            //Obtiene el listado de submenu            
            $submenu = $this->mu->consultar_menu_sistema($padre->iIdPermiso,1);

            //Valida el menu principal para ver si tiene asignado un permiso la tabla de permisos por usuario
            $checkusuario = $this->mu->mostrar_permisos_usuario($idusuario,$padre->iIdPermiso);

            if(count($checkusuario)>0){

                foreach($checkusuario as $value){
                    
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

                //Valida el menu principal para ver si tiene asignado un permiso la tabla de permisos por rol
                $checkrol = $this->mu->mostrar_permisos_rol($idusuario,$padre->iIdPermiso,0,1);

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
                        $default = 0;
                    }
                }else{

                    $opc_0='';
                    $opc_1='';
                    $opc_2='';
                    $default = 0;
                }  
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

                    //Valida el submenu para ver si tiene asignado un permiso la tabla de permisos por usuario
                    $checkusuario_submenu = $this->mu->mostrar_permisos_usuario($idusuario,$hijo->iIdPermiso);

                    if(count($checkusuario_submenu) > 0){
                        foreach($checkusuario_submenu as $value){

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
                        //Valida el submenu para ver si tiene asignado un permiso la tabla de permisos por rol
                        $checkrol_submenu = $this->mu->mostrar_permisos_rol($idusuario,$padre->iIdPermiso,0,1);

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
                                $default = 0;
                            }
                        }else{

                            $opc_0='';
                            $opc_1='';
                            $opc_2='';
                            $default = 0;
                        }                    
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
        $menu = $this->mu->consultar_menu_sistema(0,2);

        foreach($menu as $funciones){

            $str.= '<div class="row">
                        <div class="col-md-6">
                            <h6>'.$funciones->vPermiso.'</h6>
                        </div>
                        ';

            //Valida el menu principal para ver si tiene asignado un permiso la tabla de permisos por usuario
            $checkusuario = $this->mu->mostrar_permisos_usuario($idusuario,$funciones->iIdPermiso);

            if(count($checkusuario)>0){

                foreach($checkusuario as $value){
                    
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

                //Valida el menu principal para ver si tiene asignado un permiso la tabla de permisos por rol
                $checkrol = $this->mu->mostrar_permisos_rol($idusuario,$funciones->iIdPermiso,0,2);

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
                        $default = 0;
                    }
                }else{

                    $opc_0='';
                    $opc_1='';
                    $opc_2='';
                    $default = 0;
                }  
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

        /*$str.='<input type="hidden" name="id_usuario" value="'.$idusuario.'">
                <center>
                    <button id="guardarpermisos" class="btn waves-effect waves-light btn-success" type="submit" disabled="true">Guardar</button>
                    <button type="reset" class="btn waves-effect waves-light btn-inverse" onclick="buscarUsuario2()">Cancelar</button>
                </center>';*/

        $str.='<input type="hidden" name="id_usuario" value="'.$idusuario.'">
                <center>
                    <button id="guardarpermisos" class="btn waves-effect waves-light btn-success" type="submit" disabled="true">Guardar</button>                    
                </center>';

                if($this->mu->validar_permisos($idusuario) == TRUE){

                    $validacion = 1;

                }else{

                    $validacion = 0;
                }

                $str.= '<input type="hidden" id="validacionbtn" name="" value="'.$validacion.'">';

        return $str;

    }

    //Sobreescribe los permisos asignados a cada usuario
    public function restart(){

        $var = $this->input->post('val',true);
        $id_us = $this->input->post('id_usuario',true);

        if($this->mu->validar_permisos($id_us) == TRUE){

            $this->mu->eliminar_permisosusuario($id_us);

        }

        foreach($var as $valor => $value){

            if($value == 1){

                $resultado = $this->input->post($valor,true);

                $data['iIdUsuario'] = $id_us;
                $data['iIdPermiso'] = $valor;
                $data['iTipoAcceso'] = $resultado;

                $this->mu->agregar_permisos($data);

            }else{
                
            }

        }
        echo "correcto";
    }

    //Elimina los permisos especiales de un usuario
    public function restore(){

        if(isset($_POST['id'])){

            $id = $this->input->post('id',true);

            $resultado = $this->mu->eliminar_permisosusuario($id);

            if($resultado == TRUE){

                echo $resultado;
            }else{

                echo $resultado;
            }

        }else{
            echo "algo salio mal";
        }
    }
}
?>