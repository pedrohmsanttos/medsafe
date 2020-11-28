<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoberturaApiTest extends TestCase
{
    use MakeCoberturaTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCobertura()
    {
        $cobertura = $this->fakeCoberturaData();
        $this->json('POST', '/api/v1/coberturas', $cobertura);

        $this->assertApiResponse($cobertura);
    }

    /**
     * @test
     */
    public function testReadCobertura()
    {
        $cobertura = $this->makeCobertura();
        $this->json('GET', '/api/v1/coberturas/'.$cobertura->id);

        $this->assertApiResponse($cobertura->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCobertura()
    {
        $cobertura = $this->makeCobertura();
        $editedCobertura = $this->fakeCoberturaData();

        $this->json('PUT', '/api/v1/coberturas/'.$cobertura->id, $editedCobertura);

        $this->assertApiResponse($editedCobertura);
    }

    /**
     * @test
     */
    public function testDeleteCobertura()
    {
        $cobertura = $this->makeCobertura();
        $this->json('DELETE', '/api/v1/coberturas/'.$cobertura->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/coberturas/'.$cobertura->id);

        $this->assertResponseStatus(404);
    }
}
