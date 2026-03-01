<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_code',
        'title',
        'author',
        'publisher',
        'year',
        'stock',
        'image', // ✅ DITAMBAHKAN: Agar path gambar bisa tersimpan ke database
    ];

    /**
     * The attributes that should have default values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'stock' => 0, // ✅ Default value agar stock tidak NULL
    ];

    /**
     * Relasi ke model Transaction (hanya yang status borrowed)
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class)
            ->where('status', 'borrowed');
    }
}