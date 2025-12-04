<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'quantity',
        'price',
        'vendor_amount',
        'commission_amount',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'vendor_amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Helper methods

    public function getSubtotal()
    {
        return $this->price * $this->quantity;
    }
}
