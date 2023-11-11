<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pool extends Model
{
    use HasUuids, HasFactory;
    
    protected $fillable = [
        'target_amount',
        'collected_amount',
        'active',
    ];
}
