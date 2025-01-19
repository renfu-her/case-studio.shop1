<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'tracking_number'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_id = static::generateOrderId();
        });
    }

    protected static function generateOrderId(): string
    {
        $prefix = 'OID' . Carbon::now()->format('ym');

        // 獲取當前月份最後一個訂單編號
        $lastOrder = static::where('order_id', 'like', $prefix . '%')
            ->orderBy('order_id', 'desc')
            ->first();

        if (!$lastOrder) {
            // 如果是當月第一筆訂單
            $nextNumber = '0001';
        } else {
            // 從最後一個訂單編號提取序號並加1
            $lastNumber = intval(substr($lastOrder->order_id, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . $nextNumber;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id')->where('is_admin', 0);
    }
}
