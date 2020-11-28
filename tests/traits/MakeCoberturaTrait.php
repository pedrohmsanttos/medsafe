<?php

namespace Tests\Traits;

use Faker\Factory as Faker;
use App\Models\Cobertura;
use App\Repositories\CoberturaRepository;
use App\Models\Apolice;

trait MakeCoberturaTrait
{
    /**
     * Create fake instance of Cobertura and save it in database
     *
     * @param array $coberturaFields
     * @return Cobertura
     */
    public function makeCobertura($coberturaFields = [])
    {
        /** @var CoberturaRepository $coberturaRepo */
        $coberturaRepo = \App::make(CoberturaRepository::class);
        $theme = $this->fakeCoberturaData($coberturaFields);
        return $coberturaRepo->create($theme);
    }

    /**
     * Get fake instance of Cobertura
     *
     * @param array $coberturaFields
     * @return Cobertura
     */
    public function fakeCobertura($coberturaFields = [])
    {
        return new Cobertura($this->fakeCoberturaData($coberturaFields));
    }

    /**
     * Get fake data of Cobertura
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCoberturaData($coberturaFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'apolice_id' => function () {
                return factory(Apolice::class)->create()->id;
            },
            'nome' => $fake->word,
            'valor' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $coberturaFields);
    }
}
