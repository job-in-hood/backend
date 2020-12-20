<?php

namespace Database\Seeders;

use App\Models\SalaryType;
use Illuminate\Database\Seeder;

class SalaryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! SalaryType::all()->count()) {
            SalaryType::create([
                'name' => 'Annual'
            ]);
            SalaryType::create([
                'name' => 'Daily'
            ]);
            SalaryType::create([
                'name' => 'Hourly'
            ]);
        }
    }
}
