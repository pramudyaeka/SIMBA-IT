@extends('layouts.dashboard')

@section('title', 'History Log')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-6 py-6 space-y-8 font-jakarta">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">History Log</h1>
                <p class="text-slate-500 text-sm mt-1">Track inventory movements and user activities.</p>
            </div>
            <div class="text-sm text-slate-400 font-medium">
                {{ now()->format('l, d M Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Today's Activity</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $transactionsToday }}
                        <span class="text-sm font-normal text-slate-400">Actions</span>
                    </h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Items In</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">
                        +{{ $itemsInToday }}
                    </h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Items Out</p>
                    <h3 class="text-2xl font-bold text-rose-600 mt-1">
                        -{{ $itemsOutToday }}
                    </h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 12l4.5 4.5m0 0l4.5-4.5M12 16.5V3" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

            <div
                class="px-6 py-5 border-b border-slate-100 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 bg-slate-50/50">

                <div class="flex p-1 bg-slate-200/60 rounded-xl">
                    <button onclick="filterHistory('all')" id="tab-all"
                        class="px-4 py-1.5 rounded-lg text-sm font-semibold bg-white text-slate-800 shadow-sm transition-all">All</button>
                    <button onclick="filterHistory('in')" id="tab-in"
                        class="px-4 py-1.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-700 transition-all">Stock
                        In</button>
                    <button onclick="filterHistory('out')" id="tab-out"
                        class="px-4 py-1.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-700 transition-all">Stock
                        Out</button>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="searchInput" onkeyup="searchHistory()"
                            class="block w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm"
                            placeholder="Search user, item...">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4">Date & Time</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4 text-center">Action</th>
                            <th class="px-6 py-4">Item Details</th>
                            <th class="px-6 py-4 text-center">Qty</th>
                            <th class="px-6 py-4">Note</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach ($historyData as $log)
                            <tr class="history-row hover:bg-slate-50 transition-colors"
                                data-action="{{ $log->quantity > 0 ? 'in' : 'out' }}">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-700">
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}
                                        </span>
                                        <span class="text-xs text-slate-400">
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }} WIB
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                            {{ strtoupper(substr($log->user->name ?? 'SYS', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-700">
                                                {{ $log->user->first_name ?? 'System' }}
                                            </p>
                                            <p class="text-[11px] text-slate-400">
                                                {{ $log->user->role ?? 'System' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @php
                                        $actionClass = '';
                                        $actionIcon = '';

                                        if ($log->action == 'Restock') {
                                            $actionClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                            $actionIcon =
                                                '<svg class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>';
                                        } elseif ($log->action == 'Usage') {
                                            $actionClass = 'bg-rose-50 text-rose-700 border-rose-100';
                                            $actionIcon =
                                                '<svg class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>';
                                        } else {
                                            $actionClass = 'bg-blue-50 text-blue-700 border-blue-100';
                                            $actionIcon =
                                                '<svg class="size-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
                                        }
                                    @endphp

                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $actionClass }}">
                                        {!! $actionIcon !!} {{ $log->action }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-slate-700">
                                        {{ $log->item->item_name ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $log->category->category_name ?? '-' }}
                                    </p>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if ($log->quantity > 0)
                                        <span class="text-emerald-600 font-bold text-sm">+{{ $log->quantity }}</span>
                                    @else
                                        <span class="text-rose-600 font-bold text-sm">{{ $log->quantity }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-500 italic max-w-xs truncate"
                                        title="{{ $log->note ?? '-' }}">
                                        "{{ $log->note ?? '-' }}"
                                    </p>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50">
                <span class="text-xs text-slate-500">
                    Showing {{ $historyData->count() }} activities
                </span>
            </div>
        </div>
    </div>

    <script>
        function filterHistory(type) {
            const rows = document.querySelectorAll('.history-row');
            const tabs = {
                all: document.getElementById('tab-all'),
                in: document.getElementById('tab-in'),
                out: document.getElementById('tab-out')
            };

            Object.keys(tabs).forEach(key => {
                if (key === type) {
                    tabs[key].className =
                        "px-4 py-1.5 rounded-lg text-sm font-semibold bg-white text-slate-800 shadow-sm transition-all";
                } else {
                    tabs[key].className =
                        "px-4 py-1.5 rounded-lg text-sm font-medium text-slate-500 hover:text-slate-700 transition-all";
                }
            });

            rows.forEach(row => {
                const actionType = row.getAttribute('data-action');

                if (type === 'all') {
                    row.style.display = '';
                } else if (type === 'in') {
                    row.style.display = (actionType === 'in') ? '' : 'none';
                } else if (type === 'out') {
                    row.style.display = (actionType === 'out') ? '' : 'none';
                }
            });
        }

        function searchHistory() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.history-row');

            rows.forEach(row => {
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
