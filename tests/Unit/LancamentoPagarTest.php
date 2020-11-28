<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\LancamentoPagar;

class LancamentoPagarTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test on create.
     *
     * @return void
     */
    public function test_can_create_lancamento_pagar() 
    {
        $lancamento_pagar = factory(LancamentoPagar::class)->create();

        $this->assertDatabaseHas('lancamentos_pagar', ['id' => $lancamento_pagar->id]);
    }

    /**
     * Test on update.
     *
     * @return void
     */
    public function test_can_update_lancamento_pagar() 
    {
        $lancamento_pagar = factory(LancamentoPagar::class)->create();
        // Case edit 
        $lancamento_pagar->fornecedor_id = '1';
        // save edit
        $lancamento_pagar->save();

        // find cliente
        $this->assertDatabaseHas('lancamentos_pagar', ['id' => $lancamento_pagar->id]);
        $this->assertEquals($lancamento_pagar->fornecedor_id, '1');
    }

     /**
     * Test on show.
     *
     * @return void
     */
    public function test_can_show_lancamento_pagar() 
    {
        $lancamento_pagar = factory(LancamentoPagar::class)->create();

        $this->expectOutputString($lancamento_pagar->fornecedor_id);
        print $lancamento_pagar->fornecedor_id;
    }

    /**
     * Test on delete.
     *
     * @return void
     */
    public function test_can_delete_lancamento_pagar() 
    {
        $this->assertTrue(true);
    }

    /**
     * Test on list.
     *
     * @return void
     */
    public function test_can_list_lancamento_pagar()
    {
        // Get all clientes
        $createLancamentosPagar = factory(LancamentoPagar::class, 10)->create();
        $getLancamentoPagar     = LancamentoPagar::get();

        $this->assertTrue(count($getLancamentoPagar) == 10);
    }
}
