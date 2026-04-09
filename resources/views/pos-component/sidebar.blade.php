<aside class="w-64 min-h-screen 
    bg-white text-gray-800 
    dark:bg-slate-900 dark:text-slate-100 
    flex flex-col shadow-xl transition-colors duration-300">

    <!-- Logo / Brand -->
    <div class="px-6 py-6 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex items-center justify-center 
                        bg-green-600 text-white rounded-xl text-lg font-bold">
                PS
            </div>
            <div>
                <h2 class="text-lg font-bold">POS System</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Management Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 mt-6 space-y-2 px-3">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
           {{ request()->routeIs('dashboard') 
              ? 'bg-green-600 text-white shadow-md' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
            📊 Dashboard
        </a>

        @if(auth()->check() && auth()->user()->usertype === 'admin')
            <!-- Admin-only links -->
            

            <a href="{{ route('categories.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
               {{ request()->routeIs('categories.*') 
                  ? 'bg-green-600 text-white shadow-md' 
                  : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                🗂️ Categories
            </a>

          

            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
               {{ request()->routeIs('products.*') 
                  ? 'bg-green-600 text-white shadow-md' 
                  : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                📦 Products
            </a>
        @endif

        <!-- Links available for both admin & cashier -->
        <a href="{{ route('pos.index') }}"
           class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
           {{ request()->routeIs('pos.*') 
              ? 'bg-green-600 text-white shadow-md' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
            💳 POS Terminal
        </a>

        <a href="{{ route('sales.index') }}"
           class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
           {{ request()->routeIs('sales.*') 
              ? 'bg-green-600 text-white shadow-md' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
            📈 Sales History
        </a>

         {{-- Sidebar.blade.php --}}
<div class="space-y-2">

    {{-- Purchases Dropdown --}}
    <button 
        onclick="document.getElementById('purchasesDropdown').classList.toggle('hidden')"
        class="flex items-center gap-3 w-full px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('purchases.*') || request()->routeIs('stock.history') 
                ? 'bg-green-600 text-white shadow-md' 
                : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
        🛒 Purchases
        <span class="ml-auto">▼</span>
    </button>

    <div id="purchasesDropdown" class="ml-6 mt-1 space-y-1 hidden">
        <a href="{{ route('purchases.index') }}"
           class="block px-4 py-2 text-sm rounded hover:bg-gray-200 dark:hover:bg-slate-700
           {{ request()->routeIs('purchases.index') ? 'bg-green-600 text-white' : 'text-gray-600 dark:text-slate-300' }}">
           Make Purchases
        </a>

       <!-- <a href="{{ route('purchases.create') }}"
           class="block px-4 py-2 text-sm rounded hover:bg-gray-200 dark:hover:bg-slate-700
           {{ request()->routeIs('purchases.create') ? 'bg-green-600 text-white' : 'text-gray-600 dark:text-slate-300' }}">
           Add Purchase
        </a>-->

        <a href="{{ route('stock.history') }}"
           class="block px-4 py-2 text-sm rounded hover:bg-gray-200 dark:hover:bg-slate-700
           {{ request()->routeIs('stock.history') ? 'bg-green-600 text-white' : 'text-gray-600 dark:text-slate-300' }}">
           Stock History
        </a>
    </div>


</div>

        <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
               {{ request()->routeIs('users.*') 
                  ? 'bg-green-600 text-white shadow-md' 
                  : 'text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                👥 User Management
            </a>
    </nav>

    <!-- Footer Actions -->
    <div class="border-t border-gray-200 dark:border-slate-700 p-4 flex flex-col gap-3">

        <!-- Theme Toggle -->
        <button id="theme-toggle"
            class="flex items-center justify-center gap-2 px-4 py-2 
            bg-gray-100 text-gray-700 hover:bg-gray-200
            dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700
            rounded-lg transition">
            🌙 <span id="theme-toggle-text">Dark Mode</span>
        </button>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold
                bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                🚪 Logout
            </button>
        </form>
    </div>

</aside>

<script>
    const toggleButton = document.getElementById('theme-toggle');
    const toggleText = document.getElementById('theme-toggle-text');
    const html = document.documentElement;

    // Check saved theme or system preference
    if (
        localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        html.classList.add('dark');
        toggleText.textContent = 'Light Mode';
    } else {
        toggleText.textContent = 'Dark Mode';
    }

    toggleButton.addEventListener('click', () => {
        html.classList.toggle('dark');

        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            toggleText.textContent = 'Light Mode';
        } else {
            localStorage.setItem('theme', 'light');
            toggleText.textContent = 'Dark Mode';
        }
    });
</script>


<script>
    const toggleButton = document.getElementById('theme-toggle');
    const toggleText = document.getElementById('theme-toggle-text');
    const html = document.documentElement;

    // Check saved theme or system preference
    if (
        localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        html.classList.add('dark');
        toggleText.textContent = 'Light Mode';
    } else {
        toggleText.textContent = 'Dark Mode';
    }

    toggleButton.addEventListener('click', () => {
        html.classList.toggle('dark');

        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            toggleText.textContent = 'Light Mode';
        } else {
            localStorage.setItem('theme', 'light');
            toggleText.textContent = 'Dark Mode';
        }
    });
</script>
