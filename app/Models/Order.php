<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Phone;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'phone_id',
        'order_status',
        'quantity',
    ];

    protected $with = ['phone'];
    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id', 'id');
    }

}
