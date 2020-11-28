jQuery(document).ready(function(){
    var $el = $("#corretora");
    var corretoras = [];
    $.get("/api/v1/corretoras", function(data, status){
        var corretoras = data.Data;
    }).done(function(corretoras){
        $.each(corretoras.data, function(key,value) {
            $el.append($("<option></option>")
                .attr("value", value.id).text(value.descricao));
        })
    });

    jQuery('#corretor_cadastro').submit(function(){
        var dados = jQuery(this).serialize();

        jQuery.ajax({
            type: "POST",
            url: "/api/v1/corretor",
            data: dados,
            success: function(data)
            {
                alert(data.message);
            }
        }).fail(function(res) {
            let erros = JSON.parse(res.responseText);
            let mensagem = '';
            if(erros.errors.nome){
                mensagem += '<br>'+erros.errors.nome[0];
            }
            if(erros.errors.cpf){
                mensagem += '<br>'+erros.errors.cpf[0];
            }
            if(erros.errors.email){
                mensagem += '<br>'+erros.errors.email[0];
            }
            if(erros.errors.telefone){
                mensagem += '<br>'+erros.errors.telefone[0];
            }
            if(erros.errors.celular){
                mensagem += '<br>'+erros.errors.celular[0];
            }
            if(erros.errors.corretora){
                mensagem += '<br>'+erros.errors.corretora[0];
            }
            if(erros.errors.bairro){
                mensagem += '<br>'+erros.errors.bairro[0];
            }
            if(erros.errors.cep){
                mensagem += '<br>'+erros.errors.cep[0];
            }
            if(erros.errors.cidade){
                mensagem += '<br>'+erros.errors.cidade[0];
            }
            if(erros.errors.cnpj){
                mensagem += '<br>'+erros.errors.cnpj[0];
            }
            if(erros.errors.inscricao_municipal){
                mensagem += '<br>'+erros.errors.inscricao_municipal[0];
            }
            if(erros.errors.susep){
                mensagem += '<br>'+erros.errors.susep[0];
            }
            if(erros.errors.uf){
                mensagem += '<br>'+erros.errors.uf[0];
            }
            if(erros.errors.telefone_2){
                mensagem += '<br>'+erros.errors.telefone_2[0];
            }
            
            $.alert({
                title: 'Erros!',
                content: mensagem,
            });
        });
        
        return false;
    });

    jQuery("#cep").blur(function(){
        // Remove tudo o que não é número para fazer a pesquisa
        var cep = this.value.replace(/[^0-9]/, "");
        // Validação do CEP; caso o CEP não possua 8 números, então cancela
        // a consulta
        if(cep.length != 8){
            return false;
        }
        
        // A url de pesquisa consiste no endereço do webservice + o cep que
        // o usuário informou + o tipo de retorno desejado (entre "json",
        // "jsonp", "xml", "piped" ou "querty")
        var url = "https://viacep.com.br/ws/"+cep+"/json/";
        
        // Faz a pesquisa do CEP, tratando o retorno com try/catch para que
        // caso ocorra algum erro (o cep pode não existir, por exemplo) a
        // usabilidade não seja afetada, assim o usuário pode continuar//
        // preenchendo os campos normalmente
        $.getJSON(url, function(dadosRetorno){
            try{
                // Preenche os campos de acordo com o retorno da pesquisa
                $("#rua").val(dadosRetorno.logradouro);
                $("#bairro").val(dadosRetorno.bairro);
                $("#cidade").val(dadosRetorno.localidade);
                $("#uf").val(dadosRetorno.uf);
            }catch(ex){}
        });
    });

    jQuery("#cep_f").blur(function(){
        // Remove tudo o que não é número para fazer a pesquisa
        var cep = this.value.replace(/[^0-9]/, "");
        console.log('busca cep');
        // Validação do CEP; caso o CEP não possua 8 números, então cancela
        // a consulta
        if(cep.length != 8){
            return false;
        }
        
        // A url de pesquisa consiste no endereço do webservice + o cep que
        // o usuário informou + o tipo de retorno desejado (entre "json",
        // "jsonp", "xml", "piped" ou "querty")
        var url = "https://viacep.com.br/ws/"+cep+"/json/";
        
        // Faz a pesquisa do CEP, tratando o retorno com try/catch para que
        // caso ocorra algum erro (o cep pode não existir, por exemplo) a
        // usabilidade não seja afetada, assim o usuário pode continuar//
        // preenchendo os campos normalmente
        $.getJSON(url, function(dadosRetorno){
            try{
                // Preenche os campos de acordo com o retorno da pesquisa
                $("#rua_f").val(dadosRetorno.logradouro);
                $("#bairro_f").val(dadosRetorno.bairro);
                $("#cidade_f").val(dadosRetorno.localidade);
                $("#uf_f").val(dadosRetorno.uf);
            }catch(ex){}
        });
    });

    $("#mesmo_endereco").click(function(){
        if($(this).prop("checked") == true){
            $('#cep_f').prop("disabled", true);
            $('#rua_f').prop("disabled", true);
            $('#bairro_f').prop("disabled", true);
            $('#cidade_f').prop("disabled", true);
            $('#uf_f').prop("disabled", true);
            $('#numero_f').prop("disabled", true);
            $('#complemento_f').prop("disabled", true);
        }
        else if($(this).prop("checked") == false){
            $('#cep_f').prop("disabled", false);
            $('#rua_f').prop("disabled", false);
            $('#bairro_f').prop("disabled", false);
            $('#cidade_f').prop("disabled", false);
            $('#uf_f').prop("disabled", false);
            $('#numero_f').prop("disabled", false);
            $('#complemento_f').prop("disabled", false);
        }
    });
});