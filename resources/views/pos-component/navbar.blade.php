<header class="bg-black shadow px-6 py-3 flex justify-between items-center">
    <h1 class="font-semibold text-lg">@yield('title', 'Dashboard')</h1>

   <div class="text-sm text-green">
    {{ now()->format('d M Y, H:i') }} |
    {{ auth()->check() ? auth()->user()->name : 'Guest' }}
</div>
</header>
