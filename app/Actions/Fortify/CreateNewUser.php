<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'clinic_name' => ['required', 'string','min:3', 'max:255'],
            'clinic_slug' => ['required', 'string','alpha_dash','max:255','unique:tenants,slug'],

        ])->validate();
        //Execute the transaction so the Tenant and user are created together safely
        return DB::transaction(function() use ($input){
            //Create the clinic tenant record first
            $tenant=Tenant::create([
                'name'=>$input['clinic_name'],
                'slug'=>str($input['clinic_slug'])->slug(),
                'is_active'=>true
            ]);
            //Create the Admin  user and linked them directly to the tenant id
            return User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'tenant_id' => $tenant->id,
            ]);

        });
        //Create the clinic tenant record first



    }
}
