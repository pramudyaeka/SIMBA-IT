@extends('layouts.dashboard')

@section('title', 'Add Category')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="mb-6 px-4 sm:px-0">
        <h1 class="text-2xl font-bold text-gray-800">Add New Category</h1>
        <p class="text-sm text-gray-500">Create a new category to organize your items.</p>
    </div>

    <form action="#" method="POST" class="bg-white shadow-lg rounded-xl overflow-hidden">
        @csrf
        
        <div class="p-6 space-y-6">
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input type="text" id="name" name="name" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                    placeholder="e.g. Office Supplies"
                    required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200"
                    placeholder="Describe what kind of items belong to this category..."
                    required></textarea>
            </div>

        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-colors">
                Save Category
            </button>
        </div>
    </form>
</div>
@endsection