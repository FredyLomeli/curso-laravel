<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /** @test */
    function it_walcome_users_whit_nickname(){
        $this->get('/saludo/alfredo/fredy')
        ->assertStatus(200)
        ->assertSee('Bienvenido Alfredo, tu apodo es Fredy');
    }
    /** @test */
    function it_welcomes_users_whitout_nickname(){
        $this->get('/saludo/alfredo')
        ->assertStatus(200)
        ->assertSee('Bienvenido Alfredo');
    }
}
