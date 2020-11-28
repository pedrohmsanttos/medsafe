$("#cep").change(function() {
	var value = $(this).val();
	if(value.length == 9){
		$.ajax({
			url: "https://ddd.pricez.com.br/cep/"+value+".json",
			success:function(data) {
				data = data.payload;
		  		$(".ddd").val(data.ddd);
		  		$("#municipio").val(data.cidade);
		  		$("#uf").val(data.estado).trigger('change');
		  		$("#bairro").val(data.bairro);
		  		$("#rua").val(data.logradouro);
		  	}
		});
	}
});