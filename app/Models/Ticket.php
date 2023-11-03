<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Ticket extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'order_id',
        'ticket_number',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function winner()
    {
        return $this->hasOne(Winner::class, 'ticket_id');
    }
}
