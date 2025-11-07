<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex items-center justify-center background-overlay">
        <div class="flex items-center justify-center w-3/4 mx-auto content-wrapper">
            <div class="flex-1 flex justify-center items-center logo-container">
                <img src="{{ asset('icons/logo.png') }}" alt="Logo" class="w-3/4 md:w-2/3 lg:w-1/2 h-auto">
            </div>

            <div class="flex-1 flex justify-center login-card-container">
                <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-lg rounded-lg login-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
