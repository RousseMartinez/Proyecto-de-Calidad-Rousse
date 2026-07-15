<?php

namespace Tests\Unit\Models;

use App\Models\Appointment;
use App\Models\Client;
use Tests\TestCase;

class AppointmentModelTest extends TestCase
{
    /** @test */
    // Verifica que el modelo permita asignar masivamente los campos esperados.
    public function appointment_has_expected_fillable_attributes()
    {
        $appointment = new Appointment();

        $this->assertEquals([
            'client_id',
            'title',
            'description',
            'start_time',
            'end_time'
        ], $appointment->getFillable());
    }

    /** @test */
    // Verifica que una cita pertenezca a un cliente mediante la relación belongsTo.
    public function appointment_belongs_to_a_client()
    {
        $appointment = new Appointment();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $appointment->client()
        );

        $this->assertEquals(
            'client_id',
            $appointment->client()->getForeignKeyName()
        );
    }
}