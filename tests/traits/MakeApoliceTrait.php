<?php

namespace Tests\Traits;

use Faker\Factory as Faker;
use App\Models\Apolice;
use App\Repositories\ApoliceRepository;
use App\Models\Corretor;
use App\Models\Pedido;
use App\Models\Cliente;

trait MakeApoliceTrait
{
    /**
     * Create fake instance of Apolice and save it in database
     *
     * @param array $apoliceFields
     * @return Apolice
     */
    public function makeApolice($apoliceFields = [])
    {
        /** @var ApoliceRepository $apoliceRepo */
        $apoliceRepo = \App::make(ApoliceRepository::class);
        $theme = $this->fakeApoliceData($apoliceFields);
        return $apoliceRepo->create($theme);
    }

    /**
     * Get fake instance of Apolice
     *
     * @param array $apoliceFields
     * @return Apolice
     */
    public function fakeApolice($apoliceFields = [])
    {
        return new Apolice($this->fakeApoliceData($apoliceFields));
    }

    /**
     * Get fake data of Apolice
     *
     * @param array $postFields
     * @return array
     */
    public function fakeApoliceData($apoliceFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'corretor_id' => factory(Corretor::class)->create()->id,
            'pedido_id' => factory(Pedido::class)->create()->id,
            'cliente_id' => factory(Cliente::class)->create()->id,
            'numero' => $fake->word,
            'endosso' => $fake->word,
            'ci' => $fake->word,
            'classe_bonus' => $fake->word,
            'proposta' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $apoliceFields);
    }
}
