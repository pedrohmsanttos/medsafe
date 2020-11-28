<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TesourariaRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\FornecedorRepository;
use App\Repositories\FormaDePagamentoRepository;
use App\Repositories\PlanoDeContasRepository;

class RelatorioTesourariaController extends Controller
{
     /** @var  TesourariaRepository */
     private $tesourariaRepository;

     /** @var  ClienteRepository */
     private $clienteRepository;
 
     /** @var  FornecedorRepository */
     private $fornecedorRepository;
 
     /** @var  FormaDePagamentoRepository */
     private $formaDePagamentoRepository;
 
     /** @var  PlanoDeContasRepository */
     private $planoDeContasRepository;

     public function __construct(
        TesourariaRepository $tesourariaRepo, 
        ClienteRepository $clienteRepo, 
        FornecedorRepository $fornecedorRepo, 
        FormaDePagamentoRepository $formaDePagamentoRepository,
        PlanoDeContasRepository $planoDeContasRepository
    )
    {
        $this->tesourariaRepository         = $tesourariaRepo;
        $this->clienteRepository            = $clienteRepo;
        $this->fornecedorRepository         = $fornecedorRepo;
        $this->formaDePagamentoRepository   = $formaDePagamentoRepository;
        $this->planoDeContasRepository      = $planoDeContasRepository;   

        $this->middleware('permission:relatorio_tesouraria', ['only' => ['index','relatorio','doRelatorio','show','edit', 'update']]); 

    }

    public function relatorio()
    {
        /** Titulo da página */
        $title = "Relatório - Tesouraria";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioTesouraria";

        $clientes                       = $this->clienteRepository->all();
        $fornecedores                   = $this->fornecedorRepository->all();
        $formas_de_pagamento            = $this->formaDePagamentoRepository->all();
        $planos_de_conta                = $this->planoDeContasRepository->all();

        return view('relatorio.tesouraria', compact('title','breadcrumb','clientes', 'fornecedores', 'formas_de_pagamento', 'planos_de_conta'));
    }

    public function doRelatorio(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Tesouraria";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioTesouraria";

        $input       = $request->all();
        $tesourarias = $this->tesourariaRepository->relatorio($input);

        return view('relatorio.tesouraria_lista', compact('title','breadcrumb', 'tesourarias','input'));
    }
}
