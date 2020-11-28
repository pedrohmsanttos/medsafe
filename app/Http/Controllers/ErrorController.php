<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function notFound()
    {
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = 'dashboard';
        $title = 'Página Não Encontrada';
        $type_error = "404";
        $header_error = "Erro 404 - Página Não Encontrada.";
        $message_error = "Não encontramos a página que você está procurando.";
        
        return view('errors.error', compact('title', 'breadcrumb', 'type_error', 'message_error', 'header_error'));
    }
    public function methodNotAllowed()
    {
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = 'dashboard';
        $title = 'Método não permitido';
        $type_error = "405";
        $header_error = "Erro 405 - Método não permitido.";
        $message_error = "O servidor não suporta o método solicitado.";
        return view('errors.error', compact('title', 'breadcrumb', 'type_error', 'message_error', 'header_error'));
    }
    public function fatal()
    {
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = 'dashboard';
        $title = 'Erro Interno do Servidor';
        $type_error = "500";
        $header_error = "Erro 500 - Erro Interno do Servidor.";
        $message_error = "O servidor encontrou um erro inesperado e não pôde concluir sua solicitação.";
        return view('errors.error', compact('title', 'breadcrumb', 'type_error', 'message_error', 'header_error'));
    }
}
