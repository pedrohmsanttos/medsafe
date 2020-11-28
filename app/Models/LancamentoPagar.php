<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Parametro;

/**
 * Class LancamentoPagar
 * @package App\Models
 * @version March 29, 2019, 3:18 pm UTC
 *
 * @property \App\Models\Fornecedore fornecedore
 * @property \Illuminate\Database\Eloquent\Collection ganhoNegocios
 * @property \Illuminate\Database\Eloquent\Collection negocioProdutos
 * @property \Illuminate\Database\Eloquent\Collection organizacaoEnderecos
 * @property \Illuminate\Database\Eloquent\Collection permissionRole
 * @property \Illuminate\Database\Eloquent\Collection pessoaEnderecos
 * @property \Illuminate\Database\Eloquent\Collection roleUser
 * @property integer fornecedor_id
 * @property date data_vencimento
 * @property date data_emissao
 * @property string valor_titulo
 * @property string numero_documento
 */
class LancamentoPagar extends Model
{
    use SoftDeletes;

    public $table = 'lancamentos_pagar';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'fornecedor_id',
        'data_vencimento',
        'data_emissao',
        'valor_titulo',
        'numero_documento',
        'corretor_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fornecedor_id' => 'integer',
        'data_vencimento' => 'date',
        'data_emissao' => 'date',
        'valor_titulo' => 'string',
        'numero_documento' => 'string',
        'corretor_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'fornecedor_id' => 'required',
        'data_vencimento' => 'required',
        'data_emissao' => 'required',
        'valor_titulo' => 'required',
        'numero_documento' => 'required|max:20'
    ];

    
    /**
     * Get data format Y-m-d
     *
     * @return Date
    */
    public function getDataVencimento()
    {
        if ($this->data_vencimento) {
            return $this->data_vencimento->format('d/m/Y');
        }
        return null;
    }

    /**
     * Get data format d/m/Y
     *
     * @return Date
    */
    public function getDataEmissao()
    {
        if ($this->data_emissao) {
            return $this->data_emissao->format('d/m/Y');
        }
        return null;
    }

    public function getStatus(){
        $baixa = BaixaPagar::where('lancamentopagar_id', $this->id)->first();
        if(!empty($baixa) ){
            return true;
        }
        return false;
    }

    /**
     * Get titulo
     *
     * @return String
    */
    public function getTitulo()
    {
        return 'Nº '. str_pad($this->id, 8, "0", STR_PAD_LEFT)  . ' | R$' . number_format((float)$this->valor_titulo, 2, '.', '');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id', 'id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function corretor()
    {
        return $this->belongsTo(Corretor::class, 'corretor_id', 'id')->withTrashed();
    }

    public function calculaVencimentoComissao(String $periodo){
        $intervalo = Parametro::where('nome','Prazo inicial para contagem de dias do vencimento das comissões')->get()[0];
        date_default_timezone_set('America/Recife');
        $dataHoje = date('Y-m-d', time());
        $data = date('Y-m-d', strtotime('+'.trim($intervalo->valor).' days',strtotime($dataHoje) ));
        $parametro = "";
        if( $periodo == 'MENSAL' ){
            $parametro = Parametro::where('nome','Dia de pagamento das comissões mensais')->get()[0];
            $dataPagamento = date('Y-m-'.$parametro->valor, time());
            if( strtotime($dataPagamento) < strtotime($data) ){
                $mes = date('m', time());
                $dataPagamento = date('Y-m-d', strtotime('+1 months',strtotime($dataPagamento) ));
                if(strtotime($dataPagamento) < strtotime($data)){
                    return date('Y-m-d', strtotime('+1 months',strtotime($dataPagamento) ));
                }
                return $dataPagamento;
            }
            return $dataPagamento;
        } else{
            $parametro = Parametro::where('nome','Dia de pagamento das comissões da primeira quinzena')->get()[0];
            $dataPrimeiraQuinzena = date('Y-m-'.$parametro->valor, time());
            if( strtotime($dataPrimeiraQuinzena) < strtotime($data) ){
                $parametroSegundaQuinzena = Parametro::where('nome','Dia de pagamento das comissões da segunda quinzena')->get()[0];
                $dataSegundaQuinzena = date('Y-m-'.$parametroSegundaQuinzena->valor, time());
                $dataQuinzenaFutura = date('Y-m-d', strtotime('+1 months',strtotime($dataPrimeiraQuinzena) ));
                if( strtotime($dataSegundaQuinzena) < strtotime($data) && strtotime($dataQuinzenaFutura) < strtotime($data)){
                    return date('Y-m-d', strtotime('+1 months',strtotime($dataSegundaQuinzena) ));
                    // segunda quinzena do proximo mês
                } else if(strtotime($dataSegundaQuinzena) >= strtotime($data)){
                    return $dataSegundaQuinzena;
                } else if(strtotime($dataQuinzenaFutura) >= strtotime($data)){
                    //primeira quinzena do próximo mês
                    return $dataQuinzenaFutura;
                } 
            }
            return $dataPrimeiraQuinzena;
        }
    }

}
