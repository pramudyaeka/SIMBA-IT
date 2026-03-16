<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-white border-r border-slate-200 text-slate-600 flex flex-col transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 font-jakarta">

    {{-- HEADER SIDEBAR --}}
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="size-9 bg-indigo-600 rounded-lg flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h1 class="text-base font-bold text-slate-800 tracking-tight leading-none">SIMBA IT</h1>
                <p class="text-[10px] font-semibold text-indigo-500 uppercase tracking-wider mt-0.5">Inventory System</p>
            </div>
        </div>

        <button type="button" onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-md text-slate-400 hover:bg-slate-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- MENU LIST --}}
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

        {{-- SECTION: MAIN --}}
        <p class="px-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Main</p>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->is('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg class="size-5 {{ request()->is('dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
        </a>

        @php
            $isDataActive = request()->is('items*') || request()->is('categories*');
        @endphp

        <button type="button" onclick="toggleDropdown('data-menu', 'data-arrow')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ $isDataActive ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <div class="flex items-center gap-3">
                <svg class="size-5 {{ $isDataActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>Data Management</span>
            </div>
            <svg id="data-arrow" class="size-4 transition-transform duration-200 {{ $isDataActive ? 'rotate-180 text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="data-menu" class="overflow-hidden transition-all duration-300 {{ $isDataActive ? '' : 'hidden' }}">
            <div class="mt-1 space-y-0.5">
                <a href="{{ route('items.manage') }}" class="flex items-center gap-3 pl-12 pr-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('items*') ? 'text-indigo-600 bg-indigo-50/50' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }}">
                    <svg class="size-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Items
                </a>
                <a href="{{ route('categories.manage') }}" class="flex items-center gap-3 pl-12 pr-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->is('categories*') ? 'text-indigo-600 bg-indigo-50/50' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }}">
                    <svg class="size-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Categories
                </a>
            </div>
        </div>

        {{-- SECTION: ANALYTICS & HISTORY --}}
        <p class="px-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">Analytics</p>

        {{-- MENU REPORTS (KHUSUS ADMIN) --}}
        @if (auth()->check() && auth()->user()->access_level === 'admin')
            <a href="{{ route('reports.page') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->is('report*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="size-5 {{ request()->is('report*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Reports</span>
            </a>
        @endif

        {{-- MENU HISTORY (ADMIN & STAFF) --}}
        <a href="{{ route('history.page') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->is('history*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg class="size-5 {{ request()->is('history*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>History</span>
        </a>

        {{-- SECTION: SYSTEM (KHUSUS ADMIN) --}}
        @if (auth()->check() && auth()->user()->access_level === 'admin')
            <p class="px-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">System</p>

            <a href="{{ route('accountManagement.page') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group {{ request()->is('account*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 {{ request()->is('account*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <span>Account Management</span>
            </a>
        @endif

    </nav>
</aside>

<script>
    function toggleDropdown(menuId, arrowId) {
        const menu = document.getElementById(menuId);
        const arrow = document.getElementById(arrowId);

        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            arrow.classList.add('rotate-180', 'text-indigo-500');
            arrow.classList.remove('text-slate-400');
        } else {
            menu.classList.add('hidden');
            arrow.classList.remove('rotate-180', 'text-indigo-500');
            arrow.classList.add('text-slate-400');
        }
    }
</script>