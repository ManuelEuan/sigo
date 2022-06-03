$(document).ready(function () {
	/**Inicializar variables**/

	//recuperar_unidad_medida();
	url = $("#url").val();
	listar_compromisos_1();
});
function listar_compromisos_1() {
	//funcion que lista los ultimos 4
	var recurso = "acciones/compromisos/listar_4";
	$.ajax({
		type: "GET",
		url: url + recurso,
		success: function (data) {
			$("#listado_compromisos").empty();
			$("#listado_compromisos").html(data);

		}
	});
}








