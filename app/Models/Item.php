<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'part_number',
        'category_id', // PENTING: Gunakan category_id, bukan category
        'stock',
        'description',
        'status',
    ];

    /**
     * Relasi: Belongs To
     * Satu Item "milik" satu Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}