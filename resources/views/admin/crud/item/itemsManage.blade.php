@extends('layouts.dashboard')

@section('title', 'Item Management')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-6 py-2 space-y-8 font-sans">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Item Management</h1>
                <p class="text-slate-500 text-sm mt-1">Manage your inventory items efficiently.</p>
            </div>
            <div class="text-sm text-slate-400 font-medium">
                {{ now()->format('l, d M Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div id="card-in" onclick="filterTable('in')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500">In Stock</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold text-slate-800">{{ $inStockCount }}</h3>
                            <span
                                class="text-sm font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Items</span>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-600 mt-4 font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                    Click to filter</p>
            </div>

            <div id="card-restock" onclick="filterTable('restock')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Need Restock</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold text-slate-800">{{ $lowStockCount }}</h3>
                            <span class="text-sm font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">Items</span>
                        </div>
                    </div>
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-amber-600 mt-4 font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                    Click to filter</p>
            </div>

            <div id="card-out" onclick="filterTable('out')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Out of Stock</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold text-slate-800">{{ $outOfStockCount }}</h3>
                            <span class="text-sm font-medium text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md">Items</span>
                        </div>
                    </div>
                    <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-rose-600 mt-4 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Click
                    to filter</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

            <div class="flex items-center gap-3 h-10">
                <span id="filter-badge"
                    class="hidden px-3 py-1.5 rounded-full bg-slate-800 text-white text-xs font-bold items-center gap-2 shadow-sm animate-pulse transition-all">
                    <span id="filter-text">Filtered</span>
                    <button onclick="filterTable('reset')" class="hover:text-slate-300 focus:outline-none">
                        <svg class="size-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </span>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm placeholder-slate-400"
                        placeholder="Search item...">
                </div>

                <div class="flex gap-2">
                    <button
                        class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-indigo-600 text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="hidden sm:inline">Add Stock</span>
                    </button>

                    <button onclick="openModal('addItemModal')"
                        class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Add Item
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table id="dataTable" class="min-w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th onclick="sortTable(1)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none">
                                <div class="flex items-center gap-2">Item Name <svg id="icon-1"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg></div>
                            </th>
                            <th onclick="sortTable(2)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Category <svg id="icon-2"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg></div>
                            </th>
                            <th onclick="sortTable(3)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Status <svg id="icon-3"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg></div>
                            </th>
                            <th onclick="sortTable(4)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Stock <svg id="icon-4"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg></div>
                            </th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($items as $item)
                            <tr class="item-row group hover:bg-indigo-50/30 transition-colors duration-200"
                                data-stock="{{ $item->stock }}">

                                <td class="px-6 py-4 text-sm text-slate-400 text-center font-medium">{{ $loop->iteration }}</td>

                                <td
                                    class="px-6 py-4 text-sm font-medium text-slate-700 group-hover:text-indigo-700 transition-colors">
                                    {{ $item->item_name }}
                                    @if($item->part_number)
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $item->part_number }}</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $item->category->category_name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                        $badgeClass = '';
                                        $statusText = 'Available';
                                        if ($item->stock == 0) {
                                            $badgeClass = 'bg-rose-50 text-rose-700 border-rose-100 ring-rose-500/20';
                                            $statusText = 'Out of Stock';
                                        } elseif ($item->stock < 10) {
                                            $badgeClass = 'bg-amber-50 text-amber-700 border-amber-100 ring-amber-500/20';
                                            $statusText = 'Low Stock';
                                        } else {
                                            $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-100 ring-emerald-500/20';
                                            $statusText = 'In Stock';
                                        }
                                    @endphp
                                    <span
                                        class="inline-flex items-center w-28 justify-center py-1 rounded-full text-xs font-semibold border ring-1 ring-inset {{ $badgeClass }}">
                                        <span class="mr-1.5 size-1.5 rounded-full bg-current"></span>
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 text-center font-bold">
                                    {{ $item->stock }} <span class="text-slate-400 font-normal text-xs ml-0.5">pcs</span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- EDIT BUTTON --}}
                                        <button onclick="openEditModal(
                                                '{{ $item->id }}',
                                                '{{ $item->item_name }}',
                                                '{{ $item->part_number }}',
                                                '{{ $item->stock }}',
                                                '{{ $item->category_id }}',
                                                `{{ $item->description }}`
                                            )"
                                            class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- DELETE BUTTON --}}
                                        <button onclick="openDeleteModal('{{ $item->id }}', '{{ $item->item_name }}')"
                                            class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
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

            <div id="noDataMessage"
                class="{{ count($items) > 0 ? 'hidden' : '' }} flex flex-col items-center justify-center py-16 text-center">
                <div class="p-4 bg-slate-50 rounded-full mb-3 ring-8 ring-slate-50/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-slate-900 font-semibold text-lg">No items found</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-xs mx-auto">Try adding new items or adjust filters.</p>
            </div>
        </div>
    </div>

    <div id="addItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"
            onclick="closeModal('addItemModal')"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg opacity-0 translate-y-4 sm:translate-y-0 scale-95"
                    id="modalPanel">

                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800" id="modal-title">Add New Item</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Enter item details to update inventory.</p>
                        </div>
                        <button type="button" onclick="closeModal('addItemModal')"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('items.store') }}" method="POST"> @csrf
                        <div class="px-6 py-6 space-y-5">

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Item Name <span
                                        class="text-rose-500">*</span></label>
                                <input type="text" name="item_name" required placeholder="e.g. Macbook Pro M3"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700">
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Part Number</label>
                                    <input type="text" name="part_number" placeholder="PN-2024-XXX"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Initial Stock <span
                                            class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="stock" required min="0" placeholder="0"
                                            class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700">
                                        <span
                                            class="absolute inset-y-0 right-4 flex items-center text-xs text-slate-400 font-medium">Qty</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Category <span
                                        class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select name="category_id" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 appearance-none cursor-pointer">
                                        <option value="" disabled selected>Select Category...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Description / Notes</label>
                                <textarea name="description" rows="3" placeholder="Add additional details about the item..."
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:text-slate-400 text-sm font-medium text-slate-700 resize-none"></textarea>
                            </div>

                        </div>

                        <div
                            class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all">
                                Save Item
                            </button>
                            <button type="button" onclick="closeModal('addItemModal')"
                                class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="editItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="editModalBackdrop"
            onclick="closeModal('editItemModal')"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg opacity-0 translate-y-4 sm:translate-y-0 scale-95"
                    id="editModalPanel">

                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800" id="modal-title">Edit Item</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Update item information and stock.</p>
                        </div>
                        <button type="button" onclick="closeModal('editItemModal')"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form id="editItemForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-6 py-6 space-y-5">

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Item Name <span
                                        class="text-rose-500">*</span></label>
                                <input type="text" id="edit_item_name" name="item_name" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Part Number</label>
                                    <input type="text" id="edit_part_number" name="part_number"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Stock <span
                                            class="text-rose-500">*</span></label>
                                    <input type="number" id="edit_stock" name="stock" required min="0"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Category <span
                                        class="text-rose-500">*</span></label>
                                <select id="edit_category_id" name="category_id" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Description / Notes</label>
                                <textarea id="edit_description" name="description" rows="3"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 resize-none"></textarea>
                            </div>

                        </div>

                        <div
                            class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all">
                                Update Item
                            </button>

                            <button type="button" onclick="closeModal('editItemModal')"
                                class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">
                                Cancel
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    <div id="deleteItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">

        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="deleteModalBackdrop"
            onclick="closeModal('deleteItemModal')"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 scale-95"
                    id="deleteModalPanel">

                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Delete Item</h3>
                            <p class="text-xs text-slate-500 mt-0.5">This action cannot be undone.</p>
                        </div>
                        <button type="button" onclick="closeModal('deleteItemModal')"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form id="deleteItemForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="px-6 py-6">
                            <p class="text-sm text-slate-600">
                                Are you sure want to delete item:
                                <span class="font-bold text-rose-600" id="deleteItemName"></span> ?
                            </p>
                        </div>

                        <div
                            class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-rose-200 hover:bg-rose-700 hover:shadow-rose-300 transition-all">
                                Yes, Delete
                            </button>

                            <button type="button" onclick="closeModal('deleteItemModal')"
                                class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">
                                Cancel
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        // --- 1. MODAL LOGIC ---
        function openModal(modalId) {
            const modal = document.getElementById(modalId);

            const backdrop = modal.querySelector('[id$="ModalBackdrop"]') || modal.querySelector('#modalBackdrop');
            const panel = modal.querySelector('[id$="ModalPanel"]') || modal.querySelector('#modalPanel');

            modal.classList.remove('hidden');

            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);

            const backdrop = modal.querySelector('[id$="ModalBackdrop"]') || modal.querySelector('#modalBackdrop');
            const panel = modal.querySelector('[id$="ModalPanel"]') || modal.querySelector('#modalPanel');

            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }


        // --- 2. FILTER LOGIC ---
        let currentFilter = 'all';

        function filterTable(type) {
            const rows = document.querySelectorAll('.item-row');
            const cardIn = document.getElementById('card-in');
            const cardRestock = document.getElementById('card-restock');
            const cardOut = document.getElementById('card-out');
            const badge = document.getElementById('filter-badge');
            const badgeText = document.getElementById('filter-text');

            // Toggle filter
            if (currentFilter === type && type !== 'reset') {
                type = 'reset';
            }
            currentFilter = type;

            // Reset Styles
            [cardIn, cardRestock, cardOut].forEach(c => c.classList.remove('ring-2', 'ring-offset-2', 'ring-emerald-500', 'ring-amber-500', 'ring-rose-500'));
            badge.classList.add('hidden');
            badge.classList.remove('flex');

            // Apply Styles
            if (type === 'in') {
                cardIn.classList.add('ring-2', 'ring-emerald-500', 'ring-offset-2');
                badgeText.innerText = "In Stock";
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else if (type === 'restock') {
                cardRestock.classList.add('ring-2', 'ring-amber-500', 'ring-offset-2');
                badgeText.innerText = "Needs Restock";
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else if (type === 'out') {
                cardOut.classList.add('ring-2', 'ring-rose-500', 'ring-offset-2');
                badgeText.innerText = "Out of Stock";
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            }

            // Filter Rows
            let visibleCount = 0;
            let rowNumber = 1;

            rows.forEach(row => {
                const stock = parseInt(row.getAttribute('data-stock'));
                let show = false;

                if (type === 'in') {
                    if (stock >= 10) show = true;
                } else if (type === 'restock') {
                    if (stock > 0 && stock < 10) show = true;
                } else if (type === 'out') {
                    if (stock == 0) show = true;
                } else {
                    show = true; // Show All
                }

                if (show) {
                    row.style.display = '';
                    row.getElementsByTagName('td')[0].innerText = rowNumber++;
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Empty State
            const noDataMsg = document.getElementById('noDataMessage');
            if (visibleCount === 0) noDataMsg.classList.remove('hidden');
            else noDataMsg.classList.add('hidden');
        }

        // --- 3. SEARCH LOGIC ---
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.item-row');
                    let visibleCount = 0;
                    let rowNumber = 1;

                    rows.forEach(row => {
                        // Search by Item Name (col 1) or Category (col 2)
                        const itemName = row.cells[1].textContent.toLowerCase();
                        const category = row.cells[2].textContent.toLowerCase();

                        if (itemName.includes(filter) || category.includes(filter)) {
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

        // --- 4. SORT LOGIC ---
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

                if (columnIndex === 4) { // Stock column
                    const numA = parseFloat(cellA.replace(/[^0-9.-]+/g, ""));
                    const numB = parseFloat(cellB.replace(/[^0-9.-]+/g, ""));
                    return isAscending ? numA - numB : numB - numA;
                }

                return isAscending
                    ? cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: 'base' })
                    : cellB.localeCompare(cellA, undefined, { numeric: true, sensitivity: 'base' });
            });

            tbody.append(...rows);

            // Re-apply numbering
            let rowNumber = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    row.getElementsByTagName('td')[0].innerText = rowNumber++;
                }
            });

            // Update Icons
            document.querySelectorAll('thead th svg').forEach(svg => {
                svg.classList.remove('text-indigo-600', 'rotate-180');
                svg.classList.add('text-slate-300');
            });
            const activeIcon = document.getElementById(`icon-${columnIndex}`);
            if (activeIcon) {
                activeIcon.classList.remove('text-slate-300');
                activeIcon.classList.add('text-indigo-600');
                if (isAscending) activeIcon.classList.add('rotate-180');
            }
        }

        function openEditModal(id, item_name, part_number, stock, category_id, description) {
            const modal = document.getElementById("editItemModal");
            const backdrop = modal.querySelector("#editModalBackdrop");
            const panel = modal.querySelector("#editModalPanel");

            document.getElementById("edit_item_name").value = item_name;
            document.getElementById("edit_part_number").value = part_number;
            document.getElementById("edit_stock").value = stock;
            document.getElementById("edit_category_id").value = category_id;
            document.getElementById("edit_description").value = description;

            // set action form update
            document.getElementById("editItemForm").action = `/items/${id}`;

            modal.classList.remove("hidden");

            setTimeout(() => {
                backdrop.classList.remove("opacity-0");
                panel.classList.remove("opacity-0", "translate-y-4", "scale-95");
                panel.classList.add("opacity-100", "translate-y-0", "scale-100");
            }, 10);
        }

        function openDeleteModal(id, item_name) {
            const modal = document.getElementById("deleteItemModal");
            const backdrop = modal.querySelector("#deleteModalBackdrop");
            const panel = modal.querySelector("#deleteModalPanel");

            document.getElementById("deleteItemName").innerText = item_name;

            // set action form delete
            document.getElementById("deleteItemForm").action = `/items/${id}`;

            modal.classList.remove("hidden");

            setTimeout(() => {
                backdrop.classList.remove("opacity-0");
                panel.classList.remove("opacity-0", "translate-y-4", "scale-95");
                panel.classList.add("opacity-100", "translate-y-0", "scale-100");
            }, 10);
        }
    </script>
@endsection