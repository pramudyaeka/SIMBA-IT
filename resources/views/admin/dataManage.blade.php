@php
    $collection = [
        ['item_name' => 'Contoh Item 1', 'category' => 'Kategori A', 'status' => 'Available', 'stock' => 150],
        ['item_name' => 'Contoh Item 2', 'category' => 'Kategori B', 'status' => 'Unavailable', 'stock' => 0],
        ['item_name' => 'Contoh Item 3', 'category' => 'Kategori A', 'status' => 'Available', 'stock' => 200],
        ['item_name' => 'Contoh Item 4', 'category' => 'Kategori C', 'status' => 'Available', 'stock' => 75],
        ['item_name' => 'Contoh Item 5', 'category' => 'Kategori B', 'status' => 'Unavailable', 'stock' => 0],
        ['item_name' => 'Contoh Item 6', 'category' => 'Kategori A', 'status' => 'Available', 'stock' => 120],
        ['item_name' => 'Contoh Item 7', 'category' => 'Kategori C', 'status' => 'Available', 'stock' => 90],
        ['item_name' => 'Contoh Item 8', 'category' => 'Kategori B', 'status' => 'Unavailable', 'stock' => 0],
        ['item_name' => 'Contoh Item 9', 'category' => 'Kategori A', 'status' => 'Available', 'stock' => 300],
        ['item_name' => 'Contoh Item 10', 'category' => 'Kategori C', 'status' => 'Available', 'stock' => 60],
    ];
@endphp

@extends('layouts.dashboard')

@section('title', 'Data Management')

@section('content')
    <div class="w-full px-6 py-6 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                <p class="text-sm font-medium text-emerald-600">In Stock</p>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-800">40</span>
                        <span class="text-sm text-slate-500">Items</span>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                <p class="text-sm font-medium text-amber-500">Need Restock</p>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-800">7</span>
                        <span class="text-sm text-slate-500">Items</span>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                <p class="text-sm font-medium text-rose-500">Out of Stock</p>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-slate-800">2</span>
                        <span class="text-sm text-slate-500">Items</span>
                    </div>
                    <div class="p-3 bg-rose-50 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-rose-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Data Management</h1>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex gap-3">
                    <a href="{{ route('crud.addItem') }}"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Add Item
                    </a>
                    <button
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Add Stock
                    </button>
                </div>

                <div class="relative w-full md:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm placeholder-slate-400"
                        placeholder="Search item or category...">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table id="dataTable" class="min-w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No
                            </th>

                            <th onclick="sortTable(1)"
                                class="group px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-left cursor-pointer select-none hover:bg-slate-100 transition">
                                <div class="flex items-center gap-2">
                                    Item Name
                                    <svg id="icon-1" class="w-4 h-4 text-slate-300 transition-transform duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>

                            <th onclick="sortTable(2)"
                                class="group px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-left cursor-pointer select-none hover:bg-slate-100 transition">
                                <div class="flex items-center gap-2">
                                    Category
                                    <svg id="icon-2" class="w-4 h-4 text-slate-300 transition-transform duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>

                            <th onclick="sortTable(3)"
                                class="group px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center cursor-pointer select-none hover:bg-slate-100 transition">
                                <div class="flex items-center justify-center gap-2">
                                    Status
                                    <svg id="icon-3" class="w-4 h-4 text-slate-300 transition-transform duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>

                            <th onclick="sortTable(4)"
                                class="group px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center cursor-pointer select-none hover:bg-slate-100 transition">
                                <div class="flex items-center justify-center gap-2">
                                    Stock
                                    <svg id="icon-4" class="w-4 h-4 text-slate-300 transition-transform duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>

                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                                Action</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach ($collection as $item)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4 text-sm text-slate-600 text-center font-medium">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 text-sm text-slate-700 font-semibold">{{ $item['item_name'] }}</td>

                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item['category'] }}</td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $isAvailable = $item['status'] === 'Available';
                                        $badgeClass = $isAvailable
                                            ? 'bg-emerald-100 text-emerald-700 border-emerald-200'
                                            : 'bg-rose-100 text-rose-700 border-rose-200';
                                    @endphp
                                    <span
                                        class="inline-block w-24 py-1 rounded-full text-xs font-semibold border text-center {{ $badgeClass }}">
                                        {{ $item['status'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 text-center font-semibold">{{ $item['stock'] }}
                                    <span class="text-slate-400 font-normal text-xs">pcs</span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            class="p-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg transition"
                                            title="View QR">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="size-6">
                                                <path fill-rule="evenodd"
                                                    d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 9.375v-4.5ZM4.875 4.5a.375.375 0 0 0-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 0 0 .375-.375v-4.5a.375.375 0 0 0-.375-.375h-4.5Zm7.875.375c0-1.036.84-1.875 1.875-1.875h4.5C20.16 3 21 3.84 21 4.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5a1.875 1.875 0 0 1-1.875-1.875v-4.5Zm1.875-.375a.375.375 0 0 0-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 0 0 .375-.375v-4.5a.375.375 0 0 0-.375-.375h-4.5ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75A.75.75 0 0 1 6 7.5v-.75Zm9.75 0A.75.75 0 0 1 16.5 6h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75ZM3 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.035-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 19.125v-4.5Zm1.875-.375a.375.375 0 0 0-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 0 0 .375-.375v-4.5a.375.375 0 0 0-.375-.375h-4.5Zm7.875-.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm6 0a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75ZM6 16.5a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm9.75 0a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm-3 3a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm6 0a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                        <button class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg transition"
                                            title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="noDataMessage" class="hidden flex flex-col items-center justify-center py-12 text-center">
                <div class="p-4 bg-slate-50 rounded-full mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-slate-900 font-medium">No items found</h3>
                <p class="text-slate-500 text-sm mt-1">Try adjusting your search criteria</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- 1. SEARCH FUNCTIONALITY ---
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#dataTable tbody tr');
                    let hasVisibleRow = false;

                    rows.forEach(row => {
                        // Search in "Item Name" (col 1) and "Category" (col 2)
                        const itemName = row.cells[1].textContent.toLowerCase();
                        const category = row.cells[2].textContent.toLowerCase();

                        if (itemName.includes(filter) || category.includes(filter)) {
                            row.style.display = '';
                            hasVisibleRow = true;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Toggle empty state message
                    const noDataMsg = document.getElementById('noDataMessage');
                    if (noDataMsg) noDataMsg.classList.toggle('hidden', hasVisibleRow);

                    updateRowNumbers();
                });
            }
        });

        // --- 2. UPDATE ROW NUMBERS ---
        function updateRowNumbers() {
            const rows = document.querySelectorAll('#dataTable tbody tr');
            let counter = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    row.cells[0].textContent = counter++;
                }
            });
        }

        // --- 3. SORT FUNCTIONALITY ---
        function sortTable(columnIndex) {
            const table = document.getElementById("dataTable");
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            // Determine Sort Direction
            // Note: Default on first click is 'asc' due to the toggle logic below
            const header = document.querySelectorAll('thead th')[columnIndex];
            const currentDir = header.getAttribute('data-dir') || 'none';
            const newDir = (currentDir === 'none' || currentDir === 'desc') ? 'asc' : 'desc';

            // Update attribute
            header.setAttribute('data-dir', newDir);
            const isAscending = newDir === 'asc';

            // Perform Sort
            rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[columnIndex].innerText.trim();
                const cellB = rowB.cells[columnIndex].innerText.trim();

                // Special Handling for "Stock" column (index 4)
                if (columnIndex === 4) {
                    const numA = parseFloat(cellA.replace(/[^0-9.-]+/g, ""));
                    const numB = parseFloat(cellB.replace(/[^0-9.-]+/g, ""));
                    return isAscending ? numA - numB : numB - numA;
                }

                // Natural Sort for Text
                return isAscending
                    ? cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: 'base' })
                    : cellB.localeCompare(cellA, undefined, { numeric: true, sensitivity: 'base' });
            });

            // Re-render rows
            tbody.append(...rows);

            // Post-sort cleanups
            updateRowNumbers();
            updateSortIcons(columnIndex, newDir);
        }

        // --- 4. VISUAL ICONS UPDATE ---
        function updateSortIcons(columnIndex, direction) {
            // Reset all icons to default state
            document.querySelectorAll('thead th svg').forEach(svg => {
                svg.classList.remove('text-indigo-600', 'rotate-180');
                svg.classList.add('text-slate-300');
            });

            // Reset all data-dir attributes except current
            document.querySelectorAll('thead th').forEach((th, idx) => {
                if (idx !== columnIndex) th.setAttribute('data-dir', 'none');
            });

            // Activate current icon
            const activeIcon = document.getElementById(`icon-${columnIndex}`);
            if (activeIcon) {
                activeIcon.classList.remove('text-slate-300');
                activeIcon.classList.add('text-indigo-600');

                // Rotate if Ascending (pointing up)
                if (direction === 'asc') {
                    activeIcon.classList.add('rotate-180');
                } else {
                    activeIcon.classList.remove('rotate-180');
                }
            }
        }
    </script>
@endsection