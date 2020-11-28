<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Traits\MakeCorretorTrait as MakeCorretorTrait;

class CorretorApiTest extends TestCase
{
    use MakeCorretorTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCorretor()
    {
        $corretor = $this->fakeCorretorData();
        $this->json('POST', '/api/v1/corretor', $corretor);

        $this->assertApiResponse($corretor);
    }

    /**
     * @test
     */
    public function testReadCorretor()
    {
        $corretor = $this->makeCorretor();
        $this->json('GET', '/api/v1/corretor/'.$corretor->id);

        $this->assertApiResponse($corretor->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCorretor()
    {
        $corretor = $this->makeCorretor();
        $editedCorretor = $this->fakeCorretorData();

        $this->json('PUT', '/api/v1/corretor/'.$corretor->id, $editedCorretor);

        $this->assertApiResponse($editedCorretor);
    }

    /**
     * @test
     */
    public function testDeleteCorretor()
    {
        $corretor = $this->makeCorretor();
        $this->json('DELETE', '/api/v1/corretor/'.$corretor->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/corretor/'.$corretor->id);

        $this->assertResponseStatus(404);
    }
}
