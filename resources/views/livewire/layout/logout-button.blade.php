<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();  

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <button wire:click="logout">
        <x-mary-menu-item title="Logout" icon="o-archive-box"/>
    </button>
</div>
