@props(['title', 'value', 'icon' => null])

<div class="bg-white dark:bg-slate-800 
            p-5 rounded-xl shadow-md 
            transition-colors duration-300">

    <div class="flex items-center justify-between">

        <div>
           <p class="bg-black text-gray dark:bg-gray-800 dark:text-gray-200 text-sm p-1 rounded">
    {{ $title }}
</p>

            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ $value }}
            </p>
        </div>

        @if($icon)
            <div class="text-3xl">
                {{ $icon }}
            </div>
        @endif

    </div>
</div>
