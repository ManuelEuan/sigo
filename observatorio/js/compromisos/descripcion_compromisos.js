$(document).ready(function () {
	//recuperar_unidad_medida();
	url = $("#url").val();
	id_compromiso=$("#id_compromiso").val();
	listar_componentes();
});


function listar_componentes() {
	var recurso = "acciones/compromisos/componentes/"+id_compromiso;
	$.ajax({
		type: "GET",
		url: url + recurso,
		success: function (data) {
			$("#productDescription").empty();
			$("#productDescription").html(data);

		}
	});
}








