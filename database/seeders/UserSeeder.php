<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        // Insérer deux utilisateurs avec le rôle d'administrateur
        DB::table('users')->insert([
            'name' => 'Djiyé NGOM',
            'email' => 'ngomdjiye@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Omar Sow',
            'email' => 'omarsow388@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
