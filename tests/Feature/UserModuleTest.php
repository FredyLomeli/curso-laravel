<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModuleTest extends TestCase
{
    /** @test */
    function it_loads_the_user_list_page(){
        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de usuarios')
        ->assertSee('Joel')
        ->assertSee('Ellie');
    }
    /** @test */
    function it_loads_the_user_details_page(){
        $this->get('/usuario/5')
        ->assertStatus(200)
        ->assertSee('Mostrando detalle del usuario: 5');
    }
    /** @test */
    function it_loads_the_new_user_page(){
        // este comando muestra el error mas detallado
        // $this->withoutExceptionHandling();
        $this->get('/usuario/nuevo')
        ->assertStatus(200)
        ->assertSee('Crear nuevo usuario');
    }
}
