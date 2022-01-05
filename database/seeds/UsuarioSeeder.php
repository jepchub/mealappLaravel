<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'=> 'Jose',
            'email'=> 'jose@jose.com',
            'password'=> Hash::make('12345678'),
            'url'=> 'http://codeJepc.com',
        ]);
        // $user->perfil()->create();

        $user2 = User::create([
            'name'=> 'Pepe',
            'email'=> 'pepe@pepe.com',
            'password'=> Hash::make('12345678'),
            'url'=> 'http://codePepe.com',
        ]);
        // $user2->perfil()->create();

        // DB::table('users')->insert([
        //     'name'=> 'Jose',
        //     'email'=> 'jose@jose.com',
        //     'password'=> Hash::make('12345678'),
        //     'url'=> 'http://codeJepc.com',
        //     'created_at'=> date('Y-m-d H:i:s'),
        //     'updated_at'=> date('Y-m-d H:i:s'),
        // ]);

        // DB::table('users')->insert([
        //     'name'=> 'Pepe',
        //     'email'=> 'pepe@pepe.com',
        //     'password'=> Hash::make('12345678'),
        //     'url'=> 'http://codePepe.com',
        //     'created_at'=> date('Y-m-d H:i:s'),
        //     'updated_at'=> date('Y-m-d H:i:s'),
        // ]);
    }
}
