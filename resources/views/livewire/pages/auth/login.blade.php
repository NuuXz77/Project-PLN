<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        Session::flash('status', 'Login successful!');
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        {{-- Logo / Head --}}
        <div>
            {{-- <x-application-logo class=" text-gray-900 dark:text-white" /> --}}
            <x-input-label for="judul" :value="__('Login Admin')" class="text-center font-bold text-4xl my-8" />
        </div>
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full !text-black" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full pr-10 !text-black"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />

                <!-- Tombol untuk toggle visibility password -->
                <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <!-- Ikon untuk show password (mata terbuka) -->
                    <svg id="show-icon" class="h-5 w-5 text-gray-500" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.274.823-.676 1.584-1.186 2.25M15 12a3 3 0 01-6 0m6 0a3 3 0 01-6 0m6 0c0 1.657-1.343 3-3 3s-3-1.343-3-3m6 0c0-1.657-1.343-3-3-3s-3 1.343-3 3m6 0c.51.666.912 1.427 1.186 2.25M21.542 12C20.268 16.057 16.477 19 12 19c-4.477 0-8.268-2.943-9.542-7" />
                    </svg>
                    <!-- Ikon untuk hide password (mata tertutup) -->
                    <svg id="hide-icon" class="h-5 w-5 text-gray-500 hidden" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7 .274-.823.676-1.584 1.186-2.25m13.677 5.018A10.05 10.05 0 0121.542 12C20.268 16.057 16.477 19 12 19a10.05 10.05 0 01-1.875-.175m0 0l.875-3.825M9.125 18.825L10 15m3.875 3.825L14 15m-4.875 3.825L8 15m3.125-3.825L12 15m4.875-3.825L16 15M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <script>
            function togglePasswordVisibility() {
                const passwordField = document.getElementById('password');
                const showIcon = document.getElementById('show-icon');
                const hideIcon = document.getElementById('hide-icon');

                if (passwordField.type === 'password') {
                    // Jika password disembunyikan, ubah ke text (tampilkan password)
                    passwordField.type = 'text';
                    showIcon.classList.add('hidden'); // Sembunyikan ikon show
                    hideIcon.classList.remove('hidden'); // Tampilkan ikon hide
                } else {
                    // Jika password ditampilkan, ubah ke password (sembunyikan password)
                    passwordField.type = 'password';
                    hideIcon.classList.add('hidden'); // Sembunyikan ikon hide
                    showIcon.classList.remove('hidden'); // Tampilkan ikon show
                }
            }
        </script>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="checkbox checkbox-primary checkbox-sm" name="remember" required>
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Saya setuju dengan ketentuan !') }}</span>
            </label>
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="ms-3 btn mb-5" wire:loading.attr="disabled" wire:click="login">
                <span wire:loading.remove>{{ __('Masuk') }}</span>
                <span wire:loading class="loading loading-spinner text-primary"></span>
            </x-primary-button>

            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                {{ __('Forgot your password?') }}
            </a>
            @endif
            
            
        </div>
    </form>

    <!-- Script untuk mendengarkan event Livewire -->
    <script>
        Livewire.on('show-toast', (data) => {
            showToast(data.message, data.type);
        });
    </script>
</div>