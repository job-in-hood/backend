<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultRolesAndPermissions::class);

        $this->call(IndustrySeeder::class);

        $this->call(LocationTypeSeeder::class);
        $this->call(LocationSeeder::class);


    }
}
