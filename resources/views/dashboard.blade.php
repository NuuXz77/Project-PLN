<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            <x-mary-header title="Dashboard" separator />
        </h2>
    </x-slot>
    
    <div>
        <livewire:pelanggan.statiska-info/>
    </div>

    @if(session('status') == 'Login successful!')
        <div id="toast" class="toast flex flex-wrap justify-center">
            <div class="alert alert-info flex items-center">
                <span class="mr-2">Login Success</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                </svg>
            </div>
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('toast').style.display = 'none';
            }, 3000);
        </script>
    @endif
</x-layouts.app>