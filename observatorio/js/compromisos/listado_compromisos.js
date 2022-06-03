$(document).ready(function () {
	/**Inicializar variables**/

	//recuperar_unidad_medida();
	url = $("#url").val();
	//listar_compromisos();
	buscar_datos();
	listar_dependencias();
});
//esta funcion es la principal, la que lanza los demas funciones dependiendo de lo que se pida
function evento(opcion) {
	$("#paginado").val(1);
	$("#txt_1").val(opcion);
	buscar_datos();
}
function buscar_datos() {
	marcador = $("#txt_1").val();
	textobuscar = $("#busqueda").val();
	busqueda_numero = $("#busqueda_numero").val();
	pagina = $("#paginado").val();
	id_dependencia = $("#cbo_dependencias").val();

	if (textobuscar != "") {
		//var b = document.querySelector("#busqueda_numero");
		//b.setAttribute("disabled", "");
		buscar = textobuscar;

	} else {

		buscar = (busqueda_numero == "") ? "" : parseInt(busqueda_numero);
	}

	if (marcador == 1) {
		mostrarDatos(buscar, pagina,id_dependencia);
	} else if(marcador == 2) {
		mostrar_procesos(buscar, pagina,id_dependencia);
	}else{
		mostrar_iniciar(buscar, pagina,id_dependencia);
	}
}

$("body").on("click", ".pagination li a", function (e) {
	e.preventDefault();
	$("#paginado").val($(this).attr("href"));

	buscar_datos();
});
function mostrarDatos(valorBuscar, pagina,id_dependencia) {
	var recurso;

	if (typeof (valorBuscar) == "string") {
		recurso = "acciones/compromisos/mostrar";
		$.ajax({

			url: url + recurso,
			type: "POST",
			data: {buscar: valorBuscar, nropagina: pagina,idDpendencia:id_dependencia},
			dataType: "json",
			success: function (response) {

				filas = "";
				var progress_color = ['progress-bar-primario', 'progress-bar-secundario', 'progress-bar-terciario', 'progress-bar-cuaternario'];
				var colors = ['#00A36A', '#212743', '#694688', '#6CBB37'];
				var i = 0;
				$.each(response.compromisos, function (key, item) {
					var imagen;
					if (item.imagenes.vEvidencia == null){
						imagen="project.jpg";
					}else{
						imagen=item.imagenes.vEvidencia;
					}


					filas += `<div class="col-sm-6 col-lg-3 isotope-item brands" ">
								<div class="portfolio-item">
										<a href="${url}compromisos/descripcion/${btoa(item.iIdCompromiso)}/${btoa(item.iIdDependencia)}">
											<span class="thumb-info thumb-info-lighten border-radius-0">
												<span class="thumb-info-wrapper border-radius-0">
														<img style="height: 250px !important;" src="${url}archivos/documentosImages/${imagen}" class="img-fluid border-radius-0" alt="">
														
														<span class="thumb-info-title" style="opacity: 0.7 !important;">
															<span style="font-size: 40px !important;text-align: center !important;" class="thumb-info-inner">${item.iNumero}</span>
															<span style="background-color: ${colors[i]} !important;" class="thumb-info-type">Compromiso</span>
														</span>
												</span>
											</span>
											<div class="progress mb-2" style="margin-top: 7px">
												<div class="progress-bar ${progress_color[i]}" role="progressbar" aria-valuenow="${item.dPorcentajeAvance}" aria-valuemin="0" aria-valuemax="100" style="width: ${item.dPorcentajeAvance}%;">
												${item.dPorcentajeAvance} %
												</div>
											</div>
											<p>${item.vCompromiso} </p>
										</a>
								</div>
						</div>`;
					if (i >= 3) {
						i = 0;
					} else {
						i++;
					}

				});
				$("#listado_cumplidos").html(filas);

				linkseleccionado = Number(pagina);
				//total registros
				totalregistros = response.totalregistros;
				//cantidad de registros por pagina
				cantidadregistros = response.cantidad;

				numerolinks = Math.ceil(totalregistros / cantidadregistros);
				paginador = "<ul class='pagination float-right'>";

				if (linkseleccionado > 1) {
					paginador += "<li class='page-item'><a class='page-link'  href='1'>&laquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
				}
				//muestro de los enlaces
				//cantidad de link hacia atras y adelante
				cant = 2;
				//inicio de donde se va a mostrar los links
				pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
				//condicion en la cual establecemos el fin de los links
				if (numerolinks > cant) {
					//conocer los links que hay entre el seleccionado y el final
					pagRestantes = numerolinks - linkseleccionado;
					//defino el fin de los links
					pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
				} else {
					pagFin = numerolinks;
				}
				for (var i = 1; i <= numerolinks; i++) {
					if (i == linkseleccionado) {
						paginador += `<li class="page-item active"><a class="page-link" href="javascript:void(0)">${i}</a></li>`;
					} else {
						paginador += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;
					}
				}
				//condicion para mostrar el boton sigueinte y ultimo
				if (linkseleccionado < numerolinks) {
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
				}

				paginador += "</ul>";
				$(".pagination").html(paginador);

			}
		});
	} else {
		recurso = "acciones/compromisos/mostrar_number";
		$.ajax({
			url: url + recurso,
			type: "POST",
			data: {buscar: valorBuscar, nropagina: pagina},
			dataType: "json",
			success: function (response) {
				filas = "";
				var progress_color = ['progress-bar-primario', 'progress-bar-secundario', 'progress-bar-terciario', 'progress-bar-cuaternario'];
				var colors = ['#00A36A', '#212743', '#694688', '#6CBB37'];
				var i = 0;
				$.each(response.compromisos, function (key, item) {
					var imagen;
					if (item.imagenes.vEvidencia == null){
						imagen="project.jpg";
					}else{
						imagen=item.imagenes.vEvidencia;
					}


					filas += `<div class="col-sm-6 col-lg-3 isotope-item brands" ">
								<div class="portfolio-item">
										<a href="${url}compromisos/descripcion/${btoa(item.iIdCompromiso)}/${btoa(item.iIdDependencia)}">
											<span class="thumb-info thumb-info-lighten border-radius-0">
												<span class="thumb-info-wrapper border-radius-0">
														<img style="height: 250px !important;" src="${url}archivos/documentosImages/${imagen}" class="img-fluid border-radius-0" alt="">
														
														<span class="thumb-info-title" style="opacity: 0.7 !important;">
															<span style="font-size: 40px !important;text-align: center !important;" class="thumb-info-inner">${item.iNumero}</span>
															<span style="background-color: ${colors[i]} !important;" class="thumb-info-type">Compromiso</span>
														</span>
												</span>
											</span>
											<div class="progress mb-2" style="margin-top: 7px">
												<div class="progress-bar ${progress_color[i]}" role="progressbar" aria-valuenow="${item.dPorcentajeAvance}" aria-valuemin="0" aria-valuemax="100" style="width: ${item.dPorcentajeAvance}%;">
												${item.dPorcentajeAvance} %
												</div>
											</div>
											<p>${item.vCompromiso} </p>
										</a>
								</div>
						</div>`;
					if (i >= 3) {
						i = 0;
					} else {
						i++;
					}
				});
				$("#listado_cumplidos").html(filas);

				linkseleccionado = Number(pagina);
				//total registros
				totalregistros = response.totalregistros;
				//cantidad de registros por pagina
				cantidadregistros = response.cantidad;

				numerolinks = Math.ceil(totalregistros / cantidadregistros);
				paginador = "<ul class='pagination float-right'>";

				if (linkseleccionado > 1) {
					paginador += "<li class='page-item'><a class='page-link'  href='1'>&laquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
				}
				//muestro de los enlaces
				//cantidad de link hacia atras y adelante
				cant = 2;
				//inicio de donde se va a mostrar los links
				pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
				//condicion en la cual establecemos el fin de los links
				if (numerolinks > cant) {
					//conocer los links que hay entre el seleccionado y el final
					pagRestantes = numerolinks - linkseleccionado;
					//defino el fin de los links
					pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
				} else {
					pagFin = numerolinks;
				}
				for (var i = 1; i <= numerolinks; i++) {
					if (i == linkseleccionado) {
						paginador += `<li class="page-item active"><a class="page-link" href="javascript:void(0)">${i}</a></li>`;
					} else {
						paginador += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;
					}
				}
				//condicion para mostrar el boton sigueinte y ultimo
				if (linkseleccionado < numerolinks) {
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";
				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
				}
				paginador += "</ul>";
				$(".pagination").html(paginador);
			}
		});
	}


}

function mostrar_procesos(valorBuscar, pagina,IdDependencia) {
	var recurso;

	if (typeof (valorBuscar) == "string") {
		recurso = "acciones/compromisos/mostrar_procesos";
		$.ajax({
			url: url + recurso,
			type: "POST",
			data: {buscar: valorBuscar, nropagina: pagina,Id_dependencia:IdDependencia},
			dataType: "json",
			success: function (response) {
				filas = "";
				var progress_color = ['progress-bar-primario', 'progress-bar-secundario', 'progress-bar-terciario', 'progress-bar-cuaternario'];
				var colors = ['#00A36A', '#212743', '#694688', '#6CBB37'];
				var i = 0;
				$.each(response.compromisos, function (key, item) {
					var imagen;
					if (item.imagenes.vEvidencia == null){
						imagen="project.jpg";
					}else{
						imagen=item.imagenes.vEvidencia;
					}


					filas += `<div class="col-sm-6 col-lg-3 isotope-item brands" ">
								<div class="portfolio-item">
										<a href="${url}compromisos/descripcion/${btoa(item.iIdCompromiso)}/${btoa(item.iIdDependencia)}">
											<span class="thumb-info thumb-info-lighten border-radius-0">
												<span class="thumb-info-wrapper border-radius-0">
														<img style="height: 250px !important;" src="${url}archivos/documentosImages/${imagen}" class="img-fluid border-radius-0" alt="">
														
														<span class="thumb-info-title" style="opacity: 0.7 !important;">
															<span style="font-size: 40px !important;text-align: center !important;" class="thumb-info-inner">${item.iNumero}</span>
															<span style="background-color: ${colors[i]} !important;" class="thumb-info-type">Compromiso</span>
														</span>
												</span>
											</span>
											<div class="progress mb-2" style="margin-top: 7px">
												<div class="progress-bar ${progress_color[i]}" role="progressbar" aria-valuenow="${item.dPorcentajeAvance}" aria-valuemin="0" aria-valuemax="100" style="width: ${item.dPorcentajeAvance}%;">
												${item.dPorcentajeAvance} %
												</div>
											</div>
											<p>${item.vCompromiso} </p>
										</a>
								</div>
						</div>`;
					if (i >= 3) {
						i = 0;
					} else {
						i++;
					}

				});
				$("#listado_cumplidos").html(filas);

				linkseleccionado = Number(pagina);
				//total registros
				totalregistros = response.totalregistros;
				//cantidad de registros por pagina
				cantidadregistros = response.cantidad;

				numerolinks = Math.ceil(totalregistros / cantidadregistros);
				paginador = "<ul class='pagination float-right'>";

				if (linkseleccionado > 1) {
					paginador += "<li class='page-item'><a class='page-link'  href='1'>&laquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
				}
				//muestro de los enlaces
				//cantidad de link hacia atras y adelante
				cant = 2;
				//inicio de donde se va a mostrar los links
				pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
				//condicion en la cual establecemos el fin de los links
				if (numerolinks > cant) {
					//conocer los links que hay entre el seleccionado y el final
					pagRestantes = numerolinks - linkseleccionado;
					//defino el fin de los links
					pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
				} else {
					pagFin = numerolinks;
				}
				for (var i = 1; i <= numerolinks; i++) {
					if (i == linkseleccionado) {
						paginador += `<li class="page-item active"><a class="page-link" href="javascript:void(0)">${i}</a></li>`;
					} else {
						paginador += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;
					}


				}
				//condicion para mostrar el boton sigueinte y ultimo
				if (linkseleccionado < numerolinks) {
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
				}

				paginador += "</ul>";
				$(".pagination").html(paginador);

			}
		});
	} else {
		recurso = "acciones/compromisos/mostrar_procesos_number";
		$.ajax({
			url: url + recurso,
			type: "POST",
			data: {buscar: valorBuscar, nropagina: pagina},
			dataType: "json",
			success: function (response) {

				filas = "";
				var progress_color = ['progress-bar-primario', 'progress-bar-secundario', 'progress-bar-terciario', 'progress-bar-cuaternario'];
				var colors = ['#00A36A', '#212743', '#694688', '#6CBB37'];
				var i = 0;
				$.each(response.compromisos, function (key, item) {
					var imagen;
					if (item.imagenes.vEvidencia == null){
						imagen="project.jpg";
					}else{
						imagen=item.imagenes.vEvidencia;
					}


					filas += `<div class="col-sm-6 col-lg-3 isotope-item brands" ">
								<div class="portfolio-item">
										<a href="${url}compromisos/descripcion/${btoa(item.iIdCompromiso)}/${btoa(item.iIdDependencia)}">
											<span class="thumb-info thumb-info-lighten border-radius-0">
												<span class="thumb-info-wrapper border-radius-0">
														<img style="height: 250px !important;" src="${url}archivos/documentosImages/${imagen}" class="img-fluid border-radius-0" alt="">
														
														<span class="thumb-info-title" style="opacity: 0.7 !important;">
															<span style="font-size: 40px !important;text-align: center !important;" class="thumb-info-inner">${item.iNumero}</span>
															<span style="background-color: ${colors[i]} !important;" class="thumb-info-type">Compromiso</span>
														</span>
												</span>
											</span>
											<div class="progress mb-2" style="margin-top: 7px">
												<div class="progress-bar ${progress_color[i]}" role="progressbar" aria-valuenow="${item.dPorcentajeAvance}" aria-valuemin="0" aria-valuemax="100" style="width: ${item.dPorcentajeAvance}%;">
												${item.dPorcentajeAvance} %
												</div>
											</div>
											<p>${item.vCompromiso} </p>
										</a>
								</div>
						</div>`;
					if (i >= 3) {
						i = 0;
					} else {
						i++;
					}

				});
				$("#listado_cumplidos").html(filas);

				linkseleccionado = Number(pagina);
				//total registros
				totalregistros = response.totalregistros;
				//cantidad de registros por pagina
				cantidadregistros = response.cantidad;

				numerolinks = Math.ceil(totalregistros / cantidadregistros);
				paginador = "<ul class='pagination float-right'>";

				if (linkseleccionado > 1) {
					paginador += "<li class='page-item'><a class='page-link'  href='1'>&laquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
				}
				//muestro de los enlaces
				//cantidad de link hacia atras y adelante
				cant = 2;
				//inicio de donde se va a mostrar los links
				pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
				//condicion en la cual establecemos el fin de los links
				if (numerolinks > cant) {
					//conocer los links que hay entre el seleccionado y el final
					pagRestantes = numerolinks - linkseleccionado;
					//defino el fin de los links
					pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
				} else {
					pagFin = numerolinks;
				}
				for (var i = 1; i <= numerolinks; i++) {
					if (i == linkseleccionado) {
						paginador += `<li class="page-item active"><a class="page-link" href="javascript:void(0)">${i}</a></li>`;
					} else {
						paginador += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;
					}


				}
				//condicion para mostrar el boton sigueinte y ultimo
				if (linkseleccionado < numerolinks) {
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
				}

				paginador += "</ul>";
				$(".pagination").html(paginador);
			}
		});
	}
}

function mostrar_iniciar(valorBuscar, pagina,id_dependencia) {
	var recurso;

	if (typeof (valorBuscar) == "string") {
		recurso = "acciones/compromisos/mostrar_procesos_iniciar";
		$.ajax({
			url: url + recurso,
			type: "POST",
			data: {buscar: valorBuscar, nropagina: pagina,idDependencia:id_dependencia},
			dataType: "json",
			success: function (response) {
				filas = "";
				var progress_color = ['progress-bar-primario', 'progress-bar-secundario', 'progress-bar-terciario', 'progress-bar-cuaternario'];
				var colors = ['#00A36A', '#212743', '#694688', '#6CBB37'];
				var i = 0;
				$.each(response.compromisos, function (key, item) {
					var imagen;
					if (item.imagenes.vEvidencia == null){
						imagen="project.jpg";
					}else{
						imagen=item.imagenes.vEvidencia;
					}


					filas += `<div class="col-sm-6 col-lg-3 isotope-item brands" ">
								<div class="portfolio-item">
										<a href="${url}compromisos/descripcion/${btoa(item.iIdCompromiso)}/${btoa(item.iIdDependencia)}">
											<span class="thumb-info thumb-info-lighten border-radius-0">
												<span class="thumb-info-wrapper border-radius-0">
														<img style="height: 250px !important;" src="${url}archivos/documentosImages/${imagen}" class="img-fluid border-radius-0" alt="">
														
														<span class="thumb-info-title" style="opacity: 0.7 !important;">
															<span style="font-size: 40px !important;text-align: center !important;" class="thumb-info-inner">${item.iNumero}</span>
															<span style="background-color: ${colors[i]} !important;" class="thumb-info-type">Compromiso</span>
														</span>
												</span>
											</span>
											<div class="progress mb-2" style="margin-top: 7px">
												<div class="progress-bar ${progress_color[i]}" role="progressbar" aria-valuenow="${item.dPorcentajeAvance}" aria-valuemin="0" aria-valuemax="100" style="width: ${item.dPorcentajeAvance}%;">
												${item.dPorcentajeAvance} %
												</div>
											</div>
											<p>${item.vCompromiso} </p>
										</a>
								</div>
						</div>`;
					if (i >= 3) {
						i = 0;
					} else {
						i++;
					}

				});
				$("#listado_cumplidos").html(filas);

				linkseleccionado = Number(pagina);
				//total registros
				totalregistros = response.totalregistros;
				//cantidad de registros por pagina
				cantidadregistros = response.cantidad;

				numerolinks = Math.ceil(totalregistros / cantidadregistros);
				paginador = "<ul class='pagination float-right'>";

				if (linkseleccionado > 1) {
					paginador += "<li class='page-item'><a class='page-link'  href='1'>&laquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
				}
				//muestro de los enlaces
				//cantidad de link hacia atras y adelante
				cant = 2;
				//inicio de donde se va a mostrar los links
				pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
				//condicion en la cual establecemos el fin de los links
				if (numerolinks > cant) {
					//conocer los links que hay entre el seleccionado y el final
					pagRestantes = numerolinks - linkseleccionado;
					//defino el fin de los links
					pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
				} else {
					pagFin = numerolinks;
				}
				for (var i = 1; i <= numerolinks; i++) {
					if (i == linkseleccionado) {
						paginador += `<li class="page-item active"><a class="page-link" href="javascript:void(0)">${i}</a></li>`;
					} else {
						paginador += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;
					}


				}
				//condicion para mostrar el boton sigueinte y ultimo
				if (linkseleccionado < numerolinks) {
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
				}

				paginador += "</ul>";
				$(".pagination").html(paginador);

			}
		});
	} else {
		recurso = "acciones/compromisos/mostrar_procesos_number_iniciar";
		$.ajax({
			url: url + recurso,
			type: "POST",
			data: {buscar: valorBuscar, nropagina: pagina},
			dataType: "json",
			success: function (response) {
				filas = "";
				var progress_color = ['progress-bar-primario', 'progress-bar-secundario', 'progress-bar-terciario', 'progress-bar-cuaternario'];
				var colors = ['#00A36A', '#212743', '#694688', '#6CBB37'];
				var i = 0;
				$.each(response.compromisos, function (key, item) {
					var imagen;
					if (item.imagenes.vEvidencia == null){
						imagen="project.jpg";
					}else{
						imagen=item.imagenes.vEvidencia;
					}


					filas += `<div class="col-sm-6 col-lg-3 isotope-item brands" ">
								<div class="portfolio-item">
										<a href="${url}compromisos/descripcion/${btoa(item.iIdCompromiso)}/${btoa(item.iIdDependencia)}">
											<span class="thumb-info thumb-info-lighten border-radius-0">
												<span class="thumb-info-wrapper border-radius-0">
														<img style="height: 250px !important;" src="${url}archivos/documentosImages/${imagen}" class="img-fluid border-radius-0" alt="">
														
														<span class="thumb-info-title" style="opacity: 0.7 !important;">
															<span style="font-size: 40px !important;text-align: center !important;" class="thumb-info-inner">${item.iNumero}</span>
															<span style="background-color: ${colors[i]} !important;" class="thumb-info-type">Compromiso</span>
														</span>
												</span>
											</span>
											<div class="progress mb-2" style="margin-top: 7px">
												<div class="progress-bar ${progress_color[i]}" role="progressbar" aria-valuenow="${item.dPorcentajeAvance}" aria-valuemin="0" aria-valuemax="100" style="width: ${item.dPorcentajeAvance}%;">
												${item.dPorcentajeAvance} %
												</div>
											</div>
											<p>${item.vCompromiso} </p>
										</a>
								</div>
						</div>`;
					if (i >= 3) {
						i = 0;
					} else {
						i++;
					}

				});
				$("#listado_cumplidos").html(filas);

				linkseleccionado = Number(pagina);
				//total registros
				totalregistros = response.totalregistros;
				//cantidad de registros por pagina
				cantidadregistros = response.cantidad;

				numerolinks = Math.ceil(totalregistros / cantidadregistros);
				paginador = "<ul class='pagination float-right'>";

				if (linkseleccionado > 1) {
					paginador += "<li class='page-item'><a class='page-link'  href='1'>&laquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
				}
				//muestro de los enlaces
				//cantidad de link hacia atras y adelante
				cant = 2;
				//inicio de donde se va a mostrar los links
				pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
				//condicion en la cual establecemos el fin de los links
				if (numerolinks > cant) {
					//conocer los links que hay entre el seleccionado y el final
					pagRestantes = numerolinks - linkseleccionado;
					//defino el fin de los links
					pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
				} else {
					pagFin = numerolinks;
				}
				for (var i = 1; i <= numerolinks; i++) {
					if (i == linkseleccionado) {
						paginador += `<li class="page-item active"><a class="page-link" href="javascript:void(0)">${i}</a></li>`;
					} else {
						paginador += `<li class="page-item"><a class="page-link" href="${i}">${i}</a></li>`;
					}


				}
				//condicion para mostrar el boton sigueinte y ultimo
				if (linkseleccionado < numerolinks) {
					paginador += "<li class='page-item'><a class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
					paginador += "<li class='page-item'><a class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";

				} else {
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
					paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
				}

				paginador += "</ul>";
				$(".pagination").html(paginador);
			}
		});
	}
}
function listar_dependencias() {
	/*Url estatica*/

	var route = "acciones/compromisos/listar_dependencias";
	$.ajax({
		type: "GET",
		url: url + route,
		data: "ok=ok",
		success: function (data) {
			value = 0;
			JSON.parse(data, function (k, v) {
				if (isNaN(v) === true) {
					if (typeof v === 'object') {
					} else {
						//texto
						var o = new Option("option text", value);
						$("#cbo_dependencias").append(o);
						$(o).html(v);
					}
				} else {
					//numero
					value = v;
				}

			});
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert("Status: " + textStatus);
			alert("Error: " + errorThrown);

		}
	});
}






