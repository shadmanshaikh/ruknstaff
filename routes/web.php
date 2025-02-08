<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;

Volt::route('/', 'dashboard.dashboard')->name('home')->middleware('auth');
Volt::route('/attendance', 'attendance.index')->name('attendance')->middleware('auth');
Volt::route('/login' , 'login.login')->name('login'); 
Route::get('/logout' , function(){
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login')->with('status', 'You have been logged out.')->withHeaders([
        'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT'
    ]);
});