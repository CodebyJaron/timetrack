<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        if (App::environment(['local', 'testing'])) {
            $this->call([
                // UserSeeder::class,

                App\Models\User->create([
                    'firstName' => 'Test',
                    'lastName' => 'test',
                    'email' => 'test@test.com',
                    'password' => Hash::make('admin'),
                ])
            ]);
        }
    }
}
