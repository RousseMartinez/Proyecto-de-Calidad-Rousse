<?php

namespace Tests\Integration;

use App\Models\Breed;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que los datos de una mascota puedan actualizarse correctamente
     * y que los cambios se almacenen en la base de datos.
     */
    public function test_se_puede_actualizar_una_mascota(): void
    {
        // Arrange: se crean las dependencias necesarias.
        $client = Client::factory()->create();

        $species = Species::create([
            'name' => 'Perro',
        ]);

        $breed = Breed::create([
            'name' => 'Poodle',
            'species_id' => $species->id,
        ]);

        // Se crea una mascota existente.
        $pet = Pet::create([
            'name' => 'Max',
            'species_id' => $species->id,
            'breed_id' => $breed->id,
            'client_id' => $client->id,
            'gender' => 'male',
            'age' => 3,
        ]);

        // Act: se actualizan los datos de la mascota.
        $pet->update([
            'name' => 'Max Updated',
            'age' => 4,
        ]);

        // Assert: se verifica que los cambios se hayan guardado.
        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
            'name' => 'Max Updated',
            'age' => 4,
        ]);
    }
}