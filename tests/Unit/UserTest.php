<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_usuario_puede_crearse_correctamente(): void
    {
        $user = User::factory()->create([
            'name' => 'Usuario de Prueba',
            'email' => 'usuario@test.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Usuario de Prueba',
            'email' => 'usuario@test.com',
        ]);
    }

    public function test_un_usuario_tiene_un_email_unico(): void
    {
        User::factory()->create([
            'email' => 'usuario@test.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create([
            'email' => 'usuario@test.com',
        ]);
    }

    public function test_la_contrasena_del_usuario_se_almacena_encriptada(): void
    {
        $password = 'password123';

        $hashedPassword = Hash::make($password);

        $this->assertNotEquals(
            $password,
            $hashedPassword
        );

        $this->assertTrue(
            Hash::check($password, $hashedPassword)
        );
    }
}