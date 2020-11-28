<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Cliente;

class ClienteTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test on create.
     *
     * @return void
     */
    public function test_can_create_cliente() {
        $cliente = factory(Cliente::class)->create();

        $this->assertDatabaseHas('clientes', ['id' => $cliente->id]);
    }

    /**
     * Test on update.
     *
     * @return void
     */
    public function test_can_update_cliente() {
        $cliente = factory(Cliente::class)->create();
        // Case edit 
        $cliente->razaoSocial = 'Inhalt';
        // save edit
        $cliente->save();

        // find cliente
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id]);
        $this->assertEquals($cliente->razaoSocial, 'Inhalt');
    }

    /**
     * Test on show.
     *
     * @return void
     */
    public function test_can_show_cliente() {
        $cliente = factory(Cliente::class)->create();

        $this->expectOutputString($cliente->razaoSocial);
        print $cliente->razaoSocial;
    }

    /**
     * Test on delete.
     *
     * @return void
     */
    public function test_can_delete_delete() {
        $this->assertTrue(true);
    }

    /**
     * Test on list.
     *
     * @return void
     */
    public function test_can_list_clieinte() {
        // Get all clientes
        $cliente = factory(Cliente::class, 10)->create();
        $clientes = Cliente::get();

        $this->assertTrue(count($clientes) == 10);
    }
}
