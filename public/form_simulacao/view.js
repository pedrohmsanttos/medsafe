jQuery(document).ready(function(){
    // Planos
    var $planos = $("#tipo_produto_id");
    var plan = [];
    $.get("/api/v1/planos", function(data, status){
        plan = data.Data;
    }).done(function(plan){
        $.each(plan.data, function(key,value) {
            $planos.append($("<option></option>")
                .attr("value", value.id).text(value.descricao));
        })
    });
    // Categorias
    var $categorias = $("#categoria_produto_id");
    var cat = [];
    $.get("/api/v1/categorias", function(data, status){
        cat = data.Data;
    }).done(function(cat){
        $.each(cat.data, function(key,value) {
            $categorias.append($("<option></option>")
                .attr("value", value.id).text(value.descricao));
        })
    });
    // faturamentos
    var $faturamentos = $("#faturamento_id");
    var fats = [];
    $.get("/api/v1/faturamentos", function(data, status){
        fats = data.Data;
    }).done(function(fats){
        $.each(fats.data, function(key,value) {
            $faturamentos.append($("<option></option>")
                .attr("value", value.id).text(value.descricao));
        })
    });

    jQuery('#plano').hide();

    jQuery('#simulacao').submit(function(){
        var dados = jQuery(this).serialize();
        
        jQuery.ajax({
            type: "POST",
            url: "/api/v1/negocios",
            data: dados,
            success: function(data)
            {
                var dados = data.data;
                var $plano = $("#plano");
                jQuery('#simulacao').hide();
                alert('Simulação efetuada com sucesso!');
                jQuery('#categoria_val').text(dados['categoria']);
                jQuery('#plano_val').text(dados['plano']);
                jQuery('#valor').text('R$ '+dados['valor']);

                jQuery('#plano').show();
            }
        }).fail(function(res) {
            let erros = JSON.parse(res.responseText);
            let mensagem = '';
            if(erros.errors.nome){
                mensagem += '<br>'+erros.errors.nome[0];
            }
            if(erros.errors.categoria_produto_id){
                mensagem += '<br>'+erros.errors.categoria_produto_id[0];
            }
            if(erros.errors.email){
                mensagem += '<br>'+erros.errors.email[0];
            }
            if(erros.errors.telefone_1){
                mensagem += '<br>'+erros.errors.telefone_1[0];
            }
            if(erros.errors.telefone_2){
                mensagem += '<br>'+erros.errors.telefone_2[0];
            }
            if(erros.errors.telefone_3){
                mensagem += '<br>'+erros.errors.telefone_3[0];
            }
            if(erros.errors.tipopessoa){
                mensagem += '<br>'+erros.errors.tipopessoa[0];
            }
            if(erros.errors.tipo_produto_id){
                mensagem += '<br>'+erros.errors.tipo_produto_id[0];
            }
            
            $.alert({
                title: 'Erros!',
                content: mensagem,
            });
        });
        
        return false;
    });
});