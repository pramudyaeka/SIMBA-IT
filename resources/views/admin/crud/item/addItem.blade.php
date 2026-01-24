@extends('layouts.dashboard')

@section('title', 'Add Item')

@section('content')
<div class="max-w-4xl mx-auto py-2">
    <div class="mb-6 px-4 sm:px-0">
        <h1 class="text-2xl font-bold text-gray-800">Add New Item</h1>
        <p class="text-sm text-gray-500">Create a new item in your inventory.</p>
    </div>

    <form action="#" method="POST" class="bg-white shadow-lg rounded-xl overflow-hidden">
        @csrf
        
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label for="item_name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                    <input type="text" id="item_name" name="item_name" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                        placeholder="e.g. Wireless Mouse"
                        required>
                </div>

                <div>
                    <label for="partNumber" class="block text-sm font-medium text-gray-700 mb-1">Part Number</label>
                    <input type="text" id="partNumber" name="partNumber" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                        placeholder="e.g. PN-2023-001"
                        required>
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <input type="text" id="category" name="category" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                        placeholder="e.g. Electronics"
                        required>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                    <input type="number" id="stock" name="stock" min="0"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                        placeholder="0"
                        required>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                    placeholder="Brief description about the item..."
                    required></textarea>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-colors">
                Save Item
            </button>
        </div>
    </form>
</div>
@endsection