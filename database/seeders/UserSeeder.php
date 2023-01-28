<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'name'       => 'Admin',
            'email'      => 'admin@mail.com',
            'password'   => Hash::make('12345678'),
            'role_id'    => Role::where('slug', 'admin')->first()->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
