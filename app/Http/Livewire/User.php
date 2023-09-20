<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class User extends Component
{
    public $email;
    public $password;
    public function render()
    {
        return view('livewire.user');
    }
    public function authenticate()
    {
        sleep(2);
        $credentials = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('locations');
        }

        return session()->flash('error', 'Email atau password tidak sesuai');
    }
}
