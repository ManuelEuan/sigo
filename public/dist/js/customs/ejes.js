function buscarPolitica(){
	var base_url=$("#base_url").val();
	var eje=$("#cboEje").val();
	   $.ajax({
            type: 'POST',
            dataType: 'json',
            url: base_url+"C_compromisos/listarpp",
            data: {"iIdEje": eje},
            success: function( data ) {
           $('#iIdTema').find('option').remove(); 
			$('#iIdTema').append('<option value="0">Seleccione</option>');
		  for (x = 0; x < data.length; x++) {
		   $('#iIdTema').append(`<option value="${data[x].iIdTema}">${data[x].vTema}</option>`);		  
		}
            }
        });
}

function limpiar_campos(){
	
}
