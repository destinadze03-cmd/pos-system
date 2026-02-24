<aside class="w-64 min-h-screen 
    bg-white text-gray-800 
    dark:bg-slate-900 dark:text-slate-100 
    flex flex-col shadow-lg transition-colors duration-300">

    <!-- Logo / Brand -->
    <div class="px-6 py-5 text-2xl font-bold tracking-wide 
        border-b border-gray-200 
        dark:border-slate-700">
        🧾 POS System
    </div>

    <!-- Navigation -->
    <nav class="flex-1 mt-6 space-y-1">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-6 py-3 text-sm font-medium rounded-l-full transition
           {{ request()->routeIs('dashboard') 
              ? 'bg-gray-200 dark:bg-slate-800 text-black dark:text-white' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-800 hover:text-black dark:hover:text-white' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('products.index') }}"
           class="flex items-center gap-3 px-6 py-3 text-sm font-medium rounded-l-full transition
           {{ request()->routeIs('products.*') 
              ? 'bg-gray-200 dark:bg-slate-800 text-black dark:text-white' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-800 hover:text-black dark:hover:text-white' }}">
            📦 Products
        </a>

        <a href="{{ route('pos.index') }}"
           class="flex items-center gap-3 px-6 py-3 text-sm font-medium rounded-l-full transition
           {{ request()->routeIs('pos.*') 
              ? 'bg-gray-200 dark:bg-slate-800 text-black dark:text-white' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-800 hover:text-black dark:hover:text-white' }}">
            🛒 POS
        </a>

        <a href="{{ route('sales.index') }}"
           class="flex items-center gap-3 px-6 py-3 text-sm font-medium rounded-l-full transition
           {{ request()->routeIs('sales.*') 
              ? 'bg-gray-200 dark:bg-slate-800 text-black dark:text-white' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-800 hover:text-black dark:hover:text-white' }}">
            🧮 Sales
        </a>

        <a href="{{ route('Report.print') }}"
           class="flex items-center gap-3 px-6 py-3 text-sm font-medium rounded-l-full transition
           {{ request()->routeIs('Report.*') 
              ? 'bg-gray-200 dark:bg-slate-800 text-black dark:text-white' 
              : 'text-gray-600 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-800 hover:text-black dark:hover:text-white' }}">
            🧾 Report
        </a>

    </nav>

    <!-- Theme toggle & Logout -->
    <div class="border-t border-gray-200 dark:border-slate-700 p-4 flex flex-col gap-2">

        <!-- Theme Toggle Button -->
        <button id="theme-toggle"
            class="flex items-center justify-center gap-2 px-4 py-2 
            bg-gray-200 text-gray-800 hover:bg-gray-300
            dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600
            rounded-lg transition">
            🌙 <span id="theme-toggle-text">Dark Mode</span>
        </button>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold
                bg-green-600 hover:bg-red-700 text-white rounded-lg transition">
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

