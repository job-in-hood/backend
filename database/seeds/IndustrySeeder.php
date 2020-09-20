<?php
namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = Industry::all()->count();

        if (! $count)
        Industry::create([
           'name' => 'Other'
        ]);
    }
}
