<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal (mass assignable)
    protected $fillable = [
        'invoice_number',
        'user_id',
        'total_price',
        'discount',
        'final_total',
        'amount_paid',
        'change_amount',
        'status',
    ];

    // Relasi ke detail transaksi (One-to-Many)
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Relasi ke Kasir (User) (Many-to-One)
    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
