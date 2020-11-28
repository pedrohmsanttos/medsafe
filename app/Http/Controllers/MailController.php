<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mail;
use App\Jobs\SendMail;
use Auth;

class MailController extends Controller
{

    public function configuracao(){
        $title = "Mensagens de e-mail";
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "mensagens_email";
        $emails = Mail::all();

        return view('config.email',compact('title', 'emails', 'breadcrumb'));
    }

    public function teste(){
        // Teste de evio
        $emails = Mail::all();
        
        $vars  = array(
            '__nome__' => 'Matheus Felipe'
        );  

        $dados = new \stdClass();//create a new 
        $dados->destinatarioNome  = "Matheus";
        $dados->destinatarioEmail = "matheus.felipe@inhalt.com.br";
        $dados->logo              = "";
        $dados->tipo              = "cadastro_corretor";

        dispatch(new SendMail($vars, $dados, $emails[0]));
        // fim do teste

        return view('config.email',compact('title', 'emails', 'breadcrumb'));
    }

    public function update($id, Request $request){
    	$email    = Mail::find($id);
        $assunto  = $request->input("assunto");
        $conteudo = $request->input("conteudo");
        try{
            $email->assunto  = $assunto;
            $email->conteudo = $conteudo;
            $email->update();
        }catch (Exception $e) {
            return redirect()->route('500');
        }
		
        return redirect('/email');
    }
}

