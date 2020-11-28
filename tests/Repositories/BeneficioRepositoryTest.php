<?php

namespace Tests\Repositories;

use App\Models\Beneficio;
use App\Repositories\BeneficioRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\MakeBeneficioTrait;
use Tests\ApiTestTrait;

class BeneficioRepositoryTest extends TestCase
{
    use DatabaseMigrations, MakeBeneficioTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var BeneficioRepository
     */
    protected $beneficioRepo;

    public function setUp()
    {
        parent::setUp();
        $this->beneficioRepo = \App::make(BeneficioRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateBeneficio()
    {
        $beneficio = $this->fakeBeneficioData();
        $createdBeneficio = $this->beneficioRepo->create($beneficio);
        $createdBeneficio = $createdBeneficio->toArray();
        $this->assertArrayHasKey('id', $createdBeneficio);
        $this->assertNotNull($createdBeneficio['id'], 'Created Beneficio must have id specified');
        $this->assertNotNull(Beneficio::find($createdBeneficio['id']), 'Beneficio with given id must be in DB');
        $this->assertModelData($beneficio, $createdBeneficio);
    }

    /**
     * @test read
     */
    public function testReadBeneficio()
    {
        $beneficio = $this->makeBeneficio();
        $dbBeneficio = $this->beneficioRepo->find($beneficio->id);
        $dbBeneficio = $dbBeneficio->toArray();
        $this->assertModelData($beneficio->toArray(), $dbBeneficio);
    }

    /**
     * @test update
     */
    public function testUpdateBeneficio()
    {
        $beneficio = $this->makeBeneficio();
        $fakeBeneficio = $this->fakeBeneficioData();
        $updatedBeneficio = $this->beneficioRepo->update($fakeBeneficio, $beneficio->id);
        $this->assertModelData($fakeBeneficio, $updatedBeneficio->toArray());
        $dbBeneficio = $this->beneficioRepo->find($beneficio->id);
        $this->assertModelData($fakeBeneficio, $dbBeneficio->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteBeneficio()
    {
        $beneficio = $this->makeBeneficio();
        $resp = $this->beneficioRepo->delete($beneficio->id);
        $this->assertTrue($resp);
        $this->assertNull(Beneficio::find($beneficio->id), 'Beneficio should not exist in DB');
    }
}
