@extends('layouts.dashboard')

@section('title', 'Monthly Report')

@section('content')
    <div class="w-full max-w-7xl mx-auto px-6 py-6 space-y-8 font-jakarta">

        <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Monthly Report</h1>
                <p class="text-slate-500 text-sm mt-1">Inventory stock summary for the selected period.</p>
            </div>
            
            <div class="w-full md:w-auto">
                <form action="{{ route('reports.page') }}" method="GET" class="flex items-center gap-2 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="month" name="period" value="{{ $period }}" 
                            class="pl-9 pr-3 py-1.5 bg-transparent border-none text-slate-700 font-semibold text-sm focus:ring-0 cursor-pointer">
                    </div>
                    <button type="submit" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-colors">
                        Load
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Stock</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ number_format($totalStock) }}</h3>
                    <p class="text-xs text-slate-500 mt-1">Across {{ $totalItems }} unique items</p>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Running Low</p>
                    <h3 class="text-3xl font-bold text-amber-500 mt-1">{{ $lowStockItems }}</h3>
                    <p class="text-xs text-slate-500 mt-1">Items below 10 units</p>
                </div>
                <div class="p-3 bg-amber-50 text-amber-500 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Empty Stock</p>
                    <h3 class="text-3xl font-bold text-rose-500 mt-1">{{ $outOfStockItems }}</h3>
                    <p class="text-xs text-slate-500 mt-1">Needs immediate attention</p>
                </div>
                <div class="p-3 bg-rose-50 text-rose-500 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
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
                        placeholder="Search items...">
                </div>

                <div class="flex gap-2 w-full sm:w-auto">
                    <a href="{{ url('/admin/export-excel?period='.$period) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-emerald-200 transition-all duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Excel</span>
                    </a>
                    <a href="{{ url('/admin/export-pdf?period='.$period) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-rose-200 transition-all duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <span>PDF</span>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-xs uppercase tracking-wider text-slate-500 font-semibold border-b border-slate-100">
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Item Name</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Stock</th>
                            <th class="px-6 py-4 text-center">Last Updated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($reportData as $item)
                            <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                <td class="px-6 py-4 text-sm text-slate-400 text-center font-medium">{{ $loop->iteration }}</td>
                                
                                <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                    {{-- Gunakan object property (->) bukan array (['']) --}}
                                    {{ $item->item_name }} 
                                </td>
                                
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $item->category->category_name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @php
                                            // Logika Status Berdasarkan Stok
                                            if ($item->stock <= 0) {
                                            $statusText = 'Out of Stock';
                                            $statusClass = 'text-rose-600 bg-rose-50 border-rose-100';
                                        } elseif ($item->stock < 10) {
                                            $statusText = 'Low Stock';
                                            $statusClass = 'text-amber-600 bg-amber-50 border-amber-100';
                                        } else {
                                            $statusText = 'Available';
                                            $statusClass = 'text-emerald-600 bg-emerald-50 border-emerald-100';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                    
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold text-slate-700">{{ $item->stock }}</span>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-500 text-center">
                                    {{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 bg-slate-50 rounded-full mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">No items found for this report period.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection