@extends('layouts.dashboard')

@section('title', 'Account Management')

@section('content')
    {{-- Custom Scrollbar Style --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
    </style>

    <div class="w-full max-w-7xl mx-auto px-6 py-6 space-y-8 font-jakarta">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Account Management</h1>
                <p class="text-slate-500 text-sm mt-1">Manage user access, roles, and positions.</p>
            </div>
            <div class="text-sm text-slate-400 font-medium">
                {{ now()->format('l, d M Y') }}
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Users</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $totalUsers ?? 0 }}</h3>
                    <p class="text-xs text-slate-500 mt-1">Registered accounts</p>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Users</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-1">{{ $activeUsers ?? 0 }}</h3>
                    <p class="text-xs text-slate-500 mt-1">Currently active</p>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Admins</p>
                    <h3 class="text-3xl font-bold text-violet-600 mt-1">{{ $adminCount ?? 0 }}</h3>
                    <p class="text-xs text-slate-500 mt-1">System Administrators</p>
                </div>
                <div class="p-3 bg-violet-50 text-violet-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
            </div>
        </div>

        {{-- Main Table Content --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" id="searchInput" class="block w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm" placeholder="Search users...">
                </div>

                <button onclick="openCreateUserModal()" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                    Add New User
                </button>
            </div>

            <div class="overflow-x-auto">
                <table id="userTable" class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4">User Profile</th>
                            <th class="px-6 py-4">Job Title (Position)</th>
                            <th class="px-6 py-4">System Role</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Joined Date</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($users as $user)
                            <tr class="user-row group hover:bg-indigo-50/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-10 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-bold text-indigo-600 border-2 border-white shadow-sm uppercase">
                                            {{ substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700 user-name">{{ $user->first_name }} {{ $user->last_name }}</p>
                                            <p class="text-xs text-slate-500 user-email">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Position (Jabatan Asli) --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-slate-600">{{ $user->role ?? '-' }}</span>
                                </td>

                                {{-- Role (Hak Akses) --}}
                                <td class="px-6 py-4">
                                    @php
                                        $roleColor = match($user->access_level ?? 'Viewer') {
                                            'admin' => 'bg-violet-100 text-violet-700 border-violet-200',
                                            'staff' => 'bg-blue-50 text-blue-600 border-blue-200',
                                            'viewer' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            default => 'bg-slate-100 text-slate-600 border-slate-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $roleColor }} uppercase">
                                        {{ $user->access_level ?? 'staff' }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    @if(($user->status ?? 'Active') === 'Active')
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
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Edit Button --}}
                                        <button onclick="editUser(
                                            '{{ $user->id }}', 
                                            '{{ addslashes($user->first_name) }}', 
                                            '{{ addslashes($user->last_name) }}', 
                                            '{{ $user->email }}', 
                                            '{{ $user->role }}', 
                                            '{{ addslashes($user->position) }}', 
                                            '{{ $user->phone }}', 
                                            '{{ addslashes($user->address) }}'
                                        )" 
                                        class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all shadow-sm" title="Edit Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                        {{-- Delete Button --}}
                                        <button onclick="deleteUser('{{ $user->id }}', '{{ addslashes($user->first_name) }} {{ addslashes($user->last_name) }}')"
                                            class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-all shadow-sm" title="Delete User">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">No users found in database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL CREATE & EDIT --}}
    <div id="userModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="userModalBackdrop" onclick="toggleModal('userModal', false)"></div>
        
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div id="userModalPanel" class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 scale-95">
                    
                    <div class="bg-white px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add New User</h3>
                        <button onclick="toggleModal('userModal', false)" class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form id="userForm" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <div class="px-6 py-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                            {{-- Nama Depan & Belakang --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">First Name <span class="text-rose-500">*</span></label>
                                    <input type="text" id="inputFirstName" name="first_name" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="John" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Last Name <span class="text-rose-500">*</span></label>
                                    <input type="text" id="inputLastName" name="last_name" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="Doe" required>
                                </div>
                            </div>
                            
                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                                <input type="email" id="inputEmail" name="email" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="john@example.com" required>
                            </div>

                            {{-- Position & Role --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">Position (Jabatan) <span class="text-rose-500">*</span></label>
                                    {{-- FIX: ID diubah jadi inputPosition --}}
                                    <select id="inputRole" name="role" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm bg-white cursor-pointer" required>
                                        <option value="" disabled selected>Select Position</option>
                                        <option value="Supervisor IT">Supervisor IT</option>
                                        <option value="Foreman IT">Foreman IT</option>
                                        <option value="Service Desk IT">Service Desk IT</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1">System Role <span class="text-rose-500">*</span></label>
                                    <select id="inputAccessLevel" name="access_level" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm bg-white cursor-pointer" required>
                                        <option value="staff">Staff (User)</option>
                                        <option value="admin">Administrator</option>
                                        <option value="viewer">Viewer Only</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Phone</label>
                                <input type="text" id="inputPhone" name="phone" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="0812...">
                            </div>

                            {{-- Address --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Address</label>
                                <textarea id="inputAddress" name="address" rows="2" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm resize-none" placeholder="User address..."></textarea>
                            </div>

                            {{-- Password --}}
                            <div class="pt-2 border-t border-slate-100">
                                <label class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                                <input type="password" id="inputPassword" name="password" class="w-full px-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm" placeholder="••••••••">
                                <p id="passwordHelp" class="text-[10px] text-slate-400 mt-1 hidden">Leave blank if you don't want to change password.</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="button" onclick="toggleModal('userModal', false)" class="flex-1 px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-50 transition">Cancel</button>
                            <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden Delete Form --}}
    <form id="deleteUserForm" method="POST" class="hidden">@csrf @method('DELETE')</form>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Search Function
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('.user-row');
                rows.forEach(row => {
                    const name = row.querySelector('.user-name').innerText.toLowerCase();
                    const email = row.querySelector('.user-email').innerText.toLowerCase();
                    if (name.includes(filter) || email.includes(filter)) { row.style.display = ''; } else { row.style.display = 'none'; }
                });
            });

            // SweetAlert Notifications
            @if ($errors->any())
                Swal.fire({ icon: 'error', title: 'Error', html: '<ul class="text-left text-sm text-rose-500 list-disc ml-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>', confirmButtonColor: '#E11D48' });
            @elseif (session('success'))
                Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}", confirmButtonColor: '#4F46E5', timer: 3000 });
            @elseif (session('error'))
                Swal.fire({ icon: 'error', title: 'Oops', text: "{{ session('error') }}", confirmButtonColor: '#E11D48' });
            @endif
        });

        // --- MODAL FUNCTIONS ---
        function toggleModal(modalId, show = true) {
            const modal = document.getElementById(modalId);
            const backdrop = document.getElementById(modalId + 'Backdrop');
            const panel = document.getElementById(modalId + 'Panel'); // FIX: Menggunakan ID yang benar untuk panel

            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    // Pastikan panel ada sebelum dimanipulasi
                    if(panel) {
                        panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
                        panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                    }
                }, 10);
            } else {
                backdrop.classList.add('opacity-0');
                if(panel) {
                    panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
                    panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');
                }
                setTimeout(() => { modal.classList.add('hidden'); }, 300);
            }
        }

        function openCreateUserModal() {
            document.getElementById('modalTitle').innerText = "Add New User";
            document.getElementById('userForm').action = "{{ route('users.store') }}"; 
            document.getElementById('formMethod').value = "POST"; 
            
            // Reset Form Values
            document.getElementById('inputFirstName').value = "";
            document.getElementById('inputLastName').value = "";
            document.getElementById('inputEmail').value = "";
            document.getElementById('inputAccessLevel').value = "";
            document.getElementById('inputRole').value = "staff"; // Default Role
            document.getElementById('inputPhone').value = "";
            document.getElementById('inputAddress').value = "";
            
            // Handle Password Field
            const passInput = document.getElementById('inputPassword');
            passInput.value = ""; 
            passInput.required = true; 
            document.getElementById('passwordHelp').classList.add('hidden'); 

            toggleModal('userModal', true);
        }

        function editUser(id, firstName, lastName, email, role, accessLevel, phone, address) {
            document.getElementById('modalTitle').innerText = "Edit User Details";
            document.getElementById('userForm').action = `/users/${id}`; 
            document.getElementById('formMethod').value = "PUT"; 
            
            // Set Form Values
            document.getElementById('inputFirstName').value = firstName;
            document.getElementById('inputLastName').value = lastName;
            document.getElementById('inputEmail').value = email;
            
            // FIX: Set value dropdown berdasarkan parameter
            document.getElementById('inputRole').value = role; 
            document.getElementById('inputAccessLevel').value = (accessLevel === 'null' || accessLevel === '') ? '' : accessLevel;
            
            document.getElementById('inputPhone').value = (phone === 'null' || phone === '') ? '' : phone;
            document.getElementById('inputAddress').value = (address === 'null' || address === '') ? '' : address;
            
            // Password is optional for Edit
            const passInput = document.getElementById('inputPassword');
            passInput.value = ""; 
            passInput.required = false; 
            document.getElementById('passwordHelp').classList.remove('hidden');

            toggleModal('userModal', true);
        }

        function deleteUser(id, fullName) {
            Swal.fire({
                title: 'Delete User?',
                text: `Are you sure you want to delete "${fullName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E11D48',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteUserForm');
                    form.action = `/users/${id}`;
                    form.submit();
                }
            })
        }
    </script>
@endsection