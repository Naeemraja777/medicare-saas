<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth','role:clinic_admin,doctor,receptionist'])->group(function(){
    Route::get('/home', function () {
        return 'Logged in to clinic'.auth()->user()->tenant->name.'as'.str(auth()->user()->role)->title();
    })->name('home');

});
