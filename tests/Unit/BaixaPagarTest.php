<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\BaixaPagar;

class BaixaPagarTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test on create.
     *
     * @return void
     */
    public function test_can_create_baixa_pagar()
    {
        $baixa = factory(BaixaPagar::class)->create();

        $this->assertDatabaseHas('baixa_contas_pagar', ['id' => $baixa->id]);
    }

    /**
     * Test on update.
     *
     * @return void
     */
    public function test_can_update_baixa_pagar()
    {
        $baixa = factory(BaixaPagar::class)->create();
        // Case edit 
        $baixa->disponibilidade = '2014-01-07';
        // save edit
        $baixa->save();

        // find baixa
        $this->assertDatabaseHas('baixa_contas_pagar', ['id' => $baixa->id]);
        $this->assertEquals($baixa->disponibilidade->toDateTimeString(), '2014-01-07 00:00:00');
    }

    /**
     * Test on show.
     *
     * @return void
     */
    public function test_can_show_baixa_pagar()
    {
        $baixa = factory(BaixaPagar::class)->create();

        $this->expectOutputString($baixa->disponibilidade);
        print $baixa->disponibilidade;
    }

    /**
     * Test on delete.
     *
     * @return void
     */
    public function test_can_delete_baixa_pagar() {
        $baixa = factory(BaixaPagar::class)->create();

        $baixa->delete();

        $this->assertSoftDeleted('baixa_contas_pagar', ['id' => $baixa->id]);
    }

    /**
     * Test on list.
     *
     * @return void
     */
    public function test_can_list_baixas_pagas() 
    {
        // Get all Baixas a Pagar
        $baixas = factory(BaixaPagar::class, 10)->create();
        $getBaixas = BaixaPagar::get();

        $this->assertTrue(count($getBaixas) == 10);
    }

    /**
    * A basic test request auth!
    *
    * @return void
    */
    public function testBasicRequest()
    {
        $response = $this->get('/baixapagar');

        $response->assertStatus(302);
    }

    /**
    * A Baixa a Pagar belengs to the Lançamento
    *
    * @return void
    */
    public function a_baixa_pagar_belongs_to_the_lancamento()
    {
        $this->assertInstanceOf('App\Models\LancamentoPagar', $this->baixa->lancamentosPagar()->first());
    }

    /**
    * A Baixa a Pagar belengs to the Conta Bancária
    *
    * @return void
    */
    public function a_baixa_pagar_belongs_to_the_conta_bancaria()
    {
        $this->assertInstanceOf('App\Models\ContaBancaria', $this->baixa->contasBancaria()->first());
    }

    /**
    * A Baixa a Pagar belengs to the Conta Bancária
    *
    * @return void
    */
    public function a_baixa_pagar_belongs_to_the_forma_pagamento()
    {
        $this->assertInstanceOf('App\Models\FormaDePagamento', $this->baixa->formasDePagamento()->first());
    }
}
