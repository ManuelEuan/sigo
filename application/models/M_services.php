<?php
class M_services extends CI_Model
{
    function __construct()
	{
		parent::__construct();
        $this->sigo = $this->load->database('default',TRUE);
       // $this->sigo2030 = $this->load->database('sigo2030',TRUE);
        //$this->ssop = $this->load->database('ssop',TRUE);
    }

    function avance_ods_sigo2030()
    {
    	//CON ODS INDIRECTOS
    	$sql = 'SELECT od."iIdOds", COUNT(od."iIdDetalleActividad") AS acts, SUM(od."nAvance") AS avance
				FROM 
					((SELECT met."iIdOds", da."iIdDetalleActividad", da."nAvance"
					FROM "DetalleActividad" da
					INNER JOIN "Actividad" act  ON act."iIdActividad" = da."iIdActividad"
					INNER JOIN "IndicadorMetaODS" ind ON ind."iIdIndicadorMetaOds" = act."iIdIndicadorMetaOds"
					INNER JOIN "MetaODS" met ON met."iIdMetaOds" = ind."iIdMetaOds"
					WHERE da."iActivo" = 1) UNION (	SELECT DISTINCT met."iIdOds", da."iIdDetalleActividad", da."nAvance" 
						FROM "DetalleActividad" da
						INNER JOIN "Actividad" act  ON act."iIdActividad" = da."iIdActividad" 
						INNER JOIN "ActividadMetaODS" am ON am."iIdActividad" = act."iIdActividad"
						INNER JOIN "MetaODS" met ON met."iIdMetaOds" = am."iIdMetaOds"
						WHERE da."iActivo" = 1)) AS od
				GROUP BY od."iIdOds"
				ORDER BY od."iIdOds"';

		// SOLO ODS DIRECTOS
		/*$sql = 'SELECT od."iIdOds", COUNT(od."iIdDetalleActividad") AS acts, SUM(od."nAvance") AS avance
				FROM (SELECT met."iIdOds", da."iIdDetalleActividad", da."nAvance"
					FROM "DetalleActividad" da
					INNER JOIN "Actividad" act  ON act."iIdActividad" = da."iIdActividad"
					INNER JOIN "IndicadorMetaODS" ind ON ind."iIdIndicadorMetaOds" = act."iIdIndicadorMetaOds"
					INNER JOIN "MetaODS" met ON met."iIdMetaOds" = ind."iIdMetaOds"
					WHERE da."iActivo" = 1) AS od
				GROUP BY od."iIdOds"
				ORDER BY od."iIdOds"';*/
		return $this->sigo2030->query($sql);
    }

    function avance_ods_sigo()
    {
    	$sql = 'SELECT od."iIdOds", COUNT(od."iIdDetalleActividad") AS acts, SUM(od."nAvance") AS avance
				FROM (SELECT DISTINCT la."iIdOds", da."iIdDetalleActividad", da."nAvance"
				FROM "DetalleActividad" da
				INNER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = da."iIdActividad"
				INNER JOIN "PED2019LineaAccion" la ON la."iIdLineaAccion" = al."iIdLineaAccion"
				WHERE da."iActivo" = 1) od
				GROUP BY od."iIdOds"
				ORDER BY od."iIdOds"';
		return $this->sigo->query($sql);
    }

    function avance_ods_ssop()
    {
    	/*$sql = 'SELECT ods."iIdOds", COUNT(ods."iIdObra") acts, SUM(ods."iAvanceFisico") AS avance 
				FROM (SELECT Distinct o."iIdObra", la."iIdOds", c."iAvanceFisico"
				FROM "Obra" o
				INNER JOIN "Alineacion" al ON al."iIdObra" = o."iIdObra"
				INNER JOIN "PED2019LineaAccion" la ON la."iIdLineaAccion" = al."iIdLineaAccion"
				INNER JOIN "Contrato" c ON c."iIdObra" = o."iIdObra" AND c."iActivo" = 1
				WHERE o."iActivo" = 1) ods 
				GROUP BY ods."iIdOds"
				ORDER BY ods."iIdOds"';*/
		$sql = 'SELECT ods."iIdOds", COUNT(ods."iIdObra") acts, SUM(ods."iAvanceFisico") AS avance 
				FROM (SELECT Distinct o."iIdObra", od."iIdOds", c."iAvanceFisico"
				FROM "Obra" o
				INNER JOIN "ObraODS" od ON od."iIdObra" = o."iIdObra"				
				INNER JOIN "Contrato" c ON c."iIdObra" = o."iIdObra" AND c."iActivo" = 1
				WHERE o."iActivo" = 1) ods 
				GROUP BY ods."iIdOds"
				ORDER BY ods."iIdOds"';
		return $this->ssop->query($sql);
    }

    function avance_muni_ods_sigo()
    {
    	$sql = 'SELECT mun."iIdMunicipio", od."iIdOds", SUM(av."nAvance") avance
				FROM (SELECT DISTINCT la."iIdOds", da."iIdDetalleActividad"
				FROM "DetalleActividad" da
				INNER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = da."iIdActividad"
				INNER JOIN "PED2019LineaAccion" la ON la."iIdLineaAccion" = al."iIdLineaAccion"
				WHERE da."iActivo" = 1) od
				INNER JOIN "DetalleEntregable" de ON de."iIdDetalleActividad" = od."iIdDetalleActividad" AND de."iActivo" = 1
				INNER JOIN "Avance" av ON av."iIdDetalleEntregable" = de."iIdDetalleEntregable" AND av."iActivo" = 1 AND av."iAprobado" = 1
				INNER JOIN "Municipio" mun ON mun."iIdMunicipio" = av."iMunicipio"
				GROUP BY mun."iIdMunicipio", od."iIdOds"
				ORDER BY mun."iIdMunicipio", od."iIdOds"';
    	return $this->sigo->query($sql);
    }

    function municipios()
    {
    	$sql = 'SELECT "iIdMunicipio", "vMunicipio" FROM "Municipio" m';
    	return $this->sigo->query($sql);
    }

    function acciones_ods_sigo($ods)
    {
    	$sql = 'SELECT COALESCE(SUM(avan.avance),0) avance, COALESCE(SUM(avan.beneficiarios),0) beneficiarios
				FROM (SELECT fechas.avance,  
							(CASE en."iMismosBeneficiarios"
									 WHEN 1 THEN mismosben.beneficiarios
									 WHEN 0 THEN fechas.beneficiarios
							 END ) AS beneficiarios
							FROM (SELECT DISTINCT da."iIdDetalleActividad"
							FROM "DetalleActividad" da
							INNER JOIN "ActividadLineaAccion" al ON al."iIdActividad" = da."iIdActividad"
							INNER JOIN "PED2019LineaAccion" la ON la."iIdLineaAccion" = al."iIdLineaAccion"
							WHERE da."iActivo" = 1 AND la."iIdOds" = '.$ods.') od
							INNER JOIN "DetalleEntregable" de On de."iIdDetalleActividad" = od."iIdDetalleActividad" AND de."iActivo" = 1
							INNER JOIN "Entregable" en ON en."iIdEntregable" = de."iIdEntregable"
							INNER JOIN (SELECT "iIdDetalleEntregable", MAX("dFecha") maxfecha, SUM("nAvance") avance, SUM("nBeneficiariosH" + "nBeneficiariosM") beneficiarios FROM "Avance"  WHERE "iActivo" = 1 AND "iAprobado" = 1 GROUP BY "iIdDetalleEntregable") fechas ON fechas."iIdDetalleEntregable" = de."iIdDetalleEntregable"
							LEFT OUTER JOIN (SELECT "iIdDetalleEntregable", "dFecha", SUM("nBeneficiariosH" + "nBeneficiariosM") beneficiarios FROM "Avance"  WHERE "iActivo" = 1 AND "iAprobado" = 1 GROUP BY "iIdDetalleEntregable", "dFecha") AS mismosben ON mismosben."dFecha" = fechas.maxfecha AND mismosben."iIdDetalleEntregable" = de."iIdDetalleEntregable"
							) AS avan';
		$query = $this->sigo->query($sql);
		return ($query) ? $query->row():false;
    }

    function acciones_ods_sigo2030($ods)
    {
    	//CON INDICADORES INDIRECTOS
    	$sql = 'SELECT COALESCE(SUM(avan.avance),0) avance, COALESCE(SUM(avan.beneficiarios),0) beneficiarios
				FROM (SELECT fechas.avance,  
							(CASE en."iMismosBeneficiarios"
									 WHEN 1 THEN mismosben.beneficiarios
									 WHEN 0 THEN fechas.beneficiarios
							 END ) AS beneficiarios
							FROM (SELECT od."iIdDetalleActividad"
				FROM 
					((SELECT da."iIdDetalleActividad"
					FROM "DetalleActividad" da
					INNER JOIN "Actividad" act  ON act."iIdActividad" = da."iIdActividad"
					INNER JOIN "IndicadorMetaODS" ind ON ind."iIdIndicadorMetaOds" = act."iIdIndicadorMetaOds"
					INNER JOIN "MetaODS" met ON met."iIdMetaOds" = ind."iIdMetaOds"
					WHERE da."iActivo" = 1 AND met."iIdOds" = '.$ods.') UNION (	SELECT DISTINCT da."iIdDetalleActividad" 
						FROM "DetalleActividad" da
						INNER JOIN "Actividad" act  ON act."iIdActividad" = da."iIdActividad" 
						INNER JOIN "ActividadMetaODS" am ON am."iIdActividad" = act."iIdActividad"
						INNER JOIN "MetaODS" met ON met."iIdMetaOds" = am."iIdMetaOds"
						WHERE da."iActivo" = 1 AND met."iIdOds" = '.$ods.')) AS od
				GROUP BY od."iIdDetalleActividad") od
							INNER JOIN "DetalleEntregable" de On de."iIdDetalleActividad" = od."iIdDetalleActividad" AND de."iActivo" = 1
							INNER JOIN "Entregable" en ON en."iIdEntregable" = de."iIdEntregable"
							INNER JOIN (SELECT "iIdDetalleEntregable", MAX("dFecha") maxfecha, SUM("nAvance") avance, SUM("nBeneficiariosH" + "nBeneficiariosM") beneficiarios FROM "Avance"  WHERE "iActivo" = 1 AND "iAprobado" = 1 GROUP BY "iIdDetalleEntregable") fechas ON fechas."iIdDetalleEntregable" = de."iIdDetalleEntregable"
							LEFT OUTER JOIN (SELECT "iIdDetalleEntregable", "dFecha", SUM("nBeneficiariosH" + "nBeneficiariosM") beneficiarios FROM "Avance"  WHERE "iActivo" = 1 AND "iAprobado" = 1 GROUP BY "iIdDetalleEntregable", "dFecha") AS mismosben ON mismosben."dFecha" = fechas.maxfecha AND mismosben."iIdDetalleEntregable" = de."iIdDetalleEntregable"
							) AS avan';
							
		// ODS DIRECTOS
		/*$sql = 'SELECT COALESCE(SUM(avan.avance),0) avance, COALESCE(SUM(avan.beneficiarios),0) beneficiarios
				FROM (SELECT fechas.avance,  
							(CASE en."iMismosBeneficiarios"
									 WHEN 1 THEN mismosben.beneficiarios
									 WHEN 0 THEN fechas.beneficiarios
							 END ) AS beneficiarios
							FROM (SELECT od."iIdDetalleActividad"
				FROM 
					(SELECT da."iIdDetalleActividad"
					FROM "DetalleActividad" da
					INNER JOIN "Actividad" act  ON act."iIdActividad" = da."iIdActividad"
					INNER JOIN "IndicadorMetaODS" ind ON ind."iIdIndicadorMetaOds" = act."iIdIndicadorMetaOds"
					INNER JOIN "MetaODS" met ON met."iIdMetaOds" = ind."iIdMetaOds"
					WHERE da."iActivo" = 1 AND met."iIdOds" = '.$ods.') AS od
				GROUP BY od."iIdDetalleActividad") od
							INNER JOIN "DetalleEntregable" de On de."iIdDetalleActividad" = od."iIdDetalleActividad" AND de."iActivo" = 1
							INNER JOIN "Entregable" en ON en."iIdEntregable" = de."iIdEntregable"
							INNER JOIN (SELECT "iIdDetalleEntregable", MAX("dFecha") maxfecha, SUM("nAvance") avance, SUM("nBeneficiariosH" + "nBeneficiariosM") beneficiarios FROM "Avance"  WHERE "iActivo" = 1 AND "iAprobado" = 1 GROUP BY "iIdDetalleEntregable") fechas ON fechas."iIdDetalleEntregable" = de."iIdDetalleEntregable"
							LEFT OUTER JOIN (SELECT "iIdDetalleEntregable", "dFecha", SUM("nBeneficiariosH" + "nBeneficiariosM") beneficiarios FROM "Avance"  WHERE "iActivo" = 1 AND "iAprobado" = 1 GROUP BY "iIdDetalleEntregable", "dFecha") AS mismosben ON mismosben."dFecha" = fechas.maxfecha AND mismosben."iIdDetalleEntregable" = de."iIdDetalleEntregable"
							) AS avan';*/
		$query = $this->sigo2030->query($sql);
		return ($query) ? $query->row():false;
    }

    function acciones_ods_ssop($ods)
    {
    	$sql = 'SELECT Distinct o."iIdObra", od."iIdOds", ac."nMeta" avance, o."vBeneficiarios" beneficiarios
				FROM "Obra" o
				INNER JOIN "ObraODS" od ON od."iIdObra" = o."iIdObra"				
				INNER JOIN "Contrato" c ON c."iIdObra" = o."iIdObra" AND c."iActivo" = 1
				INNER JOIN "Accion" ac ON ac."iIdContrato" = c."iIdContrato" AND ac."iActivo" = 1
				WHERE o."iActivo" = 1 AND od."iIdOds" = '.$ods;
		/*$sql = 'SELECT SUM(av.avance) avance, SUM(av.beneficiarios) beneficiarios
				FROM (SELECT Distinct o."iIdObra", od."iIdOds", ac."nMeta" avance, CAST(o."vBeneficiarios" AS INTEGER) beneficiarios
				FROM "Obra" o
				INNER JOIN "ObraODS" od ON od."iIdObra" = o."iIdObra"				
				INNER JOIN "Contrato" c ON c."iIdObra" = o."iIdObra" AND c."iActivo" = 1
				INNER JOIN "Accion" ac ON ac."iIdContrato" = c."iIdContrato" AND ac."iActivo" = 1
				WHERE o."iActivo" = 1 AND od."iIdOds" = '.$ods.') av';*/
		return $query = $this->ssop->query($sql)->result();
		//return ($query) ? $query->row():false;
    }
}