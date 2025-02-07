<?php

namespace App\Livewire\Login;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    use WithFileUploads;
    public $email , $password;
    #[Layout('components.layouts.auth')]
    public function render()
    {
        return view('livewire.login.login');
    }
    public function loginCheck(){
        $validatedData = $this->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validatedData)) {
            $this->addError('username', 'Invalid credentials.');
            return;
        }
        
        return redirect()->route('home')->with('status', 'You are now logged in!');
    }
}
