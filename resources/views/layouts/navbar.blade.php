<header class="font-jakarta bg-white border-b border-slate-200 sticky top-0 z-30 w-full">
    
    <div class="flex items-center justify-between py-3 px-6 lg:px-8">

        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" 
                class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 active:scale-95 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <h1 class="text-xl font-bold text-slate-800 tracking-tight">
                @yield('title', 'Dashboard') </h1>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">

            <button class="relative p-2 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition">
                <span class="absolute top-2 right-2.5 size-2 bg-rose-500 rounded-full border border-white"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </button>

            <div class="w-px h-8 bg-slate-100 hidden sm:block"></div>

            <div class="relative" id="userMenuContainer">
                <button onclick="toggleUserMenu()" class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-full hover:bg-slate-50 transition text-left group">
                    
                    <div class="hidden sm:block text-right leading-tight mr-1">
                        <p class="text-sm font-bold text-slate-700 group-hover:text-indigo-600 transition-colors">
                            {{ Auth::user()->first_name ?? 'User' }}
                        </p>
                        <p class="text-[11px] text-slate-400">
                            Staff IT
                        </p>
                    </div>

                    <div class="size-9 bg-linear-to-br from-indigo-500 to-violet-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-white">
                        {{ substr(Auth::user()->first_name ?? 'U', 0, 1) }}
                    </div>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 text-slate-400 group-hover:text-slate-600 transition-colors hidden sm:block">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div id="userDropdown" class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-1.5 z-50 transform origin-top-right transition-all">
                    
                    <div class="px-4 py-3 border-b border-slate-50 sm:hidden">
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->first_name ?? 'User' }}</p>
                        <p class="text-xs text-slate-500">Staff IT</p>
                    </div>

                    <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Profile
                    </a>
                    
                    <div class="border-t border-slate-100 my-1"></div>
                    
                    <button id="logoutBtn" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 flex items-center gap-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </button>
                </div>
            </div>

        </div>
    </div>
</header>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<script>
    function toggleUserMenu() {
        const menu = document.getElementById('userDropdown');
        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const container = document.getElementById('userMenuContainer');
        const menu = document.getElementById('userDropdown');
        if (!container.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    document.getElementById('logoutBtn').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('userDropdown').classList.add('hidden');

        Swal.fire({
            title: 'Logout?',
            text: "Are you sure you want to end your session?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5', // Indigo-600
            cancelButtonColor: '#E11D48', // Rose-600
            confirmButtonText: 'Yes, Logout',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>