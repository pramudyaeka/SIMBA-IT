@extends('layouts.dashboard')

@section('title', 'Item Management')

@section('content')
    {{-- Dependencies --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="w-full max-w-7xl mx-auto px-6 py-2 space-y-8 font-sans">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Item Management</h1>
                <p class="text-slate-500 text-sm mt-1">Manage your inventory items efficiently.</p>
            </div>
            <div class="text-sm text-slate-400 font-medium">
                {{ now()->format('l, d M Y') }}
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- In Stock --}}
            <div id="card-in" onclick="filterTable('in')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all relative overflow-hidden">
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

            {{-- Restock --}}
            <div id="card-restock" onclick="filterTable('restock')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all relative overflow-hidden">
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

            {{-- Out of Stock --}}
            <div id="card-out" onclick="filterTable('out')"
                class="group cursor-pointer p-6 bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all relative overflow-hidden">
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

        {{-- Toolbar Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3 h-10">
                <span id="filter-badge"
                    class="hidden px-3 py-1.5 rounded-full bg-slate-800 text-white text-xs font-bold items-center gap-2 shadow-sm animate-pulse transition-all">
                    <span id="filter-text">Filtered</span>
                    <button type="button" onclick="filterTable('reset')" class="hover:text-slate-300 focus:outline-none">
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

                @if (auth()->user()->access_level === 'admin')
                    <div class="flex gap-2">
                        <button type="button" onclick="openAddStockModal()"
                            class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-indigo-600 text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="hidden sm:inline">Add Stock</span>
                        </button>
                        <button type="button" onclick="toggleModal('addItemModal')"
                            class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all duration-200 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Add Item
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Table Data --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table id="dataTable" class="min-w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th onclick="sortTable(1)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none">
                                <div class="flex items-center gap-2">Item Name
                                    <svg id="icon-1"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>
                            <th onclick="sortTable(2)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Category
                                    <svg id="icon-2"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>
                            <th onclick="sortTable(3)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Status
                                    <svg id="icon-3"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>
                            <th onclick="sortTable(4)"
                                class="px-6 py-4 cursor-pointer group hover:bg-slate-100 transition-colors select-none text-center">
                                <div class="flex items-center justify-center gap-2">Stock
                                    <svg id="icon-4"
                                        class="size-3 text-slate-300 group-hover:text-indigo-500 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($items as $item)
                            <tr class="item-row group hover:bg-indigo-50/30 transition-colors duration-200"
                                data-stock="{{ $item->stock }}" data-max="{{ $item->max_stock }}">
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
                                        $badge = 'bg-emerald-50 text-emerald-700 border-emerald-100 ring-emerald-500/20';
                                        $status = 'In Stock';
                                        $threshold = $item->max_stock * 0.5;

                                        if ($item->stock == 0) {
                                            $badge = 'bg-rose-50 text-rose-700 border-rose-100 ring-rose-500/20';
                                            $status = 'Out of Stock';
                                        } elseif ($item->stock <= $threshold) {
                                            $badge = 'bg-amber-50 text-amber-700 border-amber-100 ring-amber-500/20';
                                            $status = 'Low Stock';
                                        }
                                    @endphp
                                    <span
                                        class="inline-flex items-center w-28 justify-center py-1 rounded-full text-xs font-semibold border ring-1 ring-inset {{ $badge }}">
                                        <span class="mr-1.5 size-1.5 rounded-full bg-current"></span>{{ $status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm text-slate-700 font-bold">{{ $item->stock }} <span
                                            class="font-normal text-xs text-slate-400">{{ $item->units ?? 'pcs' }}</span></div>
                                    @if($item->damaged_stock > 0)
                                        <div
                                            class="text-[10px] text-rose-500 font-semibold mt-1 bg-rose-50 rounded px-1.5 py-0.5 inline-block">
                                            {{ $item->damaged_stock }} Defect
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">

                                        {{-- HANYA ADMIN YANG BISA EDIT & DELETE --}}
                                        @if (auth()->check() && auth()->user()->access_level === 'admin')
                                            {{-- Edit Button --}}
                                            <button type="button"
                                                onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->item_name) }}', '{{ $item->part_number }}', '{{ $item->stock }}', '{{ $item->max_stock }}', '{{ $item->category_id }}', '{{ $item->units ?? 'pcs' }}', `{{ $item->description }}`)"
                                                class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all shadow-sm"
                                                title="Edit Item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            {{-- Delete Button --}}
                                            <button type="button"
                                                onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->item_name) }}')"
                                                class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-all shadow-sm"
                                                title="Delete Item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif

                                        {{-- QR CODE BISA DILIHAT SEMUA (ADMIN & STAFF) --}}
                                        <button type="button"
                                            onclick="openQrModal('{{ addslashes($item->item_name) }}', '{{ $item->part_number ?? $item->id }}')"
                                            class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg transition-all shadow-sm"
                                            title="Show QR Code">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                        </button>

                                        {{-- HANYA ADMIN YANG BISA DEFECT & RESOLVE --}}
                                        @if (auth()->check() && auth()->user()->access_level === 'admin')
                                            {{-- Defect Button --}}
                                            <button type="button"
                                                onclick="openDefectModal('{{ $item->id }}', '{{ addslashes($item->item_name) }}', '{{ $item->stock }}')"
                                                class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-orange-50 hover:text-orange-600 hover:border-orange-200 rounded-lg transition-all shadow-sm"
                                                title="Mark as Defect">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </button>

                                            {{-- Resolve Defect Button --}}
                                            @if($item->damaged_stock > 0)
                                                <button type="button"
                                                    onclick="openResolveModal('{{ $item->id }}', '{{ addslashes($item->item_name) }}', '{{ $item->damaged_stock }}')"
                                                    class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-teal-50 hover:text-teal-600 hover:border-teal-200 rounded-lg transition-all shadow-sm"
                                                    title="Resolve Defect (Retur/Buang)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Empty State --}}
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

    {{-- MODAL SECTION --}}
    @include('admin.crud.partials.modals')

    {{-- Alerts & Validation Errors Check --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '<li>{{ $error }}</li>';
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    html: `<ul class="text-left text-sm text-rose-500 list-disc ml-5">${errorMessages}</ul>`,
                    confirmButtonColor: '#e11d48'
                });
            @endif

            @if(session('success'))
                Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", confirmButtonColor: '#4f46e5' });
            @endif

            @if(session('error'))
                Swal.fire({ icon: 'error', title: 'Failed!', text: "{{ session('error') }}", confirmButtonColor: '#e11d48' });
            @endif
                    });
    </script>

    {{-- Scripts --}}
    <script>
        const allItemsData = @json($items);

        // --- GLOBAL MODAL CONTROLLER ---
        function toggleModal(modalId, show = true) {
            const modal = document.getElementById(modalId);
            const backdrop = document.getElementById(modalId + 'Backdrop') || modal.querySelector('[id$="Backdrop"]');
            const panel = document.getElementById(modalId + 'Panel') || modal.querySelector('[id$="Panel"]');

            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
                    panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                }, 10);
            } else {
                backdrop.classList.add('opacity-0');
                panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
                panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    if (modalId === 'addStockModal' && asScanner) asScanner.clear();
                }, 300);
            }
        }

        // --- ADD STOCK LOGIC ---
        let asScanner = null;
        let asManualMode = false;

        function openAddStockModal() {
            asBackStep1();
            toggleModal('addStockModal', true);
        }

        function asToggleManual() {
            asManualMode = !asManualMode;
            const cam = document.getElementById('as-cameraArea');
            const man = document.getElementById('as-manualArea');
            const btn = document.getElementById('as-btnToggle');

            if (asManualMode) {
                if (asScanner) asScanner.clear();
                cam.classList.add('hidden');
                man.classList.remove('hidden');
                btn.innerText = "Back to Camera Scanner";
                document.getElementById('as-manualInput').focus();
            } else {
                cam.classList.remove('hidden');
                man.classList.add('hidden');
                btn.innerText = "Camera Issue? Search Manually";
                asScanner = new Html5QrcodeScanner("as-qr-reader", { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 });
                asScanner.render(asOnScanSuccess);
            }
        }

        function asOnScanSuccess(decodedText) {
            const foundItem = allItemsData.find(i => i.id == decodedText || i.part_number == decodedText);
            if (foundItem) {
                asSelectItem(foundItem);
            } else {
                Swal.fire({ icon: 'warning', title: 'Not Found', text: 'Item not found in database.', confirmButtonColor: '#4f46e5' });
            }
        }

        function asSearchItem() {
            const val = document.getElementById('as-manualInput').value.toLowerCase();
            const list = document.getElementById('as-searchResultList');
            list.innerHTML = '';

            if (!val) { list.classList.add('hidden'); return; }

            const filtered = allItemsData.filter(i => i.item_name.toLowerCase().includes(val));

            if (filtered.length === 0) {
                list.innerHTML = '<li class="px-4 py-3 text-sm text-slate-500 text-center">No item found</li>';
            } else {
                filtered.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 cursor-pointer border-b border-slate-100 last:border-0 flex justify-between';
                    li.innerHTML = `<span>${item.item_name}</span> <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">Stock: ${item.stock}</span>`;
                    li.onclick = () => asSelectItem(item);
                    list.appendChild(li);
                });
            }
            list.classList.remove('hidden');
        }

        function asSelectItem(item) {
            if (asScanner) asScanner.clear();

            document.getElementById('as-step1').classList.add('hidden');
            document.getElementById('as-step2').classList.remove('hidden');

            document.getElementById('as-itemName').innerText = item.item_name;
            document.getElementById('as-itemStock').innerText = `Current Stock: ${item.stock}`;
            document.getElementById('as-id').value = item.id;
            document.getElementById('as-qty').value = 1;
            document.getElementById('as-reject-qty').value = 0;
            document.getElementById('as-note').value = '';
        }

        function asBackStep1() {
            document.getElementById('as-step2').classList.add('hidden');
            document.getElementById('as-step1').classList.remove('hidden');

            asManualMode = false;
            document.getElementById('as-cameraArea').classList.remove('hidden');
            document.getElementById('as-manualArea').classList.add('hidden');
            document.getElementById('as-btnToggle').innerText = "Camera Issue? Search Manually";

            if (!asScanner) {
                asScanner = new Html5QrcodeScanner("as-qr-reader", { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 });
                asScanner.render(asOnScanSuccess);
            }
        }

        function asSubmit() {
            const qty = document.getElementById('as-qty').value;
            const rejectQty = document.getElementById('as-reject-qty').value;
            const note = document.getElementById('as-note').value;

            if (qty < 1 && rejectQty < 1) {
                Swal.fire('Error', 'Please input at least 1 quantity.', 'error');
                return;
            }

            document.getElementById('as-form-qty').value = qty;
            document.getElementById('as-form-reject-qty').value = rejectQty;
            document.getElementById('as-form-note').value = note;

            const form = document.getElementById('as-form');
            document.body.appendChild(form);
            form.submit();
        }

        // --- SPECIFIC MODAL TRIGGERS ---

        function openEditModal(id, item_name, part_number, stock, max_stock, category_id, units, description) {
            document.getElementById("edit_item_name").value = item_name;
            document.getElementById("edit_part_number").value = part_number;
            document.getElementById("edit_stock").value = stock;
            document.getElementById("edit_max_stock").value = max_stock;
            document.getElementById("edit_category_id").value = category_id;

            // Set Unit Value
            const unitSelect = document.getElementById("edit_units");
            if (units && units !== 'null' && units !== '') {
                unitSelect.value = units;
            } else {
                unitSelect.value = 'pcs';
            }

            document.getElementById("edit_description").value = description;
            document.getElementById("editItemForm").action = `/items/${id}`;
            toggleModal('editItemModal', true);
        }

        function openDeleteModal(id, item_name) {
            document.getElementById("deleteItemName").innerText = item_name;
            document.getElementById("deleteItemForm").action = `/items/${id}`;
            toggleModal('deleteItemModal', true);
        }

        function openQrModal(itemName, identifier) {
            document.getElementById("qrItemName").innerText = itemName;
            document.getElementById("qrItemCode").innerText = identifier || 'N/A';

            const qrData = encodeURIComponent(identifier);
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${qrData}`;
            document.getElementById("qrCodeImage").src = qrUrl;

            toggleModal('qrItemModal', true);
        }

        function openDefectModal(id, name, maxGoodStock) {
            document.getElementById('defect_item_id').value = id;
            document.getElementById('defect_item_name').innerText = name;
            document.getElementById('defect_max_stock').innerText = maxGoodStock;
            document.getElementById('defect_qty').max = maxGoodStock;
            document.getElementById('defect_qty').value = 1;
            toggleModal('defectModal', true);
        }

        function openResolveModal(id, name, damagedStock) {
            document.getElementById('resolve_item_id').value = id;
            document.getElementById('resolve_item_name').innerText = name;
            document.getElementById('resolve_max_stock').innerText = damagedStock;
            document.getElementById('resolve_qty').max = damagedStock;
            document.getElementById('resolve_qty').value = damagedStock;
            toggleModal('resolveModal', true);
        }

        function downloadQR() {
            const imgUrl = document.getElementById("qrCodeImage").src;
            const itemName = document.getElementById("qrItemName").innerText;
            fetch(imgUrl).then(response => response.blob()).then(blob => {
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.download = `QR-${itemName.replace(/\s+/g, '-')}.png`;
                link.click();
            }).catch(console.error);
        }

        // --- FILTER & SORT ---

        let currentFilter = 'all';

        function filterTable(type) {
            const rows = document.querySelectorAll('.item-row');
            const cardIn = document.getElementById('card-in');
            const cardRestock = document.getElementById('card-restock');
            const cardOut = document.getElementById('card-out');
            const badge = document.getElementById('filter-badge');

            if (currentFilter === type && type !== 'reset') { type = 'reset'; }
            currentFilter = type;

            [cardIn, cardRestock, cardOut].forEach(c => c.classList.remove('ring-2', 'ring-offset-2', 'ring-emerald-500', 'ring-amber-500', 'ring-rose-500'));
            badge.classList.add('hidden');
            badge.classList.remove('flex');

            if (type === 'in') {
                cardIn.classList.add('ring-2', 'ring-emerald-500', 'ring-offset-2');
                badge.classList.remove('hidden'); badge.classList.add('flex');
            } else if (type === 'restock') {
                cardRestock.classList.add('ring-2', 'ring-amber-500', 'ring-offset-2');
                badge.classList.remove('hidden'); badge.classList.add('flex');
            } else if (type === 'out') {
                cardOut.classList.add('ring-2', 'ring-rose-500', 'ring-offset-2');
                badge.classList.remove('hidden'); badge.classList.add('flex');
            }

            let visibleCount = 0;
            let rowNumber = 1;

            rows.forEach(row => {
                const stock = parseInt(row.getAttribute('data-stock'));
                const maxStock = parseInt(row.getAttribute('data-max'));
                let show = false;

                if (type === 'in') { if (stock > (maxStock * 0.5)) show = true; }
                else if (type === 'restock') { if (stock > 0 && stock <= (maxStock * 0.5)) show = true; }
                else if (type === 'out') { if (stock == 0) show = true; }
                else { show = true; }

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

        // Search
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.item-row');
                    let visibleCount = 0;
                    let rowNumber = 1;

                    rows.forEach(row => {
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

        // Sort
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

            let rowNumber = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') {
                    row.getElementsByTagName('td')[0].innerText = rowNumber++;
                }
            });

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
    </script>
@endsection