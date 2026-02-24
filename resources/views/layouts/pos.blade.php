<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'POS System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<style>
@media print {
    .print\:hidden {
        display: none !important;
    }
}
</style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-slate-900 
             text-gray-800 dark:text-gray-100 
             transition-colors duration-300">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('pos-component.sidebar')

    <div class="flex-1 flex flex-col">

        {{-- Top Navbar --}}
        @include('pos-component.navbar')

        {{-- Page Content --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
