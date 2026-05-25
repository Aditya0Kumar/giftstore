<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GiftStore - Premium Gift Experience</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-brand selection:bg-accent selection:text-white bg-surface">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0">
            <div class="mb-6">
                <a href="{{ route('home') }}" class="text-3xl font-serif font-medium tracking-tight text-brand flex items-center gap-2 hover:opacity-90 transition duration-300">
                    <x-application-logo class="w-9 h-9 text-accent" />
                    <span>GiftStore</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-white border border-border shadow-xl rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

