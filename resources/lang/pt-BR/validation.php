<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'O :attribute deve ser aceito.',
    'active_url'           => 'O :attribute não é um URL válido.',
    'after'                => 'O :attribute deve ser uma data depois :date.',
    'after_or_equal'       => 'O :attribute deve ser uma data depois ou igual a :date.',
    'alpha'                => 'O :attribute pode conter apenas letras.',
    'alpha_dash'           => 'O :attribute pode conter apenas letras, numeros, traços e sublinhados.',
    'alpha_num'            => 'O :attribute pode conter apenas letras e numeros.',
    'array'                => 'O :attribute deve ser um array.',
    'before'               => 'O :attribute deve ser uma data antes :date.',
    'before_or_equal'      => 'O :attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O :attribute deve estar entre :min e :max.',
        'file'    => 'O :attribute deve estar entre :min e :max kilobytes.',
        'string'  => 'O :attribute deve estar entre :min e :max caracteres.',
        'array'   => 'O :attribute deve ter entre :min e :max items.',
    ],
    'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'O :attribute confirmação não corresponde.',
    'date'                 => 'O :attribute não é uma data válida.',
    'date_format'          => 'O :attribute não corresponde ao formato :format.',
    'different'            => 'O :attribute e :other deve ser diferente.',
    'digits'               => 'O :attribute dever ter :digits digitos.',
    'digits_between'       => 'O :attribute dever ter entre :min e :max digitos.',
    'dimensions'           => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo :attribute tem um valor duplicado.',
    'email'                => 'O :attribute Deve ser um endereço de e-mail válido.',
    'exists'               => 'O selecionado :attribute é inválido.',
    'file'                 => 'O :attribute deve ser um arquivo.',
    'filled'               => 'O campo :attribute deve ter um valor.',
    'gt'                   => [
        'numeric' => 'O :attribute deve ser maior que :value.',
        'file'    => 'O :attribute deve ser maior que :value kilobytes.',
        'string'  => 'O :attribute deve ser maior que :value caracteres.',
        'array'   => 'O :attribute deve ter mais de :value items.',
    ],
    'gte'                  => [
        'numeric' => 'O :attribute deve ser maior ou igual :value.',
        'file'    => 'O :attribute deve ser maior ou igual :value kilobytes.',
        'string'  => 'O :attribute deve ser maior ou igual :value caracteres.',
        'array'   => 'O :attribute deve ter :value itens ou mais.',
    ],
    'image'                => 'O :attribute deve ser uma imagem.',
    'in'                   => 'O selected :attribute é inválido.',
    'in_array'             => 'O campo :attribute não existe em :other.',
    'integer'              => 'O :attribute deve ser um inteiro.',
    'ip'                   => 'O :attribute deve ser um endereço IP válido.',
    'ipv4'                 => 'O :attribute deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'O :attribute deve ser um endereço IPv6 válido.',
    'json'                 => 'O :attribute deve ser uma string JSON válida.',
    'lt'                   => [
        'numeric' => 'O :attribute deve ser menor que :value.',
        'file'    => 'O :attribute deve ser menor que :value kilobytes.',
        'string'  => 'O :attribute deve ser menor que :value caracteres.',
        'array'   => 'O :attribute deve ter menos de :value items.',
    ],
    'lte'                  => [
        'numeric' => 'O :attribute deve ser menor ou igual :value.',
        'file'    => 'O :attribute deve ser menor ou igual :value kilobytes.',
        'string'  => 'O :attribute deve ser menor ou igual :value caracteres.',
        'array'   => 'O :attribute não deve ter mais do que :value items.',
    ],
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior que :max.',
        'file'    => 'O :attribute não pode ser maior que :max kilobytes.',
        'string'  => 'O :attribute não pode ser maior que :max caracteres.',
        'array'   => 'O :attribute pode não ter mais do que :max items.',
    ],
    'mimes'                => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O :attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O :attribute deve ser pelo menos :min.',
        'file'    => 'O :attribute deve ser pelo menos :min kilobytes.',
        'string'  => 'O :attribute deve ser pelo menos :min caracteres.',
        'array'   => 'O :attribute deve ter pelo menos :min items.',
    ],
    'not_in'               => 'O selecionado :attribute é inválido.',
    'not_regex'            => 'O :attribute formato é inválido.',
    'numeric'              => 'O :attribute deve ser um número.',
    'present'              => 'O campo :attribute deve estar presente.',
    'regex'                => 'O :attribute formato é inválido.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless'      => 'O campo :attribute é obrigatório unless :other é in :values.',
    'required_with'        => 'O campo :attribute é obrigatório quando :values é presente.',
    'required_with_all'    => 'O campo :attribute é obrigatório quando :values é presente.',
    'required_without'     => 'O campo :attribute é obrigatório quando :values é não presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum :values are presente.',
    'same'                 => 'O :attribute e :other deve combinar.',
    'size'                 => [
        'numeric' => 'O :attribute dever ter :size.',
        'file'    => 'O :attribute dever ter :size kilobytes.',
        'string'  => 'O :attribute dever ter :size caracteres.',
        'array'   => 'O :attribute deve conter :size items.',
    ],
    'string'               => 'O :attribute dever ter a string.',
    'timezone'             => 'O :attribute dever ter a valid zone.',
    'unique'               => 'O :attribute já foi cadastrado.',
    'uploaded'             => 'O :attribute não foi possível fazer o upload.',
    'url'                  => 'O :attribute o formato é inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'CNPJ'                  => 'CNPJ',
        'razaoSocial'           => 'Razão Social',
        'email'                 => 'E-mail',
        'nomeFantasia'          => 'Nome Fantasia',
        'classificacao'         => 'Classificação',
        'descricao'             => 'Descrição',
        'tipoPessoa'            => 'Tipo de Pessoa',
        'inscricaoEstadual'     => 'Inscrição Estadual',
        'inscricaoMunicipal'    => 'Inscrição Municipal',
        'nomeTitular'           => 'Nome do titular',
        'CNPJCPF'               => 'CNPJ/CPF',
        'CPF'                   => 'CPF do titular',
        'cep'                   => 'CEP',
        'rua'                   => 'Logradouro',
        'numero'                => 'Número',
        'bairro'                => 'Bairro',
        'municipio'             => 'Município',
        'uf'                    => 'Estado',
        'funcao'                => 'Função',
        'telefone'              => 'Telefone',
        'numeroConta'           => 'N° Conta',
        'numeroAgencia'         => 'N° Agência',
        'caixa'                 => 'Caixa',
        'banco'                 => 'Banco',
        'dataSaldoInicial'      => 'Data do Saldo Inicial',
        'saldoInicial'          => 'Saldo Inicial',
        'tipoConta'             => 'Tipo de Conta',
        'contabancaria_id'      => 'Conta Bancária',
        'descricaoCorretor'     => 'Descrição do Corretor',
        'arquivo'               => 'Arquivo',
        'titulo'                => 'Título',
        'login'                 => 'Login',
        'name'                  => 'Nome',
        'password'              => 'Senha',
        'roles'                 => 'Permissões',
        'display_name'          => 'Nome Completo',
        'description'           => 'Descrição',
        'pagamento_id'          => 'Forma de Pagamento',
        'conta_bancaria_id'     => 'Conta Bancária',
        'lancamentopagar_id'    => 'Lançamento a Pagar',
        'lancamentoreceber_id'  => 'Lançamento a Receber',
        'duracao'               => 'Duração',
        'assunto'               => 'Assunto',
        'urlProposta'           => 'URL da Proposta',
        'numero_documento'      => 'Número Documento',
        'data_emissao'          => 'Data Emissão',
        'category_id'           => 'Categoria',
        'mensagem'              => 'Mensagem',
        'comment'               => 'Mensagem',
        'faturamento_id'        => 'Faturamento',
        'data_criacao'          => 'Data Negócio'
    ],

];
