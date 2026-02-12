<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Import Carbon untuk hitung tanggal

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'description']; // Hapus slug dan status dari sini

    // Relasi ke Items
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }

    /**
     * ACCESSOR: getStatusAttribute
     * Dipanggil dengan cara: $category->status
     */
    public function getStatusAttribute()
    {
        // 1. Cek apakah ada barang?
        if ($this->items()->count() > 0) {
            return 'Active'; // Ada barang = Selalu Active
        }

        // 2. Jika kosong, cek umur kategori
        // Apakah dibuat lebih dari 3 bulan lalu?
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        
        if ($this->created_at < $threeMonthsAgo) {
            return 'Inactive'; // Kosong & Tua (> 3 bulan)
        }

        return 'Active'; // Kosong & Baru (< 3 bulan)
    }
}