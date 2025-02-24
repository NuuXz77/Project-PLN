<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LogoutButton extends Component
{
    public function logout()
    {
        Auth::logout();
        return redirect()->to('/login');
    }

    public function render()
    {
        return view('livewire.logout-button');
    }
}
