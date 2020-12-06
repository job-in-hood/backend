<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\LocationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $citiesFile = Storage::get('seeds/cities.csv');

        $data_array = array_map("str_getcsv", explode("\n", $citiesFile));
        $labels = array_shift($data_array);

        $data = collect($data_array)->map(function ($line) use ($labels) {
            if (count($labels) == count($line)) {
                return array_combine($labels, $line);
            }
        });

        $location_types = LocationType::select('id','name')->get();

        $data->filter(fn($data) => $data)->each(function($data) use ($location_types) {
            $type = $location_types->firstWhere('name', $data['location_type']);
            unset($data['location_type']);

            $location = Location::firstOrNew(['display_name' => $data['display_name']])->fill($data);
            $location->slug = Str::slug($location->name);

            if ($type)
                $location->locationType()->associate($type);

            $location->save();
        });
    }
}
