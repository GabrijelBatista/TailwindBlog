<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name'=>'Antonija Spajić',
            'email' => 'antonija@admin.com',
            'password' => \Hash::make('admin.antonija123'),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        \DB::table('users')->insert([
            'name'=>'Enis Pekić',
            'email' => 'enis@admin.com',
            'password' => \Hash::make('admin.enis123'),
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}

