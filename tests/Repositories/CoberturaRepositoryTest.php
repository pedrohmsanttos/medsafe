<?php

namespace Tests\Repositories;

use App\Models\Cobertura;
use App\Repositories\CoberturaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\MakeCoberturaTrait;
use Tests\ApiTestTrait;

class CoberturaRepositoryTest extends TestCase
{
    use DatabaseMigrations, MakeCoberturaTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CoberturaRepository
     */
    protected $coberturaRepo;

    public function setUp()
    {
        parent::setUp();
        $this->coberturaRepo = \App::make(CoberturaRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCobertura()
    {
        $cobertura = $this->fakeCoberturaData();
        $createdCobertura = $this->coberturaRepo->create($cobertura);
        $createdCobertura = $createdCobertura->toArray();
        $this->assertArrayHasKey('id', $createdCobertura);
        $this->assertNotNull($createdCobertura['id'], 'Created Cobertura must have id specified');
        $this->assertNotNull(Cobertura::find($createdCobertura['id']), 'Cobertura with given id must be in DB');
        $this->assertModelData($cobertura, $createdCobertura);
    }

    /**
     * @test read
     */
    public function testReadCobertura()
    {
        $cobertura = $this->makeCobertura();
        $dbCobertura = $this->coberturaRepo->find($cobertura->id);
        $dbCobertura = $dbCobertura->toArray();
        $this->assertModelData($cobertura->toArray(), $dbCobertura);
    }

    /**
     * @test update
     */
    public function testUpdateCobertura()
    {
        $cobertura = $this->makeCobertura();
        $fakeCobertura = $this->fakeCoberturaData();
        $updatedCobertura = $this->coberturaRepo->update($fakeCobertura, $cobertura->id);
        $this->assertModelData($fakeCobertura, $updatedCobertura->toArray());
        $dbCobertura = $this->coberturaRepo->find($cobertura->id);
        $this->assertModelData($fakeCobertura, $dbCobertura->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCobertura()
    {
        $cobertura = $this->makeCobertura();
        $resp = $this->coberturaRepo->delete($cobertura->id);
        $this->assertTrue($resp);
        $this->assertNull(Cobertura::find($cobertura->id), 'Cobertura should not exist in DB');
    }
}
