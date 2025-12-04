<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper methods
    public function getSubtotal()
    {
        return $this->product->getFinalPrice() * $this->quantity;
    }

    // Static method to get cart total for a user
    public static function getCartTotal($userId)
    {
        return static::where('user_id', $userId)
            ->with('product')
            ->get()
            ->sum(function ($cart) {
                return $cart->getSubtotal();
            });
    }

    // Static method to get cart count for a user
    public static function getCartCount($userId)
    {
        return static::where('user_id', $userId)->sum('quantity');
    }
}
