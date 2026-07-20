<?php

namespace Tests\Unit;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_item_tiene_los_atributos_fillable_esperados(): void
    {
        $item = new Item();

        $this->assertEquals(
            [
                'item_name',
                'slug',
                'description',
                'quantity',
                'unit_price',
            ],
            $item->getFillable()
        );
    }

    public function test_el_item_genera_un_slug_despues_de_crearse(): void
    {
        $item = Item::create([
            'item_name' => 'Vacuna Antirrábica',
            'slug' => 'temporal',
            'description' => 'Vacuna para mascotas',
            'quantity' => 10,
            'unit_price' => 25.50,
        ]);

        $this->assertEquals(
            'vacuna-antirrabica-' . $item->id,
            $item->fresh()->slug
        );
    }

    public function test_el_item_se_guarda_correctamente_en_la_base_de_datos(): void
    {
        $item = Item::create([
            'item_name' => 'Jeringas',
            'slug' => 'jeringas',
            'description' => 'Jeringas descartables',
            'quantity' => 50,
            'unit_price' => 2.50,
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'item_name' => 'Jeringas',
            'quantity' => 50,
        ]);
    }
}