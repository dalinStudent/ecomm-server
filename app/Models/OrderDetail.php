<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zipcode',
        'payment_id',
        'payment_mode',
        'status',
        'remark',
    ];

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_detail_id', 'id');
    }
}
