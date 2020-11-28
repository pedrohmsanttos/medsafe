<?php

namespace Tests\Repositories;

use App\Models\Corretor;
use App\Repositories\CorretorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\MakeCorretorTrait;
use Tests\ApiTestTrait;

class CorretorRepositoryTest extends TestCase
{
    use DatabaseMigrations, MakeCorretorTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CorretorRepository
     */
    protected $corretorRepo;

    public function setUp()
    {
        parent::setUp();
        $this->corretorRepo = \App::make(CorretorRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCorretor()
    {
        $corretor = $this->fakeCorretorData();
        $createdCorretor = $this->corretorRepo->create($corretor);
        $createdCorretor = $createdCorretor->toArray();
        $this->assertArrayHasKey('id', $createdCorretor);
        $this->assertNotNull($createdCorretor['id'], 'Created Corretor must have id specified');
        $this->assertNotNull(Corretor::find($createdCorretor['id']), 'Corretor with given id must be in DB');
        $this->assertModelData($corretor, $createdCorretor);
    }

    /**
     * @test read
     */
    public function testReadCorretor()
    {
        $corretor = $this->makeCorretor();
        $dbCorretor = $this->corretorRepo->find($corretor->id);
        $dbCorretor = $dbCorretor->toArray();
        $this->assertModelData($corretor->toArray(), $dbCorretor);
    }

    /**
     * @test update
     */
    public function testUpdateCorretor()
    {
        $corretor = $this->makeCorretor();
        $fakeCorretor = $this->fakeCorretorData();
        $updatedCorretor = $this->corretorRepo->update($fakeCorretor, $corretor->id);
        $this->assertModelData($fakeCorretor, $updatedCorretor->toArray());
        $dbCorretor = $this->corretorRepo->find($corretor->id);
        $this->assertModelData($fakeCorretor, $dbCorretor->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCorretor()
    {
        $corretor = $this->makeCorretor();
        $resp = $this->corretorRepo->delete($corretor->id);
        $this->assertTrue($resp);
        $this->assertNull(Corretor::find($corretor->id), 'Corretor should not exist in DB');
    }
}
