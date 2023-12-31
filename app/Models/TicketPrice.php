<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TicketPrice extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'price',
    ];
}
