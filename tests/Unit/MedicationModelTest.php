<?php

namespace Tests\Unit;

use App\Models\Medication;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Species;
use App\Models\Breed;
use App\Models\Client;

class MedicationModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_medicacion_tiene_los_atributos_fillable_esperados(): void
    {
        $medication = new Medication();

        $this->assertEquals(
            [
                'pet_id',
                'medication_name',
                'administered_at',
                'dosage',
                'frequency',
                'administering_veterinarian',
                'notes',
            ],
            $medication->getFillable()
        );
    }

    public function test_la_medicacion_pertenece_a_una_mascota(): void
    {
        $medication = new Medication();

        $this->assertInstanceOf(
            BelongsTo::class,
            $medication->pet()
        );
    }

    public function test_se_puede_crear_una_medicacion_para_una_mascota(): void
    {
        $species = Species::create([
            'name' => 'Perro',
        ]);

        $breed = Breed::create([
            'name' => 'Labrador',
            'species_id' => $species->id,
        ]);

        $client = Client::factory()->create();

        $pet = Pet::factory()->create([
            'species_id' => $species->id,
            'breed_id' => $breed->id,
            'client_id' => $client->id,
        ]);

        $medication = Medication::create([
            'pet_id' => $pet->id,
            'medication_name' => 'Amoxicilina',
            'administered_at' => now(),
            'dosage' => '500 mg',
            'frequency' => 'Cada 8 horas',
            'administering_veterinarian' => 'Dr. Veterinario',
            'notes' => 'Administrar después de los alimentos',
        ]);

        $this->assertDatabaseHas('medications', [
            'id' => $medication->id,
            'pet_id' => $pet->id,
            'medication_name' => 'Amoxicilina',
        ]);
    }
}