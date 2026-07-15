<?php

namespace Tests\Unit\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ClientModelTest extends TestCase
{
    /**
     * Verifica que el modelo Client tenga definidos
     * correctamente los atributos asignables (fillable).
     */
    public function test_client_has_expected_fillable_attributes()
    {
        $client = new Client();

        $this->assertEquals([
            'name',
            'slug',
            'email',
            'phone_number',
            'address',
            'notes',
        ], $client->getFillable());
    }

    /**
     * Verifica que un cliente pueda tener muchas mascotas.
     */
    public function test_client_has_many_pets()
    {
        $this->assertInstanceOf(
            HasMany::class,
            (new Client())->pets()
        );
    }

    /**
     * Verifica que un cliente pueda tener muchas citas.
     */
    public function test_client_has_many_appointments()
    {
        $this->assertInstanceOf(
            HasMany::class,
            (new Client())->appointments()
        );
    }

    /**
     * Verifica que el modelo Client utilice la tabla correcta.
     */
    public function test_client_uses_correct_table()
    {
        $client = new Client();

        $this->assertEquals(
            'clients',
            $client->getTable()
        );
    }
}