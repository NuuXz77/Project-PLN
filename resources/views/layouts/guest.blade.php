<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-200 dark:bg-base-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-end pt-6 sm:pt-0 bg-gray-100 ">
            <div class="absolute inset-0 z-0">
                <img src="{{asset('img/wpp-pln.svg')}}" alt="" class="w-full h-full object-cover">
            </div>
            <div class="z-10 md:mr-20 w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-200 dark:bg-base-200 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
