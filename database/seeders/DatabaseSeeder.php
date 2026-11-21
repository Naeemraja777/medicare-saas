<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenant=Tenant::create([
            'name'=>'Mayo Central Hospital',
            'slug'=>'mayo-center',
            'is_active'=>true,
        ]);
//        $password=Hash::make('password12347');
        $password=Hash::make('password1234');
        User::create([
            'name'=>'John Admin',
            'email'=>'admin@mediscare.test',
            'password'=>$password,
            'tenant_id'=>$tenant->id,
            'role'=>User::ROLE_ADMIN,
        ]);
        User::create([
            'name'=>'mohd naeem',
            'email'=>'doctor@medicare.test',
            'password'=>$password,
            'tenant_id'=>$tenant->id,
            'role'=>User::ROLE_DOCTOR,
        ]);
        User::create([
            'name'=>'Azra bibi',
            'email'=>'reception@medicare.test',
            'password'=>$password,
            'tenant_id'=>$tenant->id,
            'role'=>User::ROLE_RECEPTIONIST,
        ]);




    }
}
