<?php

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
        $count = DB::table('industries')->count();

        if (! $count)
        DB::table('industries')->insert([
            'name' => 'Other'
        ]);
    }
}
