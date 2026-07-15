<?php

namespace Tests\Unit\Models;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class PetModelTest extends TestCase
{
    /** @test */
    public function pet_has_expected_fillable_attributes()
    {
        $pet = new Pet();

        $this->assertEquals([
            'name',
            'species_id',
            'breed_id',
            'age',
            'gender',
            'client_id',
            'photo'
        ], $pet->getFillable());
    }

    /** @test */
    public function pet_belongs_to_client()
    {
        $this->assertInstanceOf(
            BelongsTo::class,
            (new Pet())->client()
        );
    }

    /** @test */
    public function pet_belongs_to_species()
    {
        $this->assertInstanceOf(
            BelongsTo::class,
            (new Pet())->species()
        );
    }

    /** @test */
    public function pet_has_many_vaccinations()
    {
        $this->assertInstanceOf(
            HasMany::class,
            (new Pet())->vaccinations()
        );
    }
}