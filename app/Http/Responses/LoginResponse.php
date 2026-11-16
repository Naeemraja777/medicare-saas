<?php
namespace App\Http\Responses;
use App\Models\User;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user=auth()->user();
        return match($user->role){
            User::ROLE_ADMIN=>redirect()->intended('admin/dashboard'),
            User::ROLE_DOCTOR=>redirect()->intended('doctor/appointments'),
            User::ROLE_RECEPTIONIST=>redirect()->intended('reception/scheduler'),
            default=>redirect()->intended('home'),

        };
        // TODO: Implement toResponse() method.
    }

}
