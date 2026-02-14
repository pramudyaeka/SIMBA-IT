@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <section class="w-full max-w-7xl mx-auto p-6 py-2 space-y-8 font-jakarta">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Inventory Overview</h1>
                <p class="text-slate-500 text-sm">Monitor stock levels and warehouse performance.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- KARTU SCANNER --}}
            <div onclick="openScannerModal()"
                class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-600 p-6 text-white shadow-lg shadow-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div
                            class="mb-3 inline-flex rounded-xl bg-white/20 p-2 backdrop-blur-sm group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-6 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold">Scan QR Code</h3>
                        <p class="text-sm text-indigo-100 mt-1 font-medium">Ambil / Tambah Stok</p>
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
                        style="width: {{ ($totalItems > 0) ? (($lowStockCount + $outOfStockCount) / count($items)) * 100 : 0 }}%">
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
            <div
                class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
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
                <div class="relative w-full sm:w-auto">
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search items..."
                        class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:w-64 transition-all">
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
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($items as $item)
                            <tr class="item-row group hover:bg-indigo-50/30 transition-colors duration-200"
                                data-stock="{{ $item->stock }}">
                                <td class="px-6 py-4 text-center text-slate-400 font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700 group-hover:text-indigo-600 transition-colors">
                                    {{ $item->item_name }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-center">
                                    <span
                                        class="inline-flex w-24 justify-center items-center gap-1.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200 whitespace-nowrap">
                                        {{ $item->category->category_name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-slate-700">
                                    {{ $item->stock }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClass = match (true) {
                                            $item->stock == 0 => 'bg-rose-50 text-rose-600 border-rose-100 ring-rose-500/10',
                                            $item->stock < 10 => 'bg-orange-50 text-orange-600 border-orange-100 ring-orange-500/10',
                                            default => 'bg-emerald-50 text-emerald-600 border-emerald-100 ring-emerald-500/10',
                                        };
                                        $statusLabel = $item->stock == 0 ? 'Out of Stock' : ($item->stock < 10 ? 'Low Stock' : 'In Stock');
                                    @endphp
                                    <span
                                        class="inline-flex w-28 justify-center items-center py-1 rounded-full text-xs font-semibold border ring-1 ring-inset {{ $statusClass }} whitespace-nowrap">
                                        <span class="mr-1.5 size-1.5 rounded-full bg-current"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="openQrModal('{{ $item->item_name }}', '{{ $item->id }}')"
                                        class="p-2 bg-white border border-slate-200 text-slate-500 hover:bg-emerald-50 hover:text-emerald-600 rounded-lg transition-all shadow-sm"
                                        title="Tampilkan QR Code">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">No data available from database
                                </td>
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

    {{-- ============================================== --}}
    {{-- MODALS SECTION --}}
    {{-- ============================================== --}}

    {{-- Modal Tampilkan QR Code --}}
    <div id="qrItemModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="qrModalBackdrop"
            onclick="closeQrModal()"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm opacity-0 translate-y-4 sm:translate-y-0 scale-95"
                    id="qrModalPanel">

                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Item QR Code</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Scan untuk melihat atau update stok.</p>
                        </div>
                        <button type="button" onclick="closeQrModal()"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-8 flex flex-col items-center justify-center">
                        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100 mb-4 ring-4 ring-slate-50">
                            <img id="qrCodeImage" src="" alt="QR Code" class="w-48 h-48 object-contain">
                        </div>
                        <h4 id="qrItemName" class="text-lg font-bold text-slate-800 text-center"></h4>
                        <p id="qrItemCode"
                            class="text-sm font-mono text-slate-500 mt-1 text-center bg-slate-100 px-3 py-1 rounded-md"></p>
                    </div>

                    <div
                        class="bg-slate-50 px-6 py-4 flex flex-col sm:flex-row-reverse gap-3 rounded-b-3xl border-t border-slate-100">
                        <button type="button" onclick="downloadQR()"
                            class="inline-flex w-full sm:w-auto justify-center items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download QR
                        </button>
                        <button type="button" onclick="closeQrModal()"
                            class="inline-flex w-full sm:w-auto justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition-all">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Scanner Transaksi (Update Baru) --}}
    <div id="scannerModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" id="scannerModalBackdrop"
            onclick="closeScannerModal()"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 scale-95"
                    id="scannerModalPanel">

                    <div class="bg-white px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Transaksi Inventaris</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Silakan pilih item yang ingin diproses</p>
                        </div>
                        <button type="button" onclick="closeScannerModal()"
                            class="text-slate-400 hover:text-rose-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-5">
                        <div class="flex gap-4 p-1 bg-slate-100 rounded-xl mb-5">
                            <button type="button" onclick="setTransactionType('take')" id="btnTake"
                                class="flex-1 py-2 text-sm font-bold rounded-lg bg-white text-indigo-600 shadow-sm transition-all">Ambil
                                Barang</button>
                            <button type="button" onclick="setTransactionType('add')" id="btnAdd"
                                class="flex-1 py-2 text-sm font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all">Tambah
                                Stok</button>
                        </div>

                        {{-- ============================== --}}
                        {{-- LANGKAH 1: CARI BARANG (SCAN/MANUAL) --}}
                        {{-- ============================== --}}
                        <div id="step1-find">
                            <div id="cameraArea"
                                class="rounded-2xl overflow-hidden border-2 border-dashed border-slate-300 bg-slate-50 p-2">
                                <div id="qr-reader" class="w-full"></div>
                            </div>

                            <div id="manualArea" class="hidden relative">
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Cari Berdasarkan Nama
                                    Barang</label>
                                <input type="text" id="manualInput" onkeyup="searchItemByName()"
                                    placeholder="Ketik nama barang..." autocomplete="off"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm font-medium">

                                <ul id="searchResultList"
                                    class="absolute z-20 w-full bg-white border border-slate-200 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto hidden">
                                </ul>
                            </div>

                            <div class="text-center mt-4">
                                <button type="button" onclick="toggleManualMode()" id="btnToggleManual"
                                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                    Kamera Bermasalah? Cari Manual
                                </button>
                            </div>
                        </div>

                        {{-- ============================== --}}
                        {{-- LANGKAH 2: INPUT QUANTITY (QTY) --}}
                        {{-- ============================== --}}
                        <div id="step2-qty" class="hidden space-y-5">
                            <div class="p-4 bg-indigo-50 rounded-xl text-center border border-indigo-100">
                                <p class="text-xs text-indigo-600 font-semibold mb-1 uppercase tracking-wider">Barang
                                    Terpilih</p>
                                <h4 id="selectedItemName" class="text-xl font-bold text-slate-800">Nama Barang</h4>
                                <p id="selectedItemStatus" class="text-sm text-slate-500 mt-1">Stok: 0</p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Jumlah (Qty)</label>
                                <input type="number" id="transactionQty" value="1" min="1"
                                    class="w-full px-4 py-2.5 text-center text-xl rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 font-bold text-slate-800">
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button type="button" onclick="backToStep1()"
                                    class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors">Ganti
                                    Barang</button>
                                <button type="button" onclick="submitTransaction()"
                                    class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-md">Proses</button>
                            </div>
                        </div>

                    </div>

                    <form id="scanActionForm" action="{{ route('items.transaction') ?? '#' }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="type" id="submitType" value="take">
                        <input type="hidden" name="qty" id="submitQty">
                        <input type="hidden" name="identifier" id="submitIdentifier">
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- ============================================== --}}
    {{-- SWEETALERT NOTIFICATIONS --}}
    {{-- ============================================== --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#4f46e5'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#e11d48'
                });
            });
        </script>
    @endif

    {{-- ============================================== --}}
    {{-- SCRIPTS SECTION --}}
    {{-- ============================================== --}}
    <script>
        // Mengirim data items dari controller ke JavaScript
        const allItemsData = @json($items);

        // --- LOGIKA FILTER & SEARCH TABLE ---
        function filterTable(type) {
            const rows = document.querySelectorAll('.item-row');
            const cardAll = document.getElementById('card-all');
            const cardRestock = document.getElementById('card-restock');
            const badge = document.getElementById('filter-badge');
            const showingText = document.getElementById('showing-text');

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

            let visibleCount = 0;
            let rowNumber = 1;

            rows.forEach(row => {
                const stock = parseInt(row.getAttribute('data-stock'));
                let shouldShow = false;

                if (type === 'restock') {
                    if (stock < 10) shouldShow = true;
                } else {
                    shouldShow = true;
                }

                if (shouldShow) {
                    row.style.display = '';
                    const numberCell = row.getElementsByTagName('td')[0];
                    numberCell.innerText = rowNumber++;
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            showingText.innerText = `Showing ${visibleCount} items`;
        }

        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.item-row');

            let rowNumber = 1;
            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.getElementsByTagName('td')[1].textContent || row.getElementsByTagName('td')[1].innerText;

                if (text.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = "";
                    const numberCell = row.getElementsByTagName('td')[0];
                    numberCell.innerText = rowNumber++;
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });
            document.getElementById('showing-text').innerText = `Showing ${visibleCount} items`;
        }

        // --- LOGIKA TAMPILKAN QR CODE ---
        function openQrModal(itemName, identifier) {
            const modal = document.getElementById("qrItemModal");
            const backdrop = modal.querySelector("#qrModalBackdrop");
            const panel = modal.querySelector("#qrModalPanel");

            document.getElementById("qrItemName").innerText = itemName;
            document.getElementById("qrItemCode").innerText = identifier || 'N/A';

            const qrData = encodeURIComponent(identifier);
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${qrData}`;
            document.getElementById("qrCodeImage").src = qrUrl;

            modal.classList.remove("hidden");
            setTimeout(() => {
                backdrop.classList.remove("opacity-0");
                panel.classList.remove("opacity-0", "translate-y-4", "scale-95");
                panel.classList.add("opacity-100", "translate-y-0", "scale-100");
            }, 10);
        }

        function closeQrModal() {
            const modal = document.getElementById('qrItemModal');
            const backdrop = document.getElementById('qrModalBackdrop');
            const panel = document.getElementById('qrModalPanel');

            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }

        function downloadQR() {
            const imgUrl = document.getElementById("qrCodeImage").src;
            const itemName = document.getElementById("qrItemName").innerText;

            fetch(imgUrl)
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement("a");
                    link.href = URL.createObjectURL(blob);
                    link.download = `QR-${itemName.replace(/\s+/g, '-')}.png`;
                    link.click();
                })
                .catch(console.error);
        }

        // --- LOGIKA SCANNER & TRANSAKSI ---
        let html5QrcodeScanner = null;
        let currentTransactionType = 'take';
        let isManualMode = false;

        function setTransactionType(type) {
            currentTransactionType = type;
            const btnTake = document.getElementById('btnTake');
            const btnAdd = document.getElementById('btnAdd');

            if (type === 'take') {
                btnTake.className = "flex-1 py-2 text-sm font-bold rounded-lg bg-white text-indigo-600 shadow-sm transition-all";
                btnAdd.className = "flex-1 py-2 text-sm font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all";
            } else {
                btnAdd.className = "flex-1 py-2 text-sm font-bold rounded-lg bg-white text-emerald-600 shadow-sm transition-all";
                btnTake.className = "flex-1 py-2 text-sm font-bold rounded-lg text-slate-500 hover:text-slate-700 transition-all";
            }
        }

        function openScannerModal() {
            const modal = document.getElementById('scannerModal');
            const backdrop = document.getElementById('scannerModalBackdrop');
            const panel = document.getElementById('scannerModalPanel');

            // Reset ke Step 1
            backToStep1();
            setTransactionType('take');

            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'scale-100');
            }, 10);
        }

        function closeScannerModal() {
            const modal = document.getElementById('scannerModal');
            const backdrop = document.getElementById('scannerModalBackdrop');
            const panel = document.getElementById('scannerModalPanel');

            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear();
                }
            }, 300);
        }

        // Jalankan saat Scanner menemukan QR
        function onScanSuccess(decodedText, decodedResult) {
            let audio = new Audio('https://www.soundjay.com/buttons/sounds/button-3.mp3');
            audio.play().catch(e => console.log('Audio blocked by browser'));

            // Cari item berdasarkan ID atau part_number yang di scan
            const foundItem = allItemsData.find(i => i.id == decodedText || i.part_number == decodedText);

            if (foundItem) {
                selectItemForTransaction(foundItem);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Ditemukan',
                    text: 'QR Code tidak cocok dengan barang manapun di database.',
                    confirmButtonColor: '#4f46e5'
                });
            }
        }

        function onScanFailure(error) {
            // Biarkan kosong
        }

        // Pencarian Manual By Name (Auto-complete)
        function toggleManualMode() {
            isManualMode = !isManualMode;
            const camArea = document.getElementById('cameraArea');
            const manArea = document.getElementById('manualArea');
            const btnToggle = document.getElementById('btnToggleManual');

            if (isManualMode) {
                if (html5QrcodeScanner) html5QrcodeScanner.clear();
                camArea.classList.add('hidden');
                manArea.classList.remove('hidden');
                btnToggle.innerText = "Kembali ke Scanner Kamera";
                document.getElementById('manualInput').focus();
            } else {
                camArea.classList.remove('hidden');
                manArea.classList.add('hidden');
                btnToggle.innerText = "Kamera Bermasalah? Cari Manual";
                document.getElementById('manualInput').value = '';
                document.getElementById('searchResultList').classList.add('hidden');

                // Mulai ulang scanner
                html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 });
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }
        }

        function searchItemByName() {
            const inputVal = document.getElementById('manualInput').value.toLowerCase();
            const resultList = document.getElementById('searchResultList');
            resultList.innerHTML = '';

            if (!inputVal) {
                resultList.classList.add('hidden');
                return;
            }

            const filteredItems = allItemsData.filter(i => i.item_name.toLowerCase().includes(inputVal));

            if (filteredItems.length === 0) {
                resultList.innerHTML = '<li class="px-4 py-3 text-sm text-slate-500 text-center">Barang tidak ditemukan</li>';
            } else {
                filteredItems.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 cursor-pointer border-b border-slate-100 last:border-0 flex justify-between items-center';
                    li.innerHTML = `<span>${item.item_name}</span> <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">Stok: ${item.stock}</span>`;
                    li.onclick = () => { selectItemForTransaction(item); };
                    resultList.appendChild(li);
                });
            }
            resultList.classList.remove('hidden');
        }

        // Pindah dari Step 1 ke Step 2 (Input Qty)
        function selectItemForTransaction(item) {
            // Matikan scanner jika sedang aktif
            if (html5QrcodeScanner && !isManualMode) {
                html5QrcodeScanner.clear();
            }

            // Sembunyikan Step 1, Tampilkan Step 2
            document.getElementById('step1-find').classList.add('hidden');
            document.getElementById('step2-qty').classList.remove('hidden');

            // Isi Data UI
            document.getElementById('selectedItemName').innerText = item.item_name;
            document.getElementById('selectedItemStatus').innerText = `Sisa Stok Saat Ini: ${item.stock}`;

            // Set Hidden Form Identifier
            document.getElementById('submitIdentifier').value = item.id;
            document.getElementById('transactionQty').value = 1;

            // Bersihkan input manual
            document.getElementById('manualInput').value = '';
            document.getElementById('searchResultList').classList.add('hidden');
        }

        // Kembali dari Step 2 ke Step 1
        function backToStep1() {
            document.getElementById('step2-qty').classList.add('hidden');
            document.getElementById('step1-find').classList.remove('hidden');

            // Jika dalam mode kamera, jalankan ulang kameranya
            if (!isManualMode) {
                html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 });
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }
        }

        // Final Submit
        // Final Submit
        function submitTransaction() {
            const qty = document.getElementById('transactionQty').value;
            if (!qty || qty < 1) {
                Swal.fire('Oops!', 'Jumlah barang minimal 1', 'warning');
                return;
            }

            // 1. Isi data ke dalam form tersembunyi
            document.getElementById('submitType').value = currentTransactionType;
            document.getElementById('submitQty').value = qty;

            // 2. AMBIL FORM SEBELUM TAMPILAN DIHAPUS
            const form = document.getElementById('scanActionForm');

            // 3. Pindahkan form ke luar area modal (ke dalam body) agar aman dari penghapusan
            document.body.appendChild(form);

            // 4. Ubah tampilan modal menjadi Loading
            document.getElementById('scannerModalPanel').innerHTML = `
                    <div class="p-10 flex flex-col items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-slate-800">Memproses Transaksi...</h3>
                    </div>
                `;

            // 5. Submit form dengan aman
            form.submit();
        }
    </script>
@endsection