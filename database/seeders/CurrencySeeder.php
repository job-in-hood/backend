<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! Currency::all()->count()) {
            Currency::create([
                'name' => 'GBP',
                'symbol' => '£'
            ]);
            Currency::create([
                'name' => 'USD',
                'symbol' => '$'
            ]);
            Currency::create([
                'name' => 'EUR',
                'symbol' => '€'
            ]);
        }
    }
}
