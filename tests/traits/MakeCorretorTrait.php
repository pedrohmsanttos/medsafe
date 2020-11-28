<?php

namespace Tests\Traits;

use Faker\Factory as Faker;
use App\Models\Corretor;
use App\Repositories\CorretorRepository;
use App\Models\Corretora;

trait MakeCorretorTrait
{
    /**
     * Create fake instance of Corretor and save it in database
     *
     * @param array $corretorFields
     * @return Corretor
     */
    public function makeCorretor($corretorFields = [])
    {
        /** @var CorretorRepository $corretorRepo */
        $corretorRepo = \App::make(CorretorRepository::class);
        $theme = $this->fakeCorretorData($corretorFields);
        return $corretorRepo->create($theme);
    }

    /**
     * Get fake instance of Corretor
     *
     * @param array $corretorFields
     * @return Corretor
     */
    public function fakeCorretor($corretorFields = [])
    {
        return new Corretor($this->fakeCorretorData($corretorFields));
    }

    /**
     * Get fake data of Corretor
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCorretorData($corretorFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'nome' => $fake->word,
            'cpf' => $fake->word,
            'telefone' => $fake->word,
            'email' => $fake->word,
            'celular' => $fake->word,
            'corretora_id' => factory(Corretora::class)->create()->id,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s')
        ], $corretorFields);
    }
}
