<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function SumaDiasAFecha($fecha,$dias)
{	
	$fecha_nueva=strtotime("+".$dias." days", $fecha);
	$fecha_final = date("Y\-m\-d",$fecha_nueva);
	return($fecha_final);
}

function DecimalMoneda($decin)
{
	if($decin > 0 || $decin < 0) return number_format($decin, 2, '.', ',');
	else return 0;
}

function Decimal($decin, $numdecimales=2)
{
	$numero = number_format($decin,$numdecimales,'.',',');
	//verificamos los cuatro ultimos decimales
	$cont = $numdecimales;
	while( $cont > 0 ){
		//obtenemos el ultimo digito;si es cero se elimina. Si no es cero, nos salimos del ciclo.
		$ultimo = substr($numero, -1);
		if( strcmp($ultimo,"0") == 0){
			$resto = substr($numero,0,strlen($numero)-1);
			$numero = $resto;
		}
		else{
			break;
		}
		$cont--;
	}

	if(substr($numero,-1) == '.') $numero = substr($numero,0,strlen($numero)-1);
	return $numero;
}


//Convierte fecha de mysql a normal 
function cambiaf_a_normal($fecha,$incluirhora=false,$separador='/'){ 
	$anio = substr($fecha,0,4);
	$mes = substr($fecha,5,2);
	$dia = substr($fecha,8,2);
	if($anio == '1900' && $mes == '01' && $dia == '01')
	{
		$fecha = '';
	}
	else
	{
		if($incluirhora)
		{
			$hora = substr($fecha,11,8);
			$fecha= $hora." ".$dia.$separador.$mes.$separador.$anio;
		}else $fecha = $dia.$separador.$mes.$separador.$anio;
	}	
	
	return $fecha;
}

function cambiaf_a_mysql($fecha){
	$anio = substr($fecha,6,4);
	$mes = substr($fecha,3,2);
	$dia = substr($fecha,0,2);
    $lafecha=$anio."-".$mes."-".$dia;
    return $lafecha;
}

function DiaSemana($IntDia){
	$ValorDevuelto = "";
	switch($IntDia){
		case 1:
			$ValorDevuelto = "Domingo";
			break;
		case 2:
			$ValorDevuelto = "Lunes";
			break;
		case 3:
			$ValorDevuelto = "Martes";
			break;
		case 4:
			$ValorDevuelto = "Mi&eacute;rcoles";
			break;
		case 5:
			$ValorDevuelto = "Jueves";
			break;
		case 6:
			$ValorDevuelto = "Viernes";
			break;
		case 7:
			$ValorDevuelto = "S&aacute;bado";
			break;
	}
	return $ValorDevuelto;
}

function NombreMes($IntMes){
	$ValorDevuelto = "";
	switch($IntMes){
		case 1:
			$ValorDevuelto = "Enero";
			break;
		case 2:
			$ValorDevuelto = "Febrero";
			break;
		case 3:
			$ValorDevuelto = "Marzo";
			break;
		case 4:
			$ValorDevuelto = "Abril";
			break;
		case 5:
			$ValorDevuelto = "Mayo";
			break;
		case 6:
			$ValorDevuelto = "Junio";
			break;
		case 7:
			$ValorDevuelto = "Julio";
			break;
		case 8:
			$ValorDevuelto = "Agosto";
			break;
		case 9:
			$ValorDevuelto = "Septiembre";
			break;
		case 10:
			$ValorDevuelto = "Octubre";
			break;
		case 11:
			$ValorDevuelto = "Noviembre";
			break;
		case 12:
			$ValorDevuelto = "Diciembre";
			break;
	}
	return $ValorDevuelto;
}

function NombreMesAbrev($IntMes){
	$ValorDevuelto = "";
	switch($IntMes){
		case 1:
			$ValorDevuelto = "Ene";
			break;
		case 2:
			$ValorDevuelto = "Feb";
			break;
		case 3:
			$ValorDevuelto = "Mar";
			break;
		case 4:
			$ValorDevuelto = "Abr";
			break;
		case 5:
			$ValorDevuelto = "May";
			break;
		case 6:
			$ValorDevuelto = "Jun";
			break;
		case 7:
			$ValorDevuelto = "Jul";
			break;
		case 8:
			$ValorDevuelto = "Ago";
			break;
		case 9:
			$ValorDevuelto = "Sep";
			break;
		case 10:
			$ValorDevuelto = "Oct";
			break;
		case 11:
			$ValorDevuelto = "Nov";
			break;
		case 12:
			$ValorDevuelto = "Dic";
			break;
	}
	return $ValorDevuelto;
}

//Convierte fecha de mysql a fecha larga
function FechaLarga($fecha){ 
	$anio = substr($fecha,0,4);
	$mes = substr($fecha,5,2);
	$dia = substr($fecha,8,2);
	return $dia." de ".NombreMes((int)$mes)." de ".$anio;
}

function EliminaComas($cantidad){
	$numero =str_replace(",","",$cantidad);
	return $numero;	
}

function FormatCantidad($decin,$auto=true,$numdec=2){
	if($auto){
		//return number_format($decin,2,'.',',');
		$numero = number_format($decin,$numdec,'.',',');
		//verificamos los cuatro ultimos decimales
		$cont = 6;
		while( $cont > 0 ){
			//obtenemos el ultimo digito;si es cero se elimina. Si no es cero, nos salimos del ciclo.
			$ultimo = substr($numero, -1);
			if( strcmp($ultimo,"0") == 0 ){
				$resto = substr($numero,0,strlen($numero)-1);
				$numero = $resto;
			}
			else{
				break;
			}
			$cont--;
		}
		//si el ultimo es un punto lo eliminamos
		$ultimo = substr($numero, -1);
		if( strcmp($ultimo,".") == 0 ){
			$resto = substr($numero,0,strlen($numero)-1);
			$numero = $resto;
		}
		return $numero;
	}else{		
		$numero = number_format($decin,$numdec,'.',',');
		return $numero;
	}
}

//Prepara una cadena para imprimirla con echo
function LimpiaCadena($cadena){
	$sustituye = array("\r\n", "\n\r", "\n", "\r", ".", "'", ",");
	$cadena = str_replace($sustituye, "", $cadena);
	
	return $cadena;
}

//Prepara una cadena para guardarla en BD, reemplazando los caracteres especiales
function PreparaCadenaABD($cadena){
	$cadenaBD = '';
	$search  = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Ê');
	$replace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ú');
	$cadena = strtoupper($cadena);
	$cadenaBD =  str_replace($search, $replace, $cadena);
	return $cadenaBD;
}

function QuitaAcentosReporteCoordenadas($cadena){
	$cadenaBD = '';
	$search  = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ê','ñ','Ñ');
	$replace = array('A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'e','n','N');
	$cadenaBD =  str_replace($search, $replace, $cadena);
	$cadenaBD = utf8_decode(strtoupper($cadenaBD));
	return $cadenaBD;
}

function Paginador($obj_query,$pagina,$tamaniopag=10)
{
	/******** Valores devueltos *************/

	$d['resultado'] = array();
	$d['total_registros'] = ($obj_query != false) ? $obj_query->num_rows():0;
	$d['numero_paginas'] = ceil($d['total_registros'] / $tamaniopag);

	/******** Fin de valores devueltos ******/
	
	if($pagina < 0 ||  $pagina > $d['numero_paginas'])
	{
		$pagina = 1;
		$inicio = 0;
	}
	else $inicio = ($pagina - 1) * $tamaniopag;
	$fin = ($inicio + $tamaniopag > $d['total_registros']) ? $d['total_registros']:$inicio + $tamaniopag;
	
	for ($i=$inicio; $i < $fin; $i++)
	{ 
		$d['resultado'][$i] = $obj_query->row($i);
	}
	$d['numero_registros'] = $fin - $tamaniopag;
	$d['botones_paginacion'] = PintaBotonesPaginacion($d['total_registros'],$pagina,$d['numero_paginas']);

	return $d;
}

function PintaBotonesPaginacion($num_reg,$num_pag_actual,$num_pags,$num_btn_pag=5)
{
	$paginacion = '';
	$num_btn_lado = ($num_btn_pag - 1) / 2;
		
	if($num_pags > 1)
	{ 
		$paginacion .= '<div class="row">';
		$paginacion .= '<div class="col-md-6"><br><div class="text-left">'.$num_reg.' registros / Página '.$num_pag_actual.' de '.$num_pags.'</div></div>';
		$paginacion .= '<div class="col-md-6">';
		
		$paginacion .= '<nav aria-label="Page navigation example">';
			  $paginacion .= '<ul class="pagination">';
			  	
			  	$anterior = $num_pag_actual - 1;
			  	$siguiente = $num_pag_actual + 1;
			  	if($num_pag_actual == 1)
			  	{
			    	$paginacion .= '<li class="page-item disabled"><a href="#" class="page-link">Primero</a></li>';
					$paginacion .= '<li class="page-item disabled"><a href="#" class="page-link">Anterior</a></li>';
				}else
				{
					$paginacion .= '<li class="page-item"><a href="#" onclick="Buscar(1);" class="page-link">Primero</a></li>';
					$paginacion .= '<li class="page-item"><a href="#" onclick="Buscar('.$anterior.');" class="page-link">Anterior</a></li>';
				}

				if($num_pags > $num_btn_pag)
				{
				    if($num_pag_actual >= $num_btn_pag)
				    {
						if($num_pag_actual >= ($num_pags- $num_btn_pag +1))
						{
							$lim_inicio = $num_pags - $num_btn_pag + 1;
							$lim_fin = $num_pags;
						}
						else
						{
							$lim_inicio = $num_pag_actual-$num_btn_lado;
							$lim_fin = $num_pag_actual + $num_btn_lado;
						}
				    }else
				    {
				    	$lim_inicio = 1;
				    	$lim_fin = $num_btn_pag;
				    }
				}else
				{
					$lim_inicio = 1;
					$lim_fin = $num_pags;
				}

			    for($i=$lim_inicio; $i <= $lim_fin ; $i++)
			    { 
			    	if($num_pag_actual == $i) $paginacion .= '<li class="page-item active"><a href="#" class="page-link">'.$i.'</a></li>';
			    	else $paginacion .= '<li class="page-item"><a href="#" class="page-link" onclick="Buscar('.$i.');">'.$i.'</a></li>';
			    }

			    if($num_pag_actual == $num_pags)
			    {
			    	$paginacion .= '<li class="page-item disabled"><a href="#" class="page-link">Siguiente</a></li>';
					$paginacion .= '<li class="page-item disabled"><a href="#" class="page-link">Último</a></li>';
				}else
				{
					$paginacion .= '<li class="page-item"><a href="#" onclick="Buscar('.$siguiente.');" class="page-link">Siguiente</a></li>';
					$paginacion .= '<li class="page-item"><a href="#" onclick="Buscar('.$num_pags.');" class="page-link">Último</a></li>';
				}
			$paginacion .= '</ul>';
		$paginacion .= '</nav>';
		$paginacion .= '</div>';
		$paginacion .= '</div>';
	}
	else
	{
		if($num_reg > 0)
		{
			$paginacion .= '<div class="row">';
				$paginacion .= '<div class="col-md-6"><br><div class="text-left">'.$num_reg.' registros / Página '.$num_pag_actual.' de '.$num_pags.'</div></div>';
				$paginacion .= '<div class="col-md-6"></div>';
			$paginacion .= '</div>';
		}

	}
	return $paginacion;
}

function obtener_extension($filename)
{
    $pos = strrpos($filename, '.');
    if($pos===false) {
        return false;
    } else {
        return strtolower(substr($filename,$pos));
    }
}

function obtener_nombre($nombrearchivo)
{
	$pos = strrpos($nombrearchivo, '.');
    if($pos===false) {
        return false;
    } else {
        return substr($nombrearchivo,0,$pos);
    }
}

//############################dec_romana ($numero,$case)################
//#
//#     - De decimal a numeración romana
//#
//#     case da la opción de representar el numero con símbolos
//#     en minúscula o mayúscula (xlvii ó XLVII). Será "l" para
//#     el primer caso y "u" para el segundo (lower, upper)
//#####################################################################
 
function decimal_a_romano($numero,$case="u")
{
	$romano = '';
	$simbolos=array("I","V","X","L","C","D","M");
	$valores=array ("1","5","10","50","100","500","1000","5000");
	if ($numero<=3999) {
		while ($numero>0)
		{
			$i=0;
			while ($i<7)
			{
				while ($numero>=$valores[$i] && $numero<$valores[$i+1])
				{
					$par=$i%2;  // paridad
					if ($numero>=$valores[$i+1]-$valores[$i-$par])
					{
						$romano=$romano.$simbolos[$i-$par].$simbolos[$i+1];
						$numero=$numero-($valores[$i+1]-$valores[$i-$par]);
					}
					else
					{
						$romano=$romano.$simbolos[$i];
						$numero=$numero-$valores[$i];
					}
				}
				$i++;
			}
		}
		if ($case=="l") $romano=strtolower ($romano);
	}
	else $romano="overflow";
	return $romano;
}
 
// Ejemplo de uso -->  
//echo $numero=dec_romana("2349","u");

function generar_token()
{
	$var = rand(100000, 999999);
	return md5($var);
}

?>