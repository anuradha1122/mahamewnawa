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
    <body class="font-sans text-gray-700 antialiased">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-screen items-center justify-center p-10 text-white lg:flex">
                <img src="/images/mahamevnawa-amawatura.jpg" alt="Mahamewnawa" class="absolute h-full w-full">
            </div>
            <div class="w-full mx-auto sm:max-w-2xl mt-6 px-6 py-4 bg-white overflow-hidden">
                <div class="flex flex-col items-start gap-2 text-left sm:items-center sm:text-center">
                    <h1 class="text-2xl font-medium py-5">
                        <span class="text-red-800">Welcome</span> to Mahamewnawa Monastery
                    </h1>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
