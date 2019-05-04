<?php

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
         $this->call(UsersTableSeeder::class);
         $this->call(ResearchAreasTableSeeder::class);
         $this->call(DistrictsSeeder::class);
         $this->call(ContractsSeeder::class);
         $this->call(ObjsSeeder::class);
         $this->call(TaskParamsSeeder::class);
    }
}
