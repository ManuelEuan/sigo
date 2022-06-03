<?php

class M_compromisos extends CI_Model
{

	private $table = 'Entregable';
	private $idF = 'iIdEntregable';

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	//Muetra los ultimos 4 compromisos actualizados
	public function listar_compromisos4()
	{
		$this->db->select('cp.iIdCompromiso,cp.vCompromiso,cp.iNumero,cp.iIdDependencia');
		$this->db->from('CompromisoPag cp');
		$this->db->order_by('cp.dUltimaAct', 'DESC');
		$this->db->limit(4);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,
					'iIdDependencia' => $row->iIdDependencia
				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}

	//funcion que lista los documentos por compromiso
	public function listar_documentos($id_Compromiso)
	{
		$this->db->select('Evi.iIdEvidencia,Evi.vEvidencia,Evi.iFotoInicio,Evi.iOrdenFoto');
		$this->db->from('EvidenciaPag Evi');
		$this->db->join('ComponentePag cpag', 'Evi.iIdComponente = cpag.iIdComponente', 'JOIN');
		$this->db->join('CompromisoPag compag', 'cpag.iIdCompromiso = compag.iIdCompromiso', 'JOIN');
		$this->db->where("compag.iIdCompromiso='$id_Compromiso' and \"Evi.vTipo\"='Documento'");
		$this->db->order_by('Evi.iIdEvidencia', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos [] = [
					'vEvidencia' => $row->vEvidencia,
				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}

	//funcion que lista las fotos por compromiso
	public function listar_galeria($id_Compromiso)
	{
		$this->db->select('Evi.iIdEvidencia,Evi.vEvidencia,Evi.iFotoInicio,Evi.iOrdenFoto');
		$this->db->from('EvidenciaPag Evi');
		$this->db->join('ComponentePag cpag', 'Evi.iIdComponente = cpag.iIdComponente', 'JOIN');
		$this->db->join('CompromisoPag compag', 'cpag.iIdCompromiso = compag.iIdCompromiso', 'JOIN');
		$this->db->where("compag.iIdCompromiso='$id_Compromiso' and \"Evi.vTipo\"='Fotografía'");
		$this->db->order_by('Evi.iOrdenFoto', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos [] = [
					'vEvidencia' => $row->vEvidencia,
				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}

	//funcion que list los videos por compromiso
	public function listar_videos($id_Compromiso)
	{
		$this->db->select('Evi.iIdEvidencia,Evi.vEvidencia');
		$this->db->from('EvidenciaPag Evi');
		$this->db->join('ComponentePag cpag', 'Evi.iIdComponente = cpag.iIdComponente', 'JOIN');
		$this->db->join('CompromisoPag compag', 'cpag.iIdCompromiso = compag.iIdCompromiso', 'JOIN');
		$this->db->where("compag.iIdCompromiso='$id_Compromiso' and \"Evi.vTipo\"='Video'");
		$this->db->order_by('Evi.iIdEvidencia', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos [] = [
					'vEvidencia' => $row->vEvidencia,
				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}
	//funcion que lista las fotos de portada
	public function listar_fotos_portada($id_Compromiso)
	{
		$this->db->select('Evi.iIdEvidencia,Evi.vEvidencia,Evi.iFotoInicio,Evi.iOrdenFoto');
		$this->db->from('EvidenciaPag Evi');
		$this->db->join('ComponentePag cpag', 'Evi.iIdComponente = cpag.iIdComponente', 'JOIN');
		$this->db->join('CompromisoPag compag', 'cpag.iIdCompromiso = compag.iIdCompromiso', 'JOIN');
		$this->db->where("compag.iIdCompromiso='$id_Compromiso' and \"Evi.iFotoInicio\"='1' and \"Evi.vTipo\"='Fotografía'");
		$this->db->order_by('Evi.iOrdenFoto', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos [] = [
					'vEvidencia' => $row->vEvidencia,
				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}
	//funcion que lista las fotos inicio por compromiso, recupera la foto principal de portada
	public function recuperar_fotografias($id_Compromiso)
	{
		$this->db->select('Evi.iIdEvidencia,Evi.vEvidencia,Evi.iFotoInicio,Evi.iOrdenFoto');
		$this->db->from('EvidenciaPag Evi');
		$this->db->join('ComponentePag cpag', 'Evi.iIdComponente = cpag.iIdComponente', 'JOIN');
		$this->db->join('CompromisoPag compag', 'cpag.iIdCompromiso = compag.iIdCompromiso', 'JOIN');
		$this->db->where("compag.iIdCompromiso='$id_Compromiso' and \"Evi.iFotoInicio\"='1' and \"Evi.vTipo\"='Fotografía'");
		$this->db->order_by('Evi.iOrdenFoto', 'asc');
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos = array(
					'vEvidencia' => $row->vEvidencia,
				);
			}
		} else {
			$datos = array(
				'vEvidencia' => null
			);
		}
		return $datos;
	}
	//funcion que lista los ultimos 10 compromisos actualizados
	public function listar_compromisos10()
	{
		$this->db->select('cp.iIdCompromiso,cp.vCompromiso,cp.vDescripcion,cp.iIdDependencia');
		$this->db->from('CompromisoPag cp');
		$this->db->order_by('cp.dUltimaAct', 'DESC');
		$this->db->limit(10);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'vDescripcion' => $row->vDescripcion,
					'iIdDependencia' => $row->iIdDependencia,
					'imagenes' => $imagenes,
				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}
	//funcion que lista los compromisos por cumplidos
	public function listar_compromisos()
	{
		$orden_by = 'cp.dUltimaAct AND cp.iIdCompromiso';
		$this->db->select('cp.iIdCompromiso,cp.vCompromiso,cp.iNumero,dPorcentajeAvance,cp.iIdDependencia');
		$this->db->from('CompromisoPag cp');
		$this->db->order_by('cp.iIdCompromiso', 'ASC');
		$this->db->where('iEstatus', 6);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,
					'dPorcentajeAvance' => $row->dPorcentajeAvance,
					'iIdDependencia' => $row->iIdDependencia


				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}
	//funcion que lista los compromisos por cumplidos
	public function listar_compromisosP()
	{
		$orden_by = 'cp.dUltimaAct AND cp.iIdCompromiso';
		$this->db->select('cp.iIdCompromiso,cp.vCompromiso,cp.iNumero,dPorcentajeAvance,cp.iIdDependencia');
		$this->db->from('CompromisoPag cp');
		$this->db->order_by('cp.iIdCompromiso', 'ASC');
		$this->db->where('iEstatus', 5);
		//$this->db->limit(10);


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,
					'dPorcentajeAvance' => $row->dPorcentajeAvance,
					'iIdDependencia' => $row->iIdDependencia


				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function listar_compromisosI()
	{
		$orden_by = 'cp.dUltimaAct AND cp.iIdCompromiso';
		$this->db->select('cp.iIdCompromiso,cp.vCompromiso,cp.iNumero,dPorcentajeAvance,cp.iIdDependencia');
		$this->db->from('CompromisoPag cp');
		$this->db->order_by('cp.iIdCompromiso', 'ASC');
		$this->db->where('iEstatus', 4);
		//$this->db->limit(10);


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,
					'dPorcentajeAvance' => $row->dPorcentajeAvance,
					'iIdDependencia' => $row->iIdDependencia


				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function listar_descripcion_compromiso($key)
	{
		$this->db->select('cp.vCompromiso,cp.iNumero');
		$this->db->from('CompromisoPag cp');
		//$this->db->order_by('cp.iIdCompromiso', 'ASC');
		$this->db->where('cp.iIdCompromiso', $key);
		//$this->db->limit(10);


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [

					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,


				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function listar_responsable($key)
	{
		$this->db->select('De.vDependencia');
		$this->db->from('Dependencia De');
		//$this->db->order_by('cp.iIdCompromiso', 'ASC');
		$this->db->where('De.iIdDependencia', $key);
		//$this->db->limit(10);


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [

					'vDependencia' => $row->vDependencia
				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function listar_participantes($key)
	{
		$this->db->select('de.vDependencia');
		$this->db->from('CompromisoCorresponsablePag cc');
		$this->db->join('Dependencia de', 'cc.iIdDependencia = de.iIdDependencia', 'JOIN');

		//$this->db->order_by('cp.iIdCompromiso', 'ASC');
		$this->db->where('cc.iIdCompromiso', $key);
		//$this->db->limit(10);


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [

					'vDependencia' => $row->vDependencia
				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function listar_componentes($key)
	{
		$this->db->select('cp.iIdComponente,cp.vComponente,cp.nAvance,cp.vDescripcion');
		$this->db->from('ComponentePag cp');
		$this->db->order_by('cp.iOrden', 'DESC');
		$this->db->where('iIdCompromiso', $key);


		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [
					'iIdComponente' => $row->iIdComponente,
					'vComponente' => $row->vComponente,
					'nAvance' => $row->nAvance,
					'vDescripcion' => $row->vDescripcion
				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function buscar($buscar, $id_dependencia = FALSE, $inicio = FALSE, $cantidadregistro = FALSE)
	{
		//$this->db->ilike("vCompromiso", $buscar);
		if ($id_dependencia == 0) {

			$this->db->select("*");
			$this->db->from('CompromisoPag cp');

			$this->db->where("iEstatus='6' and \"vCompromiso\" ilike '%$buscar%'");
			$this->db->order_by('iNumero', 'ASC');

			if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
				$this->db->limit($cantidadregistro, $inicio);
			}
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
					$datos[] = [
						'iIdCompromiso' => $row->iIdCompromiso,
						'vCompromiso' => $row->vCompromiso,
						'iNumero' => $row->iNumero,
						'dPorcentajeAvance' => $row->dPorcentajeAvance,
						'iIdDependencia' => $row->iIdDependencia,
						'imagenes' => $imagenes


					];
				}
			} else {
				$datos = array();
			}


			return $datos;


			//$this->db->limit(10);


		} else {

			$this->db->select("*");
			$this->db->from('CompromisoPag cp');

			$this->db->where("iEstatus='6' and \"iIdDependencia\"='$id_dependencia'");
			$this->db->order_by('iNumero', 'ASC');

			if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
				$this->db->limit($cantidadregistro, $inicio);
			}
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
					$datos[] = [
						'iIdCompromiso' => $row->iIdCompromiso,
						'vCompromiso' => $row->vCompromiso,
						'iNumero' => $row->iNumero,
						'dPorcentajeAvance' => $row->dPorcentajeAvance,
						'iIdDependencia' => $row->iIdDependencia,
						'imagenes' => $imagenes


					];
				}
			} else {
				$datos = array();
			}


			return $datos;
		}
	}

	public function buscar_number($buscar, $inicio = FALSE, $cantidadregistro = FALSE)
	{
		//$this->db->ilike("vCompromiso", $buscar);
		$text = 'CAST ("iNumero" AS text)';


		$this->db->select("*");
		$this->db->from('CompromisoPag cp');

		$this->db->where("iEstatus='6' and $text like '%$buscar%'");
		$this->db->order_by('iNumero', 'ASC');

		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro, $inicio);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,
					'dPorcentajeAvance' => $row->dPorcentajeAvance,
					'iIdDependencia' => $row->iIdDependencia,
					'imagenes' => $imagenes


				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function buscar_proceso($buscar, $id_dependencia = FALSE, $inicio = FALSE, $cantidadregistro = FALSE)
	{
		if ($id_dependencia == 0) {

			$this->db->select("*");
			$this->db->from('CompromisoPag cp');

			$this->db->where("iEstatus='5' and \"vCompromiso\" ilike '%$buscar%'");
			$this->db->order_by('iNumero', 'ASC');

			if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
				$this->db->limit($cantidadregistro, $inicio);
			}
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
					$datos[] = [
						'iIdCompromiso' => $row->iIdCompromiso,
						'vCompromiso' => $row->vCompromiso,
						'iNumero' => $row->iNumero,
						'dPorcentajeAvance' => $row->dPorcentajeAvance,
						'iIdDependencia' => $row->iIdDependencia,
						'imagenes' => $imagenes
					];
				}
			} else {
				$datos = array();
			}
			return $datos;
		} else {

			$this->db->select("*");
			$this->db->from('CompromisoPag cp');

			$this->db->where("iEstatus='5' and \"iIdDependencia\"='$id_dependencia'");
			$this->db->order_by('iNumero', 'ASC');

			if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
				$this->db->limit($cantidadregistro, $inicio);
			}
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
					$datos[] = [
						'iIdCompromiso' => $row->iIdCompromiso,
						'vCompromiso' => $row->vCompromiso,
						'iNumero' => $row->iNumero,
						'dPorcentajeAvance' => $row->dPorcentajeAvance,
						'iIdDependencia' => $row->iIdDependencia,
						'imagenes' => $imagenes


					];
				}
			} else {
				$datos = array();
			}


			return $datos;
		}
	}

	public function buscar_proceso_number($buscar, $inicio = FALSE, $cantidadregistro = FALSE)
	{
		//$this->db->ilike("vCompromiso", $buscar);
		$text = 'CAST ("iNumero" AS text)';


		$this->db->select("*");
		$this->db->from('CompromisoPag cp');

		$this->db->where("iEstatus='5' and $text like '%$buscar%'");
		$this->db->order_by('iNumero', 'ASC');

		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro, $inicio);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,
					'dPorcentajeAvance' => $row->dPorcentajeAvance,
					'iIdDependencia' => $row->iIdDependencia,
					'imagenes' => $imagenes


				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function buscar_iniciar($buscar, $id_dependencia = FALSE, $inicio = FALSE, $cantidadregistro = FALSE)
	{
		if ($id_dependencia == 0) {

			$this->db->select("*");
			$this->db->from('CompromisoPag cp');

			$this->db->where("iEstatus='4' and \"vCompromiso\" ilike '%$buscar%'");
			$this->db->order_by('iNumero', 'ASC');

			if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
				$this->db->limit($cantidadregistro, $inicio);
			}
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
					$datos[] = [
						'iIdCompromiso' => $row->iIdCompromiso,
						'vCompromiso' => $row->vCompromiso,
						'iNumero' => $row->iNumero,
						'dPorcentajeAvance' => $row->dPorcentajeAvance,
						'iIdDependencia' => $row->iIdDependencia,
						'imagenes' => $imagenes


					];
				}
			} else {
				$datos = array();
			}


			return $datos;


			//$this->db->limit(10);


		} else {

			$this->db->select("*");
			$this->db->from('CompromisoPag cp');

			$this->db->where("iEstatus='4' and \"iIdDependencia\"='$id_dependencia'");
			$this->db->order_by('iNumero', 'ASC');

			if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
				$this->db->limit($cantidadregistro, $inicio);
			}
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
					$datos[] = [
						'iIdCompromiso' => $row->iIdCompromiso,
						'vCompromiso' => $row->vCompromiso,
						'iNumero' => $row->iNumero,
						'dPorcentajeAvance' => $row->dPorcentajeAvance,
						'iIdDependencia' => $row->iIdDependencia,
						'imagenes' => $imagenes


					];
				}
			} else {
				$datos = array();
			}


			return $datos;
		}
	}

	public function buscar_iniciar_number($buscar, $inicio = FALSE, $cantidadregistro = FALSE)
	{

		$text = 'CAST ("iNumero" AS text)';
		$this->db->select("*");
		$this->db->from('CompromisoPag cp');

		$this->db->where("iEstatus='4' and $text like '%$buscar%'");
		$this->db->order_by('iNumero', 'ASC');

		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro, $inicio);
		}
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$imagenes = $this->recuperar_fotografias($row->iIdCompromiso);
				$datos[] = [
					'iIdCompromiso' => $row->iIdCompromiso,
					'vCompromiso' => $row->vCompromiso,
					'iNumero' => $row->iNumero,
					'dPorcentajeAvance' => $row->dPorcentajeAvance,
					'iIdDependencia' => $row->iIdDependencia,
					'imagenes' => $imagenes


				];
			}
		} else {
			$datos = array();
		}


		return $datos;
	}

	public function recuperar_dependencias()
	{
		$this->db->select('d.iIdDependencia,d.vDependencia');
		$this->db->from('Dependencia d');
		$this->db->order_by('d.vDependencia', 'ASC');
		$this->db->where('iActivo', 1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datos[] = [
					'iIdDependencia' => $row->iIdDependencia,
					'vDependencia' => $row->vDependencia

				];
			}
		} else {
			$datos = array();
		}
		return $datos;
	}


}

?>
