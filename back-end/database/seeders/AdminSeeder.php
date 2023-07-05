<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' =>  bcrypt('admin123'),
            'is_admin' => true,
        ]);
        info('Admin created: ' . $this->admin->id);

    }
}
