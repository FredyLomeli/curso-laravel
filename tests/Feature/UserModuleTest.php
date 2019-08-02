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
        ->assertSee('Usuarios');
    }
    /** @test */
    function it_loads_the_user_details_page(){
        $this->get('/usuario/5')
        ->assertStatus(200)
        ->assertSee('Mostrar el ID del usuario 5');
    }
    /** @test */
    function it_loads_the_new_user_page(){
        $this->get('/usuario/nuevo')
        ->assertStatus(200)
        ->assertSee('Crear nuevo usuario');
    }
}
