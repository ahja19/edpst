<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'phone',
        'address',
        'status',
        'payment_status',
        'payment_proof',
        'paid_at',
        'total',
        'shipping_courier',
        'tracking_number',
        'shipped_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Lunas',
            'pending' => 'Menunggu Verifikasi',
            default => 'Belum Dibayar',
        };
    }

    public function getPaymentStatusCssAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'paid',
            'pending' => 'verifying',
            default => 'unpaid',
        };
    }
}