<?php

namespace Tests\Integration;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que un cliente pueda crearse correctamente
     * y almacenarse en la base de datos.
     */
    public function test_puede_crear_un_cliente(): void
    {
        // Datos del nuevo cliente.
        $clientData = [
            'name' => 'Daniela Briceño',
            'email' => 'daniela.briceño@example.com',
            'phone_number' => '987654321',
            'address' => 'Av. bonita 123',
            'notes' => 'Cliente registrado para atención veterinaria.',
        ];

        // Se crea el cliente utilizando el modelo.
        $client = Client::create($clientData);

        // Se verifica que el cliente exista en la base de datos.
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Daniela Briceño',
            'email' => 'daniela.briceño@example.com',
        ]);
    }
}