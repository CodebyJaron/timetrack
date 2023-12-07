<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::create([
            'firstName' => 'Admin',
            'lastName' => 'Adminson',
            'email' => 'admin@test.com',
            'password' => Hash::make('10script10'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where([
            'first_name' => 'Admin',
            'last_name' => 'Adminson',
            'email' => 'admin@test.com',
        ])->delete();
    }
};
