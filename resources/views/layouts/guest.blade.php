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
        <!-- Daisyui -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#e5e5e5] antialiased bg-[#0a0a0a]">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <div class="flex-grow">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </div>

            @include('layouts.footer')
        </div>
        @stack('scripts')
    </body>
</html>
