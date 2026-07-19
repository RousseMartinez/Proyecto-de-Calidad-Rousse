<?php

namespace Tests\Integration;

use App\Models\Breed;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que una mascota pueda crearse correctamente
     * asociada a un cliente, una especie y una raza.
     */
    public function test_puede_crear_una_mascota(): void
    {
        // Se crean los registros necesarios para las relaciones.
        $client = Client::factory()->create();

        $species = Species::create([
            'name' => 'Perro',
        ]);

        $breed = Breed::create([
            'name' => 'Poodle',
            'species_id' => $species->id,
        ]);

        // Datos de la nueva mascota.
        $petData = [
            'name' => 'Copito',
            'species_id' => $species->id,
            'breed_id' => $breed->id,
            'age' => 3,
            'gender' => 'Macho',
            'client_id' => $client->id,
        ];

        // Se crea la mascota utilizando el modelo.
        $pet = Pet::create($petData);

        // Se verifica que la mascota exista en la base de datos.
        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
            'name' => 'Copito',
            'client_id' => $client->id,
            'species_id' => $species->id,
            'breed_id' => $breed->id,
        ]);
    }
}