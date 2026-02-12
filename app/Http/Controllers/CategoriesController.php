<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        // Ambil kategori & hitung jumlah itemnya
        $categories = Category::withCount('items')->latest()->get();

        // Hitung Statistik (Manual loop karena status sekarang dinamis/bukan kolom DB)
        $totalCategories = $categories->count();
        $activeCategories = $categories->filter(fn($c) => $c->status === 'Active')->count();
        $emptyCategories = $categories->where('items_count', 0)->count();

        return view('admin.crud.category.categoriesManage', compact(
            'categories',
            'totalCategories',
            'activeCategories',
            'emptyCategories'
        ));
    }

    public function store(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'category_name' => 'required|string|max:255|unique:categories,category_name',
        'description' => 'required|string', // Validasi description wajib diisi
    ]);

    // 2. Simpan ke Database
    Category::create([
        'category_name' => $request->category_name,
        'description' => $request->description // Simpan description
    ]);

    // 3. Redirect kembali
    return redirect()->back()->with('success', 'Category added successfully!');
}
}