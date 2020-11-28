<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\LancamentoReceber;

class LancamentoReceberTest extends TestCase
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
    public function test_can_create_lancamento_receber() {
        $lancamento_receber = factory(LancamentoReceber::class)->create();

        $this->assertDatabaseHas('lancamentos_receber', ['id' => $lancamento_receber->id]);
    }

    /**
     * Test on update.
     *
     * @return void
     */
    public function test_can_update_lancamento_receber() {
        $lancamento_receber = factory(LancamentoReceber::class)->create();
        // Case edit 
        $lancamento_receber->cliente_id = '1';
        // save edit
        $lancamento_receber->save();

        // find cliente
        $this->assertDatabaseHas('lancamentos_receber', ['id' => $lancamento_receber->id]);
        $this->assertEquals($lancamento_receber->cliente_id, '1');
    }

    /**
     * Test on show.
     *
     * @return void
     */
    public function test_can_show_lancamento_receber() {
        $lancamento_receber = factory(LancamentoReceber::class)->create();

        $this->expectOutputString($lancamento_receber->cliente_id);
        print $lancamento_receber->cliente_id;
    }

    /**
     * Test on delete.
     *
     * @return void
     */
    public function test_can_delete_lancamento_receber() {
        $this->assertTrue(true);
    }

    /**
     * Test on list.
     *
     * @return void
     */
    public function test_can_list_lancamento_receber() {
        // Get all clientes
        $lancamento_receber = factory(LancamentoReceber::class, 10)->create();
        $lancamento_recebers = LancamentoReceber::get();

        $this->assertTrue(count($lancamento_recebers) == 10);
    }

}
