<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id',
    'total_price',
    'payment_method',
    'shipping_address',
    'nama_rekening',
    'bukti_transfer',
    'status',
];

    public function user()
{
    return $this->belongsTo(User::class);
}

public function items()
{
    return $this->hasMany(OrderItem::class);
}

public function getBankLabelAttribute()
{
    return match ($this->bank) {
        'bca' => 'BCA - 1234567890 a.n. PT E-Commerce',
        'mandiri' => 'Mandiri - 9876543210 a.n. PT E-Commerce',
        'bni' => 'BNI - 1122334455 a.n. PT E-Commerce',
        default => ucfirst($this->bank),
    };
}


}
