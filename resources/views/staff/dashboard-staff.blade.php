@php
    $collection = [
        [
            'item_name' => 'Contoh Item 1',
            'category' => 'Kategori A',
            'status' => 'Available',
            'stock' => 150,
        ],
        [
            'item_name' => 'Contoh Item 2',
            'category' => 'Kategori B',
            'status' => 'Unavailable',
            'stock' => 0,
        ],
        [
            'item_name' => 'Contoh Item 3',
            'category' => 'Kategori A',
            'status' => 'Available',
            'stock' => 200,
        ],
        [
            'item_name' => 'Contoh Item 4',
            'category' => 'Kategori C',
            'status' => 'Available',
            'stock' => 75,
        ],
        [
            'item_name' => 'Contoh Item 5',
            'category' => 'Kategori B',
            'status' => 'Unavailable',
            'stock' => 0,
        ],
        [
            'item_name' => 'Contoh Item 6',
            'category' => 'Kategori A',
            'status' => 'Available',
            'stock' => 120,
        ],
        [
            'item_name' => 'Contoh Item 7',
            'category' => 'Kategori C',
            'status' => 'Available',
            'stock' => 90,
        ],
        [
            'item_name' => 'Contoh Item 8',
            'category' => 'Kategori B',
            'status' => 'Unavailable',
            'stock' => 0,
        ],
        [
            'item_name' => 'Contoh Item 9',
            'category' => 'Kategori A',
            'status' => 'Available',
            'stock' => 300,
        ],
        [
            'item_name' => 'Contoh Item 10',
            'category' => 'Kategori C',
            'status' => 'Available',
            'stock' => 60,
        ],
    ];
@endphp

@extends('layouts.dashboard')
@section('title','Dashboard')

@section('content')
    <section class="w-full">

        <!-- Statistik Dashboard -->
        <div class="w-full grid grid-cols-3 gap-6 py-4 px-8">

            <!-- Scan QR Code -->
            <div class="group cursor-pointer rounded-xl
            bg-linear-to-br from-sky-400 to-blue-500
            p-4 text-white shadow-md
            hover:-translate-y-1 hover:shadow-lg transition-all duration-300">

                <p class="font-semibold mb-2">Scan QR Code</p>

                <div class="flex flex-col items-center justify-center gap-2">
                    <img src="{{ asset('images/QR Code.png') }}" alt="QR Code"
                        class="w-36 brightness-0 invert opacity-90 group-hover:scale-105 transition">

                    <span class="text-xs text-white/90">
                        Scan untuk melihat detail barang
                    </span>
                </div>
            </div>

            <!-- Statistik Kategori -->
            <div class="flex flex-col gap-4">

                <!-- Total Category -->
                <div class="p-4 rounded-xl h-32
                bg-linear-to-br from-violet-400 to-purple-600
                text-white shadow-md
                hover:-translate-y-1 hover:shadow-lg transition-all duration-300">

                    <p class="text-sm text-white/90">Total Category</p>

                    <div class="flex items-center mt-3">
                        <p class="font-semibold text-3xl">3</p>
                        <p class="ml-3 text-sm font-medium">Categories</p>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-12 ml-auto text-white/80">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6h16.5M3.75 12h16.5M3.75 18h16.5" />
                        </svg>
                    </div>
                </div>

                <!-- Need Restock -->
                <div class="p-4 rounded-xl h-32
                bg-linear-to-br from-amber-400 to-orange-500
                text-white shadow-md
                hover:-translate-y-1 hover:shadow-lg transition-all duration-300">

                    <p class="text-sm text-white/90">Need Restock</p>

                    <div class="flex items-center mt-3">
                        <p class="font-semibold text-3xl">7</p>
                        <p class="ml-3 text-sm font-medium">Items</p>

                        <svg xmlns="http://www.w3.org/2000/svg" class="size-12 ml-auto text-white/90"
                            viewBox="0 -960 960 960" fill="currentColor">
                            <path
                                d="M480-580q-17 0-28.5-11.5T440-620q0-17 11.5-28.5T480-660q17 0 28.5 11.5T520-620q0 17-11.5 28.5T480-580Zm-40-140v-200h80v200h-80ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z" />
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Statistik Stok -->
            <div class="flex flex-col gap-4">

                <!-- In Stock -->
                <div class="p-4 rounded-xl h-32
                bg-linear-to-br from-emerald-400 to-green-600
                text-white shadow-md
                hover:-translate-y-1 hover:shadow-lg transition-all duration-300">

                    <p class="text-sm text-white/90">In Stock</p>

                    <div class="flex items-center mt-3">
                        <p class="font-semibold text-3xl">40</p>
                        <p class="ml-3 text-sm font-medium">Items</p>

                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto size-12 text-white/90"
                            viewBox="0 -960 960 960" fill="currentColor">
                            <path
                                d="M200-80q-33 0-56.5-23.5T120-160v-451q-18-11-29-28.5T80-680v-120q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v120q0 23-11 40.5T840-611v451q0 33-23.5 56.5T760-80H200Zm0-520v440h560v-440H200Zm-40-80h640v-120H160v120Zm200 280h240v-80H360v80Z" />
                        </svg>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="p-4 rounded-xl h-32
                bg-linear-to-br from-rose-400 to-red-600
                text-white shadow-md
                hover:-translate-y-1 hover:shadow-lg transition-all duration-300">

                    <p class="text-sm text-white/90">Out of Stock</p>

                    <div class="flex items-center mt-3">
                        <p class="font-semibold text-3xl">2</p>
                        <p class="ml-3 text-sm font-medium">Items</p>

                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto size-12 text-white/90"
                            viewBox="0 -960 960 960" fill="currentColor">
                            <path
                                d="M440-400v-360h80v360h-80Zm0 200v-80h80v80h-80ZM240-40H120q-33 0-56.5-23.5T40-120v-120h80v120h120v80Zm480 0v-80h120v-120h80v120q0 33-23.5 56.5T840-40H720ZM40-720v-120q0-33 23.5-56.5T120-920h120v80H120v120H40Zm800 0v-120H720v-80h120q33 0 56.5 23.5T920-840v120h-80Z" />
                        </svg>
                    </div>
                </div>

            </div>
        </div>


        <!-- Item Summary -->
        <div class="w-full px-8">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <p class="text-base font-semibold mb-4 text-slate-700">Item Summary</p>

                <div class="overflow-x-auto rounded-lg bg-white">
                    <table class="min-w-full">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-2 text-sm font-semibold text-slate-600 text-center">No</th>
                                <th class="px-4 py-2 text-sm font-semibold text-slate-600 text-center">Item Name</th>
                                <th class="px-4 py-2 text-sm font-semibold text-slate-600 text-center">Category</th>
                                <th class="px-4 py-2 text-sm font-semibold text-slate-600 text-center">Status</th>
                                <th class="px-4 py-2 text-sm font-semibold text-slate-600 text-center">Stock</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($collection as $item)
                                                <tr class=" odd:bg-white even:bg-slate-50 hover:bg-slate-50 transition">
                                                    <td class="px-4 py-2 text-sm text-center text-slate-600">{{ $loop->iteration }}</td>
                                                    <td class="px-4 py-2 text-sm text-center text-slate-700">{{ $item['item_name'] }}</td>
                                                    <td class="px-4 py-2 text-sm text-center text-slate-600">{{ $item['category'] }}</td>
                                                    <td class="px-4 py-2 text-sm text-center">
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                                {{ $item['status'] === 'Available'
                                ? 'bg-emerald-100 text-emerald-700'
                                : 'bg-rose-100 text-rose-700' }}">
                                                            {{ $item['status'] }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-center text-slate-700">
                                                        {{ $item['stock'] }} pcs
                                                    </td>
                                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection