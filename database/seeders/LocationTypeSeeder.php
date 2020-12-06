<?php

namespace Database\Seeders;

use App\Models\LocationType;
use Illuminate\Database\Seeder;

class LocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!LocationType::all()->count()) {
            $types = collect(['Country', 'City', 'District', 'Postcode']);

            $types->each(fn($typeName) => LocationType::create(['name' => $typeName]));
        }
    }
}
