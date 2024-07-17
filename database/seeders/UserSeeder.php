<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name'        => 'Mario Aurelio',
            'last_name'         => 'Gasca López',
            'email'             => 'hola@mariogasca.com',
            'password'          => Hash::make( 'password' ),
        ]);

        User::factory( 99 )->create();
    }
}
