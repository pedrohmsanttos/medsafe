<?php

namespace App\Traits;

trait ContaBancariaTrait
{
    /**
     * Move credits to this conta bancária
     * @param  integer $valor
     * @param  string  $type
     * @param  array   $meta
     */
    public function deposito($valor, $type = 'deposito', $meta = [], $accepted = true)
    {
        $this->carteira()->create([
                'valor' => getRealValue($valor),
                'hash' => uniqid('lwch_'),
                'tipo' => $type,
                'accepted' => $accepted,
                'meta' => $meta
            ]);
    }

    /**
     * Fail to move credits to this conta bancária
     * @param  integer $valor
     * @param  string  $type
     * @param  array   $meta
     */
    public function falhaDeposito($valor, $type = 'deposito', $meta = [])
    {
        $this->deposito($valor, $type, $meta, false);
    }

    /**
     * Attempt to move credits from this conta bancária
     * @param  integer $valor
     * @param  string  $type
     * @param  array   $meta
     * @param  boolean $shouldAccept
     */
    public function retirada($valor, $type = 'retirada', $meta = [], $shouldAccept = true)
    {
        $this->carteira()->create([
                'valor' => getRealValue($valor),
                'hash' => uniqid('lwch_'),
                'tipo' => $type,
                'accepted' => $shouldAccept,
                'meta' => $meta
            ]);
    }

    /**
     * Move credits from this conta bancária
     * @param  integer $valor
     * @param  string  $type
     * @param  array   $meta
     * @param  boolean $shouldAccept
     */
    public function forceWithdraw($valor, $type = 'retirada', $meta = [])
    {
        return $this->retirada($valor, $type, $meta, false);
    }

    /**
     * Returns the actual balance for this carteira.
     * Might be different from the balance property if the database is manipulated
     * @return float balance
     */
    public function balancoAtual()
    {
        $credito = $this->carteira->transactions()
            ->whereIn('tipo', ['deposito', 'reembolso'])
            ->where('accepted', 1)
            ->sum('valor');

        $debito = $this->carteira->transactions()
            ->whereIn('tipo', ['retirada', 'pagamento'])
            ->where('accepted', 1)
            ->sum('valor');

        return $credito - $debito;
    }
}
