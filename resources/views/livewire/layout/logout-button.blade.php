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
        <x-mary-menu-item icon="o-arrow-left-on-rectangle" class="hover:bg-gray-100 hover:text-black"/>
    </button>
</div>
