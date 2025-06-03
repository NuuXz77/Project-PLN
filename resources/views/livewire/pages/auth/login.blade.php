<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        // dd($this->validate());
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        Session::flash('status', 'Login successful!');
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
};
?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        {{-- Logo / Head --}}
        <div class="flex items-center justify-center h-20 p-14">
            <div class="text-center">
                <img src="{{ asset('img/logo_PLN.svg') }}" alt="logo pln" width="150" class="mx-auto">
                <h1 class="text-3xl text-black dark:text-white mt-4">LOGIN</h1>
            </div>
        </div>
        <!-- Email Address -->
        <div>
            <x-mary-input label="Email" icon="o-user" wire:model="form.email" id="email"
                class="block mt-1 w-full text-black dark:text-white" type="email" name="email" required autofocus
                autocomplete="username" />
            {{-- <x-input-error :messages="$errors->get('form.email')" class="mt-2" /> --}}
        </div>
        <!-- Password -->
        <div class="mt-4 relative">
            <x-mary-password label="Password" id="password" wire:model="form.password" type="password" name="password"
                required autocomplete="current-password" clearable class="text-black dark:text-white" />
            {{-- <x-input-error :messages="$errors->get('form.password')" class="mt-2" /> --}}
        </div>
        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="checkbox checkbox-primary checkbox-sm" name="remember" required>
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saya setuju dengan') }}
                    <a href="{{ route('terms') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ __('syarat dan ketentuan') }}
                    </a>
                </span>
            </label>
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="ms-3 btn mb-5" wire:loading.attr="disabled" wire:click="login">
                <span wire:loading.remove>{{ __('Masuk') }}</span>
                <span wire:loading class="loading loading-spinner text-primary"></span>
            </x-primary-button>

            {{-- <div>
                <div class="text-sm text-center text-gray-600 dark:text-gray-400">
                    Belum memiliki akun?
                    <a class="underline hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('register') }}" wire:navigate>
                        {{ __('Register disini') }}
                    </a>
                </div>

                <div class="text-sm text-center text-gray-600 dark:text-gray-400 mt-1">
                    atau
                </div>

                @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Lupa password anda?') }}
                    </a>
                </div>
                @endif
            </div> --}}
        </div>
    </form>
</div>
