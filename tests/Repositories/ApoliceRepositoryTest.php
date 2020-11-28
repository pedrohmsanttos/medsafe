<?php

namespace Tests\Repositories;

use App\Models\Apolice;
use App\Repositories\ApoliceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\MakeApoliceTrait;
use Tests\ApiTestTrait;

class ApoliceRepositoryTest extends TestCase
{
    use DatabaseMigrations, MakeApoliceTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ApoliceRepository
     */
    protected $apoliceRepo;

    public function setUp()
    {
        parent::setUp();
        $this->apoliceRepo = \App::make(ApoliceRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateApolice()
    {
        $apolice = $this->fakeApoliceData();
        $createdApolice = $this->apoliceRepo->create($apolice);
        $createdApolice = $createdApolice->toArray();
        $this->assertArrayHasKey('id', $createdApolice);
        $this->assertNotNull($createdApolice['id'], 'Created Apolice must have id specified');
        $this->assertNotNull(Apolice::find($createdApolice['id']), 'Apolice with given id must be in DB');
        $this->assertModelData($apolice, $createdApolice);
    }

    /**
     * @test read
     */
    public function testReadApolice()
    {
        $apolice = $this->makeApolice();
        $dbApolice = $this->apoliceRepo->find($apolice->id);
        $dbApolice = $dbApolice->toArray();
        $this->assertModelData($apolice->toArray(), $dbApolice);
    }

    /**
     * @test update
     */
    public function testUpdateApolice()
    {
        $apolice = $this->makeApolice();
        $fakeApolice = $this->fakeApoliceData();
        $updatedApolice = $this->apoliceRepo->update($fakeApolice, $apolice->id);
        $this->assertModelData($fakeApolice, $updatedApolice->toArray());
        $dbApolice = $this->apoliceRepo->find($apolice->id);
        $this->assertModelData($fakeApolice, $dbApolice->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteApolice()
    {
        $apolice = $this->makeApolice();
        $resp = $this->apoliceRepo->delete($apolice->id);
        $this->assertTrue($resp);
        $this->assertNull(Apolice::find($apolice->id), 'Apolice should not exist in DB');
    }
}
