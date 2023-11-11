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

    protected static function boot()
    {
        parent::boot();

        $isPoolExists = Pool::first();

        if($isPoolExists)
        {
            static::updated(function ($order) {
                if ($order->isDirty('active') && $order->active === 1) {
                    $pool = Pool::first();
                    $pool->collected_amount += $order->final_price;
                    $pool->save();
                }
            });
        }
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'order_id');
    }
}
