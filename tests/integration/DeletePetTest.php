<?php

namespace Tests\Integration;

use App\Models\Breed;
use App\Models\Client;
use App\Models\Pet;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que una mascota pueda eliminarse correctamente
     * de la base de datos.
     */
    public function test_se_puede_eliminar_una_mascota(): void
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

        // Se crea la mascota que será eliminada.
        $pet = Pet::create([
            'name' => 'Max',
            'species_id' => $species->id,
            'breed_id' => $breed->id,
            'client_id' => $client->id,
            'gender' => 'male',
            'age' => 3,
        ]);

        // Act: se elimina la mascota.
        $pet->delete();

        // Assert: se verifica que la mascota ya no exista en la base de datos.
        $this->assertDatabaseMissing('pets', [
            'id' => $pet->id,
        ]);
    }
}