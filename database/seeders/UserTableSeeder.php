<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(4)->create();

        User::factory()->create([
            'email' => 'test@mail.com',
            'password' => Hash::make('secret123'),
        ]);

        $this->command->info('User created');
    }
}
