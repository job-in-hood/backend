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
        if (! Industry::all()->count())
        Industry::create([
           'name' => 'Other'
        ]);
    }
}
