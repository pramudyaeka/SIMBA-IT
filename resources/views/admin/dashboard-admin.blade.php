@php
    // 1. Data Tetap Sama
    $collection = collect([
        ['item_name' => 'Macbook Pro M2', 'category' => 'Electronics', 'status' => 'Available', 'stock' => 150],
        ['item_name' => 'Mechanical Keyboard', 'category' => 'Accessories', 'status' => 'Unavailable', 'stock' => 0],
        ['item_name' => 'Logitech MX Master', 'category' => 'Accessories', 'status' => 'Available', 'stock' => 200],
        ['item_name' => 'Samsung Monitor 24"', 'category' => 'Electronics', 'status' => 'Available', 'stock' => 75],
        ['item_name' => 'USB-C Hub', 'category' => 'Accessories', 'status' => 'Unavailable', 'stock' => 0],
        ['item_name' => 'Ergo Chair', 'category' => 'Furniture', 'status' => 'Available', 'stock' => 12],
        ['item_name' => 'Standing Desk', 'category' => 'Furniture', 'status' => 'Available', 'stock' => 5],
        ['item_name' => 'Webcam 4K', 'category' => 'Electronics', 'status' => 'Low Stock', 'stock' => 3],
        ['item_name' => 'Mousepad XL', 'category' => 'Accessories', 'status' => 'Available', 'stock' => 300],
        ['item_name' => 'Headset Gaming', 'category' => 'Electronics', 'status' => 'Available', 'stock' => 60],
    ]);

    // 2. Statistik (Global)
    $totalCategories = $collection->unique('category')->count();
    $totalItems = $collection->sum('stock');
    $lowStockCount = $collection->where('stock', '<', 10)->where('stock', '>', 0)->count();
    $outOfStockCount = $collection->where('stock', 0)->count();
    $inStockCount = $collection->where('stock', '>', 0)->count();
@endphp

@extends('layouts.dashboard')
@section('title', 'Dashboard Overview')

@section('content')
    <section class="w-full max-w-7xl mx-auto p-6 py-2 space-y-8 font-jakarta">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Inventory Overview</h1>
                <p class="text-slate-500 text-sm">Monitor stock levels and warehouse performance.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <div
                class="group relative overflow-hidden rounded-3xl bg-linear-to-br from-indigo-600 to-violet-600 p-6 text-white shadow-lg shadow-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 cursor-pointer md:col-span-2 xl:col-span-1">
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div class="mb-3 inline-flex rounded-xl bg-white/20 p-2 backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold">Scan QR Code</h3>
                        <p class="text-sm text-indigo-100 mt-1">Check item details instantly</p>
                    </div>
                </div>
            </div>

            <div id="card-all" onclick="filterTable('all')"
                class="cursor-pointer rounded-3xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-all ring-2 ring-indigo-500 ring-offset-2">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Categories</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalCategories }}</h3>
                    </div>
                    <div class="rounded-full bg-purple-50 p-3 text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-medium text-slate-400">
                    <span class="text-purple-600 bg-purple-50 px-2 py-0.5 rounded mr-2">Show All</span>
                </div>
            </div>

            <div id="card-restock" onclick="filterTable('restock')"
                class="cursor-pointer rounded-3xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-all border-transparent">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Needs Restock</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $lowStockCount + $outOfStockCount }}</h3>
                    </div>
                    <div class="rounded-full bg-orange-50 p-3 text-orange-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-orange-500 h-1.5 rounded-full"
                        style="width: {{ ($totalItems > 0) ? (($lowStockCount + $outOfStockCount) / count($collection)) * 100 : 0 }}%">
                    </div>
                </div>
                <p class="mt-2 text-xs text-slate-400">Click to filter</p>
            </div>

            <div
                class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Units</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalItems }}</h3>
                    </div>
                    <div class="rounded-full bg-emerald-50 p-3 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                    <span>Available: <b class="text-slate-700">{{ $inStockCount }}</b> items</span>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-bold text-slate-800">Item List</h2>
                    <span id="filter-badge"
                        class="hidden px-2 py-1 rounded-md bg-orange-100 text-orange-700 text-xs font-bold border border-orange-200 items-center gap-1">
                        Filtering: Needs Restock
                        <button onclick="filterTable('all')" class="ml-1 hover:text-orange-900"><svg class="size-3"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg></button>
                    </span>
                </div>
                <div class="relative">
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search items..."
                        class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 w-48 md:w-64 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="size-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="inventoryTable">
                    <thead>
                        <tr
                            class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4 text-center w-16">#</th>
                            <th class="px-6 py-4">Item Name</th>
                            <th class="px-6 py-4 text-center">Category</th>
                            <th class="px-6 py-4 text-center">Stock</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($collection as $item)
                            <tr class="item-row group hover:bg-indigo-50/30 transition-colors duration-200"
                                data-stock="{{ $item['stock'] }}">
                                <td class="px-6 py-4 text-center text-slate-400 font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700 group-hover:text-indigo-600 transition-colors">
                                    {{ $item['item_name'] }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-center">
                                    <span
                                        class="inline-flex w-24 justify-center items-center gap-1.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200 whitespace-nowrap">
                                        {{ $item['category'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-slate-700">
                                    {{ $item['stock'] }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClass = match (true) {
                                            $item['stock'] == 0 => 'bg-rose-50 text-rose-600 border-rose-100 ring-rose-500/10',
                                            $item['stock'] < 10 => 'bg-orange-50 text-orange-600 border-orange-100 ring-orange-500/10',
                                            default => 'bg-emerald-50 text-emerald-600 border-emerald-100 ring-emerald-500/10',
                                        };
                                        $statusLabel = $item['stock'] == 0 ? 'Out of Stock' : ($item['stock'] < 10 ? 'Low Stock' : 'In Stock');
                                    @endphp
                                    <span
                                        class="inline-flex w-28 justify-center items-center py-1 rounded-full text-xs font-semibold border ring-1 ring-inset {{ $statusClass }} whitespace-nowrap">
                                        <span class="mr-1.5 size-1.5 rounded-full bg-current"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50">
                <span class="text-xs text-slate-500" id="showing-text">Showing all items</span>
            </div>
        </div>

    </section>

    <script>
        function filterTable(type) {
            const rows = document.querySelectorAll('.item-row');
            const cardAll = document.getElementById('card-all');
            const cardRestock = document.getElementById('card-restock');
            const badge = document.getElementById('filter-badge');
            const showingText = document.getElementById('showing-text');

            // 1. Reset Styles Kartu (Visual)
            if (type === 'restock') {
                cardRestock.classList.add('ring-2', 'ring-orange-500', 'ring-offset-2', 'border-transparent');
                cardAll.classList.remove('ring-2', 'ring-indigo-500', 'ring-offset-2');
                cardAll.classList.add('border-slate-100');
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                cardAll.classList.add('ring-2', 'ring-indigo-500', 'ring-offset-2');
                cardRestock.classList.remove('ring-2', 'ring-orange-500', 'ring-offset-2', 'border-transparent');
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }

            // 2. Logika Filter & Penomoran Ulang
            let visibleCount = 0;
            let rowNumber = 1; // Counter untuk nomor urut baru

            rows.forEach(row => {
                const stock = parseInt(row.getAttribute('data-stock'));
                let shouldShow = false;

                // Tentukan apakah baris harus tampil
                if (type === 'restock') {
                    if (stock < 10) shouldShow = true;
                } else {
                    shouldShow = true;
                }

                // Terapkan display dan Update Nomor
                if (shouldShow) {
                    row.style.display = '';

                    // --- BAGIAN INI YANG MEMPERBAIKI NOMOR URUT ---
                    // Mengambil sel pertama (kolom No) dan mengganti teksnya
                    const numberCell = row.getElementsByTagName('td')[0];
                    numberCell.innerText = rowNumber++;
                    // ---------------------------------------------

                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update text footer
            showingText.innerText = `Showing ${visibleCount} items`;
        }

        // Fungsi Search juga perlu update nomor agar konsisten
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.item-row');

            let rowNumber = 1;

            rows.forEach(row => {
                const text = row.getElementsByTagName('td')[1].textContent || row.getElementsByTagName('td')[1].innerText;

                if (text.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = "";

                    // Update nomor saat search juga
                    const numberCell = row.getElementsByTagName('td')[0];
                    numberCell.innerText = rowNumber++;
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
@endsection