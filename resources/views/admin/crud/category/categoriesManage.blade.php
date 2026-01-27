@php
    // Dummy Data untuk Kategori
    $categories = collect([
        ['name' => 'Electronics', 'slug' => 'electronics', 'status' => 'Active', 'item_count' => 150],
        ['name' => 'Office Furniture', 'slug' => 'office-furniture', 'status' => 'Active', 'item_count' => 45],
        ['name' => 'Stationery', 'slug' => 'stationery', 'status' => 'Active', 'item_count' => 300],
        ['name' => 'Computer Accessories', 'slug' => 'computer-accessories', 'status' => 'Active', 'item_count' => 85],
        ['name' => 'Network Equipment', 'slug' => 'network-equipment', 'status' => 'Inactive', 'item_count' => 0], // Empty
        ['name' => 'Pantry Supplies', 'slug' => 'pantry-supplies', 'status' => 'Active', 'item_count' => 20],
        ['name' => 'Cleaning Tools', 'slug' => 'cleaning-tools', 'status' => 'Inactive', 'item_count' => 0], // Empty
        ['name' => 'Software Licenses', 'slug' => 'software-licenses', 'status' => 'Active', 'item_count' => 50],
        ['name' => 'Safety Gear', 'slug' => 'safety-gear', 'status' => 'Active', 'item_count' => 12],
        ['name' => 'Archive Boxes', 'slug' => 'archive-boxes', 'status' => 'Active', 'item_count' => 0], // Active but empty
    ]);

    // Hitung Statistik
    $totalCategories = $categories->count();
    $activeCategories = $categories->where('status', 'Active')->count();
    $emptyCategories = $categories->where('item_count', 0)->count();
@endphp

@extends('layouts.dashboard')

@section('title', 'Category Management')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-6 py-2 space-y-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Category Management</h1>
                <p class="text-slate-500 text-sm mt-1">Organize and manage your item categories.</p>
            </div>
            
            <div class="text-sm text-slate-400 font-medium">
                {{ now()->format('l, d M Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div id="card-total" onclick="filterTable('all')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Categories</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold text-slate-800">{{ $totalCategories }}</h3>
                            <span class="text-sm font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">Types</span>
                        </div>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-indigo-600 mt-4 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Show All</p>
            </div>

            <div id="card-active" onclick="filterTable('active')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Active Status</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold text-slate-800">{{ $activeCategories }}</h3>
                            <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Active</span>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-600 mt-4 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click to filter</p>
            </div>

            <div id="card-empty" onclick="filterTable('empty')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Empty Categories</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold text-slate-800">{{ $emptyCategories }}</h3>
                            <span class="text-sm font-medium text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md">0 Items</span>
                        </div>
                    </div>
                    <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-rose-600 mt-4 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click to filter</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            <div class="flex items-center h-10">
                <span id="filter-badge" class="hidden px-3 py-1.5 rounded-full bg-slate-800 text-white text-xs font-bold items-center gap-2 shadow-sm animate-pulse transition-all">
                    <span id="filter-text">Filtered</span>
                    <button onclick="filterTable('reset')" class="hover:text-slate-300 focus:outline-none" title="Clear Filter">
                        <svg class="size-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                </span>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm placeholder-slate-400"
                        placeholder="Search category...">
                </div>

                <div class="flex gap-2">
                    <a href="#" 
                       class="px-5 py-2.5 bg-linear-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Category
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table id="dataTable" class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4 text-center w-16">No</th>
                            
                            <th onclick="sortTable(1)" class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none">
                                <div class="flex items-center gap-2">Category Name <svg id="icon-1" class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </th>

                            <th onclick="sortTable(2)" class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none">
                                <div class="flex items-center gap-2">Slug / Code <svg id="icon-2" class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </th>

                            <th onclick="sortTable(3)" class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Status <svg id="icon-3" class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </th>

                            <th onclick="sortTable(4)" class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Total Items <svg id="icon-4" class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </th>

                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($categories as $cat)
                            <tr class="item-row group hover:bg-indigo-50/30 transition-colors duration-200" 
                                data-status="{{ $cat['status'] }}"
                                data-count="{{ $cat['item_count'] }}">
                                
                                <td class="px-6 py-4 text-sm text-slate-400 text-center font-medium">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 text-sm font-medium text-slate-700 group-hover:text-indigo-700 transition-colors">
                                    {{ $cat['name'] }}
                                </td>

                                <td class="px-6 py-4 text-sm font-mono text-slate-500">
                                    {{ $cat['slug'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $isActive = $cat['status'] === 'Active';
                                        $statusClass = $isActive 
                                            ? 'bg-emerald-50 text-emerald-700 border-emerald-100 ring-emerald-500/20' 
                                            : 'bg-slate-100 text-slate-500 border-slate-200 ring-slate-500/20';
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border ring-1 ring-inset {{ $statusClass }}">
                                        <span class="mr-1.5 size-1.5 rounded-full bg-current"></span>
                                        {{ $cat['status'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($cat['item_count'] > 0)
                                        <span class="px-3 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                                            {{ $cat['item_count'] }} Items
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-md bg-rose-50 text-rose-700 text-xs font-bold border border-rose-100">
                                            Empty
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-100 rounded-lg transition-all shadow-sm" title="Edit Category">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                        <button class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 rounded-lg transition-all shadow-sm" title="Delete Category">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="noDataMessage" class="hidden flex flex-col items-center justify-center py-16 text-center">
                <div class="p-4 bg-slate-50 rounded-full mb-3 ring-8 ring-slate-50/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-slate-900 font-semibold text-lg">No categories found</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-xs mx-auto">Try adjusting your filters or search criteria.</p>
            </div>
        </div>
    </div>

    <script>
        // --- FILTER FUNCTIONALITY (Adapted for Categories) ---
        let currentFilter = 'all';

        function filterTable(type) {
            const rows = document.querySelectorAll('.item-row');
            const cardTotal = document.getElementById('card-total');
            const cardActive = document.getElementById('card-active');
            const cardEmpty = document.getElementById('card-empty');
            
            const badge = document.getElementById('filter-badge');
            const badgeText = document.getElementById('filter-text');

            if (currentFilter === type && type !== 'reset') {
                type = 'reset';
            }
            currentFilter = type;

            // 1. Reset Styles
            [cardTotal, cardActive, cardEmpty].forEach(c => {
                c.classList.remove('ring-2', 'ring-offset-2', 'ring-indigo-500', 'ring-emerald-500', 'ring-rose-500');
            });
            badge.classList.add('hidden');
            badge.classList.remove('flex');

            // 2. Apply Styles & Logic
            if (type === 'all') { // Optional visual feedback for "Total" card
                cardTotal.classList.add('ring-2', 'ring-indigo-500', 'ring-offset-2');
                // No badge needed for "All" usually, but can be added if desired
            } else if (type === 'active') {
                cardActive.classList.add('ring-2', 'ring-emerald-500', 'ring-offset-2');
                badgeText.innerText = "Active Categories";
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else if (type === 'empty') {
                cardEmpty.classList.add('ring-2', 'ring-rose-500', 'ring-offset-2');
                badgeText.innerText = "Empty Categories";
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            }

            // 3. Filter Rows Logic
            let visibleCount = 0;
            let rowNumber = 1;

            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                const count = parseInt(row.getAttribute('data-count'));
                let show = false;

                if (type === 'active') {
                    if (status === 'Active') show = true;
                } else if (type === 'empty') {
                    if (count === 0) show = true;
                } else {
                    show = true; // Show All (Reset or 'all')
                }

                if (show) {
                    row.style.display = '';
                    row.getElementsByTagName('td')[0].innerText = rowNumber++;
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const noDataMsg = document.getElementById('noDataMessage');
            if (visibleCount === 0) noDataMsg.classList.remove('hidden');
            else noDataMsg.classList.add('hidden');
        }

        // --- SEARCH FUNCTIONALITY ---
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.item-row');
                    let visibleCount = 0;
                    let rowNumber = 1;

                    rows.forEach(row => {
                        const name = row.cells[1].textContent.toLowerCase();
                        const slug = row.cells[2].textContent.toLowerCase();
                        
                        if (name.includes(filter) || slug.includes(filter)) {
                            row.style.display = '';
                            row.getElementsByTagName('td')[0].innerText = rowNumber++;
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    
                    const noDataMsg = document.getElementById('noDataMessage');
                    if (visibleCount === 0) noDataMsg.classList.remove('hidden');
                    else noDataMsg.classList.add('hidden');
                });
            }
        });

        // --- SORT FUNCTIONALITY ---
        function sortTable(columnIndex) {
            const table = document.getElementById("dataTable");
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            const header = document.querySelectorAll('thead th')[columnIndex];
            const currentDir = header.getAttribute('data-dir') || 'none';
            const newDir = (currentDir === 'none' || currentDir === 'desc') ? 'asc' : 'desc';

            header.setAttribute('data-dir', newDir);
            const isAscending = newDir === 'asc';

            rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[columnIndex].innerText.trim();
                const cellB = rowB.cells[columnIndex].innerText.trim();

                // Sort number for Column 4 (Total Items)
                if (columnIndex === 4) { 
                    const numA = parseFloat(cellA.replace(/[^0-9.-]+/g, ""));
                    const numB = parseFloat(cellB.replace(/[^0-9.-]+/g, ""));
                    return isAscending ? numA - numB : numB - numA;
                }

                return isAscending
                    ? cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: 'base' })
                    : cellB.localeCompare(cellA, undefined, { numeric: true, sensitivity: 'base' });
            });

            tbody.append(...rows);
            
            // Re-apply row numbering based on current visibility
            let rowNumber = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    row.getElementsByTagName('td')[0].innerText = rowNumber++;
                }
            });
            
            updateSortIcons(columnIndex, newDir);
        }

        function updateSortIcons(columnIndex, direction) {
            document.querySelectorAll('thead th svg').forEach(svg => {
                svg.classList.remove('text-indigo-600', 'rotate-180');
                svg.classList.add('text-slate-300');
            });

            document.querySelectorAll('thead th').forEach((th, idx) => {
                if (idx !== columnIndex) th.setAttribute('data-dir', 'none');
            });

            const activeIcon = document.getElementById(`icon-${columnIndex}`);
            if (activeIcon) {
                activeIcon.classList.remove('text-slate-300');
                activeIcon.classList.add('text-indigo-600');
                if (direction === 'asc') activeIcon.classList.add('rotate-180');
                else activeIcon.classList.remove('rotate-180');
            }
        }
    </script>
@endsection