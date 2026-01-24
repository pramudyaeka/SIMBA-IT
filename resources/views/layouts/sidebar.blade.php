<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64
           bg-linear-to-b from-gray-900 to-gray-800 text-white flex flex-col transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">

    <!-- Header -->
    <div class="p-5 flex items-center justify-between border-b border-gray-700">
        <div>
            <h1 class="text-xl font-bold tracking-wide">SIMBA IT</h1>
            <p class="text-xs text-gray-400">Dashboard</p>
        </div>

        <!-- Close (mobile) -->
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white">
            ✕
        </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-4 space-y-1">

        <!-- Active item -->
        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg
                  bg-indigo-600 text-white">
            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l9-9 9 9v9a3 3 0 0 1-3 3h-4v-6H10v6H6a3 3 0 0 1-3-3z" />
            </svg>
            <span>Home</span>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg
                  text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20 7l-8-4-8 4v10l8 4 8-4V7z" />
            </svg>
            <span>Items</span>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg
                  text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 7h18M3 12h18M3 17h18" />
            </svg>
            <span>Categories</span>
        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg
                  text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.325 4.317a1 1 0 0 1 1.35-.936l1.225.49a1 1 0 0 0 .75 0l1.225-.49a1 1 0 0 1 1.35.936v1.14a1 1 0 0 0 .293.707l.866.866a1 1 0 0 1 0 1.414l-.866.866a1 1 0 0 0-.293.707v1.14a1 1 0 0 1-1.35.936l-1.225-.49a1 1 0 0 0-.75 0l-1.225.49a1 1 0 0 1-1.35-.936v-1.14a1 1 0 0 0-.293-.707l-.866-.866a1 1 0 0 1 0-1.414l.866-.866a1 1 0 0 0 .293-.707z" />
            </svg>
            <span>Settings</span>
        </a>
    </nav>

    <!-- User -->
    <div class="p-4 border-t border-gray-700 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold">
            P
        </div>
        <div>
            <p class="text-sm font-semibold">Pranata Eka Pramudya</p>
            <p class="text-xs text-gray-400">Supervisor</p>
        </div>
    </div>
</aside>
