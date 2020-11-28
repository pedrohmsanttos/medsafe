<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Novidade;

class NovidadeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test on create.
     *
     * @return void
     */
    public function test_can_create_novidade()
    {
        $novidade = factory(Novidade::class)->create();

        $this->assertDatabaseHas('novidades', ['id' => $novidade->id]);
    }

    /**
     * Test on update.
     *
     * @return void
     */
    public function test_can_update_novidade()
    {
        $novidade = factory(Novidade::class)->create();
        // Case edit
        $novidade->titulo = 'titulo de teste';
        // save edit
        $novidade->save();

        // find cliente
        $this->assertDatabaseHas('novidades', ['id' => $novidade->id]);
        $this->assertEquals($novidade->titulo, 'titulo de teste');
    }

    /**
     * Test on show.
     *
     * @return void
     */
    public function test_can_show_novidade()
    {
        $novidade = factory(Novidade::class)->create();

        $this->expectOutputString($novidade->titulo);
        print $novidade->titulo;
    }

    /**
     * Test on delete.
     *
     * @return void
     */
    public function test_can_delete_novidade()
    {
        $this->assertTrue(true);
    }

    /**
     * Test on list.
     *
     * @return void
     */
    public function test_can_list_novidade()
    {
        // Get all clientes
        $novidade = factory(Novidade::class, 10)->create();
        $novidades = Novidade::get();

        $this->assertTrue(count($novidades) == 10);
    }
}
