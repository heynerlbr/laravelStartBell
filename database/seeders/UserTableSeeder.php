<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_aprobador = Role::where('name', 'aprobador')->first();
        $role_proveedor = Role::where('name', 'proveedor')->first();
        $role_admin = Role::where('name', 'admin')->first();                   

        $user = new User();
        $user->name = 'Proveedor';
        $user->email = 'heyner@gmail.com';
        $user->password = bcrypt('sdk@laravel');
        $user->save();
        $user->roles()->attach($role_proveedor);

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'heyner.becerrasdk@gmail.com';
        $user->password = bcrypt('sdk@laravel');
        $user->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->name = 'Aprobador';
        $user->email = 'heynerlbr@gmail.com';
        $user->password = bcrypt('sdk@laravel');
        $user->save();
        $user->roles()->attach($role_admin);


    }
}
