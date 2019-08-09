<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_loads_the_user_list_page(){
        factory(User::class)->create([
            'name' => 'Joel'
        ]);
        factory(User::class)->create([
            'name' => 'Ellie'
        ]);

        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('Listado de usuarios')
        ->assertSee('Joel')
        ->assertSee('Ellie');
    }
    /** @test */
    function it_loads_the_user_list_empty_page(){
        $this->get('/usuarios')
        ->assertStatus(200)
        ->assertSee('No hay usuarios registrados');
    }
    /** @test */
    function it_loads_the_user_details_page(){
        
        $user = factory(User::class)->create([
            'name' => 'Joel'
        ]);

        $this->get("/usuario/{$user->id}")
        ->assertStatus(200)
        ->assertSee("Nombre: {$user->name}")
        ->assertSee("Correo electronico: {$user->email}");
    }
    /** @test */
    function it_display_a_404_error_if_the_user_is_not_found(){
        $this->get('/usuario/10000')
        ->assertStatus(404)
        ->assertSee('Pagina no encontrada');
    }
    /** @test */
    function it_loads_the_new_user_page(){
        // este comando muestra el error mas detallado
        // $this->withoutExceptionHandling();
        $this->get('/usuario/nuevo')
        ->assertStatus(200)
        ->assertSee('Crear nuevo usuario');
    }
    /** @test */
    function it_create_a_new_user(){
        $this->post(route('user.store'),[
            'name' => 'Jose Alfredo Jimenez',
            'email' => 'jose.jimenez@frexal.net',
            'password' => '12345',
        ])->assertRedirect(route('users.index'));

        $this->assertCredentials([
            'name' => 'Jose Alfredo Jimenez',
            'email' => 'jose.jimenez@frexal.net',
            'password' => '12345',
        ]);

        // $this->assertDatabaseHas('users',[
        //     'name' => 'Jose Alfredo Jimenez',
        //     'email' => 'jose.jimenez@frexal.net',
        //     // 'password' => '12345',
        // ]);
    }
    /** @test */
    function the_name_id_required(){
        $this->post(route('user.store'), [
            'name' => '',
            'email' => 'ing.lomeli@gmail.com',
            'password'=> '123456',
        ])->assertStatus(route('user.create'))
            ->assertSessioHasErrors(['name' => 'El campo nombre es obligatorio']);
        
        $this->assertDatabaseMissing('users',[
            'email' => 'ing.lomeli@gmail.com',
        ]);
    }
}
