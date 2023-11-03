<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Order extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'active',
        'order_nr',
        'first_name',
        'last_name',
        'ticket_quantity',
        'cancel_reason',
        'final_price',
        'payment_method',
        'token',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'order_id');
    }
}
