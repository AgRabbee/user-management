<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'     => 'Super Admin',
            'email'    => 'system@admin.com',
            'password' => Hash::make(123456),
            'role'     => 1,
        ]);
        DB::table('users')->insert([
            'name'     => 'Rabbee',
            'email'    => 'a@b.com',
            'password' => Hash::make('01799872659'),
            'role'     => 2,
        ]);
    }
}
