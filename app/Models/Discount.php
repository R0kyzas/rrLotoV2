<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Discount extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'code',
        'percentage',
    ];
}
