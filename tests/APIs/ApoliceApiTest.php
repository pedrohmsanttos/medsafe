<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApoliceApiTest extends TestCase
{
    use MakeApoliceTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateApolice()
    {
        $apolice = $this->fakeApoliceData();
        $this->json('POST', '/api/v1/apolices', $apolice);

        $this->assertApiResponse($apolice);
    }

    /**
     * @test
     */
    public function testReadApolice()
    {
        $apolice = $this->makeApolice();
        $this->json('GET', '/api/v1/apolices/'.$apolice->id);

        $this->assertApiResponse($apolice->toArray());
    }

    /**
     * @test
     */
    public function testUpdateApolice()
    {
        $apolice = $this->makeApolice();
        $editedApolice = $this->fakeApoliceData();

        $this->json('PUT', '/api/v1/apolices/'.$apolice->id, $editedApolice);

        $this->assertApiResponse($editedApolice);
    }

    /**
     * @test
     */
    public function testDeleteApolice()
    {
        $apolice = $this->makeApolice();
        $this->json('DELETE', '/api/v1/apolices/'.$apolice->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/apolices/'.$apolice->id);

        $this->assertResponseStatus(404);
    }
}
