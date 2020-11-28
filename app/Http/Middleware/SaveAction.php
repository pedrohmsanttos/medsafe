<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SaveAction
{  
/**
* Handle an incoming request.
*
* @param  \Illuminate\Http\Request  $request
* @param  \Closure  $next
* @return mixed
*/
    public function handle($request, Closure $next)
    {   
        $dataToLog = "\n";
        if(Auth::user() != null){
            $dataToLog .= 'User id: '  . Auth::user()->id . "\n";
        }
        date_default_timezone_set('America/Recife');
        $dataHoje = date('Y-m-d', time());
        $filename = '../storage/logs/log-'.$dataHoje.'.txt';
        $dataHoje = date('Y-m-d', time());
        $dataToLog .= 'IP Address: ' . $request->ip() . "\n";
        $dataToLog .= 'URL: '    . $request->fullUrl() . "\n";
        $dataToLog .= 'Method: ' . $request->method() . "\n";
        $dataToLog .= 'Input: '  . $request->getContent() . "\n";
        $dataToLog .= 'Time: '  . date('d/m/Y \à\s H:i:s') . "\n";
        $arquivo = fopen($filename,'a');
        fwrite($arquivo,$dataToLog);
        fclose($arquivo);

        return $next($request);
    }

}
