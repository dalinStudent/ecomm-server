<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'img',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details');
    }
}
