<?php

namespace Tests\Integration;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAppointmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que una cita pueda crearse correctamente
     * y almacenarse en la base de datos.
     */
    public function test_puede_crear_una_cita(): void
    {
        // Se crea un cliente que será asociado a la cita.
        $client = Client::factory()->create();

        // Datos de la nueva cita.
        $appointmentData = [
            'client_id' => $client->id,
            'title' => 'Consulta veterinaria',
            'description' => 'Consulta general de la mascota',
            'start_time' => '2026-07-20 10:00:00',
            'end_time' => '2026-07-20 11:00:00',
        ];

        // Se crea la cita utilizando el modelo.
        $appointment = Appointment::create($appointmentData);

        // Se verifica que la cita exista en la base de datos.
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'client_id' => $client->id,
            'title' => 'Consulta veterinaria',
        ]);
    }
}