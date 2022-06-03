<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'control_pagina/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//======================Acciones compromisos====================================//
$route['compromisos/listar'] = 'C_compromisos/index';

$route['acciones/compromisos/listar_4'] = 'Control_pagina/ListarCompromisos4';
$route['acciones/compromisos/listar_10'] = 'Control_pagina/ListarCompromisos10';
$route['acciones/compromisos/listar'] = 'C_compromisos/ListarCompromisos';
$route['acciones/compromisos/listarP'] = 'C_compromisos/ListarCompromisosP';
$route['acciones/compromisos/listarI'] = 'C_compromisos/ListarCompromisosI';
$route['acciones/compromisos/mostrar'] = 'C_compromisos/mostrar';
$route['acciones/compromisos/mostrar_number'] = 'C_compromisos/mostrar_number';
$route['acciones/compromisos/mostrar_procesos'] = 'C_compromisos/mostrarProcesos';
$route['acciones/compromisos/mostrar_procesos_number'] = 'C_compromisos/procesos_number';
$route['acciones/compromisos/mostrar_procesos_iniciar'] = 'C_compromisos/mostrarProcesosIniciar';
$route['acciones/compromisos/mostrar_procesos_number_iniciar'] = 'C_compromisos/procesos_numberIniciar';
$route['acciones/compromisos/listar_dependencias'] = 'C_compromisos/listar_dependencias';







$route['compromisos/descripcion/(:any)/(:any)'] = 'C_compromisos_descripcion/index';
$route['acciones/compromisos/componentes/(:any)'] = 'C_compromisos_descripcion/ListarComponentes';

//=======================Acciones bienes y servicios===========//
$route['acciones/bienesyservicios/agregar'] = 'C_Bienesys/AgregarServicio';
$route['acciones/bienesyservicios/listar_unidad_medida'] = 'C_Bienesys/listar_unidad_medida';
$route['acciones/bienesyservicios/eliminar'] = 'C_Bienesys/EliminarServicio';
$route['acciones/bienesyservicios/listar/(:any)'] = 'C_Bienesys/ListarServicios';
$route['acciones/bienesyservicios/actualizar/(:any)'] = 'C_Bienesys/ActualizarServicio';

//=======================Acciones poblaciones===========//
$route['acciones/poblaciones/agregar'] = 'C_Poblaciones/AgregarPoblaciones';
$route['acciones/poblaciones/listar_unidad_medida'] = 'C_Poblaciones/'; //esta ruta puede que sirva
$route['acciones/poblaciones/eliminar'] = 'C_Poblaciones/EliminarPoblacion';
$route['acciones/poblaciones/listar/(:any)'] = 'C_Poblaciones/ListarDefPoblacion';
$route['acciones/poblaciones/actualizar'] = 'C_Poblaciones/ActualizarPoblacion';
$route['acciones/poblaciones/listar_grupo_edad'] = 'C_Poblaciones/listar_grupo_Edad';

//=======================Acciones otros criterios===========//
$route['formatos/criterios/(:any)/(:any)'] = 'C_otros_criterios/index';
$route['acciones/criterios/agregar'] = 'C_otros_criterios/AgregarCriterio';
$route['acciones/criterios/listar/(:any)'] = 'C_otros_criterios/ListarCriterios';
$route['acciones/criterios/eliminar'] = 'C_otros_criterios/EliminarCriterio';
$route['acciones/criterios/actualizar'] = 'C_otros_criterios/ActualizarCriterio';

//=======================Acciones de fuentes de las poblaciones===========//
$route['formatos/Pfuentes/(:any)/(:any)'] = 'C_fuentes_otros/index';
$route['acciones/Pfuentes/agregar'] = 'C_fuentes_otros/AgregarCriterio';
$route['acciones/Pfuentes/listar/(:any)'] = 'C_fuentes_otros/ListarCriterios';
$route['acciones/Pfuentes/eliminar'] = 'C_fuentes_otros/EliminarCriterio';
$route['acciones/Pfuentes/actualizar'] = 'C_fuentes_otros/ActualizarCriterio';
$route['acciones/Pfuentes/file'] = 'C_fuentes_otros/add_files';
$route['borrar/criteriofocalizacion/file'] = 'C_fuentes_otros/drop_files';
