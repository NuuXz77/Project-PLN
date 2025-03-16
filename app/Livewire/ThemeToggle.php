<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public $theme = 'light'; // Default tema

    public function toggleTheme()
    {
        $this->theme = ($this->theme === 'light') ? 'dark' : 'light';
        session(['theme' => $this->theme]);
        $this->dispatchBrowserEvent('theme-changed', ['theme' => $this->theme]);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
