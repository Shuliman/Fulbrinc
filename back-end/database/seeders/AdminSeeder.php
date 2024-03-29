<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    protected $admin;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        info('Running AdminSeeder');

        $this->admin = User::factory()->create([
            'name' => env('ADMIN_USERNAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' =>  Hash::make(env('ADMIN_PASSWORD')),
            'is_admin' => true,
        ]);
        info('Admin created: ' . $this->admin->id);

    }
}
