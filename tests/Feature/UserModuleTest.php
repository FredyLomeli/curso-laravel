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
            'password' => '123456',
        ])->assertRedirect(route('users.index'));

        $this->assertCredentials([
            'name' => 'Jose Alfredo Jimenez',
            'email' => 'jose.jimenez@frexal.net',
            'password' => '123456',
        ]);

        // $this->assertDatabaseHas('users',[
        //     'name' => 'Jose Alfredo Jimenez',
        //     'email' => 'jose.jimenez@frexal.net',
        //     // 'password' => '12345',
        // ]);
    }
    /** @test */
    function the_name_is_required_to_create(){
        $this->from(route('user.create'))
            ->post(route('user.store'), [
                'name' => '',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.create'))
            ->assertSessionHasErrors(['name' => 'El campo nombre es obligatorio']);
        $this->assertEquals(0,User::count());
        // $this->assertDatabaseMissing('users',[
        //     'email' => 'ing.lomeli@gmail.com',
        // ]);
    }
    /** @test */
    function the_email_is_required_to_create(){
        $this->from(route('user.create'))
            ->post(route('user.store'), [
                'name' => 'Alfredo Lomeli',
                'email' => '',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.create'))
            ->assertSessionHasErrors(['email']);
        $this->assertEquals(0,User::count());
        // $this->assertDatabaseMissing('users',[
        //     'email' => 'ing.lomeli@gmail.com',
        // ]);
    }
    /** @test */
    function the_email_is_invalid_to_create(){
        $this->from(route('user.create'))
            ->post(route('user.store'), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli.com',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.create'))
            ->assertSessionHasErrors(['email']);
        $this->assertEquals(0,User::count());
        // $this->assertDatabaseMissing('users',[
        //     'email' => 'ing.lomeli@gmail.com',
        // ]);
    }
     /** @test */
     function the_email_must_be_unique_to_create(){
        factory(User::class)->create([
            'email' => 'ing.lomeli@gmail.com'
        ]);
        $this->from(route('user.create'))
            ->post(route('user.store'), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.create'))
            ->assertSessionHasErrors(['email']);
        $this->assertEquals(1,User::count());
    }
    /** @test */
    function the_password_is_required_to_create(){
        $this->from(route('user.create'))
            ->post(route('user.store'), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '',
            ])
            ->assertRedirect(route('user.create'))
            ->assertSessionHasErrors(['password']);
        $this->assertEquals(0,User::count());
    }
    /** @test */
    function the_password_must_be_between_6_and_12_caracteres_to_create(){
        $this->from(route('user.create'))
            ->post(route('user.store'), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '12345',
            ])
            ->assertRedirect(route('user.create'))
            ->assertSessionHasErrors(['password']);
        
            $this->from(route('user.create'))
            ->post(route('user.store'), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '123456789101112',
            ])
            ->assertRedirect(route('user.create'))
            ->assertSessionHasErrors(['password']);

        $this->assertEquals(0,User::count());
    }
    /** @test */
    function it_loads_the_edit_user_page(){
        $user = factory(User::class)->create();
        $this->get("/usuario/{$user->id}/editar")
        ->assertStatus(200)
        ->assertViewIs('users.edit')
        ->assertSee('Editar usuario')
        ->assertViewHas('user', function ($viewUser) use ($user){
            return $viewUser->id == $user->id;
        });
    }
    /** @test */
    function it_edit_a_user(){
        $user = factory(User::class)->create();

        $this->put(route('user.update',['user' => $user]),[
            'name' => 'Jose Alfredo Jimenez',
            'email' => 'jose.jimenez@frexal.net',
            'password' => '123456',
        ])->assertRedirect(route('user.show',['user' => $user]));

        $this->assertCredentials([
            'name' => 'Jose Alfredo Jimenez',
            'email' => 'jose.jimenez@frexal.net',
            'password' => '123456',
        ]);
    }
    /** @test */
    function the_name_is_required_to_update(){
        $user = factory(User::class)->create();

        $this->from(route('user.edit',['user' => $user]))
            ->put(route('user.update',['user' => $user]), [
                'name' => '',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.edit',['user' => $user]))
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('users',[
            'email' => 'ing.lomeli@gmail.com',
        ]);
    }
    /** @test */
    function the_email_is_required_to_update(){
        $user = factory(User::class)->create();

        $this->from(route('user.edit',['user' => $user]))
            ->put(route('user.update',['user' => $user]), [
                'name' => 'Alfredo Lomeli',
                'email' => '',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.edit',['user' => $user]))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',[
            'name' => 'Alfredo Lomeli',
        ]);
    }
    /** @test */
    function the_email_is_invalid_to_update(){
        $user = factory(User::class)->create();

        $this->from(route('user.edit',['user' => $user]))
            ->put(route('user.update',['user' => $user]), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli.com',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.edit',['user' => $user]))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',[
            'name' => 'Alfredo Lomeli',
        ]);
    }
     /** @test */
     function the_email_cant_be_the_same_on_other_user_unique_to_update(){
        factory(User::class)->create([
            'email' => 'same-email@example.com',
        ]); 
        $user = factory(User::class)->create([
            'email' => 'ing.lomeli@gmail.com'
        ]);

        $this->from(route('user.edit',['user' => $user]))
            ->put(route('user.update',['user' => $user]), [
                'name' => 'Alfredo Lomeli',
                'email' => 'same-email@example.com',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.edit',['user' => $user]))
            ->assertSessionHasErrors(['email']);

        $this->assertDatabaseMissing('users',[
            'name' => 'Alfredo Lomeli',
        ]);
    }
    /** @test */
    function the_email_can_be_the_same_user_to_update(){
        $user = factory(User::class)->create([
            'email' => 'ing.lomeli@gmail.com'
        ]);

        $this->from(route('user.edit',['user' => $user]))
            ->put(route('user.update',['user' => $user]), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '123456',
            ])
            ->assertRedirect(route('user.show',['user' => $user]));

        $this->assertDatabaseHas('users',[
            'name' => 'Alfredo Lomeli',
            'email' => 'ing.lomeli@gmail.com',
        ]);
    }
    /** @test */
    function the_password_is_optional_to_update(){
        $oldPassword = "CONTRASE_INICIAL";
        $user = factory(User::class)->create([
            'password' => bcrypt($oldPassword),
        ]);

        $this->from(route('user.edit',['user' => $user]))
            ->put(route('user.update',['user' => $user]), [
                'name' => 'Alfredo Lomeli',
                'email' => 'ing.lomeli@gmail.com',
                'password'=> '',
            ])
            ->assertRedirect(route('user.show',['user' => $user]));

        $this->assertCredentials([
            'name' => 'Alfredo Lomeli',
            'email' => 'ing.lomeli@gmail.com',
            'password' => $oldPassword,
        ]);
    }
    /** @test */
    function it_deletes_a_user(){
        $user = factory(User::class)->create();

        $this->delete(route('user.destroy',['user' => $user]))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users',[
            'id' => $user->id,
        ]);
    }
    // /** @test */
    // function the_password_must_be_between_6_and_12_caracteres_to_update(){
    //     $user = factory(User::class)->create();

    //     $this->from(route('user.edit',['user' => $user]))
    //         ->put(route('user.update',['user' => $user]), [
    //             'name' => 'Alfredo Lomeli',
    //             'email' => 'ing.lomeli@gmail.com',
    //             'password'=> '12345',
    //         ])
    //         ->assertRedirect(route('user.edit',['user' => $user]))
    //         ->assertSessionHasErrors(['password']);

    //     $this->assertDatabaseMissing('users',[
    //         'email' => 'ing.lomeli@gmail.com',
    //     ]);
    
    //     $this->from(route('user.edit',['user' => $user]))
    //         ->put(route('user.update',['user' => $user]), [
    //             'name' => 'Alfredo Lomeli',
    //             'email' => 'ing.lomeli@gmail.com',
    //             'password'=> '123456789101112',
    //         ])
    //         ->assertRedirect(route('user.edit',['user' => $user]))
    //         ->assertSessionHasErrors(['password']);

    //     $this->assertDatabaseMissing('users',[
    //         'email' => 'ing.lomeli@gmail.com',
    //     ]);
    // }
}
