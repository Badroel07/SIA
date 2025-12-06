<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'transaction_id',
        'medicine_id',
        'medicine_name',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    // Relasi ke Transaksi (Many-to-One)
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    // Relasi ke Obat (Many-to-One)
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
