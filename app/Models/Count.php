<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Count extends Model
{
    
    protected $table = 'counts';

    protected $fillable = [
       'inventory_id',
       'count',
       'count_type',
    ];

}
