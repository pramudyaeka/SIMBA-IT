@php
    // Dummy Data User
    $users = collect([
        [
            'id' => 1,
            'name' => 'Pranata Eka',
            'email' => 'pranata@simbait.com',
            'role' => 'Supervisor', // Role Tertinggi
            'status' => 'Active',
            'avatar' => 'PE',
            'joined_at' => '2023-01-15'
        ],
        [
            'id' => 2,
            'name' => 'Siti Aminah',
            'email' => 'siti.am@simbait.com',
            'role' => 'Admin Gudang',
            'status' => 'Active',
            'avatar' => 'SA',
            'joined_at' => '2023-03-22'
        ],
        [
            'id' => 3,
            'name' => 'Budi Santoso',
            'email' => 'budi.san@simbait.com',
            'role' => 'Staff',
            'status' => 'Active',
            'avatar' => 'BS',
            'joined_at' => '2023-06-10'
        ],
        [
            'id' => 4,
            'name' => 'Joko Anwar',
            'email' => 'joko.anwar@simbait.com',
            'role' => 'Staff',
            'status' => 'Inactive', // User non-aktif
            'avatar' => 'JA',
            'joined_at' => '2023-07-05'
        ],
        [
            'id' => 5,
            'name' => 'Rina Wati',
            'email' => 'rina.wati@simbait.com',
            'role' => 'Viewer', // Role hanya lihat
            'status' => 'Active',
            'avatar' => 'RW',
            'joined_at' => '2023-08-12'
        ],
    ]);

    $totalUsers = $users->count();
    $activeUsers = $users->where('status', 'Active')->count();
    $adminCount = $users->whereIn('role', ['Supervisor', 'Admin Gudang'])->count();
@endphp

@extends('layouts.dashboard')

@section('title', 'Account Management')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-6 py-6 space-y-8 font-sans">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Account Management</h1>
                <p class="text-slate-500 text-sm mt-1">Manage user access and roles.</p>
            </div>
            
            <div class="text-sm text-slate-400 font-medium">
                {{ now()->format('l, d M Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Users</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalUsers }}</h3>
                    <p class="text-xs text-slate-500 mt-1">Registered accounts</p>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Users</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $activeUsers }}</h3>
                    <p class="text-xs text-slate-500 mt-1">Currently active</p>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Admins & Supervisors</p>
                    <h3 class="text-3xl font-bold text-violet-600 mt-1">{{ $adminCount }}</h3>
                    <p class="text-xs text-slate-500 mt-1">High privilege access</p>
                </div>
                <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" 
                        class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm"
                        placeholder="Search users...">
                </div>

                <button onclick="openUserModal()" 
                   class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New User
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4">User Profile</th>
                            <th class="px-6 py-4">Role / Access</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Joined Date</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($users as $user)
                            <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-10 rounded-full bg-slate-200 flex items-center justify-center text-sm font-bold text-slate-600 border-2 border-white shadow-sm">
                                            {{ $user['avatar'] }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">{{ $user['name'] }}</p>
                                            <p class="text-xs text-slate-500">{{ $user['email'] }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $roleColor = match($user['role']) {
                                            'Supervisor' => 'bg-violet-100 text-violet-700 border-violet-200',
                                            'Admin Gudang' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                            'Staff' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            default => 'bg-slate-100 text-slate-600 border-slate-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $roleColor }}">
                                        {{ $user['role'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($user['status'] === 'Active')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium text-emerald-600 bg-emerald-50 border border-emerald-100">
                                            <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium text-slate-500 bg-slate-100 border border-slate-200">
                                            <span class="size-1.5 rounded-full bg-slate-400"></span> Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($user['joined_at'])->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="editUser('{{ $user['name'] }}', '{{ $user['email'] }}', '{{ $user['role'] }}')" 
                                            class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-100 rounded-lg transition-all shadow-sm" title="Edit Role">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                        <button onclick="deleteUser('{{ $user['name'] }}')"
                                            class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 rounded-lg transition-all shadow-sm" title="Delete User">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="userModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeUserModal()"></div>
        
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-xl w-full max-w-md p-6 transform transition-all scale-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-slate-800" id="modalTitle">Add New User</h3>
                    <button onclick="closeUserModal()" class="text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form id="userForm" onsubmit="saveUser(event)">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
                            <input type="text" id="inputName" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" placeholder="e.g. John Doe" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                            <input type="email" id="inputEmail" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" placeholder="e.g. john@simbait.com" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Assign Role</label>
                            <select id="inputRole" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-white">
                                <option value="Staff">Staff</option>
                                <option value="Admin Gudang">Admin Gudang</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Viewer">Viewer (Read Only)</option>
                            </select>
                        </div>
                        
                        </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" onclick="closeUserModal()" class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-600 font-semibold rounded-xl hover:bg-slate-50 transition">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('userModal');
        const modalTitle = document.getElementById('modalTitle');
        const inputName = document.getElementById('inputName');
        const inputEmail = document.getElementById('inputEmail');
        const inputRole = document.getElementById('inputRole');

        function openUserModal() {
            // Reset form for "Add New"
            modalTitle.innerText = "Add New User";
            inputName.value = "";
            inputEmail.value = "";
            inputRole.value = "Staff";
            modal.classList.remove('hidden');
        }

        function editUser(name, email, role) {
            // Pre-fill form for "Edit"
            modalTitle.innerText = "Edit User Role";
            inputName.value = name;
            inputEmail.value = email;
            inputRole.value = role;
            modal.classList.remove('hidden');
        }

        function closeUserModal() {
            modal.classList.add('hidden');
        }

        function saveUser(e) {
            e.preventDefault();
            closeUserModal();
            // Mockup Success Message
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'User data has been updated successfully.',
                confirmButtonColor: '#4F46E5',
                timer: 2000
            });
        }

        function deleteUser(name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to remove "${name}" access.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E11D48', // Rose 600
                cancelButtonColor: '#64748B', // Slate 500
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Deleted!',
                        'User access has been revoked.',
                        'success'
                    )
                }
            })
        }
    </script>
@endsection