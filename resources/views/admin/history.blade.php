@extends('layouts.dashboard')

@section('title', 'History Log')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-6 py-6 space-y-8 font-jakarta">

        {{-- Header & Filter Bulan --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">History Log</h1>
                <p class="text-slate-500 text-sm mt-1">Track inventory movements for <span class="font-semibold text-indigo-600">{{ $formattedMonth }}</span>.</p>
            </div>
            
            {{-- Form Input Bulan --}}
            <form method="GET" action="{{ route('history.page') }}" class="flex items-center gap-3 bg-white px-3 py-2 rounded-xl border border-slate-200 shadow-sm">
                <label for="period" class="text-sm font-bold text-slate-500">Period:</label>
                <input type="month" id="period" name="period" value="{{ $period }}" onchange="this.form.submit()"
                    class="bg-transparent text-sm font-semibold text-slate-700 focus:outline-none cursor-pointer">
            </form>
        </div>

        {{-- Statistics Cards (Berdasarkan Bulan yang Dipilih) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Period Activity</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $transactionsCount }} <span class="text-sm font-normal text-slate-400">Actions</span>
                    </h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Items In</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">+{{ $itemsInCount }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Items Out</p>
                    <h3 class="text-2xl font-bold text-rose-600 mt-1">{{ $itemsOutCount < 0 ? $itemsOutCount : '-' . $itemsOutCount }}</h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 12l4.5 4.5m0 0l4.5-4.5M12 16.5V3" /></svg>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- Filter Tabs --}}
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 bg-slate-50/50">
                <div class="flex p-1 bg-slate-200/60 rounded-xl">
                    <button onclick="filterHistory('all')" id="tab-all" class="px-4 py-1.5 rounded-lg text-sm font-semibold bg-white text-slate-800 shadow-sm transition-all">All</button>
                    <button onclick="filterHistory('in')" id="tab-in" class="px-4 py-1.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-700 transition-all">Stock In</button>
                    <button onclick="filterHistory('out')" id="tab-out" class="px-4 py-1.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-700 transition-all">Stock Out</button>
                    <button onclick="filterHistory('system')" id="tab-system" class="px-4 py-1.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-700 transition-all">System</button>
                </div>

                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" id="searchInput" onkeyup="searchHistory()" class="block w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm" placeholder="Search user, item...">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4">Date & Time</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4 text-center">Action</th>
                            <th class="px-6 py-4">Details / Item</th>
                            <th class="px-6 py-4 text-center">Qty</th>
                            <th class="px-6 py-4">Note</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($historyData as $log)
                            {{-- LOGIKA DATA ACTION UNTUK FILTER TABS --}}
                            @php
                                $dataAction = 'system';
                                if($log->item_id) {
                                    $dataAction = $log->quantity > 0 ? 'in' : 'out';
                                } elseif ($log->action == 'Delete Item') {
                                    $dataAction = 'system'; // Kita kelompokkan hapus item ke system/admin event
                                }
                            @endphp

                            <tr class="history-row hover:bg-slate-50 transition-colors" data-action="{{ $dataAction }}">
                                {{-- Date --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}</span>
                                        <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WITA</span>
                                    </div>
                                </td>

                                {{-- User --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="size-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                            {{ strtoupper(substr($log->user->first_name ?? 'SY', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-700">{{ $log->user->first_name ?? 'System' }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $log->user->role ?? 'System' }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Action Badge --}}
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @php
                                        $actionClass = 'bg-slate-100 text-slate-600 border-slate-200';
                                        $icon = '';

                                        if ($log->action == 'Restock') {
                                            $actionClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                            $icon = '<svg class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>';
                                        } elseif (in_array($log->action, ['Usage', 'Mark Defect'])) {
                                            $actionClass = 'bg-rose-50 text-rose-700 border-rose-100';
                                            $icon = '<svg class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>';
                                        } elseif ($log->action == 'Delete Item') {
                                            $actionClass = 'bg-rose-100 text-rose-800 border-rose-200';
                                            $icon = '<svg class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
                                        } elseif (in_array($log->action, ['Create User', 'Update User', 'Delete User', 'Create', 'Update'])) {
                                            $actionClass = 'bg-violet-50 text-violet-700 border-violet-100';
                                            $icon = '<svg class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $actionClass }}">
                                        {!! $icon !!} {{ $log->action }}
                                    </span>
                                </td>

                                {{-- Item Details / Context --}}
                                <td class="px-6 py-4">
                                    @if($log->item_id)
                                        {{-- Jika log BARANG dan barangnya MASIH ADA --}}
                                        <p class="text-sm font-semibold text-slate-700">{{ $log->item->item_name ?? 'Unknown Item' }}</p>
                                        <p class="text-xs text-slate-500">{{ $log->category->category_name ?? '-' }}</p>
                                    @elseif($log->action == 'Delete Item')
                                        {{-- Jika log BARANG tapi sudah DIHAPUS --}}
                                        <p class="text-sm font-bold text-rose-600 line-through">Deleted Item</p>
                                        <p class="text-[10px] font-semibold text-rose-400 uppercase">Removed from Database</p>
                                    @else
                                        {{-- Jika log USER / SYSTEM --}}
                                        <p class="text-sm font-medium text-slate-600 italic">User Management</p>
                                        <p class="text-xs text-slate-400">System Event</p>
                                    @endif
                                </td>

                                {{-- Quantity --}}
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($log->item_id || $log->action == 'Delete Item')
                                        @if ($log->quantity > 0)
                                            <span class="text-emerald-600 font-bold text-sm">+{{ $log->quantity }}</span>
                                        @elseif($log->quantity < 0)
                                            <span class="text-rose-600 font-bold text-sm">{{ $log->quantity }}</span>
                                        @else
                                            <span class="text-slate-400 font-bold text-sm">-</span>
                                        @endif
                                    @else
                                        {{-- Untuk User Log yang qty-nya 0 --}}
                                        <span class="text-slate-300 font-bold text-lg">-</span>
                                    @endif
                                </td>

                                {{-- Note --}}
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-500 italic max-w-xs truncate" title="{{ $log->note ?? '-' }}">
                                        "{{ $log->note ?? '-' }}"
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50">
                <span class="text-xs text-slate-500">Showing {{ $historyData->count() }} activities</span>
            </div>
        </div>
    </div>

    <script>
        function filterHistory(type) {
            const rows = document.querySelectorAll('.history-row');
            
            // Update Tab Styles
            const tabs = ['all', 'in', 'out', 'system'];
            tabs.forEach(t => {
                const btn = document.getElementById('tab-' + t);
                if (t === type) {
                    btn.className = "px-4 py-1.5 rounded-lg text-sm font-semibold bg-white text-slate-800 shadow-sm transition-all";
                } else {
                    btn.className = "px-4 py-1.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-700 transition-all";
                }
            });

            // Filter Logic
            rows.forEach(row => {
                const actionType = row.getAttribute('data-action');
                if (type === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = (actionType === type) ? '' : 'none';
                }
            });
        }

        function searchHistory() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.history-row');

            rows.forEach(row => {
                // Adjust index based on your table columns
                // 1: User, 3: Item Name, 5: Note
                const user = row.cells[1].innerText.toLowerCase();
                const item = row.cells[3].innerText.toLowerCase();
                const note = row.cells[5].innerText.toLowerCase();

                if (user.includes(filter) || item.includes(filter) || note.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
@endsection