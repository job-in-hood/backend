<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! JobType::all()->count()) {
            JobType::create([
                'name' => 'Contract'
            ]);
            JobType::create([
                'name' => 'Temporary'
            ]);
            JobType::create([
                'name' => 'Part Time'
            ]);
            JobType::create([
                'name' => 'Permanent'
            ]);
        }
    }
}
