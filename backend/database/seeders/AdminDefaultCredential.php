<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDefaultCredential extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = "Rashed alam";
        $admin->photo = "admin.jpg";
        $admin->email = "admin@gmail.com";
        $admin->password = Hash::make(12345);
        $admin->save();
    }
}
