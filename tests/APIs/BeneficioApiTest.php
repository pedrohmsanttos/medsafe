<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BeneficioApiTest extends TestCase
{
    use MakeBeneficioTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateBeneficio()
    {
        $beneficio = $this->fakeBeneficioData();
        $this->json('POST', '/api/v1/beneficios', $beneficio);

        $this->assertApiResponse($beneficio);
    }

    /**
     * @test
     */
    public function testReadBeneficio()
    {
        $beneficio = $this->makeBeneficio();
        $this->json('GET', '/api/v1/beneficios/'.$beneficio->id);

        $this->assertApiResponse($beneficio->toArray());
    }

    /**
     * @test
     */
    public function testUpdateBeneficio()
    {
        $beneficio = $this->makeBeneficio();
        $editedBeneficio = $this->fakeBeneficioData();

        $this->json('PUT', '/api/v1/beneficios/'.$beneficio->id, $editedBeneficio);

        $this->assertApiResponse($editedBeneficio);
    }

    /**
     * @test
     */
    public function testDeleteBeneficio()
    {
        $beneficio = $this->makeBeneficio();
        $this->json('DELETE', '/api/v1/beneficios/'.$beneficio->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/beneficios/'.$beneficio->id);

        $this->assertResponseStatus(404);
    }
}
