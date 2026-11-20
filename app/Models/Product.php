<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'image'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Contoh hasil: Rp 25.000 */
    protected function priceFormatted(): Attribute
    {
        return Attribute::get(fn () => 'Rp ' . number_format($this->price, 0, ',', '.'));
    }

    /** URL gambar; jika belum diupload atau file hilang, tampilkan placeholder SVG */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->image && Storage::disk('public')->exists($this->image)) {
                return asset('storage/' . $this->image);
            }

            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300">'
                 . '<rect width="400" height="300" fill="#eef3fd"/>'
                 . '<rect x="168" y="78" width="64" height="64" rx="16" fill="#3a6fd8"/>'
                 . '<text x="200" y="125" font-family="Arial" font-size="40" font-weight="bold" fill="#fff" text-anchor="middle">D</text>'
                 . '<text x="200" y="190" font-family="Arial" font-size="16" fill="#64748b" text-anchor="middle">Belum ada foto</text>'
                 . '</svg>';

            return 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
        });
    }

    /** Link WhatsApp dengan pesan otomatis berisi nama dan harga produk */
    protected function whatsappUrl(): Attribute
    {
        return Attribute::get(function () {
            $text = 'Halo ' . config('app.name') . ", saya ingin memesan:\n\n"
                  . "Produk: {$this->name}\n"
                  . "Harga: {$this->price_formatted}\n\n"
                  . 'Apakah masih tersedia?';

            return 'https://wa.me/' . config('umkm.whatsapp') . '?text=' . rawurlencode($text);
        });
    }
}