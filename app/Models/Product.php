<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'nama', 'slug', 'deskripsi', 'harga', 'stok'];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Requirement #3 (Bagian A): minimal 1 scope
    // Pemakaian: Product::tersedia()->get();
    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('stok', '>', 0);
    }

    // Scope tambahan, berguna untuk demo eager loading di README
    public function scopeDenganRelasi(Builder $query): Builder
    {
        return $query->with(['category', 'reviews']);
    }
}
