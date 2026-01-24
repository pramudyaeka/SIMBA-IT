<header class="font-jakarta bg-white border-b border-gray-200 relative z-30">
    {{-- Wrapper navbar --}}
    <div class="flex items-center justify-between py-4 px-8">

        <div class="flex items-center gap-4">
            <button onclick=""
                class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 active:scale-95 transition">
                ☰
            </button>

            <p class="text-xl font-semibold text-gray-800">
                Halo, {{ Auth::user()->first_name ?? 'User' }}!
            </p>
        </div>

        <div class="flex items-center gap-3">

            <button class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </button>

            <button class="p-2 rounded-lg hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                </svg>
            </button>

            <div class="w-px h-6 bg-gray-200 mx-2"></div>

            <div class="relative" id="userMenuContainer">
                <button onclick="toggleUserMenu()"
                    class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 px-3 py-2 rounded-lg transition text-left">
                    
                    <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>

                    <div class="flex flex-col leading-tight">
                        <p class="text-sm font-semibold text-gray-800">
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Staff IT </p>
                    </div>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-400 ml-1">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                    <div class="border-t border-gray-100 my-1"></div>
                    
                    <button id="logoutBtn" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
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
    // 1. Toggle Dropdown Menu
    function toggleUserMenu() {
        const menu = document.getElementById('userDropdown');
        menu.classList.toggle('hidden');
    }

    // Close dropdown jika klik di luar area
    document.addEventListener('click', function(event) {
        const container = document.getElementById('userMenuContainer');
        const menu = document.getElementById('userDropdown');
        if (!container.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    // 2. SweetAlert Logout Confirmation
    document.getElementById('logoutBtn').addEventListener('click', function(e) {
        e.preventDefault();
        
        // Tutup dropdown dulu biar rapi
        document.getElementById('userDropdown').classList.add('hidden');

        Swal.fire({
            title: 'Logout?',
            text: "Apakah Anda yakin ingin keluar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5', // Indigo-600
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>