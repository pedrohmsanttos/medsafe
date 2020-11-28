$(document).ready(function(){
    // $('.fone').mask('90000-0000', {reverse: true});
    $('.fone').each(function(i, el){
        //$('#'+el.id).mask("(00) 00000-0000");
        $(this).mask("(00) 00000-0000");
    });


    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cep').mask('00000-000', {reverse: true});
    $('.data').mask('00/00/0000');
    $('.date').mask('00/00/0000');
    $('.ano').mask('0000');
    $('.numero').mask('0#');
    $('.numero8').mask('00000000');
    $('.hora').mask('00:00h', {reverse: true});
    $('.hora1').mask('00:00', {reverse: true});
    $('.decimal').mask('00000000000.000', {reverse: true});
    $('.decimal1').mask('00000000000.00', {reverse: true});
    $('.peso').mask('00000000000,000Kg', {reverse: true});
    $('.money-real').mask('R$ 000.000,00', { placeholder: 'R$ __,__' }).prop('autofocus', true);
    $("input[value='tipoPessoa']").change(function(){
        if(this.value == 'pf')
        {
            $(".cpfcnpj").mask("999.999.999-99", {removeMaskOnSubmit: true});
        }
        else
        {
            $(".cpfcnpj").mask("99.999.999/9999-99", {removeMaskOnSubmit: true});
        }
    });

    // Remove mascara ao enviar o formulário
    $("form").submit(function() {
        $(".cpfcnpj").unmask();
        $(".cpf").unmask();
        $(".cep").unmask();
        $(".cnpj").unmask();
        $(".foneddd").unmask();
        $(".fone").unmask();
        $('.dinheiro').unmask();
    });
    /*
    $(".cpfcnpj").keydown(function(){
        try {
            $(".cpfcnpj").unmask();
        } catch (e) {}
    
        var tamanho = $(".cpfcnpj").val().length;
    
        if(tamanho < 11){
            $(".cpfcnpj").mask("999.999.999-99", {reverse: true});
        } else if(tamanho >= 11){
            $(".cpfcnpj").mask("99.999.999/9999-99", {reverse: true});
        }
    
        // ajustando foco
        var elem = this;
        setTimeout(function(){
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });*/

    $('.porcento').mask('##0,00%', {reverse: true});

    $(".dinheiro").each(function(){
        $(this).val(this.value.replace('.', ','));
        $(this).prop("autofocus",true);
    });
    
    $(".dinheiro").maskMoney({
         prefix: "R$ ",
         decimal: ",",
         thousands: ".",
         removeMaskOnSubmit: true
     });

    function updateMask(event) {
        var $element = $('#'+this.id);
        $(this).off('blur');
        $element.unmask();
        if(this.value.replace(/\D/g, '').length > 10) {
            $element.mask("(00) 00000-0000");
        } else {
            $element.mask("(00) 0000-00009");
        }
        $(this).on('blur', updateMask);
    }
    $('.foneddd').on('blur', updateMask);

    $(".validate-data").change(function(){
        var RegExPattern = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])      [\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;

        if (!(($(this).val().match(RegExPattern)) && ($(this).val()!=''))) {
            $(this).val("");
            $(this).parent('.form-group').addClass('has-error');
        } else {
            $(this).parent('.form-group').removeClass('has-error');
        }
    })


    $('.dataCalendario').datepicker({
        endDate: new Date,
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior'
    });

    $('.dataCalendario1').datepicker({
        endDate: new Date,
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior'
    });

    $('.dataCalendario2').datepicker({
        endDate: new Date,
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior'
    });

    $('.dataBaixa').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior'
    });

    $('.dataCalendarioAntes').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior',
    });

    $('#datepicker_component_container_1 input').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior',
        container: '#datepicker_component_container_1'
    });

    $('#datepicker_component_container_2 input').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior',
        container: '#datepicker_component_container_2'
    });

    $('#datepicker_component_container_3 input').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: 'pt-BR',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior',
        container: '#datepicker_component_container_3'
    });

});